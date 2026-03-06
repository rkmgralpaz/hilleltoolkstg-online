//import {browserZoom,helper,system, utils, ImagePreloader} from './utils.js?v=032';
import { utils, CookieManager } from "./utils.js?v=032";
import { PodcastEmbedGenerator } from './globals/podcast-embed-generator.js?v=032';
import { VideoEmbedGenerator } from './globals/video-embed-generator.js?v=032';
import { setupRelatedMediaSlider } from './blocks/block-related-media-horizontal.js?v=032';
const startModule = (block) => {
    block.classList.add('loaded');
    //
    const flipContainer = block.querySelector('.page-cards-single-v2__flip-container');
    if (!!flipContainer) {
        block.classList.add('page-cards-single-v2--animate-card-to-top');
        const transitionTime = getTransitionTime(block);
        setTimeout(() => {
            block.classList.add('page-cards-single-v2--card-flip');
            document.body.classList.remove('header-hide', 'scrolled');
            setTimeout(() => {
                block.classList.add('page-cards-single-v2--card-complete');
                block.classList.remove('page-cards-single-v2--animate-card-to-top', 'page-cards-single-v2--card-flip');
                flipContainer.remove();
                document.body.classList.add('loaded');
            }, transitionTime.step2 + 50);
        }, transitionTime.step1);
    }
    //
    block.querySelectorAll('.page-cards-single-v2__close-btn').forEach(el => {
        el.addEventListener('click', e => {
            if (window.history.length > 1 && document.referrer) {
                e.preventDefault();
                window.history.back();
            }
        });
    });
    //
    block.querySelectorAll('.page-cards-single-v2__podcast-player').forEach(el => {
        const url = el.dataset.podcast;
        const generator = new PodcastEmbedGenerator();
        const embedCode = generator.generateEmbed(url).embedCode;
        el.innerHTML = embedCode;
    });
    block.querySelectorAll('.page-cards-single-v2__video-player-with-btn').forEach(el => {
        const url = el.dataset.video;
        const imgDiv = block.querySelector('.page-cards-single-v2__video-player-poster-img');
        let loaded = false;
        if (!!imgDiv) {
            const img = new Image();
            img.onload = function () {
                if (loaded) return false;
                imgDiv.style.opacity = 1;
                imgDiv.style.backgroundImage = `url(${img.src})`;
                loaded = true;
            }
            img.src = imgDiv.dataset.src;
        }
        const btn = el.querySelector('.page-cards-single-v2__video-player-btn');
        if (!!btn) {
            btn.addEventListener('click', e => {
                btn.style.visibility = 'hidden';
                imgDiv.style.opacity = 0;
                const generator = new VideoEmbedGenerator();
                const embedCode = generator.generateEmbed(url, '100%', '100%', { autoplay: true }).embedCode;
                el.style.background = 'black';
                el.innerHTML += embedCode;
                const iframe = el.querySelector('iframe');
                if (!!iframe) {
                    const transitionPropeties = utils.getTransitionPropeties(iframe, true);
                    const transitionDuration = transitionPropeties.transitionDuration ?? 600;
                    setTimeout(() => {
                        iframe.style.opacity = 1;
                    }, transitionDuration);
                }
            });
        }
    });
    block.querySelectorAll('.page-cards-single-v2__video-player').forEach(el => {
        const url = el.dataset.video;
        const generator = new VideoEmbedGenerator();
        const embedCode = generator.generateEmbed(url, '100%', '100%').embedCode;
        el.innerHTML = embedCode;
    });

    //
    const isMobileOrTablet = () => {
        const userAgent = navigator.userAgent.toLowerCase();
        const isMobile = /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(userAgent);
        const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
        const isSmallScreen = Math.min(window.innerWidth, window.innerHeight) <= 1024;
        return isMobile || (isTouchDevice && isSmallScreen);
    }
    const shareBtn = block.querySelector('.page-cards-single-v2__share-btn');
    const shareMenu = block.querySelector('.page-cards-single-v2__share-menu');
    const shareWrapper = block.querySelector('.page-cards-single-v2__share-wrapper');
    if (!!shareBtn && !!shareMenu && !!shareWrapper) {
        shareBtn.addEventListener('click', e => {
            shareMenu.classList.toggle('page-cards-single-v2__share-menu--open');
        });
        document.addEventListener('click', e => {
            if (shareMenu.classList.contains('page-cards-single-v2__share-menu--open')) {
                shareMenu.classList.remove('page-cards-single-v2__share-menu--open');
            }
        });
        shareWrapper.addEventListener('click', e => {
            e.stopPropagation();
        });
        document.addEventListener('keyup', e => {
            if (e.key == 'Escape' && shareMenu.classList.contains('page-cards-single-v2__share-menu--open')) {
                shareMenu.classList.remove('page-cards-single-v2__share-menu--open');
                shareBtn.focus();
            }
        });
        const copyBtn = shareMenu.querySelector('.copy-link-btn');
        if (!!copyBtn) {
            let defaultText = copyBtn.textContent;
            let isMobile = isMobileOrTablet();
            copyBtn.addEventListener('click', e => {
                if (navigator.share && isMobile) {
                    const titleElement = block.querySelector('.page-cards-single-v2__title');
                    const title = !!titleElement ? titleElement.textContent : '';
                    navigator.share({
                        title: title,
                        text: '',
                        url: window.location.href
                    });
                } else {
                    const url = window.location.href;
                    const button = copyBtn;
                    // Copiar al portapapeles
                    navigator.clipboard.writeText(url).then(() => {
                        // Cambiar el texto a "Copied..."
                        button.textContent = "Copied...";
                        // Volver a "Copy Link" después de 1 segundo
                        setTimeout(() => {
                            button.textContent = defaultText;
                        }, 1000);
                    }).catch((err) => {
                        console.error('Error when copying the link:', err);
                        button.textContent = "Error";
                    });
                }
            });
        }
    }

    // Inicializar módulos de related media horizontal
    block.querySelectorAll('.block-related-media-horizontal').forEach(setupRelatedMediaSlider);
}
const getTransitionTime = (block) => {
    const computedStyle = getComputedStyle(block);
    let transitionDurationStep1 = 800;//defaults
    let transitionDurationStep2 = 1400;//defaults
    if (computedStyle) {
        transitionDurationStep1 = Number(computedStyle.getPropertyValue('--card-intro-step-1-duration').replace(/[^\d.]/g, '')) + Number(computedStyle.getPropertyValue('--card-intro-step-1-delay').replace(/[^\d.]/g, ''));
        transitionDurationStep2 = Number(computedStyle.getPropertyValue('--card-intro-step-2-duration').replace(/[^\d.]/g, '')) + Number(computedStyle.getPropertyValue('--card-intro-step-2-delay').replace(/[^\d.]/g, ''));
    }
    if (transitionDurationStep1 < 10) {
        transitionDurationStep1 = transitionDurationStep1 * 1000;
    }
    if (transitionDurationStep2 < 10) {
        transitionDurationStep2 = transitionDurationStep2 * 1000;
    }
    return {
        step1: transitionDurationStep1,
        step2: transitionDurationStep2,
    }
}
export { startModule };
