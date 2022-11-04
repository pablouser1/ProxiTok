window.addEventListener("load", () => {
  if (navigator.serviceWorker) {
    navigator.serviceWorker.register('/sw.js').then(function (reg) {
      console.log('Service worker registration was successful, scope: ', reg.scope);
    }).catch(function (error) {
      console.log('Service worker failed:', error);
    });
  }
})
