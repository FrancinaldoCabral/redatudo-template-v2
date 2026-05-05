/**
 * RedaTudo - JavaScript Interactions
 * Rebranding 2.0
 */

(function($) {
    'use strict';

    /**
     * Inicialização quando o DOM estiver pronto
     */
    $(document).ready(function() {
        initToolCardAnimations();
        initSmoothScrolling();
        initButtonEffects();
    });

    /**
     * Animações dos Tool Cards
     */
    function initToolCardAnimations() {
        $('.tool-card').each(function() {
            const $card = $(this);
            
            // Adiciona observer para animação de entrada
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '0';
                            entry.target.style.transform = 'translateY(20px)';
                            
                            setTimeout(() => {
                                entry.target.style.transition = 'opacity 0.6s, transform 0.6s';
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0)';
                            }, 100);
                            
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1
                });
                
                observer.observe($card[0]);
            }
        });
    }

    /**
     * Smooth Scrolling para links âncora
     */
    function initSmoothScrolling() {
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 80
                }, 800, 'swing');
            }
        });
    }

    /**
     * Efeitos em botões
     */
    function initButtonEffects() {
        // Efeito ripple em botões
        $('.btn, .btn-primary, .btn-secondary, .btn-urgent, .btn-tool').on('click', function(e) {
            const $button = $(this);
            const diameter = Math.max($button.width(), $button.height());
            const radius = diameter / 2;
            
            const offset = $button.offset();
            const x = e.pageX - offset.left - radius;
            const y = e.pageY - offset.top - radius;
            
            const $ripple = $('<span class="ripple"></span>').css({
                width: diameter,
                height: diameter,
                top: y + 'px',
                left: x + 'px'
            });
            
            $button.append($ripple);
            
            setTimeout(() => {
                $ripple.remove();
            }, 600);
        });
    }

    /**
     * Utilitário: Debounce function
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    /**
     * Lazy loading para imagens
     */
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    const src = img.getAttribute('data-src');
                    
                    if (src) {
                        img.src = src;
                        img.removeAttribute('data-src');
                        img.classList.add('loaded');
                    }
                    
                    observer.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    /**
     * Adiciona CSS para animação ripple
     */
    if (!document.getElementById('ripple-styles')) {
        const style = document.createElement('style');
        style.id = 'ripple-styles';
        style.textContent = `
            .ripple {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple-animation 0.6s ease-out;
                pointer-events: none;
            }
            
            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            .btn, .btn-primary, .btn-secondary, .btn-urgent, .btn-tool {
                position: relative;
                overflow: hidden;
            }
            
            img.loaded {
                animation: fadeIn 0.3s ease-in;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }

    /**
     * Parallax effect (opcional, para hero sections)
     */
    function initParallax() {
        const parallaxElements = document.querySelectorAll('[data-parallax]');
        
        if (parallaxElements.length > 0) {
            window.addEventListener('scroll', debounce(() => {
                const scrolled = window.pageYOffset;
                
                parallaxElements.forEach(element => {
                    const speed = element.dataset.parallax || 0.5;
                    const yPos = -(scrolled * speed);
                    element.style.transform = `translateY(${yPos}px)`;
                });
            }, 10));
        }
    }

    // Inicializar parallax se houver elementos
    initParallax();

    /**
     * Contador animado para stats
     */
    function animateCounter(element, target, duration = 2000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, 16);
    }

    /**
     * Observador para animar stats quando visíveis
     */
    if ('IntersectionObserver' in window) {
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const stat = entry.target.querySelector('strong');
                    if (stat && !stat.classList.contains('animated')) {
                        stat.classList.add('animated');
                        const text = stat.textContent;
                        const number = parseFloat(text.replace(/[^\d.]/g, ''));
                        
                        if (!isNaN(number) && number < 10000) {
                            animateCounter(stat, number);
                        }
                    }
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.stat').forEach(stat => {
            statsObserver.observe(stat);
        });
    }

    /**
     * Acessibilidade: Foco visível em navegação por teclado
     */
    let isUsingMouse = false;
    
    document.addEventListener('mousedown', () => {
        isUsingMouse = true;
    });
    
    document.addEventListener('keydown', () => {
        isUsingMouse = false;
    });
    
    document.addEventListener('focusin', (e) => {
        if (!isUsingMouse && e.target.matches('a, button, input, textarea, select')) {
            e.target.classList.add('keyboard-focus');
        }
    });
    
    document.addEventListener('focusout', (e) => {
        e.target.classList.remove('keyboard-focus');
    });

    // ── Table of Contents Generator ───────────────────────────────────────────
    (function initTOC() {
        var content = document.getElementById('single-content');
        var tocList    = document.getElementById('toc-list');
        var tocMobile  = document.getElementById('toc-mobile');

        if (!content || (!tocList && !tocMobile)) return;

        var headings = content.querySelectorAll('h2');
        if (headings.length < 2) return;

        var items = '';
        headings.forEach(function(h, i) {
            var id = h.id || ('toc-section-' + i);
            h.id = id;
            items += '<li><a href="#' + id + '">' + h.textContent + '</a></li>';
        });

        var list = '<ul>' + items + '</ul>';
        if (tocList)   { tocList.innerHTML   = list; }
        if (tocMobile) { tocMobile.innerHTML = list; }

        // Highlight active heading on scroll
        var allIds = Array.from(headings).map(function(h) { return h.id; });
        document.addEventListener('scroll', function() {
            var scrollY = window.scrollY || window.pageYOffset;
            var active  = allIds[0];
            allIds.forEach(function(id) {
                var el = document.getElementById(id);
                if (el && el.getBoundingClientRect().top + scrollY <= scrollY + 120) {
                    active = id;
                }
            });
            document.querySelectorAll('#toc-list a, #toc-mobile a').forEach(function(a) {
                a.classList.toggle('toc-active', a.getAttribute('href') === '#' + active);
            });
        }, { passive: true });
    })();

})(jQuery);
