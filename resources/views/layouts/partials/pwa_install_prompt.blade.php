<!-- PWA Install Prompt -->
<div id="pwa-install-banner" class="fixed top-24 left-4 right-4 z-[9999] bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 transform -translate-y-48 transition-transform duration-500 md:hidden">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex-shrink-0 flex items-center justify-center shadow-sm overflow-hidden">
            <img src="/pwa-icon-192.png?v={{ time() }}" alt="App Icon" class="w-full h-full object-cover">
        </div>
        <div class="flex-grow">
            <h4 class="font-bold text-gray-800 text-sm">Instal WakafApp</h4>
            <p class="text-xs text-gray-500">Akses lebih cepat & mudah dari layar utama</p>
        </div>
        <div class="flex flex-col gap-2">
            <button id="pwa-install-btn" class="bg-primary text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-opacity-90 transition-all">
                Instal
            </button>
            <button id="pwa-close-banner" class="text-gray-400 text-[10px] text-center hover:text-gray-600">
                Nanti saja
            </button>
        </div>
    </div>
</div>

<script>
    let deferredPrompt;
    const installBanner = document.getElementById('pwa-install-banner');
    const installBtn = document.getElementById('pwa-install-btn');
    const closeBtn = document.getElementById('pwa-close-banner');

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;
        
        // Check if user already dismissed it in this session
        if (!sessionStorage.getItem('pwa_banner_dismissed')) {
            // Show the install banner after a small delay
            setTimeout(() => {
                installBanner.classList.remove('-translate-y-48');
            }, 2000);
        }
    });

    installBtn.addEventListener('click', (e) => {
        // Hide the app provided install promotion
        installBanner.classList.add('-translate-y-48');
        // Show the install prompt
        deferredPrompt.prompt();
        // Wait for the user to respond to the prompt
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the install prompt');
            } else {
                console.log('User dismissed the install prompt');
            }
            deferredPrompt = null;
        });
    });

    closeBtn.addEventListener('click', () => {
        installBanner.classList.add('-translate-y-48');
        // Remember dismissal for this session
        sessionStorage.setItem('pwa_banner_dismissed', 'true');
    });

    window.addEventListener('appinstalled', (evt) => {
        console.log('PWA was installed');
        installBanner.classList.add('-translate-y-48');
    });
</script>
