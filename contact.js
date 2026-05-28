// Hamburger
const menu = document.querySelector('.menu-icon');
const mobileNav = document.querySelector('.mobile_Nav');
const compLogo = document.querySelector('.comp_Logo');
const hamburgerCtnt = document.querySelector('.hamburger_ctnt');
// const body = document.getElementsByName('body');
// console.log(body);

menu.addEventListener('click', () => {
    const isOpen = menu.classList.toggle('open');

    if (isOpen) {
        document.getElementById('globalnav-anim-menutrigger-bread-top-open').beginElement();
        document.getElementById('globalnav-anim-menutrigger-bread-bottom-open').beginElement();
        mobileNav.classList.add('active');
        compLogo.classList.add('active');
        hamburgerCtnt.classList.add('active');
        document.body.style.backgroundColor = "white";
    } else {
        document.getElementById('globalnav-anim-menutrigger-bread-top-close').beginElement();
        document.getElementById('globalnav-anim-menutrigger-bread-bottom-close').beginElement();
        mobileNav.classList.remove('active');
        compLogo.classList.remove('active');
        hamburgerCtnt.classList.remove('active');
        document.body.style.backgroundColor = "black";
    }
})

// For services chevron
const chevron = document.querySelector('.chevron');
const serviceList = document.querySelector('.services_List');
chevron.addEventListener('click', () => {
    chevron.classList.toggle('active');
    serviceList.classList.toggle('active');
})

// For toggle
const toggle = document.querySelectorAll('.highlight');

// Function for toggling the navlinks(reusable snippets);
toggle.forEach((button) => {
    button.addEventListener('click', () => {
        // menu.classList.add('open');
        if(button.classList.contains('activ')) {
            button.classList.remove('activ');
            // For mobile issue
            // mobileNav.classList.remove('active');
            // compLogo.classList.remove('active');
            // hamburgerCtnt.classList.remove('active');
        } else {
            turnOffPreviousButton();
            button.classList.add('activ');
        }
    })
})

function turnOffPreviousButton() {
    const previousButton = document.querySelector('.activ');
    if (previousButton) {
        previousButton.classList.remove('activ');
    }
}
