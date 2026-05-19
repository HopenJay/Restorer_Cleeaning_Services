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

// For Carousel
const gallery = document.querySelector('.gallery-container');
const prevBtn = document.querySelector('.left_arr');
const nextBtn = document.querySelector('.right_arr');

// Move by 100 px (width of one image + gap)
const scrollAmount = 100;

nextBtn.addEventListener('click', () => {
    gallery.scrollBy({left:scrollAmount, behavior:'smooth'});
});

prevBtn.addEventListener('click', () => {
    gallery.scrollBy({left:-scrollAmount, behavior:'smooth'});
});

// For Videos
const videos = [
    {
        class: "video",
        // width: "",
        // height: "",
        src: "images/Feem/video1.mp4",
    },
    {
        class: "video",
        // width: "",
        // height: "",
        src: "images/Feem/video2.mp4",
    },
    {
        class: "video",
        // width: "",
        // height: "",
        src: "images/Feem/video3.mp4",
    },
    {
        class: "video",
        // width: "",
        // height: "",
        src: "images/Feem/video4.mp4",
    },
    {
        class: "video",
        // width: "",
        // height: "",
        src: "images/Feem/video5.mp4",
    },
]

function renderVideo() {
    let videoHTML = '';

    videos.forEach((video) => {
        videoHTML += `
        <div class="vidBord">
                <video width="100%" height="240" controls class="${video.class}">
                    <source src="${video.src}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
        </div>
        `;
    })
    document.querySelector('.videoGallery').innerHTML = videoHTML;
    
    document.querySelectorAll('.vidBord').forEach((vid) => vid.style.cssText = 'margin: none; border: none; padding: none; box-sizing: border-box;');

    document.querySelector('.videoGallery').style.cssText ='font-family: sans-serif; display: grid; grid-template-columns: repeat(auto-fit, minmax(267px, 1fr)); align-items: start; justify-content: center; gap: 20px; width: 100%; height: 100%; ';

    const vid = document.querySelectorAll('.video');
    // vid.forEach((vid) => vid.style.cssText = )
    // console.log(vid);

    // NOTE: I'm keepig this just incase I might need to do a video UI. Learnt the event 'play and pause' is used for the default while the method that involves using the event 'click' is used for custom design
    // vid.forEach((video) => {
    //     video.addEventListener('play', () => {
    //         if(video.paused) {
    //             video.play();
    //             console.log('kl');
    //         } else {
    //             video.pause();
    //             console.log('lkkj')
    //         }
    //         console.log('kjlwojoi');
    //     });

    //     video.addEventListener('pause', () => {
    //         console.log('ghghghgh')
    //     })
    // })

    // if(video.play) {
    //     alert('work')
    // }
}

renderVideo();