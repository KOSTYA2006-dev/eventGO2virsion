/**
 * home.js — главная страница: countdown и фото-карусель
 * Дата события передаётся через data-event-date на body или .hero-countdown-card
 */
(function() {
    'use strict';

    let eventDate;
    let countdownInterval;

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    }

    function formatWithPadding(num, maxLength) {
        maxLength = maxLength || 2;
        return String(num).padStart(maxLength, '0');
    }

    function updateValueWithAnimation(elementId, newValue, isDays) {
        var el = document.getElementById(elementId);
        if (!el) return;
        var oldVal = el.textContent.replace(/\s/g, '');
        var newValStr = isDays ? formatNumber(newValue) : formatWithPadding(newValue);
        if (oldVal !== newValStr.replace(/\s/g, '')) {
            el.style.transition = 'all 0.3s ease';
            el.style.transform = 'scale(1.1)';
            el.style.opacity = '0.7';
            setTimeout(function() {
                el.textContent = newValStr;
                el.style.transform = 'scale(1)';
                el.style.opacity = '1';
            }, 150);
        }
    }

    function updateCountdown() {
        var now = new Date().getTime();
        var distance = eventDate - now;

        if (distance < 0) {
            var countdownEl = document.getElementById('countdown');
            if (countdownEl) {
                countdownEl.innerHTML = '<div class="countdown-event-started">' +
                    '<div style="font-size: 3rem; margin-bottom: 1rem;">🎉</div>' +
                    '<div>МЕРОПРИЯТИЕ НАЧАЛОСЬ!</div>' +
                    '<div style="font-size: 1rem; margin-top: 1rem; opacity: 0.8;">Добро пожаловать!</div>' +
                    '</div>';
            }
            if (countdownInterval) clearInterval(countdownInterval);
            return;
        }

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        updateValueWithAnimation('days', days, true);
        updateValueWithAnimation('hours', hours);
        updateValueWithAnimation('minutes', minutes);
        updateValueWithAnimation('seconds', seconds);
    }

    function initCountdown() {
        var el = document.querySelector('[data-event-date]');
        var dateString = el ? el.getAttribute('data-event-date') : null;
        try {
            if (dateString) {
                eventDate = new Date(dateString).getTime();
            }
            if (!dateString || isNaN(eventDate)) {
                eventDate = new Date('2026-10-21 18:00:00').getTime();
            }
        } catch (e) {
            eventDate = new Date('2026-10-21 18:00:00').getTime();
        }

        countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown();
    }

    function initPhotoCarousel() {
        var carousel = document.querySelector('[data-carousel]');
        if (!carousel) return;

        var slidesContainer = carousel.querySelector('[data-carousel-slides]');
        var slides = Array.prototype.slice.call(carousel.querySelectorAll('.photo-slide'));
        var dotsContainer = carousel.querySelector('[data-carousel-dots]');

        if (!slidesContainer || slides.length === 0 || !dotsContainer) return;

        var currentIndex = 0;
        var autoTimer;

        function goToSlide(index) {
            currentIndex = (index + slides.length) % slides.length;
            slidesContainer.style.transform = 'translateX(-' + currentIndex * 100 + '%)';
            dotsContainer.querySelectorAll('.photo-dot').forEach(function(dot, i) {
                dot.classList.toggle('active', i === currentIndex);
            });
        }

        slides.forEach(function(_, index) {
            var dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'photo-dot' + (index === 0 ? ' active' : '');
            dot.addEventListener('click', function() {
                goToSlide(index);
                resetAuto();
            });
            dotsContainer.appendChild(dot);
        });

        function resetAuto() {
            if (autoTimer) clearInterval(autoTimer);
            autoTimer = setInterval(function() { goToSlide(currentIndex + 1); }, 7000);
        }

        resetAuto();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initCountdown();
            initPhotoCarousel();
        });
    } else {
        initCountdown();
        initPhotoCarousel();
    }
})();
