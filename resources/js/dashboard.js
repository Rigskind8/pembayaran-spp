(function () {
    'use strict';

    function getVar(name) {
        return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
    }

    function dashToast(type, title, msg) {
        var container = document.getElementById('dbToasts');
        if (!container) return;

        var toast = document.createElement('div');
        toast.className = 'db-toast';
        var iconClass = type === 's' ? 'fa-check' : 'fa-times';
        toast.innerHTML = '<div class="db-t-ic ' + type + '"><i class="fas ' + iconClass + '"></i></div>' +
            '<div><div class="db-t-ttl">' + title + '</div><div class="db-t-msg">' + msg + '</div></div>';

        container.appendChild(toast);
        setTimeout(function () {
            toast.classList.add('hide');
            setTimeout(function () {
                toast.remove();
            }, 250);
        }, 3500);
    }

    function animateCounters() {
        document.querySelectorAll('[data-count]').forEach(function (el) {
            var target = parseInt(el.getAttribute('data-count'), 10) || 0;
            if (!target) {
                el.textContent = '0';
                return;
            }

            var start = null;
            var duration = 800;

            function step(ts) {
                if (!start) start = ts;
                var progress = Math.min((ts - start) / duration, 1);
                var eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.floor(eased * target);

                if (progress < 1) {
                    requestAnimationFrame(step);
                } else {
                    el.textContent = String(target);
                }
            }

            setTimeout(function () {
                requestAnimationFrame(step);
            }, 300);
        });
    }

    function drawLineChart(canvasId, labels, datasets) {
        var canvas = document.getElementById(canvasId);
        if (!canvas) return;

        var context = canvas.getContext('2d');
        var devicePixelRatio = window.devicePixelRatio || 1;

        function draw() {
            var rect = canvas.parentElement.getBoundingClientRect();
            var width = rect.width;
            var height = 180;
            canvas.width = width * devicePixelRatio;
            canvas.height = height * devicePixelRatio;
            canvas.style.width = width + 'px';
            canvas.style.height = height + 'px';
            context.setTransform(devicePixelRatio, 0, 0, devicePixelRatio, 0, 0);

            var paddingLeft = 50;
            var paddingRight = 16;
            var paddingTop = 16;
            var paddingBottom = 30;
            var chartWidth = width - paddingLeft - paddingRight;
            var chartHeight = height - paddingTop - paddingBottom;
            if (chartWidth <= 0 || chartHeight <= 0) return;

            var values = [];
            datasets.forEach(function (dataset) {
                values = values.concat(dataset.data || []);
            });
            var maxValue = Math.max.apply(null, values.concat([1]));
            maxValue = Math.ceil(maxValue * 1.15);

            var gridColor = getVar('--db-chart-grid') || 'rgba(0,0,0,0.04)';
            var textColor = getVar('--db-chart-txt') || '#8e96a8';

            context.strokeStyle = gridColor;
            context.lineWidth = 1;
            for (var row = 0; row <= 4; row++) {
                var y = paddingTop + chartHeight * (row / 4);
                context.beginPath();
                context.moveTo(paddingLeft, y);
                context.lineTo(width - paddingRight, y);
                context.stroke();
                var value = maxValue * (1 - row / 4);
                context.fillStyle = textColor;
                context.font = '500 10px "DM Mono", monospace';
                context.textAlign = 'right';
                context.fillText(Math.round(value).toString(), paddingLeft - 8, y + 4);
            }

            context.fillStyle = textColor;
            context.font = '600 10px "DM Sans", sans-serif';
            context.textAlign = 'center';
            labels.forEach(function (label, index) {
                var x = labels.length > 1 ? paddingLeft + (chartWidth / (labels.length - 1)) * index : paddingLeft + chartWidth / 2;
                context.fillText(label, x, height - 6);
            });

            datasets.forEach(function (dataset) {
                var series = dataset.data || [];
                if (!series.length) return;

                var points = series.map(function (value, index) {
                    return {
                        x: series.length > 1 ? paddingLeft + (chartWidth / (series.length - 1)) * index : paddingLeft + chartWidth / 2,
                        y: paddingTop + chartHeight * (1 - value / maxValue)
                    };
                });

                context.beginPath();
                context.moveTo(points[0].x, paddingTop + chartHeight);
                points.forEach(function (point) {
                    context.lineTo(point.x, point.y);
                });
                context.lineTo(points[points.length - 1].x, paddingTop + chartHeight);
                context.closePath();

                var fill = context.createLinearGradient(0, paddingTop, 0, paddingTop + chartHeight);
                fill.addColorStop(0, dataset.fill || 'rgba(6,148,162,0.12)');
                fill.addColorStop(1, 'rgba(255,255,255,0)');
                context.fillStyle = fill;
                context.fill();

                context.beginPath();
                points.forEach(function (point, index) {
                    if (index === 0) context.moveTo(point.x, point.y);
                    else context.lineTo(point.x, point.y);
                });
                context.strokeStyle = dataset.color || '#0694a2';
                context.lineWidth = 2.5;
                context.lineJoin = 'round';
                context.lineCap = 'round';
                context.stroke();

                points.forEach(function (point) {
                    context.beginPath();
                    context.arc(point.x, point.y, 4, 0, Math.PI * 2);
                    context.fillStyle = dataset.color || '#0694a2';
                    context.fill();
                    context.beginPath();
                    context.arc(point.x, point.y, 2, 0, Math.PI * 2);
                    context.fillStyle = '#fff';
                    context.fill();
                });
            });
        }

        draw();
        window.addEventListener('resize', draw);
    }

    function drawBarChart(canvasId, labels, datasets) {
        var canvas = document.getElementById(canvasId);
        if (!canvas) return;

        var context = canvas.getContext('2d');
        var devicePixelRatio = window.devicePixelRatio || 1;

        function draw() {
            var rect = canvas.parentElement.getBoundingClientRect();
            var width = rect.width;
            var height = 180;
            canvas.width = width * devicePixelRatio;
            canvas.height = height * devicePixelRatio;
            canvas.style.width = width + 'px';
            canvas.style.height = height + 'px';
            context.setTransform(devicePixelRatio, 0, 0, devicePixelRatio, 0, 0);

            var paddingLeft = 50;
            var paddingRight = 16;
            var paddingTop = 16;
            var paddingBottom = 30;
            var chartWidth = width - paddingLeft - paddingRight;
            var chartHeight = height - paddingTop - paddingBottom;
            if (chartWidth <= 0 || chartHeight <= 0) return;

            var data = (datasets[0] && datasets[0].data) || [];
            var maxValue = Math.max.apply(null, data.concat([1]));
            maxValue = Math.ceil(maxValue * 1.15);

            var gridColor = getVar('--db-chart-grid') || 'rgba(0,0,0,0.04)';
            var textColor = getVar('--db-chart-txt') || '#8e96a8';

            context.strokeStyle = gridColor;
            context.lineWidth = 1;
            for (var row = 0; row <= 4; row++) {
                var y = paddingTop + chartHeight * (row / 4);
                context.beginPath();
                context.moveTo(paddingLeft, y);
                context.lineTo(width - paddingRight, y);
                context.stroke();
                var value = maxValue * (1 - row / 4);
                context.fillStyle = textColor;
                context.font = '500 10px "DM Mono", monospace';
                context.textAlign = 'right';
                var label = value >= 1e6 ? (value / 1e6).toFixed(1) + 'jt' : value >= 1e3 ? (value / 1e3).toFixed(0) + 'rb' : Math.round(value).toString();
                context.fillText(label, paddingLeft - 8, y + 4);
            }

            context.fillStyle = textColor;
            context.font = '600 10px "DM Sans", sans-serif';
            context.textAlign = 'center';
            labels.forEach(function (label, index) {
                var barWidth = Math.min(32, chartWidth / Math.max(data.length, 1) * 0.6);
                var gap = (chartWidth - barWidth * Math.max(data.length, 1)) / (Math.max(data.length, 1) + 1);
                context.fillText(label, paddingLeft + gap + (barWidth + gap) * index + barWidth / 2, height - 6);
            });

            if (!data.length) return;
            var barWidth = Math.min(32, chartWidth / data.length * 0.6);
            var gap = (chartWidth - barWidth * data.length) / (data.length + 1);
            var color = (datasets[0] && datasets[0].color) || '#0694a2';
            var colorEnd = (datasets[0] && datasets[0].colorEnd) || '#7edce2';

            data.forEach(function (value, index) {
                var x = paddingLeft + gap + (barWidth + gap) * index;
                var barHeight = Math.max(0, chartHeight * (value / maxValue));
                var y = paddingTop + chartHeight - barHeight;
                var radius = Math.min(4, barWidth / 2);

                var gradient = context.createLinearGradient(x, y, x, paddingTop + chartHeight);
                gradient.addColorStop(0, color);
                gradient.addColorStop(1, colorEnd);
                context.fillStyle = gradient;

                context.beginPath();
                context.moveTo(x + radius, y);
                context.lineTo(x + barWidth - radius, y);
                context.quadraticCurveTo(x + barWidth, y, x + barWidth, y + radius);
                context.lineTo(x + barWidth, paddingTop + chartHeight);
                context.lineTo(x, paddingTop + chartHeight);
                context.lineTo(x, y + radius);
                context.quadraticCurveTo(x, y, x + radius, y);
                context.fill();
            });
        }

        draw();
        window.addEventListener('resize', draw);
    }

    function initCharts() {
        var data = window.__dashData || {};
        if (data.attendanceTrend) {
            drawLineChart('chartAtt', data.attendanceTrend.labels || [], [
                { data: data.attendanceTrend.hadir || [], color: '#057a55', fill: 'rgba(5,122,85,0.12)' },
                { data: data.attendanceTrend.alpha || [], color: '#c81e1e', fill: 'rgba(200,30,30,0.08)' }
            ]);
        }
        if (data.revenueTrend) {
            drawBarChart('chartRev', data.revenueTrend.labels || [], [
                { data: data.revenueTrend.totals || [], color: '#0694a2', colorEnd: '#7edce2' }
            ]);
        }
        window.__dashChartsDrawn = true;
    }

    function bindSidebarCollapse() {
        var app = document.getElementById('dashApp');
        var sidebar = document.getElementById('dashSb');
        var toggle = document.querySelector('.db-hamburger');
        var overlay = document.querySelector('.sb-overlay');

        if (!app || !sidebar || !toggle || !overlay) return;

        toggle.addEventListener('click', function () {
            app.classList.toggle('sb-open');
            sidebar.classList.toggle('db-open'); // For mobile transform
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', function () {
            app.classList.remove('sb-open');
            sidebar.classList.remove('db-open');
            overlay.classList.remove('show');
        });
    }

    function bindSidebarHover() {
        var app = document.getElementById('dashApp');
        var sidebar = document.getElementById('dashSb');
        if (!app || !sidebar) return;

        var isDesktop = function () { return window.innerWidth > 768; };

        sidebar.addEventListener('mouseenter', function () {
            if (isDesktop()) {
                app.classList.add('sb-open');
            }
        });

        sidebar.addEventListener('mouseleave', function () {
            if (isDesktop()) {
                app.classList.remove('sb-open');
            }
        });
    }

    function boot() {
        animateCounters();
        bindSidebarCollapse();
        bindSidebarHover();
        initCharts();

        var flashes = window.__dashFlash || {};
        if (flashes.success) dashToast('s', 'Info', flashes.success);
        if (flashes.error) dashToast('e', 'Error', flashes.error);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
