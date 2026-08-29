import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('carousel', (total, interval) => ({
    total,
    active: 1, // index into extended track (0 = clone of last, 1..total = real items, total+1 = clone of first)
    dragging: false,
    jumping: false,
    wasDragging: false,
    startX: 0,
    deltaX: 0,
    timer: null,

    init() {
        this.restart();
    },

    restart() {
        clearInterval(this.timer);
        if (this.total > 1 && interval) {
            this.timer = setInterval(() => this.next(), interval);
        }
    },

    next() {
        this.active++;
        this.settle();
    },

    prev() {
        this.active--;
        this.settle();
    },

    manualNext() {
        this.next();
        this.restart();
    },

    manualPrev() {
        this.prev();
        this.restart();
    },

    goTo(realIndex) {
        this.active = realIndex + 1;
        this.restart();
    },

    settle() {
        setTimeout(() => {
            if (this.active >= this.total + 1) {
                this.jumping = true;
                this.active = 1;
            } else if (this.active <= 0) {
                this.jumping = true;
                this.active = this.total;
            }
            if (this.jumping) {
                requestAnimationFrame(() => requestAnimationFrame(() => {
                    this.jumping = false;
                }));
            }
        }, 700);
    },

    realIndex() {
        let r = (this.active - 1) % this.total;
        if (r < 0) r += this.total;
        return r;
    },

    trackTransition() {
        return (this.dragging || this.jumping) ? 'none' : 'transform 700ms cubic-bezier(0.65,0,0.35,1)';
    },

    dragStart(e) {
        this.dragging = true;
        this.startX = e.touches ? e.touches[0].clientX : e.clientX;
        this.deltaX = 0;
        clearInterval(this.timer);
    },

    dragMove(e) {
        if (!this.dragging) return;
        const x = e.touches ? e.touches[0].clientX : e.clientX;
        this.deltaX = x - this.startX;
    },

    dragEnd() {
        if (!this.dragging) return;
        this.dragging = false;
        if (Math.abs(this.deltaX) > 5) {
            this.wasDragging = true;
            setTimeout(() => { this.wasDragging = false; }, 50);
        }
        const threshold = 60;
        if (this.deltaX < -threshold) {
            this.active++;
            this.settle();
        } else if (this.deltaX > threshold) {
            this.active--;
            this.settle();
        }
        this.deltaX = 0;
        this.restart();
    },
}));

Alpine.data('photoLightbox', (images) => ({
    open: false,
    index: 0,
    images,

    show(i) {
        this.index = i;
        this.open = true;
    },

    close() {
        this.open = false;
    },

    next() {
        this.index = (this.index + 1) % this.images.length;
    },

    prev() {
        this.index = (this.index - 1 + this.images.length) % this.images.length;
    },

    get current() {
        return this.images[this.index];
    },
}));

Alpine.data('bencanaViewer', (initialSlug) => ({
    activeSlug: initialSlug,
    zoom: 1,
    panX: 0,
    panY: 0,
    dragging: false,
    startX: 0,
    startY: 0,

    select(slug, title) {
        if (slug === this.activeSlug) return;
        this.activeSlug = slug;
        this.reset();

        const url = '/bencana/' + slug;
        if (window.location.pathname !== url) {
            history.pushState({ slug }, '', url);
        }
        if (title) document.title = title;
    },

    syncFromUrl() {
        const match = window.location.pathname.match(/^\/bencana\/([^/]+)/);
        if (match) {
            this.activeSlug = match[1];
            this.reset();
        }
    },

    reset() {
        this.zoom = 1;
        this.panX = 0;
        this.panY = 0;
    },

    zoomIn() {
        this.zoom = Math.min(this.zoom + 0.5, 4);
    },

    zoomOut() {
        this.zoom = Math.max(this.zoom - 0.5, 1);
        if (this.zoom === 1) {
            this.panX = 0;
            this.panY = 0;
        }
    },

    onWheel(e) {
        e.preventDefault();
        if (e.deltaY < 0) {
            this.zoomIn();
        } else {
            this.zoomOut();
        }
    },

    dragStart(e) {
        if (this.zoom <= 1) return;
        this.dragging = true;
        const point = e.touches ? e.touches[0] : e;
        this.startX = point.clientX - this.panX;
        this.startY = point.clientY - this.panY;
    },

    dragMove(e) {
        if (!this.dragging) return;
        const point = e.touches ? e.touches[0] : e;
        this.panX = point.clientX - this.startX;
        this.panY = point.clientY - this.startY;
    },

    dragEnd() {
        this.dragging = false;
    },
}));

Alpine.start();

// Fade-out before navigating away, for contexts where the native
// cross-document View Transitions API won't fire (unsupported browser, or
// an insecure origin like a plain-http .test domain — cross-document view
// transitions require a secure context). The fade-in on load is pure CSS
// (see .page-fade in app.css) so it never depends on this JS running.
if (!('startViewTransition' in document) || !window.isSecureContext) {
    document.addEventListener('click', (e) => {
        if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;

        const link = e.target.closest('a');
        if (!link || !link.href) return;
        if (link.target && link.target !== '_self') return;
        if (link.hasAttribute('download')) return;

        const url = new URL(link.href, window.location.href);
        if (url.origin !== window.location.origin) return;
        if (url.pathname === window.location.pathname && url.search === window.location.search && url.hash) return;

        e.preventDefault();
        document.documentElement.classList.add('page-fade-out');
        setTimeout(() => { window.location.href = link.href; }, 150);
    });
}
