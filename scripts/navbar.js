const navbar_menu = document.getElementById('navbar-menu')
const burger = document.getElementById('navbar-burger')
burger.addEventListener('click', () => {
  burger.classList.toggle('is-active')
  navbar_menu.classList.toggle('is-active')
})
