// PWA Installation & Service Worker Logic

let deferredPrompt;

// 1. Register Service Worker
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
                
                // Check for updates to the service worker
                registration.onupdatefound = () => {
                    const installingWorker = registration.installing;
                    installingWorker.onstatechange = () => {
                        if (installingWorker.state === 'installed') {
                            if (navigator.serviceWorker.controller) {
                                // New update available
                                console.log('New content is available; please refresh.');
                            } else {
                                // Content is cached for offline use
                                console.log('Content is now available offline!');
                            }
                        }
                    };
                };
            })
            .catch(err => {
                console.log('ServiceWorker registration failed: ', err);
            });
    });
}

// 2. Custom Install Banner Logic
window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent the mini-infobar from appearing on mobile
    e.preventDefault();
    // Stash the event so it can be triggered later.
    deferredPrompt = e;
    
    // Update UI notify the user they can install the PWA
    const installBanner = document.getElementById('pwa-install-banner');
    if (installBanner && !localStorage.getItem('pwa-prompt-dismissed')) {
        installBanner.style.display = 'flex';
    }
});

function installPWA() {
    const installBanner = document.getElementById('pwa-install-banner');
    if (installBanner) {
        installBanner.style.display = 'none';
    }
    
    if (deferredPrompt) {
        // Show the install prompt
        deferredPrompt.prompt();
        // Wait for the user to respond to the prompt
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the install prompt');
            } else {
                console.log('User dismissed the install prompt');
                localStorage.setItem('pwa-prompt-dismissed', 'true');
            }
            deferredPrompt = null;
        });
    }
}

function dismissPWA() {
    const installBanner = document.getElementById('pwa-install-banner');
    if (installBanner) {
        installBanner.style.display = 'none';
        localStorage.setItem('pwa-prompt-dismissed', 'true');
    }
}

window.addEventListener('appinstalled', (evt) => {
    // Log install to analytics
    console.log('INSTALL: Success');
    // Hide the app-provided install promotion
    const installBanner = document.getElementById('pwa-install-banner');
    if (installBanner) {
        installBanner.style.display = 'none';
    }
});
