<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - WakafApp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: '#10B981',
                        'primary-dark': '#059669',
                        'primary-light': '#D1FAE5',
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .active-nav {
                @apply bg-primary text-white shadow-lg shadow-emerald-500/20;
            }
            .form-input {
                @apply w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring focus:ring-primary/20 transition-all outline-none;
            }
        }
    </style>
    <style>
        /* Sidebar transition */
        .sidebar-transition {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Flatpickr Customization */
        .flatpickr-calendar {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
            border: 1px solid #f3f4f6 !important;
            border-radius: 0.75rem !important;
            padding: 1rem !important;
        }
        .flatpickr-months .flatpickr-month {
            color: #111827 !important;
            fill: #111827 !important;
            margin-bottom: 0.5rem !important;
        }
        .flatpickr-current-month {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding-top: 0.5rem !important;
        }
        .flatpickr-current-month input.cur-year {
            font-weight: 700 !important;
            color: #111827 !important;
            font-size: 1.125rem !important;
        }
        .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange, .flatpickr-day.selected.inRange, .flatpickr-day.startRange.inRange, .flatpickr-day.endRange.inRange {
            background: #10B981 !important;
            border-color: #10B981 !important;
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3) !important;
        }
        .flatpickr-day.today {
            border: 2px solid #10B981 !important;
            color: #10B981 !important;
        }
        .flatpickr-day:hover {
            background: #f3f4f6 !important;
            border-color: #f3f4f6 !important;
        }
        .flatpickr-day.selected:hover {
            background: #059669 !important;
            border-color: #059669 !important;
        }
        .flatpickr-day {
            border-radius: 0.5rem !important;
            color: #4b5563 !important;
            font-weight: 500 !important;
            margin: 2px !important;
            height: 36px !important;
            line-height: 36px !important;
        }
        span.flatpickr-weekday {
            color: #9ca3af !important;
            font-weight: 600 !important;
            font-size: 0.75rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
        }
        .flatpickr-prev-month, .flatpickr-next-month {
            fill: #10B981 !important;
        }
        .flatpickr-prev-month:hover, .flatpickr-next-month:hover {
            color: #10B981 !important;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    @include('admin.partials.sidebar')
    
    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity"></div>

    <div class="lg:ml-[260px] min-h-screen flex flex-col transition-all duration-300">
        @include('admin.partials.header')

        <main class="p-6 lg:p-8 flex-1">
            @yield('content')
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Toast Notification Logic
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif
    </script>
    @stack('scripts')
</body>
</html>
