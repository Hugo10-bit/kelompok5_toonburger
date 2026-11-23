import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { animate, hover, inView, stagger } from 'motion';

gsap.registerPlugin(ScrollTrigger);

let activeCleanup = null;

function isReducedMotionPreferred() {
    return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function isAlreadyScrolledAboveViewport(el) {
    const rect = el.getBoundingClientRect();
    return rect.bottom <= 0;
}

function setupGsapTextAnimations(root) {
    return gsap.context(() => {
        const heroHeading = root.querySelector('[data-gsap-text="hero-heading"]');
        const heroSubtitle = root.querySelector('[data-gsap-text="hero-subtitle"]');
        const heroCtas = root.querySelectorAll('[data-gsap-text="hero-cta"]');

        if (heroHeading || heroSubtitle || heroCtas.length) {
            const heroTl = gsap.timeline({ defaults: { ease: 'power3.out' } });

            if (heroHeading) {
                heroTl.fromTo(
                    heroHeading,
                    { y: 40, opacity: 0, scale: 0.94, rotate: -1.5 },
                    {
                        y: 0,
                        opacity: 1,
                        scale: 1,
                        rotate: 0,
                        duration: 0.75,
                        ease: 'back.out(1.4)',
                        clearProps: 'transform',
                    }
                );
            }

            if (heroSubtitle) {
                heroTl.fromTo(
                    heroSubtitle,
                    { y: 24, opacity: 0 },
                    {
                        y: 0,
                        opacity: 1,
                        duration: 0.65,
                        clearProps: 'transform',
                    },
                    heroHeading ? '-=0.48' : 0
                );
            }

            if (heroCtas.length) {
                heroTl.fromTo(
                    heroCtas,
                    { y: 18, opacity: 0, scale: 0.94 },
                    {
                        y: 0,
                        opacity: 1,
                        scale: 1,
                        duration: 0.5,
                        stagger: 0.1,
                        ease: 'back.out(1.5)',
                        clearProps: 'transform',
                    },
                    '-=0.4'
                );
            }
        }

        const ribbon = root.querySelector('[data-gsap-text="ribbon"]');
        if (ribbon) {
            gsap.fromTo(
                ribbon,
                { opacity: 0, y: 18 },
                {
                    opacity: 1,
                    y: 0,
                    duration: 0.55,
                    ease: 'power2.out',
                    clearProps: 'transform',
                    scrollTrigger: {
                        trigger: ribbon,
                        start: 'top 94%',
                        once: true,
                    },
                }
            );
        }

        root.querySelectorAll('[data-gsap-text="section-title"]').forEach((el) => {
            gsap.fromTo(
                el,
                { y: 32, opacity: 0, scale: 0.96 },
                {
                    y: 0,
                    opacity: 1,
                    scale: 1,
                    duration: 0.65,
                    ease: 'back.out(1.35)',
                    clearProps: 'transform',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 90%',
                        once: true,
                    },
                }
            );
        });

        root.querySelectorAll('[data-gsap-text="section-subtitle"]').forEach((el) => {
            gsap.fromTo(
                el,
                { y: 22, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.6,
                    delay: 0.1,
                    ease: 'power3.out',
                    clearProps: 'transform',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 90%',
                        once: true,
                    },
                }
            );
        });

        root.querySelectorAll('[data-gsap-text="banner-title"]').forEach((el) => {
            gsap.fromTo(
                el,
                { x: -24, opacity: 0 },
                {
                    x: 0,
                    opacity: 1,
                    duration: 0.6,
                    ease: 'power3.out',
                    clearProps: 'transform',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 92%',
                        once: true,
                    },
                }
            );
        });

        root.querySelectorAll('[data-gsap-text="banner-subtitle"]').forEach((el) => {
            gsap.fromTo(
                el,
                { x: -18, opacity: 0 },
                {
                    x: 0,
                    opacity: 1,
                    duration: 0.58,
                    delay: 0.08,
                    ease: 'power3.out',
                    clearProps: 'transform',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 92%',
                        once: true,
                    },
                }
            );
        });

        const storyBodies = root.querySelectorAll('[data-gsap-text="body"]');
        if (storyBodies.length) {
            gsap.fromTo(
                storyBodies,
                { y: 24, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.6,
                    stagger: 0.12,
                    ease: 'power3.out',
                    clearProps: 'transform',
                    scrollTrigger: {
                        trigger: storyBodies[0],
                        start: 'top 90%',
                        once: true,
                    },
                }
            );
        }

        root.querySelectorAll('[data-gsap-text="cta"]').forEach((el) => {
            gsap.fromTo(
                el,
                { y: 16, opacity: 0, scale: 0.95 },
                {
                    y: 0,
                    opacity: 1,
                    scale: 1,
                    duration: 0.5,
                    delay: 0.12,
                    ease: 'back.out(1.5)',
                    clearProps: 'transform',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 92%',
                        once: true,
                    },
                }
            );
        });

        root.querySelectorAll('[data-motion-grid]').forEach((grid) => {
            const cardTexts = grid.querySelectorAll('[data-gsap-text="card"]');
            if (!cardTexts.length) return;

            gsap.fromTo(
                cardTexts,
                { y: 14, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.45,
                    stagger: 0.04,
                    delay: 0.14,
                    ease: 'power2.out',
                    clearProps: 'transform',
                    scrollTrigger: {
                        trigger: grid,
                        start: 'top 88%',
                        once: true,
                    },
                }
            );
        });
    }, root);
}

function setupMotionCardAnimations(root) {
    const cleanups = [];
    const springReveal = { type: 'spring', stiffness: 255, damping: 22 };
    const springHoverIn = { type: 'spring', stiffness: 360, damping: 24 };
    const springHoverOut = { type: 'spring', stiffness: 320, damping: 26 };

    const heroBurger = root.querySelector('[data-motion-card="hero-burger"]');
    if (heroBurger) {
        const ctrl = animate(
            heroBurger,
            { opacity: [0, 1], x: [36, 0], scale: [0.9, 1], rotate: [3, 0] },
            { type: 'spring', stiffness: 220, damping: 20, delay: 0.12 }
        );
        cleanups.push(() => ctrl.stop());
    }

    const whyGrid = root.querySelector('[data-motion-grid="why"]');
    const whyCards = whyGrid ? Array.from(whyGrid.querySelectorAll('[data-motion-card="why"]')) : [];
    if (whyGrid && whyCards.length) {
        if (isAlreadyScrolledAboveViewport(whyGrid)) {
            whyCards.forEach((card) => {
                card.style.opacity = '1';
            });
        } else {
            whyCards.forEach((card) => {
                card.style.opacity = '0';
            });
            const stopInView = inView(
                whyGrid,
                () => {
                    animate(
                        whyCards,
                        { opacity: [0, 1], y: [36, 0], scale: [0.92, 1], rotate: [-1.5, 0] },
                        { ...springReveal, delay: stagger(0.08) }
                    );
                },
                { amount: 0.08 }
            );
            cleanups.push(stopInView);
        }

        whyCards.forEach((card) => {
            cleanups.push(
                hover(card, () => {
                    animate(card, { y: -6, scale: 1.02 }, springHoverIn);
                    return () => animate(card, { y: 0, scale: 1 }, springHoverOut);
                })
            );
        });
    }

    const productGrid = root.querySelector('[data-motion-grid="products"]');
    const productCards = productGrid ? Array.from(productGrid.querySelectorAll('[data-motion-card="product"]')) : [];
    if (productGrid && productCards.length) {
        if (isAlreadyScrolledAboveViewport(productGrid)) {
            productCards.forEach((card) => {
                card.style.opacity = '1';
            });
        } else {
            productCards.forEach((card) => {
                card.style.opacity = '0';
            });
            const stopInView = inView(
                productGrid,
                () => {
                    animate(
                        productCards,
                        { opacity: [0, 1], y: [40, 0], scale: [0.92, 1] },
                        { ...springReveal, delay: stagger(0.09) }
                    );
                },
                { amount: 0.08 }
            );
            cleanups.push(stopInView);
        }

        productCards.forEach((card) => {
            cleanups.push(
                hover(card, () => {
                    animate(card, { y: -6, scale: 1.018 }, springHoverIn);
                    return () => animate(card, { y: 0, scale: 1 }, springHoverOut);
                })
            );
        });
    }

    root.querySelectorAll('[data-motion-card="banner"], [data-motion-card="story"]').forEach((card) => {
        const isBanner = card.getAttribute('data-motion-card') === 'banner';
        if (isAlreadyScrolledAboveViewport(card)) {
            card.style.opacity = '1';
        } else {
            card.style.opacity = '0';
            const stopInView = inView(
                card,
                () => {
                    animate(
                        card,
                        { opacity: [0, 1], y: [30, 0], scale: [0.96, 1] },
                        { type: 'spring', stiffness: 230, damping: 24 }
                    );
                },
                { amount: 0.08 }
            );
            cleanups.push(stopInView);
        }

        if (isBanner) {
            cleanups.push(
                hover(card, () => {
                    animate(card, { y: -4, scale: 1.008 }, springHoverIn);
                    return () => animate(card, { y: 0, scale: 1 }, springHoverOut);
                })
            );
        }
    });

    const mediaCard = root.querySelector('[data-motion-card="media"]');
    if (mediaCard) {
        if (isAlreadyScrolledAboveViewport(mediaCard)) {
            mediaCard.style.opacity = '1';
        } else {
            mediaCard.style.opacity = '0';
            const stopInView = inView(
                mediaCard,
                () => {
                    animate(
                        mediaCard,
                        { opacity: [0, 1], x: [30, 0], scale: [0.94, 1], rotate: [1.5, 0] },
                        { type: 'spring', stiffness: 220, damping: 22, delay: 0.08 }
                    );
                },
                { amount: 0.08 }
            );
            cleanups.push(stopInView);
        }

        cleanups.push(
            hover(mediaCard, () => {
                animate(mediaCard, { y: -4, scale: 1.02, rotate: -0.8 }, springHoverIn);
                return () => animate(mediaCard, { y: 0, scale: 1, rotate: 0 }, springHoverOut);
            })
        );
    }

    return () => {
        cleanups.forEach((fn) => {
            if (typeof fn === 'function') fn();
        });
    };
}

function initHomeAnimations() {
    if (activeCleanup) {
        activeCleanup();
        activeCleanup = null;
    }

    const root = document.querySelector('[data-home-page]');
    if (!root) return;

    if (isReducedMotionPreferred()) {
        root.querySelectorAll('[data-gsap-text], [data-motion-card]').forEach((el) => {
            el.style.opacity = '1';
            el.style.transform = '';
        });
        return;
    }

    const gsapCtx = setupGsapTextAnimations(root);
    const cleanupMotion = setupMotionCardAnimations(root);

    window.requestAnimationFrame(() => {
        ScrollTrigger.refresh();
    });

    activeCleanup = () => {
        gsapCtx.revert();
        cleanupMotion();
    };
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHomeAnimations);
} else {
    initHomeAnimations();
}

if (!window._tbHomeAnimPjaxBound) {
    window._tbHomeAnimPjaxBound = true;
    window.addEventListener('tb:pjax:loaded', initHomeAnimations);
}
