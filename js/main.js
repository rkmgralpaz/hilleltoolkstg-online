import { CookieManager } from "./js-modules/utils.js";
import { safeURL, preloadImages, startGlobals } from "./js-modules/globals.js";

const doc = document;
const win = window;
const body = document.body;

function configureScrollRestoration() {
    
    if ('scrollRestoration' in history) {
        // Define la página donde quieres scroll automático
        const autoScrollPages = ['/misinformation/'];
        const currentPath = window.location.pathname;
        if (autoScrollPages.includes(currentPath)) {
            history.scrollRestoration = 'auto';
            if (window.scrollY) {
                document.body.classList.add('scrolled', 'header-hide');
            }
        } else {
            history.scrollRestoration = 'manual';
        }
    }
    const prevPage = sessionStorage.getItem('history');
    if(prevPage && prevPage.indexOf('/years-comparison/') === -1){
        // is previous URL is not years-comparison page reset scrollPositionComparisonYears
        sessionStorage.removeItem('scrollPositionComparisonYears');
    }
    sessionStorage.setItem('history', window.location);
}

doc.addEventListener('DOMContentLoaded', () => {//espera a que se cargue el DOM
    //    
    if (!!document.querySelector('.gform_confirmation_message') && !!document.querySelector('.block-subscription-form')) {
        document.querySelector('.block-subscription-form').scrollIntoView({
            //behavior: "smooth",
            block: 'center',
            //inline: 'center'
        });
    } else {
        //history.scrollRestoration = "manual";//restaura el scroll a cero
        configureScrollRestoration();
    }
    //alert(String(window.location).indexOf('/misinformation') === -1)
    safeURL.init();//comprueba que no haya inyeccción de script en la url
    //
    preloadImages();//se ponene en cola las imagenes principales de la página

    window.baseURL = String(window.location).split(window.location.host)[0] + window.location.host + '/';

    document.fonts.ready.then((fontFaceSet) => {//espera a que se carguen las fonts
        document.body.classList.add('fonts-loaded');

        const siteVersion = win.siteVersion || '1.0.0';

        const config = {//define la configuración de los modulos js
            mainSelector: '.js-module',
            jsModules: [

                { selector: '.block-other-stats', src: './js-modules/blocks/block-other-stats.js?ver=' + siteVersion },
                { selector: '.block-overview', src: './js-modules/blocks/block-overview.js?ver=' + siteVersion },
                { selector: '.component-format', src: './js-modules/components/component-format.js?ver=' + siteVersion },
                { selector: '.component-trend-icon', src: './js-modules/components/component-trend-icon.js?ver=' + siteVersion },
                { selector: '.block-additional-stats', src: './js-modules/blocks/block-additional-stats.js?ver=' + siteVersion },
                { selector: '.component-color-key-item', src: './js-modules/components/component-color-key-item.js?ver=' + siteVersion },
                { selector: '.block-incidents-by-type', src: './js-modules/blocks/block-incidents-by-type.js?ver=' + siteVersion },
                { selector: '.page-resources', src: './js-modules/page-resources.js?ver' + siteVersion },

                { selector: '.block-data-interactive-main-graphs', src: './js-modules/blocks/block-data-interactive-main-graphs.js?ver=' + siteVersion },
                { selector: '.page-years-comparison', src: './js-modules/page-years-comparison.js?ver' + siteVersion },

                { selector: '.page-news', src: './js-modules/page-news.js?ver' + siteVersion },
                { selector: '.page-news-single', src: './js-modules/page-news-single.js?ver' + siteVersion },
                { selector: '.site-header', src: './js-modules/header.js?ver' + siteVersion },
                { selector: '.page-header', src: './js-modules/page-header.js?ver' + siteVersion },
                { selector: '.site-header', src: './js-modules/site-header.js?ver' + siteVersion },
                { selector: '.page-cards', src: './js-modules/page-cards.js?ver' + siteVersion },
                { selector: '.page-cards-v2', src: './js-modules/page-cards-v2.js?ver' + siteVersion },
                { selector: '.page-cards-single-v2', src: './js-modules/page-cards-single-v2.js?ver' + siteVersion },
                { selector: '.page-timeline', src: './js-modules/page-timeline.js?ver' + siteVersion },
                { selector: '.block-cards', src: './js-modules/blocks/block-cards.js?ver' + siteVersion },
                { selector: '.block-rcards', src: './js-modules/blocks/block-rcards.js?ver' + siteVersion },
                { selector: '.block-multi-photo', src: './js-modules/blocks/block-multi-photo.js?ver' + siteVersion },
                { selector: '.block-multi-photo-hero', src: './js-modules/blocks/block-multi-photo-hero.js?ver' + siteVersion },
                { selector: '.block-multi-photo-extended', src: './js-modules/blocks/block-multi-photo-extended.js?ver' + siteVersion },
                { selector: '.block-quiz', src: './js-modules/blocks/block-quiz.js?ver' + siteVersion },
                { selector: '.block-landing', src: './js-modules/blocks/block-landing.js?ver' + siteVersion },
                { selector: '.block-video', src: './js-modules/blocks/block-video.js?ver' + siteVersion },
                { selector: '.block-hero', src: './js-modules/blocks/block-hero.js?ver' + siteVersion },
                { selector: '.block-testimonial', src: './js-modules/blocks/block-testimonial.js?ver' + siteVersion },
                { selector: '.block-slideshow-wimages', src: './js-modules/blocks/block-slideshow-wimages.js?ver' + siteVersion },
                { selector: '.block-accordion', src: './js-modules/blocks/block-accordion.js?ver' + siteVersion },
                { selector: '.block-text-wphoto', src: './js-modules/blocks/block-text-wphoto.js?ver' + siteVersion },
                { selector: '.block-text-only-carrousel', src: './js-modules/blocks/block-text-only-carrousel.js?ver' + siteVersion },
                { selector: '.block-bannerh', src: './js-modules/blocks/block-cta-banner-h.js?ver' + siteVersion },
                { selector: '.block-image-carousel', src: './js-modules/blocks/block-image-carousel.js?ver' + siteVersion },
                { selector: '.block-cta-misinformation-cards', src: './js-modules/blocks/block-cta-misinformation-cards.js?ver' + siteVersion },
                { selector: '.block-home-animation', src: './js-modules/blocks/block-home-animation.js?ver=' + siteVersion },
                { selector: '.block-reels', src: './js-modules/blocks/block-reels.js?ver' + siteVersion },
                { selector: '.block-youtube-embeds', src: './js-modules/blocks/block-youtube-embeds.js?ver=' + siteVersion },
                { selector: '.block-bannerv', src: './js-modules/blocks/block-cta-banner-v.js?ver' + siteVersion },
                { selector: '.block-related-media-horizontal', src: './js-modules/blocks/block-related-media-horizontal.js?ver=' + siteVersion },
                { selector: '.block-context', src: './js-modules/blocks/block-context.js?ver=' + siteVersion },
                //{selector:'.search-results', src:'./js-modules/search-results.js?ver'+siteVersion},
                { selector: '.site-footer', src: './js-modules/footer.js?ver' + siteVersion },
            ]
        }
        //carga e inicializa modulos js a medida que va escroleando la página
        if (!!document.querySelector(config.mainSelector)) {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    const isInit = entry.target.initialized;
                    const isPaused = entry.target.paused;
                    //if(isInit && !entry.intersectionRatio && !isPaused && entry.target.pauseModule){
                    if (isInit && !entry.isIntersecting && !isPaused && entry.target.pauseModule) {
                        //si está inicializado el modulo, está fuera del viewport, no está pausado y existe la función pauseModule dispara pauseModule();
                        entry.target.paused = true;
                        entry.target.pauseModule();
                        //}else if(isInit && entry.intersectionRatio && isPaused && entry.target.playModule){
                    } else if (isInit && entry.isIntersecting && isPaused && entry.target.playModule) {
                        //si está inicializado el modulo, está dentro del viewport, está pausado y existe la función playModule dispara playModule();
                        entry.target.paused = false;
                        entry.target.playModule();
                        //}else if(!isInit && entry.intersectionRatio > 0.3){
                    } else if (!isInit && entry.isIntersecting) {
                        //si no está inicializado y entra el 30% en el viewport tira la carga del módulo e inicializa
                        config.jsModules.forEach((el, i) => {
                            const type = el.selector.substring(0, 1);
                            //const selector = el.selector.split('#').join('').split('.').join('');
                            const selector = el.selector.substring(1, el.selector.length);
                            if ((type == '#' && entry.target.getAttribute('id') == selector) || (type == '.' && entry.target.classList.contains(selector))) {
                                //observer.unobserve(entry.target);
                                const moduleSpecifierStr = el.src;
                                import(moduleSpecifierStr)
                                    .then((namespaceObject) => {
                                        entry.target.initialized = true;
                                        namespaceObject.startModule(entry.target);//inicializa el modulo de js 
                                    });
                            }
                        });
                    }
                });
            }, {
                //rootMargin: '0px 0px -25% 0px',
                rootMargin: '0px 0px -10% 0px',
                //threshold: [0, .1, .2, .3, .4, .5, .6, .7, .8, .9, 1]
            });
            document.querySelectorAll(config.mainSelector).forEach((el) => {
                observer.observe(el);
            });
        }
        //
        startGlobals();//dispara funciones y eventos globales del site (globals.js);
    });
});


