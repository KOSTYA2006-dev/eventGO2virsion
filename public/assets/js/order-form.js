/**
 * order-form.js — пересчёт итога при изменении количества
 * Цена билета через data-ticket-price на #order-form или .order-card
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
        var form = document.getElementById('order-form');
        if (!form) return;

        var container = form.closest('.order-card') || form;
        var ticketPrice = parseFloat(container.getAttribute('data-ticket-price')) || 0;
        var quantityInput = document.getElementById('quantity');
        var totalAmount = document.getElementById('total-amount');

        if (!quantityInput || !totalAmount) return;

        function updateTotal() {
            var quantity = parseInt(quantityInput.value, 10) || 1;
            var subtotal = ticketPrice * quantity;
            totalAmount.textContent = number_format(subtotal, 2, '.', ' ') + ' ₽';
        }

        quantityInput.addEventListener('input', updateTotal);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
