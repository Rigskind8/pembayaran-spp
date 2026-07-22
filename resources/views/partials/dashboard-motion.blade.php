<style>
.dm-reveal {
    opacity: 0;
    transform: translateY(14px);
    transition: opacity .45s ease, transform .45s ease;
}
.dm-reveal.dm-visible {
    opacity: 1;
    transform: translateY(0);
}
.dm-skeleton {
    position: relative;
    overflow: hidden;
}
.dm-skeleton::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(148,163,184,.22) 50%, rgba(255,255,255,0) 100%);
    transform: translateX(-100%);
    animation: dmShimmer .9s ease-in-out infinite;
    pointer-events: none;
}
@keyframes dmShimmer {
    to { transform: translateX(100%); }
}
.dm-feed-item {
    opacity: 0;
    transform: translateY(-6px);
    transition: opacity .3s ease, transform .3s ease;
}
.dm-feed-item.dm-feed-live {
    opacity: 1;
    transform: translateY(0);
}
.dm-empty-animated {
    animation: dmEmptyIn .45s ease both;
}
@keyframes dmEmptyIn {
    from { opacity: 0; transform: scale(.98); }
    to { opacity: 1; transform: scale(1); }
}
.dm-tilt {
    transform-style: preserve-3d;
    will-change: transform;
}
.dm-transition-mask {
    position: fixed;
    inset: 0;
    background: var(--bg, #f3f6fb);
    opacity: 0;
    pointer-events: none;
    z-index: 9998;
    transition: opacity .22s ease;
}
.dm-transition-mask.dm-on {
    opacity: 1;
}
@media (max-width: 640px) {
    .dm-floating-ring { right: 12px; bottom: 12px; }
}
</style>

<script>
(function () {
    if (window.__dashboardMotionInit) return;
    window.__dashboardMotionInit = true;

    function clamp(v, min, max) {
        return Math.max(min, Math.min(max, v));
    }

    function parseDisplayNumber(text) {
        if (!text) return null;
        var raw = String(text).trim();
        if (!/[0-9]/.test(raw)) return null;
        var prefix = '';
        var suffix = '';
        var firstDigit = raw.search(/[0-9]/);
        var lastDigit = Math.max(raw.lastIndexOf('0'), raw.lastIndexOf('1'), raw.lastIndexOf('2'), raw.lastIndexOf('3'), raw.lastIndexOf('4'), raw.lastIndexOf('5'), raw.lastIndexOf('6'), raw.lastIndexOf('7'), raw.lastIndexOf('8'), raw.lastIndexOf('9'));
        if (firstDigit < 0 || lastDigit < 0) return null;
        prefix = raw.slice(0, firstDigit);
        suffix = raw.slice(lastDigit + 1);

        var hasIdFormat = raw.indexOf('.') >= 0 || raw.indexOf(',') >= 0;
        var digitsOnly = raw.replace(/[^0-9]/g, '');
        if (!digitsOnly) return null;
        var value = parseInt(digitsOnly, 10);
        if (!Number.isFinite(value)) return null;

        return {
            value: value,
            prefix: prefix,
            suffix: suffix,
            hasIdFormat: hasIdFormat
        };
    }

    function formatNumber(val, hasIdFormat) {
        if (!hasIdFormat) return String(val);
        return Number(val).toLocaleString('id-ID');
    }

    function countUpElement(el, duration) {
        if (!el || el.dataset.dmCounted === '1') return;
        var parsed = parseDisplayNumber(el.textContent);
        if (!parsed) return;
        if (parsed.value > 1000000000) return;

        var start = performance.now();
        var total = parsed.value;
        el.dataset.dmCounted = '1';

        function tick(now) {
            var p = clamp((now - start) / duration, 0, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            var current = Math.round(total * eased);
            el.textContent = parsed.prefix + formatNumber(current, parsed.hasIdFormat) + parsed.suffix;
            if (p < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    function addStaggerReveal() {
        var groups = [
            '.stats5 .sc',
            '.kp-stats .kp-sc',
            '.stats-row .stat-card',
            '.grid .card',
            '.list-wrap',
            '.overview-card',
            '.brochure-card',
            '.kp-card'
        ];

        groups.forEach(function (selector) {
            var items = Array.prototype.slice.call(document.querySelectorAll(selector));
            items.forEach(function (item, index) {
                item.classList.add('dm-reveal');
                item.style.transitionDelay = (Math.min(index, 8) * 85) + 'ms';
            });
        });

        var revealItems = document.querySelectorAll('.dm-reveal');
        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries, observer) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('dm-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });
            revealItems.forEach(function (item) { io.observe(item); });
        } else {
            revealItems.forEach(function (item) { item.classList.add('dm-visible'); });
        }
    }

    function applySkeleton() {
        var widgets = document.querySelectorAll('.sc, .kp-sc, .stat-card, .overview-card, .brochure-card, .list-wrap, .kp-card, .card');
        widgets.forEach(function (w) { w.classList.add('dm-skeleton'); });
        setTimeout(function () {
            widgets.forEach(function (w) { w.classList.remove('dm-skeleton'); });
        }, 720);
    }

    function animateCountsOnView() {
        var targets = document.querySelectorAll('[data-count], .sc-val, .kp-sc-val, .stat-val, .v, .kp-abs-val');
        if (!targets.length) return;

        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries, observer) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        countUpElement(entry.target, 850);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.35 });
            targets.forEach(function (el) { io.observe(el); });
        } else {
            targets.forEach(function (el) { countUpElement(el, 850); });
        }
    }

    function animateFeeds() {
        var feedItems = document.querySelectorAll('.feed-item, .kp-act-item, .kp-ann-item, .verif-item, .list-group-item');
        feedItems.forEach(function (item, idx) {
            item.classList.add('dm-feed-item');
            setTimeout(function () { item.classList.add('dm-feed-live'); }, 100 + Math.min(idx, 12) * 90);
        });
    }

    function animateEmptyStates() {
        document.querySelectorAll('.empty, .empty-state, .kp-empty, .kp-ann-empty').forEach(function (el) {
            el.classList.add('dm-empty-animated');
        });
    }

    function attachTilt() {
        var cards = document.querySelectorAll('.sc, .stat-card, .kp-sc');
        cards.forEach(function (card) {
            card.classList.add('dm-tilt');
            card.addEventListener('mousemove', function (ev) {
                if (window.matchMedia('(hover: none)').matches) return;
                var r = card.getBoundingClientRect();
                var x = (ev.clientX - r.left) / r.width;
                var y = (ev.clientY - r.top) / r.height;
                var rx = (0.5 - y) * 5;
                var ry = (x - 0.5) * 6;
                card.style.transform = 'translateY(-2px) rotateX(' + rx.toFixed(2) + 'deg) rotateY(' + ry.toFixed(2) + 'deg)';
            });
            card.addEventListener('mouseleave', function () {
                card.style.transform = '';
            });
        });
    }

    function filterFeedback() {
        var controls = document.querySelectorAll('.ftab, .schedule-tab, .btn-sm, .kp-qa-btn');
        controls.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var parentCard = btn.closest('.card, .list-wrap, .kp-card, .overview-card');
                if (!parentCard) return;
                parentCard.style.transition = 'transform .16s ease, box-shadow .16s ease';
                parentCard.style.transform = 'scale(.994)';
                setTimeout(function () { parentCard.style.transform = ''; }, 160);
            });
        });
    }

    function drawRing(canvas, value) {
        var ctx = canvas.getContext('2d');
        if (!ctx) return;
        var dpr = window.devicePixelRatio || 1;
        var size = 38;
        canvas.width = size * dpr;
        canvas.height = size * dpr;
        canvas.style.width = size + 'px';
        canvas.style.height = size + 'px';
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

        var p = clamp(value / 100, 0, 1);
        var start = -Math.PI / 2;
        var end = start + Math.PI * 2 * p;

        ctx.clearRect(0, 0, size, size);
        ctx.lineWidth = 5;
        ctx.strokeStyle = 'rgba(148,163,184,.28)';
        ctx.beginPath();
        ctx.arc(size / 2, size / 2, 14, 0, Math.PI * 2);
        ctx.stroke();

        var grad = ctx.createLinearGradient(0, 0, size, size);
        grad.addColorStop(0, '#1d4ed8');
        grad.addColorStop(1, '#06b6d4');
        ctx.strokeStyle = grad;
        ctx.beginPath();
        ctx.arc(size / 2, size / 2, 14, start, end);
        ctx.stroke();

        ctx.fillStyle = '#0f172a';
        ctx.font = '700 10px DM Sans, sans-serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText(Math.round(value) + '%', size / 2, size / 2);
    }

    function attachProgressRing() {
        var src = document.querySelector('.dm-progress-source');
        if (!src) return;
        var value = Number(src.getAttribute('data-progress') || 0);
        if (!Number.isFinite(value)) return;
        var label = src.getAttribute('data-progress-label') || 'Target';

        var wrap = document.createElement('div');
        wrap.className = 'dm-floating-ring';
        wrap.innerHTML = '<canvas class="dm-ring-canvas"></canvas><div class="dm-ring-meta"><span>' + label + '</span><strong>Progress</strong></div>';
        document.body.appendChild(wrap);

        var cv = wrap.querySelector('canvas');
        var current = 0;
        var start = performance.now();
        function animate(now) {
            var p = clamp((now - start) / 900, 0, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            current = value * eased;
            drawRing(cv, current);
            if (p < 1) requestAnimationFrame(animate);
        }
        requestAnimationFrame(animate);
    }

    function addPageTransition() {
        var mask = document.createElement('div');
        mask.className = 'dm-transition-mask';
        document.body.appendChild(mask);

        document.addEventListener('click', function (event) {
            var link = event.target.closest('a[href]');
            if (!link) return;
            var href = link.getAttribute('href') || '';
            if (!href || href[0] === '#' || href.indexOf('javascript:') === 0) return;
            if (link.target === '_blank' || link.hasAttribute('download')) return;
            if (link.origin !== window.location.origin) return;
            if (href === window.location.pathname || href === window.location.href) return;

            mask.classList.add('dm-on');
            setTimeout(function () {
                window.location.href = link.href;
            }, 120);
            event.preventDefault();
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        applySkeleton();
        addStaggerReveal();
        animateCountsOnView();
        animateFeeds();
        animateEmptyStates();
        attachTilt();
        filterFeedback();
        addPageTransition();
    });
})();
</script>
