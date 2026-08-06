// ============ ULTRA PREMIUM ANIMATION ENGINE (GSAP) ============

document.addEventListener("DOMContentLoaded", () => {
    // 0. Désactive l'animation sur les pages de projets / réalisations
    const currentPath = window.location.pathname.toLowerCase();
    const currentHref = window.location.href.toLowerCase();
    if (currentPath.includes('/projects') || currentPath.includes('/activite') || currentPath.includes('/realisations') || currentHref.includes('projets.php') || currentHref.includes('activite.php') || currentHref.includes('realisations.html')) {
        document.querySelectorAll('.gsap-reveal, [data-split], .card-project, .stat-item, .reveal-item, .hero-section h1, .hero-section p').forEach(el => {
            el.style.visibility = 'visible';
            el.style.opacity = 1;
            el.style.transform = 'none';
            el.style.transition = 'none';
            el.style.animation = 'none';
        });
        return;
    }

    // 1. Initialiser GSAP & Plugins
    if (typeof gsap !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
    } else {
        console.warn("GSAP n'est pas chargé !");
        document.querySelectorAll('.gsap-reveal, [data-split], .card-project, .stat-item').forEach(el => {
            el.style.visibility = 'visible';
            el.style.opacity = 1;
        });
        return;
    }

    // Préparer les éléments
    gsap.set('.navbar', { yPercent: -100 });
    gsap.set('.hero-section .hero-btn, .hero-section .hero-controls', { opacity: 0, y: 20 });
    
    // 2. PAGE TRANSITION (IN)
    function pageEntrance() {
        const tl = gsap.timeline();
        const transitionEl = document.querySelector('.page-transition');
        
        if (transitionEl) {
            tl.to('.transition-spinner', { opacity: 0, duration: 0.3 })
              .to('.page-transition', { 
                  yPercent: -100, 
                  duration: 1.2, 
                  ease: "expo.inOut",
                  onComplete: () => {
                      transitionEl.style.display = 'none';
                  }
              });
        }
        
        // Apparition de la Navbar
        tl.to('.navbar', { 
            yPercent: 0, 
            duration: 1, 
            ease: "power3.out" 
        }, "-=0.6");

        // SplitType pour les titres principaux
        const heroTitle = document.querySelector('.hero-section h1, .contact-title');
        const heroDesc = document.querySelector('.hero-section p, .contact-panel h3');
        
        if (typeof SplitType !== 'undefined') {
            if (heroTitle) {
                const isSingleWord = heroTitle.textContent.trim().split(/\s+/).length === 1;
                const splitTitle = new SplitType(heroTitle, { types: isSingleWord ? 'words' : 'words, chars' });
                const titleTargets = isSingleWord ? splitTitle.words : splitTitle.chars;
                tl.from(titleTargets, {
                    y: 80,
                    opacity: 0,
                    stagger: 0.02,
                    duration: 1.2,
                    ease: "back.out(1.5)",
                    clearProps: "all"
                }, "-=0.8");
            }
            if (heroDesc) {
                const splitDesc = new SplitType(heroDesc, { types: 'lines' });
                tl.from(splitDesc.lines, {
                    y: 30,
                    opacity: 0,
                    stagger: 0.1,
                    duration: 1,
                    ease: "power3.out"
                }, "-=0.8");
            }
        } else {
            if (heroTitle) tl.from(heroTitle, { y: 30, opacity: 0, duration: 1 }, "-=0.8");
            if (heroDesc) tl.from(heroDesc, { y: 30, opacity: 0, duration: 1 }, "-=0.6");
        }

        tl.to('.hero-section .hero-btn, .hero-section .hero-controls', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            stagger: 0.1,
            ease: "power3.out"
        }, "-=0.6");
    }

    pageEntrance();

    // 3. PARALLAX EFFECTS (ScrollTrigger)
    const parallaxBg = document.querySelectorAll('.hero-section::before, .hero-section::after');
    parallaxBg.forEach(el => {
        gsap.to(el, {
            y: 200,
            ease: "none",
            scrollTrigger: {
                trigger: ".hero-section",
                start: "top top",
                end: "bottom top",
                scrub: true
            }
        });
    });

    // About hero animation: keep the section stable and animate its contents
    const aboutIntro = document.querySelector('.about-intro');
    if (aboutIntro) {
        const aboutTitle = aboutIntro.querySelector('h1');
        const aboutDivider = aboutIntro.querySelector('.about-divider');
        const aboutLead = aboutIntro.querySelector('p');
        const aboutBlobs = aboutIntro.querySelectorAll('.about-intro-blob');

        const aboutTl = gsap.timeline({ defaults: { ease: "power3.out" } });

        if (aboutTitle) {
            aboutTl.from(aboutTitle, {
                y: 34,
                opacity: 0,
                duration: 0.9
            });
        }

        if (aboutDivider) {
            aboutTl.from(aboutDivider, {
                scaleX: 0,
                opacity: 0,
                transformOrigin: "center center",
                duration: 0.45
            }, "-=0.25");
        }

        if (aboutLead) {
            aboutTl.from(aboutLead, {
                y: 22,
                opacity: 0,
                duration: 0.8
            }, "-=0.15");
        }

        if (aboutBlobs.length > 0) {
            gsap.to(aboutBlobs, {
                y: (index) => index % 2 === 0 ? 14 : -14,
                x: (index) => index % 2 === 0 ? -8 : 8,
                duration: 6,
                ease: "sine.inOut",
                repeat: -1,
                yoyo: true,
                stagger: 0.4
            });
        }
    }

    // 4. SCROLL TEXT REVEALS (Titres de sections)
    const sectionTitles = document.querySelectorAll('.section-title, .section-header h2');
    if (typeof SplitType !== 'undefined' && sectionTitles.length > 0) {
        sectionTitles.forEach(title => {
            const split = new SplitType(title, { types: 'lines, words' });
            gsap.from(split.words, {
                scrollTrigger: {
                    trigger: title,
                    start: "top 85%",
                    once: true,
                },
                y: 50,
                opacity: 0,
                rotationX: -45,
                transformOrigin: "0% 50% -50",
                duration: 1.2,
                stagger: 0.04,
                ease: "expo.out"
            });
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {

    // 🔴 DÉSACTIVER ANIMATION POUR PROJETS
    if (document.querySelector('.hero-section h1')?.textContent.includes('PROJETS') || document.querySelector('.hero-section h1')?.textContent.includes('ACTIVITÉS')) {
        document.querySelectorAll('.gsap-reveal, [data-split], .card-project, .stat-item, .reveal-item, .hero-section h1, .hero-section p').forEach(el => {
            el.style.visibility = 'visible';
            el.style.opacity = 1;
            el.style.transform = 'none';
            el.style.transition = 'none';
            el.style.animation = 'none';
        });
        return;
    }

    // 👉 le reste de ton script continue ici




    // 5. CARDS BATCH REVEAL (Projets, Articles, Stats)
    const cards = gsap.utils.toArray('.card-project, .article-card, .timeline-card, .foundation-card, .structure-card, .team-card, .contact-card');
    
    if (cards.length > 0) {
        ScrollTrigger.batch(cards, {
            onEnter: batch => gsap.fromTo(batch, 
                { opacity: 0, y: 50, scale: 0.95 },
                { opacity: 1, y: 0, scale: 1, duration: 0.8, stagger: 0.1, ease: "back.out(1.2)", overwrite: true }
            ),
            start: "top 90%"
        });
    }

    // 6. 3D GLOW HOVER ON CARDS (Ultra Premium)
    cards.forEach(card => {
        const glare = document.createElement('div');
        glare.className = 'card-glare';
        card.appendChild(glare);

        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            gsap.to(glare, {
                x: x - rect.width,
                y: y - rect.height,
                opacity: 1,
                duration: 0.4,
                ease: "power2.out"
            });

            const rotateY = ((x / rect.width) - 0.5) * 10;
            const rotateX = ((y / rect.height) - 0.5) * -10;
            
            gsap.to(card, {
                rotateX: rotateX,
                rotateY: rotateY,
                transformPerspective: 1000,
                duration: 0.5,
                ease: "power2.out"
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(glare, { opacity: 0, duration: 0.5, ease: "power2.out" });
            gsap.to(card, {
                rotateX: 0,
                rotateY: 0,
                duration: 0.8,
                ease: "elastic.out(1, 0.4)"
            });
        });
    });

    // 7. COUNTERS (Statistics)
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        const text = stat.textContent.trim();
        const targetValue = parseInt(text.replace(/\D/g, ''));
        const suffix = text.replace(/[\d\s]/g, '');

        if (isNaN(targetValue)) return;

        const counterObj = { val: 0 };
        
        gsap.to(counterObj, {
            val: targetValue,
            duration: 2.5,
            ease: "expo.out",
            scrollTrigger: {
                trigger: stat,
                start: "top 85%"
            },
            onUpdate: function() {
                stat.textContent = Math.floor(counterObj.val).toLocaleString('fr-FR') + suffix;
            }
        });
    });

    // 8. LOGOS ANIMATION
    const logos = document.querySelectorAll('.funding-logos img');
    if(logos.length > 0) {
        gsap.from(logos, {
            scrollTrigger: {
                trigger: '.funding-section, .footer-logo-box',
                start: "top 85%"
            },
            y: 30,
            opacity: 0,
            scale: 0.8,
            duration: 0.8,
            stagger: 0.15,
            ease: "back.out(1.5)"
        });
        
        // Floating loop removed on request: keep logos static after entrance.
    }

    // 9. DYNAMIC NAVBAR BLUR
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.style.backdropFilter = 'blur(20px)';
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.96)';
                navbar.style.boxShadow = '0 10px 30px rgba(0,0,0,0.08)';
            } else {
                navbar.style.backdropFilter = 'blur(10px)';
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.85)';
                navbar.style.boxShadow = '0 2px 24px rgba(0,0,0,0.05)';
            }
        }, { passive: true });
    }

    // 10. SCROLL PROGRESS BAR
    const progressBar = document.createElement('div');
    progressBar.style.position = 'fixed';
    progressBar.style.top = '0';
    progressBar.style.left = '0';
    progressBar.style.width = '100%';
    progressBar.style.height = '4px';
    progressBar.style.backgroundColor = '#0da0f0';
    progressBar.style.transformOrigin = 'left';
    progressBar.style.transform = 'scaleX(0)';
    progressBar.style.zIndex = '10000';
    document.body.appendChild(progressBar);

    gsap.to(progressBar, {
        scaleX: 1,
        ease: "none",
        scrollTrigger: {
            scrub: true
        }
    });

    // 11. PAGE TRANSITION (OUT)
    const internalLinks = document.querySelectorAll('a[href^="/"]:not([href^="#"])');
    internalLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            if (e.ctrlKey || e.metaKey || e.shiftKey || link.target === "_blank") return;
            
            e.preventDefault();
            const destination = link.href;
            const transitionEl = document.querySelector('.page-transition');
            
            if (transitionEl) {
                transitionEl.style.display = 'flex';
                transitionEl.style.transformOrigin = 'bottom';
                
                const spinner = document.querySelector('.transition-spinner');
                if (spinner) spinner.style.opacity = '0';
                
                gsap.fromTo(transitionEl, 
                    { yPercent: 100 }, 
                    { yPercent: 0, duration: 0.8, ease: "expo.inOut", onComplete: () => {
                        window.location = destination;
                    }}
                );
            } else {
                window.location = destination;
            }
        });
    });
    
    console.log('✨ Ultra Premium GSAP Animations Loaded Successfully');
});
