/**
 * JS mínimo do site — só duas coisas, de propósito:
 *
 * 1. Revelar os cartões de projeto com um pequeno fade-in quando
 *    entram no ecrã ao fazer scroll.
 * 2. Respeitar quem desativou animações no sistema (acessibilidade).
 *
 * O scroll suave para "#projetos" já é feito só com CSS
 * (ver `scroll-behavior: smooth` em style.css), não precisa de JS.
 */

(function () {
    'use strict';

    var cartoes = document.querySelectorAll('.cartao');

    if (!cartoes.length) {
        return;
    }

    var prefereMenosMovimento = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Sem suporte a IntersectionObserver (browsers muito antigos) ou
    // com animações desativadas: mostra tudo já, sem efeito nenhum.
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
