/**
 * Minimal site JavaScript, intentionally limited to two things:
 *
 * 1. Reveal project cards with a small fade-in as they enter the viewport.
 * 2. Respect system-level reduced-motion preferences.
 *
 * Smooth scrolling is handled by CSS; it does not need JavaScript.
 */

(function () {
    'use strict';

    var cartoes = document.querySelectorAll('.cartao');

    if (!cartoes.length) {
        return;
    }

    var prefereMenosMovimento = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // For unsupported browsers or reduced motion, show every card immediately.
    if (prefereMenosMovimento || !('IntersectionObserver' in window)) {
        return;
    }

    cartoes.forEach(function (cartao) {
        cartao.classList.add('reveal');
    });

    var observador = new IntersectionObserver(
        function (entradas) {
            entradas.forEach(function (entrada) {
                if (entrada.isIntersecting) {
                    entrada.target.classList.add('reveal-visivel');
                    observador.unobserve(entrada.target);
                }
            });
        },
        { threshold: 0.15 }
    );

    cartoes.forEach(function (cartao) {
        observador.observe(cartao);
    });
})();
