import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { animate, hover, inView, stagger } from 'motion';

gsap.registerPlugin(ScrollTrigger);

let activeCleanup = null;

function isReducedMotionPreferred() {
    return (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) || window.innerWidth < 640;
}

function isAlreadyScrolledAboveViewport(el) {
    const rect = el.getBoundingClientRect();
    return rect.bottom <= 0;
}

function isElementDisplayed(el) {
    return Boolean(el && (el.offsetParent !== null || el.getClientRects().length > 0));
}

function getColumnCount() {
    return window.innerWidth >= 1024 ? 4 : 2;
}

function getActiveReviewTiltDeg(card) {
    const raw = parseFloat(card.dataset.tiltDeg || '0');
    if (!Number.isFinite(raw)) return 0;
    const isDesktopCard = Boolean(card.closest('.lg\\:block'));
    if (isDesktopCard) {
        return window.innerWidth >= 1024 ? raw : 0;
    }
    return window.innerWidth >= 640 && window.innerWidth < 1024 ? raw : 0;
}

function setupGsapTextAnimations(root) {
    return gsap.context(() => {
        const heroHeading = root.querySelector('[data-gsap-text="hero-heading"]');
        const heroSubtitle = root.querySelector('[data-gsap-text="hero-subtitle"]');
        const heroCtas = Array.from(root.querySelectorAll('[data-gsap-text="hero-cta"]'));

        if (heroHeading || heroSubtitle || heroCtas.length) {
            const heroAnchor = heroHeading || heroSubtitle || heroCtas[0];
            if (heroAnchor && isAlreadyScrolledAboveViewport(heroAnchor)) {
                [heroHeading, heroSubtitle, ...heroCtas].filter(Boolean).forEach((el) => {
                    gsap.set(el, { opacity: 1, clearProps: 'transform' });
                });
            } else {
                const heroTl = gsap.timeline({ defaults: { ease: 'power3.out' } });

                if (heroHeading) {
                    heroTl.fromTo(
                        heroHeading,
                        { y: 38, opacity: 0, scale: 0.94, rotate: -1.4 },
                        {
                            y: 0,
                            opacity: 1,
                            scale: 1,
                            rotate: 0,
                            duration: 0.72,
                            ease: 'back.out(1.4)',
                            clearProps: 'transform',
                        }
                    );
                }

                if (heroSubtitle) {
                    heroTl.fromTo(
                        heroSubtitle,
                        { y: 22, opacity: 0 },
                        {
                            y: 0,
                            opacity: 1,
                            duration: 0.62,
                            clearProps: 'transform',
                        },
                        heroHeading ? '-=0.46' : 0
                    );
                }

                if (heroCtas.length) {
                    heroTl.fromTo(
                        heroCtas,
                        { y: 16, opacity: 0, scale: 0.94 },
                        {
                            y: 0,
                            opacity: 1,
                            scale: 1,
                            duration: 0.48,
                            stagger: 0.09,
                            ease: 'back.out(1.5)',
                            clearProps: 'transform',
                        },
                        '-=0.38'
                    );
                }
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
                        start: 'top 91%',
                        once: true,
                    },
                }
            );
        });

        root.querySelectorAll('[data-gsap-text="section-subtitle"]').forEach((el) => {
            gsap.fromTo(
                el,
                { y: 20, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.58,
                    delay: 0.08,
                    ease: 'power3.out',
                    clearProps: 'transform',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 91%',
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

        const bodyGroups = new Map();
        root.querySelectorAll('[data-gsap-text="body"]').forEach((el) => {
            const container = el.closest('[data-motion-card], section') || root;
            if (!bodyGroups.has(container)) bodyGroups.set(container, []);
            bodyGroups.get(container).push(el);
        });

        bodyGroups.forEach((els, container) => {
            gsap.fromTo(
                els,
                { y: 20, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.56,
                    stagger: 0.1,
                    ease: 'power3.out',
                    clearProps: 'transform',
                    scrollTrigger: {
                        trigger: els[0] || container,
                        start: 'top 91%',
                        once: true,
                    },
                }
            );
        });

        const pillsWrap = root.querySelector('[data-gsap-pills]');
        if (pillsWrap) {
            const pills = pillsWrap.querySelectorAll('[data-gsap-text="pill"]');
            if (pills.length) {
                gsap.fromTo(
                    pills,
                    { y: 12, opacity: 0, scale: 0.94 },
                    {
                        y: 0,
                        opacity: 1,
                        scale: 1,
                        duration: 0.42,
                        stagger: 0.045,
                        ease: 'back.out(1.4)',
                        clearProps: 'transform',
                        scrollTrigger: {
                            trigger: pillsWrap,
                            start: 'top 92%',
                            once: true,
                        },
                    }
                );
            }
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
                    delay: 0.1,
                    ease: 'back.out(1.5)',
                    clearProps: 'transform',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 93%',
                        once: true,
                    },
                }
            );
        });

        const cols = getColumnCount();
        root.querySelectorAll('[data-motion-card]').forEach((card, cardIdx) => {
            if (!isElementDisplayed(card)) return;
            const cardTexts = card.querySelectorAll('[data-gsap-text="card"]');
            if (!cardTexts.length) return;

            const isProductOrWhy = card.matches('[data-motion-card="product"], [data-motion-card="why"]');
            const colDelay = isProductOrWhy ? (cardIdx % cols) * 0.05 : 0.06;

            gsap.fromTo(
                cardTexts,
                { y: 12, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.42,
                    stagger: 0.04,
                    delay: 0.1 + colDelay,
                    ease: 'power2.out',
                    clearProps: 'transform',
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 93%',
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
        if (isAlreadyScrolledAboveViewport(heroBurger)) {
            heroBurger.style.opacity = '1';
        } else {
            const ctrl = animate(
                heroBurger,
                { opacity: [0, 1], x: [36, 0], scale: [0.9, 1], rotate: [3, 0] },
                { type: 'spring', stiffness: 220, damping: 20, delay: 0.12 }
            );
            cleanups.push(() => ctrl.stop());
        }
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
            cleanups.push(
                inView(
                    whyGrid,
                    () => {
                        animate(
                            whyCards,
                            { opacity: [0, 1], y: [36, 0], scale: [0.92, 1], rotate: [-1.5, 0] },
                            { ...springReveal, delay: stagger(0.08) }
                        );
                    },
                    { amount: 0.08 }
                )
            );
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

    const cols = getColumnCount();
    const productCards = Array.from(root.querySelectorAll('[data-motion-card="product"]'));
    productCards.forEach((card, idx) => {
        if (isAlreadyScrolledAboveViewport(card)) {
            card.style.opacity = '1';
        } else {
            card.style.opacity = '0';
            cleanups.push(
                inView(
                    card,
                    () => {
                        animate(
                            card,
                            { opacity: [0, 1], y: [36, 0], scale: [0.92, 1] },
                            { ...springReveal, delay: (idx % cols) * 0.065 }
                        );
                    },
                    { amount: 0.06 }
                )
            );
        }

        cleanups.push(
            hover(card, () => {
                animate(card, { y: -6, scale: 1.018 }, springHoverIn);
                return () => animate(card, { y: 0, scale: 1 }, springHoverOut);
            })
        );
    });

    const statsGrid = root.querySelector('[data-motion-grid="stats"]');
    const statCards = statsGrid ? Array.from(statsGrid.querySelectorAll('[data-motion-card="stat"]')) : [];
    if (statsGrid && statCards.length) {
        if (isAlreadyScrolledAboveViewport(statsGrid)) {
            statCards.forEach((card) => {
                card.style.opacity = '1';
            });
        } else {
            statCards.forEach((card) => {
                card.style.opacity = '0';
            });
            cleanups.push(
                inView(
                    statsGrid,
                    () => {
                        animate(
                            statCards,
                            { opacity: [0, 1], y: [22, 0], scale: [0.9, 1] },
                            { ...springReveal, delay: stagger(0.08) }
                        );
                    },
                    { amount: 0.1 }
                )
            );
        }

        statCards.forEach((card) => {
            cleanups.push(
                hover(card, () => {
                    animate(card, { y: -3, scale: 1.04 }, springHoverIn);
                    return () => animate(card, { y: 0, scale: 1 }, springHoverOut);
                })
            );
        });
    }

    const faqGrid = root.querySelector('[data-motion-grid="faq"]');
    const faqCards = faqGrid ? Array.from(faqGrid.querySelectorAll('[data-motion-card="faq"]')) : [];
    if (faqGrid && faqCards.length) {
        faqCards.forEach((card, idx) => {
            if (isAlreadyScrolledAboveViewport(card)) {
                card.style.opacity = '1';
            } else {
                card.style.opacity = '0';
                cleanups.push(
                    inView(
                        card,
                        () => {
                            animate(
                                card,
                                { opacity: [0, 1], y: [22, 0], scale: [0.97, 1] },
                                { ...springReveal, delay: idx * 0.055 }
                            );
                        },
                        { amount: 0.08 }
                    )
                );
            }

            cleanups.push(
                hover(card, () => {
                    animate(card, { y: -2, scale: 1.008 }, springHoverIn);
                    return () => animate(card, { y: 0, scale: 1 }, springHoverOut);
                })
            );
        });
    }

    root.querySelectorAll('[data-motion-grid="reviews"]').forEach((reviewGrid) => {
        if (!isElementDisplayed(reviewGrid)) return;
        const reviewCards = Array.from(reviewGrid.querySelectorAll('[data-motion-card="review"]'));
        if (!reviewCards.length) return;

        if (isAlreadyScrolledAboveViewport(reviewGrid)) {
            reviewCards.forEach((card) => {
                card.style.opacity = '1';
            });
        } else {
            reviewCards.forEach((card, idx) => {
                card.style.opacity = '0';
                const targetTilt = getActiveReviewTiltDeg(card);
                cleanups.push(
                    inView(
                        card,
                        () => {
                            animate(
                                card,
                                {
                                    opacity: [0, 1],
                                    y: [28, 0],
                                    scale: [0.92, 1],
                                    rotate: [targetTilt - 2, targetTilt],
                                },
                                { ...springReveal, delay: (idx % 4) * 0.07 }
                            );
                        },
                        { amount: 0.08 }
                    )
                );
            });
        }

        reviewCards.forEach((card) => {
            cleanups.push(
                hover(card, () => {
                    animate(card, { y: -6, scale: 1.03, rotate: 0 }, springHoverIn);
                    return () => animate(card, { y: 0, scale: 1, rotate: getActiveReviewTiltDeg(card) }, springHoverOut);
                })
            );
        });
    });

    root.querySelectorAll('[data-motion-card="banner"], [data-motion-card="story"]').forEach((card) => {
        const isBanner = card.getAttribute('data-motion-card') === 'banner';
        if (isAlreadyScrolledAboveViewport(card)) {
            card.style.opacity = '1';
        } else {
            card.style.opacity = '0';
            cleanups.push(
                inView(
                    card,
                    () => {
                        animate(
                            card,
                            { opacity: [0, 1], y: [30, 0], scale: [0.96, 1] },
                            { type: 'spring', stiffness: 230, damping: 24 }
                        );
                    },
                    { amount: 0.06 }
                )
            );
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
            cleanups.push(
                inView(
                    mediaCard,
                    () => {
                        animate(
                            mediaCard,
                            { opacity: [0, 1], x: [30, 0], scale: [0.94, 1], rotate: [1.5, 0] },
                            { type: 'spring', stiffness: 220, damping: 22, delay: 0.08 }
                        );
                    },
                    { amount: 0.08 }
                )
            );
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

function initPublicAnimations() {
    if (activeCleanup) {
        activeCleanup();
        activeCleanup = null;
    }

    const root = document.querySelector('[data-gsap-motion-page]');
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
    document.addEventListener('DOMContentLoaded', initPublicAnimations);
} else {
    initPublicAnimations();
}

if (!window._tbPublicAnimPjaxBound) {
    window._tbPublicAnimPjaxBound = true;
    window.addEventListener('tb:pjax:loaded', initPublicAnimations);
}
