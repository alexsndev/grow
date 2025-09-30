import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// PWA registration & install prompt
if ('serviceWorker' in navigator) {
	window.addEventListener('load', () => {
		navigator.serviceWorker.register('/service-worker.js').then(reg => {
			// Listen for updates
			if (reg.waiting) {
				window.__swWaiting = reg.waiting;
				showUpdateBanner();
			}
			reg.addEventListener('updatefound', () => {
				const newWorker = reg.installing;
				if (newWorker) {
					newWorker.addEventListener('statechange', () => {
						if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
							window.__swWaiting = newWorker;
							showUpdateBanner();
						}
					});
				}
			});

			let refreshing = false;
			navigator.serviceWorker.addEventListener('controllerchange', () => {
				if (refreshing) return;
				refreshing = true;
				window.location.reload();
			});
		}).catch(e => console.warn('SW registration failed', e));
	});
}

let deferredPrompt = null;
const banner = document.getElementById('pwa-install-banner');
const installBtn = document.getElementById('pwa-install-btn');
const dismissBtn = document.getElementById('pwa-dismiss-btn');

window.addEventListener('beforeinstallprompt', (e) => {
	e.preventDefault();
	deferredPrompt = e;
	if (banner && !window.matchMedia('(display-mode: standalone)').matches && !localStorage.getItem('pwaDismissed')) {
		banner.classList.remove('hidden');
	}
});

installBtn?.addEventListener('click', async () => {
	if (!deferredPrompt) return;
	deferredPrompt.prompt();
	const choice = await deferredPrompt.userChoice;
	if (choice.outcome === 'accepted') {
		banner.classList.add('hidden');
	}
	deferredPrompt = null;
});

dismissBtn?.addEventListener('click', () => {
	banner.classList.add('hidden');
	localStorage.setItem('pwaDismissed', Date.now());
});

// Oculta banner se já instalado (iOS / outros ctxtos)
window.addEventListener('appinstalled', () => {
	banner?.classList.add('hidden');
});

// Update banner logic
const updateBanner = document.getElementById('pwa-update-banner');
const reloadBtn = document.getElementById('pwa-reload-btn');
const reloadDismiss = document.getElementById('pwa-reload-dismiss');

function showUpdateBanner() {
	if (!updateBanner) return;
	if (localStorage.getItem('pwaUpdateDismissed') === window.__swWaiting?.scriptURL) return;
	updateBanner.classList.remove('hidden');
}

reloadBtn?.addEventListener('click', () => {
	if (window.__swWaiting) {
		window.__swWaiting.postMessage('SKIP_WAITING');
	}
});

reloadDismiss?.addEventListener('click', () => {
	updateBanner.classList.add('hidden');
	if (window.__swWaiting) localStorage.setItem('pwaUpdateDismissed', window.__swWaiting.scriptURL);
});

// Offline / online indicator events (console for now; could hook UI toast)
window.addEventListener('offline', () => console.info('[PWA] Offline'));
window.addEventListener('online', () => console.info('[PWA] Online'));

// Listen for SW messages (future use)
navigator.serviceWorker?.addEventListener?.('message', (event) => {
	if (event.data?.type === 'SW_INSTALLED') {
		// Could handle additional logic (e.g., metrics)
	}
});

