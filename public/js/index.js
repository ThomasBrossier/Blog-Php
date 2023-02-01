const hamburger = document.querySelector('.header-mobile-hamburger');
const mobileMenu = document.querySelector('.header-mobile-menu')
hamburger.addEventListener('click',()=>{
    hamburger.classList.toggle('active');
    mobileMenu.classList.toggle('show');
})