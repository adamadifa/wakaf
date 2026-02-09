<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentCallbackController extends Controller
{
    public function handle(Request $request)
    {
        // Set configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');

        try {
            $notification = new Notification();

            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $orderId = $notification->order_id;
            $fraud = $notification->fraud_status;

            $donation = null;
            if (strpos($orderId, 'ZKT') === 0) {
                $donation = \App\Models\ZakatTransaction::where('invoice_number', $orderId)->first();
            } else {
                $donation = Donation::where('invoice_number', $orderId)->first();
            }

            if (!$donation) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $donation->status = 'pending';
                    } else {
                        $donation->status = 'confirmed';
                        $donation->confirmed_at = now();
                    }
                }
            } else if ($transaction == 'settlement') {
                $donation->status = 'confirmed';
                $donation->confirmed_at = now();
            } else if ($transaction == 'pending') {
                $donation->status = 'pending';
            } else if ($transaction == 'deny') {
                $donation->status = 'canceled';
            } else if ($transaction == 'expire') {
                $donation->status = 'expired';
            } else if ($transaction == 'cancel') {
                $donation->status = 'canceled';
            }

            $donation->save();

            return response()->json(['message' => 'Notification processed']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error processing notification', 'error' => $e->getMessage()], 500);
        }
    }
}
