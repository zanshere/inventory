// 
document.addEventListener('DOMContentLoaded',function(){
    const navLink = document.querySelectorAll('nav-link');
    const currentPages = window.location.pathname;

    navLink.forEach(link => {
        if(link.href.includes(currentPages)){
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
});