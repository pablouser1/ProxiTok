const PWA_PRELOAD = {
  pages: ['/', '/about', '/settings'],
  scripts: ['/scripts/navbar.js', '/scripts/themes/card.js'],
  styles: ['/styles/vendor/bulma.min.css', '/styles/vendor/cssgg.min.css', '/styles/themes/card.css']
}

self.addEventListener("install", function(e) {
	e.waitUntil(
		caches.open("pwa").then(function(cache) {
			return cache.addAll([
        ...PWA_PRELOAD.pages,
        ...PWA_PRELOAD.scripts,
        ...PWA_PRELOAD.styles
			]);
		})
	);
});
