(() => {
    'use strict';

    document.documentElement.classList.add('js');

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (window.AOS) {
        window.AOS.init({
            duration: 700,
            easing: 'ease-out-cubic',
            offset: 80,
            once: true,
            disable: reduceMotion,
        });
    }

    const toggle = document.querySelector('[data-nav-toggle]');
    const menu = document.querySelector('[data-nav-menu]');

    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            const isOpen = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', String(!isOpen));
            menu.classList.toggle('is-open', !isOpen);
        });
    }

    const counters = Array.from(document.querySelectorAll('[data-count]'));

    const runCounter = (el) => {
        const finalText = el.textContent.trim();
        const match = finalText.match(/^(\d+)/);

        if (!match || reduceMotion) {
            return;
        }

        const target = Number(match[1]);
        const suffix = finalText.slice(match[1].length);
        const duration = 900;
        const start = performance.now();

        const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = String(Math.round(target * eased)) + suffix;

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = finalText;
            }
        };

        requestAnimationFrame(step);
    };

    if (counters.length && 'IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    runCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });

        counters.forEach((el) => counterObserver.observe(el));
    }

    const search = document.querySelector('[data-plant-search]');
    const chips = Array.from(document.querySelectorAll('[data-plant-filter]'));
    const rows = Array.from(document.querySelectorAll('[data-plant-row]'));
    const empty = document.querySelector('[data-plant-empty]');
    const tableBody = document.querySelector('[data-plant-body]');

    if (!rows.length) {
        return;
    }

    let activeStatus = 'semua';

    const applyFilter = () => {
        const keyword = search ? search.value.trim().toLowerCase() : '';
        let visible = 0;

        rows.forEach((row) => {
            const status = row.getAttribute('data-status') || '';
            const matchesStatus = activeStatus === 'semua' || status === activeStatus;
            const matchesKeyword = !keyword || row.textContent.toLowerCase().includes(keyword);
            const show = matchesStatus && matchesKeyword;

            row.hidden = !show;
            if (show) {
                visible += 1;
            }
        });

        if (empty) {
            empty.hidden = visible !== 0;
        }

        if (tableBody && !reduceMotion) {
            tableBody.classList.remove('is-refreshing');
            void tableBody.offsetWidth;
            tableBody.classList.add('is-refreshing');
        }
    };

    if (search) {
        search.addEventListener('input', applyFilter);
    }

    chips.forEach((chip) => {
        chip.addEventListener('click', () => {
            activeStatus = chip.getAttribute('data-plant-filter') || 'semua';

            chips.forEach((item) => {
                const isActive = item === chip;
                item.classList.toggle('is-active', isActive);
                item.setAttribute('aria-pressed', String(isActive));
            });

            applyFilter();
        });
    });
})();
