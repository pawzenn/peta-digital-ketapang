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
        if (this.total > 1) {
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

Alpine.start();
