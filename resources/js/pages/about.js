(function () {
    function initAboutCarousel() {
        let currentSlide = 0;
        const totalSlides = 2;
        const autoIntervalMs = 10000;
        const carousel = document.getElementById('about-visi-misi-carousel');
        if (!carousel || carousel.dataset.aboutInit === 'true') return;
        carousel.dataset.aboutInit = 'true';

        const liveRegion = document.getElementById('about-carousel-live');
        const progressBar = document.getElementById('about-carousel-progress');
        const photos = carousel.querySelectorAll('[data-slide-photo]');
        const captions = carousel.querySelectorAll('[data-slide-caption]');
        let clearPrevTimer = null;
        let rafId = null;
        let cycleStartTime = performance.now();
        let isPaused = false;

        function setProgressRatio(ratio) {
            if (!progressBar) return;
            const clamped = Math.max(0, Math.min(1, ratio));
            progressBar.style.transform = 'scaleX(' + clamped.toFixed(4) + ')';
        }

        window.goToAboutSlide = function (nextIndex, isManual, direction) {
            const target = ((nextIndex % totalSlides) + totalSlides) % totalSlides;
            if (target === currentSlide) return;

            const dir = direction === 'prev' ? 'prev' : 'next';

            if (liveRegion) {
                liveRegion.setAttribute('aria-live', isManual ? 'polite' : 'off');
            }

            const previous = currentSlide;
            currentSlide = target;

            if (clearPrevTimer) {
                clearTimeout(clearPrevTimer);
            }

            const prevImg = photos[previous];
            const nextImg = photos[currentSlide];

            photos.forEach(function (img, idx) {
                if (idx !== previous && idx !== currentSlide) {
                    img.classList.remove(
                        'is-active',
                        'is-prev',
                        'is-entering-right',
                        'is-entering-left',
                        'is-leaving-left',
                        'is-leaving-right'
                    );
                }
            });

            if (prevImg) {
                prevImg.classList.remove('is-active', 'is-entering-right', 'is-entering-left', 'is-leaving-left', 'is-leaving-right');
                prevImg.classList.add('is-prev');
            }

            if (nextImg) {
                nextImg.classList.remove('is-active', 'is-prev', 'is-leaving-left', 'is-leaving-right', 'is-entering-right', 'is-entering-left');
                nextImg.classList.add(dir === 'prev' ? 'is-entering-left' : 'is-entering-right');
                // Force reflow so the initial offscreen position commits before sliding in.
                void nextImg.offsetWidth;
                nextImg.classList.remove('is-entering-right', 'is-entering-left');
                nextImg.classList.add('is-active');
            }

            if (prevImg) {
                void prevImg.offsetWidth;
                prevImg.classList.add(dir === 'prev' ? 'is-leaving-right' : 'is-leaving-left');
            }

            clearPrevTimer = setTimeout(function () {
                if (prevImg) {
                    prevImg.classList.remove('is-prev', 'is-leaving-left', 'is-leaving-right');
                }
            }, 720);

            captions.forEach(function (cap, idx) {
                const active = idx === currentSlide;
                cap.classList.toggle('is-active', active);
                if (active) {
                    cap.removeAttribute('aria-hidden');
                } else {
                    cap.setAttribute('aria-hidden', 'true');
                }
            });
        };

        function tickProgress(now) {
            if (isPaused || document.hidden || !document.body.contains(carousel)) {
                rafId = null;
                return;
            }

            const elapsed = now - cycleStartTime;
            if (elapsed >= autoIntervalMs) {
                window.goToAboutSlide(currentSlide + 1, false, 'next');
                cycleStartTime = now;
                setProgressRatio(0);
            } else {
                setProgressRatio(elapsed / autoIntervalMs);
            }

            rafId = requestAnimationFrame(tickProgress);
        }

        function stopAutoSlide() {
            isPaused = true;
            if (rafId !== null) {
                cancelAnimationFrame(rafId);
                rafId = null;
            }
        }

        function startAutoSlide() {
            if (!document.body.contains(carousel)) return;
            isPaused = false;
            cycleStartTime = performance.now();
            setProgressRatio(0);
            if (rafId !== null) {
                cancelAnimationFrame(rafId);
            }
            if (!document.hidden) {
                rafId = requestAnimationFrame(tickProgress);
            }
        }

        window.stepAboutSlide = function (delta) {
            window.goToAboutSlide(currentSlide + delta, true, delta < 0 ? 'prev' : 'next');
            startAutoSlide();
        };

        carousel.addEventListener('focusin', stopAutoSlide);
        carousel.addEventListener('focusout', function (event) {
            if (!carousel.contains(event.relatedTarget)) {
                startAutoSlide();
            }
        });

        if (window._tbAboutVisibilityHandler) {
            document.removeEventListener('visibilitychange', window._tbAboutVisibilityHandler);
        }
        window._tbAboutVisibilityHandler = function () {
            if (!document.body.contains(carousel)) return;
            if (document.hidden) {
                stopAutoSlide();
            } else {
                startAutoSlide();
            }
        };
        document.addEventListener('visibilitychange', window._tbAboutVisibilityHandler);

        carousel.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowLeft') {
                event.preventDefault();
                window.stepAboutSlide(-1);
            } else if (event.key === 'ArrowRight') {
                event.preventDefault();
                window.stepAboutSlide(1);
            }
        });

        let touchStartX = null;
        carousel.addEventListener('touchstart', function (event) {
            if (event.changedTouches && event.changedTouches.length > 0) {
                touchStartX = event.changedTouches[0].clientX;
            }
        }, { passive: true });

        carousel.addEventListener('touchend', function (event) {
            if (touchStartX === null || !event.changedTouches || event.changedTouches.length === 0) return;
            const diffX = event.changedTouches[0].clientX - touchStartX;
            touchStartX = null;
            if (Math.abs(diffX) > 40) {
                window.stepAboutSlide(diffX < 0 ? 1 : -1);
            }
        }, { passive: true });

        startAutoSlide();
    }

    initAboutCarousel();
    if (!window._tbAboutPjaxBound) {
        window._tbAboutPjaxBound = true;
        window.addEventListener('tb:pjax:loaded', initAboutCarousel);
    }
})();
