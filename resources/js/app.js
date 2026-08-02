import './bootstrap';

/* Mobile nav ------------------------------------------------------------- */
const burger = document.querySelector('[data-nav-toggle]');
const nav = document.querySelector('[data-nav]');

if (burger && nav) {
    // `hidden` is display:none, so the open state needs an explicit display class back.
    // The layout declares which one it wants via data-nav ("flex" for the site, "block" for admin).
    const openDisplay = nav.dataset.nav || 'block';

    const setOpen = (open) => {
        nav.classList.toggle('hidden', !open);
        nav.classList.toggle(openDisplay, open);
        burger.setAttribute('aria-expanded', String(open));
    };

    burger.addEventListener('click', () => setOpen(nav.classList.contains('hidden')));

    nav.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 1024) {
                setOpen(false);
            }
        });
    });

    // Resizing up to desktop must not leave the mobile open-state classes behind.
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            nav.classList.remove('hidden', openDisplay);
            burger.setAttribute('aria-expanded', 'false');
        } else if (!nav.classList.contains(openDisplay)) {
            nav.classList.add('hidden');
        }
    });
}

/* Enquiry form: show only the fields the chosen enquiry type needs -------- */
const enquiryForm = document.querySelector('[data-enquiry-form]');

if (enquiryForm) {
    const message = enquiryForm.querySelector('#message');
    let placeholders = {};

    try {
        placeholders = JSON.parse(enquiryForm.dataset.placeholders || '{}');
    } catch {
        placeholders = {};
    }

    const apply = () => {
        const selected = enquiryForm.querySelector('input[name="type"]:checked')?.value;

        enquiryForm.querySelectorAll('[data-when]').forEach((block) => {
            const shown = block.dataset.when.split(' ').includes(selected);
            block.classList.toggle('hidden', !shown);

            // Disabled fields are not submitted, so a hidden cohort or course
            // can never be attached to the wrong kind of enquiry.
            block.querySelectorAll('input, select, textarea').forEach((field) => {
                field.disabled = !shown;
            });
        });

        if (message && placeholders[selected]) {
            message.placeholder = placeholders[selected];
        }
    };

    enquiryForm.querySelectorAll('input[name="type"]').forEach((radio) => {
        radio.addEventListener('change', apply);
    });

    apply();
}

/* Admin off-canvas drawer ------------------------------------------------ */
const drawer = document.querySelector('[data-drawer]');

if (drawer) {
    const backdrop = document.querySelector('[data-drawer-backdrop]');
    const openButton = document.querySelector('[data-drawer-open]');
    const closeButton = document.querySelector('[data-drawer-close]');

    const isDesktop = () => window.matchMedia('(min-width: 1024px)').matches;

    const setDrawer = (open) => {
        drawer.classList.toggle('-translate-x-full', !open);
        backdrop?.classList.toggle('hidden', !open);
        // Stop the page behind the drawer from scrolling under it.
        document.body.classList.toggle('overflow-hidden', open);
        openButton?.setAttribute('aria-expanded', String(open));

        if (open) {
            closeButton?.focus();
        } else if (document.activeElement && drawer.contains(document.activeElement)) {
            openButton?.focus();
        }
    };

    openButton?.addEventListener('click', () => setDrawer(true));
    closeButton?.addEventListener('click', () => setDrawer(false));
    backdrop?.addEventListener('click', () => setDrawer(false));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !drawer.classList.contains('-translate-x-full')) {
            setDrawer(false);
        }
    });

    // Navigating away should not leave the drawer open behind the new page paint.
    drawer.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            if (!isDesktop()) setDrawer(false);
        });
    });

    // At lg the drawer becomes a static column; clear any leftover mobile state.
    window.addEventListener('resize', () => {
        if (isDesktop()) {
            backdrop?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            drawer.classList.add('-translate-x-full');
            openButton?.setAttribute('aria-expanded', 'false');
        }
    });
}

/* Scroll reveal ---------------------------------------------------------- */
const revealables = document.querySelectorAll('.reveal');

if (revealables.length) {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-in');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12 },
    );

    revealables.forEach((el) => observer.observe(el));
}

/* Dismissable flash messages -------------------------------------------- */
document.querySelectorAll('[data-dismiss]').forEach((button) => {
    button.addEventListener('click', () => button.closest('[data-dismissable]')?.remove());
});

/* Admin: confirm destructive submits ------------------------------------- */
document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) {
            event.preventDefault();
        }
    });
});

/* Admin: slug preview from title ---------------------------------------- */
const slugify = (value) =>
    value
        .toLowerCase()
        .normalize('NFD')
        .replace(/[̀-ͯ]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');

document.querySelectorAll('[data-slug-source]').forEach((source) => {
    const target = document.querySelector(source.dataset.slugSource);
    if (!target || target.value) return;

    source.addEventListener('input', () => {
        if (target.dataset.touched) return;
        target.placeholder = slugify(source.value) || 'auto-generated';
    });

    target.addEventListener('input', () => {
        target.dataset.touched = '1';
    });
});
