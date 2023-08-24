const navbarnav = document.querySelector('.navbar-nav');
const menu = document.querySelector('.extra #menu');
menu.onclick = () => {
    navbarnav.classList.toggle('active');
}

// const menu = document.querySelector('#menu');
// document.addEventListener('click', function (e) {
//     if (!menu.contains(e.target) && !navbarnav.contains(e.target)) {
//         navbarnav.classList.remove('active')
//     }
// })

