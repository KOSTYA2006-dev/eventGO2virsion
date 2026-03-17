/**
 * order-checkout.js — проверка промокода
 * Подитог через data-subtotal на .card или body
 */
(function() {
    'use strict';

    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number;
        var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
        var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
        var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;
        var s = '';
        var toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    function init() {
        var card = document.querySelector('.card');
        var subtotalValue = card ? parseFloat(card.getAttribute('data-subtotal')) : 0;
        var promoCodeInput = document.getElementById('promo_code');
        var checkPromoBtn = document.getElementById('check-promo-btn');
        var promoResult = document.getElementById('promo-result');
        var discountEl = document.getElementById('discount');
        var totalEl = document.getElementById('total');

        if (!checkPromoBtn || !promoResult) return;

        checkPromoBtn.addEventListener('click', async function() {
            var code = promoCodeInput ? promoCodeInput.value.trim() : '';
            if (!code) {
                promoResult.className = 'promo-result error';
                promoResult.textContent = 'Введите промокод или нажмите "Применить", чтобы удалить текущий';
                return;
            }

            checkPromoBtn.disabled = true;
            checkPromoBtn.textContent = 'Проверка...';

            try {
                var url = '/api/promo-code/check?code=' + encodeURIComponent(code) + '&amount=' + encodeURIComponent(subtotalValue);
                var response = await fetch(url);
                var data = await response.json();

                if (data.valid) {
                    promoResult.className = 'promo-result success';
                    promoResult.textContent = 'Промокод подходит. Скидка: ' + (data.discount_text || '');

                    var discountAmount = data.discount_amount || 0;
                    if (discountEl) discountEl.textContent = number_format(discountAmount, 2, '.', ' ') + ' ₽';
                    if (totalEl) totalEl.textContent = number_format(Math.max(0, subtotalValue - discountAmount), 2, '.', ' ') + ' ₽';
                } else {
                    promoResult.className = 'promo-result error';
                    promoResult.textContent = data.message || 'Промокод недействителен';
                }
            } catch (e) {
                promoResult.className = 'promo-result error';
                promoResult.textContent = 'Ошибка при проверке промокода';
            } finally {
                checkPromoBtn.disabled = false;
                checkPromoBtn.textContent = 'Проверить';
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
