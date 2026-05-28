<?php
// 1. Include your database connection
require_once 'admin/logic.php'; 

try {
    // 2. Fetch all blogs (newest first) and get the author's username
    $sql = "SELECT blogs.*, admins.username 
            FROM blogs
            JOIN admins ON blogs.admin_id = admins.id
            ORDER BY blogs.created_at DESC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $blogs = $stmt->fetchAll();
} catch (PDOException $e) {
    // Fail gracefully if there's a database issue
    $blogs = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Blog - Restorer Cleaning Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        :root {
            --pry: #000;
            --sec: #fff;
            --tra: transparent;
            --highlight: rgb(52, 180, 244);
            --bgColor: rgba(0, 0, 0, 0.4);
            --hr: 1px solid rgba(255, 255, 255, 0.2);
            --chevron: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="8 6 16 12 8 18"/></svg>') no-repeat center / contain;
        }

        * {
            margin: 0;
            border: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--pry);
        }

        footer {
            color: var(--sec);
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1em;
        }

        /* --- Custom Navigation Component Overrides --- */
        .tab_nav {
            display: none;
        }

        .mobile_Nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5em 1em;
            background-color: var(--pry);
            z-index: 50; /* Ensure visibility over content */
        }

        .mobile_Nav.active {
            background-color: var(--sec);
            height: 130px;
        }

        .mobile_Nav > :first-child {
            background-color: var(--tra);
        }

        .comp_Logo {
            width: 90px;
            border-radius: 50px;
        }

        .comp_Logo.active {
            display: none;
        }

        .hamburger > button {
            background: var(--sec);
            display: flex;
            align-items: center;
            padding: 1em;
            border-radius: 10px;
        }

        .hamburger_ctnt {
            position: fixed;
            width: 100vw;
            height: 100vh;
            background-color: var(--sec);
            left: 0;
            top: 130px; /* Aligns smoothly under the activated nav state */
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .hamburger_ctnt.active {
            transform: translateX(0%);
        }

        .hamburger_ctnt > ul {
            padding: 0em 1.5em;
            list-style: none;
        }

        .hamburger_ctnt > ul > li {
            padding: 0.6em 0em;
        }

        .hamburger_ctnt > ul > li > a {
            font-size: 1.2em;
        }

        .highlight {
            text-decoration: none;
            color: var(--pry);
            font-family: sans-serif;
            font-weight: bold;
        }

        .highlight.activ {
            color: var(--highlight);
        }

        .hamburger_ctnt > ul > :text-3rd {
            position: relative;
        }

        .chevron::after {
            content: "";
            position: absolute;
            left: 9em;
            top: 0.8em;
            width: 1em;
            height: 1em;
            -webkit-mask: var(--chevron);
            mask: var(--chevron);
            background-color: #000;
            transform: rotate(90deg);
            transition: transform 0.3s ease;
        }

        .chevron.active::after {
            transform: rotate(-90deg);
        }

        .services_List {
            padding: 0em 1.5em;
            list-style: none;
            max-height: 0px;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .hamburger_ctnt > ul > :nth-child(3) > ul > li {
            padding: 0.6em 0em;
        }

        .hamburger_ctnt > ul > :nth-child(3) > ul > li > a {
            color: var(--pry);
            text-decoration: none;
            font-family: sans-serif;
            font-weight: bold;
        }

        .services_List.active {
            max-height: 500px;
        }

        /* Responsive Breakpoints for navigation views */
        /* @media (min-width: 768px) {
            .mobile_Nav {
                display: none;
            }
            .tab_nav {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1em 2em;
                background-color: var(--pry);
                position: sticky;
                top: 0;
                z-index: 50;
            }
            .tab_nav div:last-child {
                display: flex;
                gap: 1.5em;
            }
            .tab_nav div:last-child a {
                color: var(--sec);
            }
            .tab_nav div:last-child a.activ {
                color: var(--highlight);
            }
        } */
            @media (min-width:600px) {
    .mobile_Nav{
        display: none;
    }

    .tab_nav {
    display: flex;
    position: fixed;
    /* border: 1px solid orange; */
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5em 1em;
    background-color: var(--pry);
    z-index: 10;
    gap: 3em;
    font-family: sans-serif;
    }

    .tab_nav > :last-child {
        display: flex;
        justify-content: space-between;
        align-items: center;
        /* border: 1px solid orange; */
        flex-grow: 1;
    }

    /* For nav links */
    .highlight{
        color: var(--sec);
        text-decoration: none;
        font-family: sans-serif;
        /* padding: 1em 0em; */
        font-weight: bold;
    }

    .highlight.activ{
        color: var(--highlight);
    }    
}
    </style>
</head>
<body class="font-sans antialiased">

    <nav class="mobile_Nav">
        <div>
            <img src="images/Feem/company_Logo.jpg" alt="Company Logo" class="comp_Logo">
        </div>
        <div class="hamburger">
            <button aria-label="menu" class="menu-icon">
                <svg width="18" height="18" viewBox="0 0 18 18">
                    <polyline id="globalnav-menutrigger-bread-bottom" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" points="2 12, 16 12">
                        <animate id="globalnav-anim-menutrigger-bread-bottom-open" attributeName="points" keyTimes="0;0.5;1" dur="0.24s" begin="indefinite" fill="freeze" calcMode="spline" keySplines="0.42, 0, 1, 1;0, 0, 0.58, 1" values=" 2 12, 16 12; 2 9, 16 9; 3.5 15, 15 3.5"></animate>
                        <animate id="globalnav-anim-menutrigger-bread-bottom-close" attributeName="points" keyTimes="0;0.5;1" dur="0.24s" begin="indefinite" fill="freeze" calcMode="spline" keySplines="0.42, 0, 1, 1;0, 0, 0.58, 1" values=" 3.5 15, 15 3.5; 2 9, 16 9; 2 12, 16 12"></animate>
                    </polyline>
                    <polyline id="globalnav-menutrigger-bread-top" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" points="2 5, 16 5">
                        <animate id="globalnav-anim-menutrigger-bread-top-open" attributeName="points" keyTimes="0;0.5;1" dur="0.24s" begin="indefinite" fill="freeze" calcMode="spline" keySplines="0.42, 0, 1, 1;0, 0, 0.58, 1" values=" 2 5, 16 5; 2 9, 16 9; 3.5 3.5, 15 15"></animate>
                        <animate id="globalnav-anim-menutrigger-bread-top-close" attributeName="points" keyTimes="0;0.5;1" dur="0.24s" begin="indefinite" fill="freeze" calcMode="spline" keySplines="0.42, 0, 1, 1;0, 0, 0.58, 1" values=" 3.5 3.5, 15 15; 2 9, 16 9; 2 5, 16 5"></animate>
                    </polyline>
                </svg>
            </button>

            <div class="hamburger_ctnt">
                <ul>
                    <li><a href="index.html" class="highlight">Home</a></li>
                    <li><a href="about_Us.html" class="highlight">About Us</a></li>
                    <li class="chevron">
                        <a href="services.html" class="highlight">Services</a>
                        <ul class="services_List">
                            <li><a href="services.html#airbnb">Airbnbs</a></li>
                            <li><a href="services.html#comm">Commercial</a></li>
                            <li><a href="services.html#deep">Deep Clean</a></li>
                            <li><a href="services.html#end">End Of Tenancy</a></li>
                            <li><a href="services.html#house">Housekeeping</a></li>
                            <li><a href="services.html#lords">Landlords</a></li>
                            <li><a href="services.html#res">Residential</a></li>
                            <li><a href="services.html#sof">Sofa & Carpets</a></li>
                        </ul>
                    </li>
                    <li><a href="contact.html" class="highlight">Contact</a></li>
                    <li><a href="blog.php" class="highlight activ">Blog</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <nav class="tab_nav">
        <div>
            <img src="images/Feem/company_Logo.jpg" alt="Company Logo" class="comp_Logo">
        </div>
        <div>
            <a href="index.html" class="highlight">Home</a>
            <a href="about_Us.html" class="highlight">About Us</a>
            <a href="services.html" class="highlight">Services</a>
            <a href="contact.html" class="highlight">Contact</a>
            <a href="blog.php" class="highlight activ">Blog</a>
        </div>
    </nav>

    <header class="bg-neutral-900 border-b border-zinc-800 py-20 text-center mt-[60px] md:mt-0">
        <div class="max-w-3xl mx-auto px-4">
            <h1 class="text-4xl sm:text-5xl font-black text-white tracking-tight mb-4">
                BLOG
            </h1>
            <p class="text-base sm:text-lg text-zinc-400 font-medium">
                Stay up to date with the latest thoughts and trends related to keeping your home and property above excellence written by our team.
            </p>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <?php if (empty($blogs)): ?>
            <div class="text-center py-20 bg-zinc-900/50 rounded-2xl border border-zinc-800 p-8 shadow-sm">
                <svg class="mx-auto h-12 w-12 text-zinc-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 12h-15m0 0l6.75-6.75M4.5 12l6.75 6.75" />
                </svg>
                <h3 class="text-lg font-bold text-zinc-200 mb-1">No posts found</h3>
                <p class="text-zinc-500 text-sm">Check back later! Our authors are brewing up some fresh content.</p>
            </div>
        <?php else: ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($blogs as $blog): ?>
                    <article class="bg-zinc-900 rounded-2xl border border-zinc-800/80 shadow-md hover:shadow-xl hover:border-zinc-700 transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                        
                        <div class="p-6 pb-0">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-950 text-indigo-400 uppercase tracking-wider">
                                Article
                            </span>
                            
                            <h2 class="text-xl font-bold text-zinc-100 mt-3 mb-2 group-hover:text-indigo-400 transition duration-200 line-clamp-2">
                                <?= htmlspecialchars($blog['title']) ?>
                            </h2>
                            
                            <p id="content-<?= $blog['id'] ?>" class="text-zinc-400 text-sm leading-relaxed line-clamp-3 whitespace-pre-line transition-all duration-300">
                                <?= htmlspecialchars($blog['content']) ?>
                            </p>

                            <button 
                                type="button" 
                                onclick="toggleReadMore(<?= $blog['id'] ?>, this)"
                                class="mt-2 text-xs font-bold text-indigo-400 hover:text-indigo-300 transition focus:outline-none"
                            >
                                Read more
                            </button>
                        </div>

                        <div class="p-6 pt-6 mt-6 border-t border-zinc-800/80 bg-zinc-950/40 space-y-3">
                            <div class="flex items-center justify-between text-xs text-zinc-500">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="font-medium text-zinc-300">
                                        <?= htmlspecialchars($blog['username'] ?? 'Unknown Author') ?>
                                    </span>
                                </div>
                                
                                <time datetime="<?= $blog['created_at'] ?>">
                                    <?= date('M d, Y', strtotime($blog['created_at'] ?? 'now')) ?>
                                </time>
                            </div>

                            <?php 
                                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
                                $share_url = $protocol . $_SERVER['HTTP_HOST'] . strtok($_SERVER["REQUEST_URI"], '?') . "?id=" . $blog['id']; 
                                $encoded_url = urlencode($share_url);
                                $encoded_title = urlencode($blog['title']);
                            ?>
                            <div class="pt-2 border-t border-zinc-800/60 flex items-center justify-between">
                                <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Share Article:</span>
                                
                                <div class="relative inline-block text-left">
                                    <button type="button" onclick="toggleShareMenu(<?= $blog['id'] ?>, event)" class="text-xs font-bold text-zinc-400 hover:text-indigo-400 transition flex items-center space-x-1 focus:outline-none">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 10.748a3.001 3.001 0 110 2.504l6.588 3.843a3.001 3.001 0 11-.48 1.613l-6.58-3.838a3.001 3.001 0 110-4.759l6.58-3.838a3.001 3.001 0 11.48 1.612l-6.588 3.843z" />
                                        </svg>
                                        <span>Share</span>
                                    </button>
                                    
                                    <div id="share-menu-<?= $blog['id'] ?>" class="hidden absolute right-0 bottom-6 z-10 mt-2 w-32 origin-bottom-right rounded-md bg-zinc-900 shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none border border-zinc-800">
                                        <div class="py-1">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $encoded_url ?>" target="_blank" rel="noopener noreferrer" class="text-zinc-300 block px-4 py-1.5 text-xs hover:bg-zinc-800 hover:text-blue-400 transition">Facebook</a>
                                            <a href="https://twitter.com/intent/tweet?url=<?= $encoded_url ?>&text=<?= $encoded_title ?>" target="_blank" rel="noopener noreferrer" class="text-zinc-300 block px-4 py-1.5 text-xs hover:bg-zinc-800 hover:text-white transition">X (Twitter)</a>
                                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $encoded_url ?>" target="_blank" rel="noopener noreferrer" class="text-zinc-300 block px-4 py-1.5 text-xs hover:bg-zinc-800 hover:text-blue-500 transition">LinkedIn</a>
                                            <a href="https://api.whatsapp.com/send?text=<?= $encoded_title ?>%20<?= $encoded_url ?>" target="_blank" rel="noopener noreferrer" class="text-zinc-300 block px-4 py-1.5 text-xs hover:bg-zinc-800 hover:text-emerald-400 transition">WhatsApp</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </article>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </main>

    <footer>
        <div>
            &copy; 2026 by Restorer Cleaning Services.
        </div>
    </footer>

    <script>
        // 1. Integrated Custom Navigation Mechanics
        const menu = document.querySelector('.menu-icon');
        const mobileNav = document.querySelector('.mobile_Nav');
        const compLogo = document.querySelector('.comp_Logo');
        const hamburgerCtnt = document.querySelector('.hamburger_ctnt');

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
        });

        const chevron = document.querySelector('.chevron');
        const serviceList = document.querySelector('.services_List');
        chevron.addEventListener('click', (e) => {
            e.stopPropagation(); // Restricts navigation collapsing errors
            chevron.classList.toggle('active');
            serviceList.classList.toggle('active');
        });

        const toggleLinks = document.querySelectorAll('.highlight');
        toggleLinks.forEach((button) => {
            button.addEventListener('click', () => {
                if(button.classList.contains('activ')) {
                    button.classList.remove('activ');
                } else {
                    turnOffPreviousButton();
                    button.classList.add('activ');
                }
            });
        });

        function turnOffPreviousButton() {
            const previousButton = document.querySelector('.highlight.activ');
            if (previousButton) {
                previousButton.classList.remove('activ');
            }
        }

        // 2. Blog Engine Mechanics (Content Expanders & Dropdowns)
        function toggleReadMore(blogId, buttonEl) {
            const contentParagraph = document.getElementById(`content-${blogId}`);
            if (contentParagraph.classList.contains('line-clamp-3')) {
                contentParagraph.classList.remove('line-clamp-3');
                buttonEl.textContent = 'Read less';
            } else {
                contentParagraph.classList.add('line-clamp-3');
                buttonEl.textContent = 'Read more';
            }
        }

        function toggleShareMenu(blogId, event) {
            event.stopPropagation();
            document.querySelectorAll('[id^="share-menu-"]').forEach(menu => {
                if(menu.id !== `share-menu-${blogId}`) menu.classList.add('hidden');
            });
            const currentMenu = document.getElementById(`share-menu-${blogId}`);
            currentMenu.classList.toggle('hidden');
        }

        // Catch global contextual click events to dismiss opened menus safely
        document.addEventListener('click', function() {
            document.querySelectorAll('[id^="share-menu-"]').forEach(menu => {
                menu.classList.add('hidden');
            });
        });
    </script>
</body>
</html>