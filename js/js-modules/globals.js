import { browserZoom, system, ImagePreloader } from './utils.js?v=032';

const doc = document;
const win = window;
const body = document.body;//

const startGlobals = function () {
    //--- avoid focus style when click ---//
    //body.classList.add('no-focus-style');
    setTimeout(() => {
        doc.addEventListener('mousedown', function (e) {
            document.body.classList.add('no-focus-style');
        });
        doc.addEventListener('keydown', function (e) {
            if (e.key == 'Tab') {
                body.classList.remove('no-focus-style');
            }
        });
        doc.addEventListener('keyup', function (e) {
            if (e.key == 'Tab') {
                body.classList.remove('no-focus-style');
            }
        });
    }, 500);
    //--- avoid focus style when click ---//
    //
    if (system.safari) {
        body.classList.add('safari');
    }
    if (system.touchDevice) {
        body.classList.add('touch-device');
    }
    detectIframeVideos();
    browserZoom.init((level) => {
        let class150 = 'browser-desktop-150-percent';
        if (level >= 133) {
            body.classList.add(class150);
        } else {
            body.classList.remove(class150);
        }
    });

    const emptyLinks = doc.querySelectorAll('a[href="#"]');//--- prevent empty links clicks
    emptyLinks.forEach(el => {
        el.addEventListener('click', (e) => {
            e.preventDefault();
            return false;
        });
    });

    const skipToContentBtn = doc.querySelector('#skip-to-content-btn');
    skipToContentBtn.addEventListener('click', (e) => {
        const mainContent = doc.querySelector('#main-content');
        const focusable = mainContent.querySelectorAll('summary, select, button, a, input[type=button], input[type=submit], input[type=radio], input[type=checkbox], .focusable');
        let elem;
        focusable.forEach(el => {
            const computedStyle = window.getComputedStyle(el);
            const display = computedStyle.getPropertyValue('display');
            const visibility = computedStyle.getPropertyValue('visibility');
            if (!elem && display != 'none' && visibility != 'hidden') {
                elem = el;
            }
        });
        win.scrollTo({
            top: 100,
            left: 0,
            behavior: 'smooth'
        });
        skipToContentBtn.blur();
        e.stopImmediatePropagation();
        setTimeout(() => {
            elem.focus();
        }, 100);
    });

    const openMainNavBtn = doc.querySelector('#open-main-nav-btn');
    openMainNavBtn.addEventListener('click', (e) => {
        const navBtn = doc.querySelector('.site-header__nav-mobile-btn');
        if (!navBtn) return false;
        if (window.innerWidth < 1024) {
            navBtn.click();
            navBtn.focus();
        } else {
            const btn = doc.querySelector('.site-nav__first-level-btn');
            if (!!btn) {
                e = new MouseEvent('mouseover', { view: window, cancelable: true, bubbles: true });
                btn.dispatchEvent(e);
                btn.focus();
            }
        }
    });

    document.addEventListener('keyup', e => {
        if (e.key == 'Escape' && document.body.classList.contains('nav-desktop-open-2')) {
            e = new MouseEvent('mouseleave', { view: window, cancelable: true, bubbles: true });
            document.querySelector('#site-header').dispatchEvent(e);
        } else if (e.key == 'Escape' && document.body.classList.contains('nav-mobile-open')) {
            document.querySelector('.site-header__nav-mobile-btn').click();
        }
    });

    animateElementsOnView();
    startSubTabs();
    startCookiesBanner();
    preloadImagesCarousel();
    customSelectResources();
    scrollToActiveYear();
    startIncidentsPopUp();
    initScrollFade();
    initYearsScrollArrows();
    animateTrendIconsOnView();

}


const scrollToActiveYear = () => {
    const container = document.querySelector('.data-interactive-single__control-years');
    const activeItem = container?.querySelector('.data-interactive-single__year.active');

    if (container && activeItem) {
        const containerRect = container.getBoundingClientRect();
        const activeItemRect = activeItem.getBoundingClientRect();

        const scrollLeft = activeItemRect.left - containerRect.left + container.scrollLeft - (container.clientWidth / 2) + (activeItemRect.width / 2);

        // Sobrescribir temporalmente scroll-behavior
        const originalScrollBehavior = container.style.scrollBehavior;
        container.style.scrollBehavior = 'auto';
        container.scrollLeft = Math.round(scrollLeft);
        container.style.scrollBehavior = originalScrollBehavior; // Restaurar valor original
    }
};

const startIncidentsPopUp = () => {
    const popup = document.querySelector('.incident-popup');
    const content = popup.querySelector('.incident-popup__content');
    const holder = popup.querySelector('.incident-popup__tooltip-container');
    const handle = popup.querySelector('.incident-popup__handle');
    let prevWinWidth = window.innerWidth;


    const hideIncidentsPopUp = () => {
        document.body.classList.remove('remove-scroll');
        popup.classList.add('incident-popup--hidden');
    };

    let maxWidth = 1024;

    window.showIncidentsPopUp = function (html, width = 1024) {
        maxWidth = width; // Actualizar el valor global
        const mediaQueryList = window.matchMedia(`(max-width: ${maxWidth}px)`);
        if (!!popup && !!holder && mediaQueryList.matches) {
            document.body.classList.add('remove-scroll');
            holder.innerHTML = html;
            popup.classList.remove('incident-popup--hidden');
        }
    };

    window.addEventListener('resize', () => {
        const mediaQueryList = window.matchMedia(`(max-width: ${maxWidth}px)`);
        if (!mediaQueryList.matches) {
            hideIncidentsPopUp();
        }
    });

    popup.addEventListener('click', hideIncidentsPopUp);
    detectSwipeDown(popup, hideIncidentsPopUp);
    content.addEventListener('click', e => {
        e.stopPropagation();
    });

    popup.addEventListener('scroll', e => {
        e.preventDefault();
    });

    popup.addEventListener('touchmove', function (e) {
        e.preventDefault();
    });

    document.addEventListener('keyup', e => {
        if (e.key === 'Escape') {
            hideIncidentsPopUp();
        }
    });

    function detectSwipeDown(element, callback) {
        let startY = 0;
        let endY = 0;
        const threshold = 50;

        element.addEventListener('touchstart', function (e) {
            startY = e.touches[0].clientY;
        }, { passive: true });

        element.addEventListener('touchmove', function (e) {
            let y = e.touches[0].clientY - startY;
            if (y > 0) {
                content.style.top = `${y}px`;
            }
        }, { passive: true });

        element.addEventListener('touchend', function (e) {
            endY = e.changedTouches[0].clientY;
            if (endY - startY > threshold) {
                callback();
            }
            setTimeout(() => {
                content.removeAttribute('style');
            }, 300);
        }, { passive: true });
    }
}

const customSelectResources = () => {
    document.querySelectorAll('.custom-select-wrapper').forEach(wrapper => {
        const toggleBtn = wrapper.querySelector('.custom-select-button');
        const options = wrapper.querySelectorAll('.custom-option');
        const arrow = toggleBtn ? toggleBtn.querySelector('.arrow') : null;

        if (!toggleBtn || options.length === 0) return;
        // calcular ancho más largo
        const temp = document.createElement('div');
        const computedStyles = getComputedStyle(toggleBtn);
        temp.style.visibility = 'hidden';
        temp.style.position = 'absolute';
        temp.style.fontWeight = computedStyles.fontWeight;
        temp.style.fontSize = computedStyles.fontSize;
        temp.style.fontFamily = computedStyles.fontFamily;
        temp.style.padding = computedStyles.padding;
        temp.style.border = computedStyles.border;
        temp.style.boxSizing = 'border-box';
        temp.style.whiteSpace = 'nowrap';
        temp.style.letterSpacing = computedStyles.letterSpacing;
        document.body.appendChild(temp);

        let maxWidth = 0;
        options.forEach(option => {
            temp.innerHTML = option.innerText + ' <span class="arrow">▾</span>';
            const width = temp.offsetWidth;
            if (width > maxWidth) maxWidth = width;
        });

        document.body.removeChild(temp);

        // Sumar el padding en CSS de cada lado
        const paddingLeft = parseFloat(computedStyles.paddingLeft) || 0;
        const paddingRight = parseFloat(computedStyles.paddingRight) || 0;
        toggleBtn.style.width = (maxWidth + paddingLeft + paddingRight) + 'px';

        wrapper.style.opacity = 1;

        toggleBtn.addEventListener('click', () => {
            // Ocultar la opción actualmente seleccionada al abrir el menú
            options.forEach(option => {
                if (option.innerText === toggleBtn.childNodes[0].nodeValue.trim()) {
                    option.style.display = 'none';
                } else {
                    option.style.display = '';
                }
            });
            wrapper.classList.toggle('open');
        });

        options.forEach(option => {
            option.addEventListener('click', () => {
                if (option.classList.contains('selected')) return; // evitar repetido

                options.forEach(o => o.classList.remove('selected'));
                option.classList.add('selected');
                toggleBtn.innerHTML = option.innerText + ' <span class="arrow"></span>';
                wrapper.classList.remove('open');
                const url = option.getAttribute('data-url');
                if (url) {
                    window.location.href = url;
                }
            });
        });

        document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target)) {
                wrapper.classList.remove('open');
            }
        });
    });

    // Los sliders de related media horizontal se inicializan automáticamente por main.js
    // cuando detecta elementos con clase .js-module.block-related-media-horizontal
};
const scrollHorizontalItems = (params => {
    const nextPrevWrapper = params.nextPrevWrapper;
    const nextBtn = params.nextBtn;
    const prevBtn = params.prevBtn;
    const scroller = params.scroller;
    const items = params.items;
    const snapToNextElement = params.snapToNextElement;

    if (!!nextPrevWrapper && !!nextBtn && !!prevBtn && !!scroller && items.length) {
        if (!!prevBtn) {
            prevBtn.addEventListener('click', (e) => {
                let left;
                if (snapToNextElement) {
                    let hit = 0;
                    items.forEach((el, i) => {
                        const pos = el.getBoundingClientRect();
                        const x = pos.left + window.innerWidth;
                        console.log(i + ' ' + x);
                        if (!hit && x >= 0) {
                            left = i == 0 ? 0 : pos.left + scroller.scrollLeft - 100;
                            hit = 1;
                        }
                    });
                } else {
                    left = scroller.scrollLeft - scroller.offsetWidth;
                }
                scroller.scrollTo({
                    left: left,
                    behavior: "smooth"
                });
            });
        }
        if (!!nextBtn) {
            nextBtn.addEventListener('click', (e) => {
                let left;
                if (snapToNextElement) {
                    let hit = 0;
                    items.forEach((el, i) => {
                        const pos = el.getBoundingClientRect();
                        const x = pos.left + el.offsetWidth - window.innerWidth;
                        if (!hit && x >= 0) {
                            left = pos.left + scroller.scrollLeft - 100;
                            hit = 1;
                        }
                    });
                } else {
                    left = scroller.scrollLeft + scroller.offsetWidth;
                }
                scroller.scrollTo({
                    left: left,
                    behavior: "smooth"
                });
            });
        }
        const resizeControl = () => {
            if (scroller.scrollWidth > scroller.clientWidth) {
                nextPrevWrapper.classList.add('visible');
            } else {
                nextPrevWrapper.classList.remove('visible');
            }
            scrollControl();
        }
        const scrollControl = () => {
            if (scroller.scrollLeft <= 0) {
                prevBtn.disabled = true;
                nextBtn.disabled = false;
            } else if (scroller.scrollLeft >= scroller.scrollWidth - scroller.clientWidth) {
                prevBtn.disabled = false;
                nextBtn.disabled = true;
            } else {
                prevBtn.disabled = false;
                nextBtn.disabled = false;
            }
        }
        scroller.addEventListener('scroll', scrollControl);
        window.addEventListener('resize', resizeControl);
        resizeControl();
    }
});

const startSubTabs = () => {
    document.querySelectorAll('.tabs-item--selected').forEach(el => {
        el.addEventListener('click', e => {
            e.preventDefault();
        });
    });
    //alert(slugify(String(window.location).split('#')[0]));
    let tabsName = String(window.location).split('#')[0].split('/')[3];
    //alert(localStorage.getItem("miGato"));
    document.querySelectorAll('.page-header__tabs').forEach(el => {
        if (localStorage.getItem(tabsName)) {
            el.scrollLeft = localStorage.getItem(tabsName);
            //el.scrollTo({left:localStorage.getItem(tabsName),behavior: "smooth"})
        }
        el.addEventListener('scroll', e => {
            localStorage.setItem(tabsName, el.scrollLeft);
        });
    });
}

const startCookiesBanner = () => {

    const cookiesBanner = document.getElementById('cookies-banner');

    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    if (!!cookiesBanner) {
        document.getElementById('cookies-banner__consent').addEventListener('click', function () {
            setCookie('cookiesAccepted', 'true', 30);
            cookiesBanner.classList.add('cookies-banner--hide');
            setTimeout(function () {
                cookiesBanner.remove();
            }, 500);
        });
        if (getCookie('cookiesAccepted')) {
            cookiesBanner.remove();
        } else {
            setTimeout(function () {
                cookiesBanner.classList.remove('cookies-banner--hide');
            }, 1000);
        }
    }
}

const animateElementsOnView = () => {
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-loaded')
            } else {
                // entry.target.classList.remove('animate-loaded')
            }
        })
    },
        {
            rootMargin: '0px 0px 0px 0px',
        });
    doc.querySelectorAll('[data-animate]').forEach((el) => {
        observer.observe(el);
    });
}

const getIDfromURL = (url) => {
    let result = '';
    if (url.indexOf('vimeo') !== -1) {
        const seg = url.split('/');
        const i = seg[seg.length - 1] == '' ? seg.length - 2 : seg.length - 1;
        const match = String(seg[i]).split('?');
        result = match[0];
    } else {
        const regExp =
            /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        const match = url.match(regExp);
        if (match && match[2].length === 11) {
            result = match[2];
        }
    }
    return result;
}

const detectIframeVideos = (params) => {
    document.querySelectorAll('iframe').forEach((el) => {
        let src = el.getAttribute('src');
        let detect = !params || !params.detect || !Array.isArray(params.detect) ? ['youtube', 'youtu.be', 'vimeo', '.mp4', '.mov', '.m4v'] : params.detect;
        let vclass = !params || !params.class ? 'iframe-video' : params.class.toString();
        detect.forEach((val) => {
            if (src && src.indexOf(val) !== -1) {
                el.classList.add(vclass);
            }
        });
    });
}

const safeURL = {
    init: function () {
        safeURL.test();
        win.addEventListener('hashchange', () => {
            safeURL.test();
        });
    },
    test: function () {
        var tmpurl = decodeURI(String(window.location));
        if (tmpurl.indexOf('#') !== -1 && (tmpurl.indexOf('<') !== -1 || tmpurl.indexOf('>') !== -1 || tmpurl.indexOf('(') !== -1 || tmpurl.indexOf(')') !== -1 || tmpurl.indexOf('{') !== -1 || tmpurl.indexOf('}') !== -1 || tmpurl.indexOf('[') !== -1 || tmpurl.indexOf(']') !== -1)) {
            window.history.replaceState({}, null, tmpurl.split('#')[0] + '#');
            return false;
        }
        if (window.history.replaceState) {
            //prevents browser from storing history with each change:
            //
        }
    },
    sanitize: function (str) {
        return String(str).replace(/<[^>]*>?/gm, '').replace(/[\])}[{(]/g, '');
    }
}

const preloadImages = () => {
    let enqueueImages = [];
    doc.querySelectorAll('.enqueue-preload').forEach((el) => {
        enqueueImages.push(String(el.dataset.src));
    });
    if (enqueueImages.length) {
        new ImagePreloader(enqueueImages);
    }
}

const preloadImagesCarousel = () => {

    const imageCarousel = document.querySelectorAll('.block-image-carousel');

    imageCarousel.forEach(element => {

        const carouselData = JSON.parse(element.getAttribute('data-carousel'));

        carouselData.forEach((item) => {
            const img = new Image();
            img.src = item.image;
        });

    });

}


const handleScrollFade = () => {
    const wrapper = document.querySelector('.data-interactive-single__control-years-wrapper');
    const container = document.querySelector('.data-interactive-single__control-years');

    if (!wrapper || !container) return;

    const leftFade = wrapper.querySelector('.fade-left');
    const rightFade = wrapper.querySelector('.fade-right');

    const tolerance = 1;
    const isScrolledToStart = container.scrollLeft <= tolerance;
    const isScrolledToEnd = Math.abs(container.scrollWidth - container.clientWidth - container.scrollLeft) <= tolerance;

    if (leftFade) {
        leftFade.style.opacity = isScrolledToStart ? '0' : '1';
    }

    if (rightFade) {
        rightFade.style.opacity = isScrolledToEnd ? '0' : '1';
    }
};

const initScrollFade = () => {
    const wrapper = document.querySelector('.data-interactive-single__control-years-wrapper');
    const container = document.querySelector('.data-interactive-single__control-years');

    if (!wrapper || !container) return;

    const leftFade = document.createElement('div');
    leftFade.className = 'fade-left';
    leftFade.style.position = 'absolute';
    leftFade.style.top = '0';
    leftFade.style.left = '0';
    leftFade.style.bottom = '0';
    leftFade.style.width = '80px';
    leftFade.style.background = 'linear-gradient(to right, #FAF2EB, transparent)';
    leftFade.style.pointerEvents = 'none';
    leftFade.style.zIndex = '1';

    const rightFade = document.createElement('div');
    rightFade.className = 'fade-right';
    rightFade.style.position = 'absolute';
    rightFade.style.top = '0';
    rightFade.style.right = '0';
    rightFade.style.bottom = '0';
    rightFade.style.width = '80px';
    rightFade.style.background = 'linear-gradient(to left, #FAF2EB, transparent)';
    rightFade.style.pointerEvents = 'none';
    rightFade.style.zIndex = '1';

    wrapper.style.position = 'relative';
    wrapper.appendChild(leftFade);
    wrapper.appendChild(rightFade);

    container.addEventListener('scroll', handleScrollFade);

    handleScrollFade();
};

// Global initializer for year scroller arrows
const initYearsScrollArrows = () => {
    const wrapper = document.querySelector('.data-interactive-single__control-years-wrapper');
    const scroller = document.querySelector('.data-interactive-single__control-years');
    const prevBtn = wrapper?.querySelector('.data-interactive-single__prev-btn');
    const nextBtn = wrapper?.querySelector('.data-interactive-single__next-btn');
    const items = scroller ? scroller.querySelectorAll('.data-interactive-single__year') : [];

    if (!(wrapper && scroller && prevBtn && nextBtn)) return;

    // expose global hook if needed
    window.initYearsScrollArrows = () => {
        scrollHorizontalItems({
            nextPrevWrapper: wrapper,
            nextBtn,
            prevBtn,
            scroller,
            items,
            snapToNextElement: false,
        });
    };

    // initialize now
    window.initYearsScrollArrows();
};
const animateTrendIconsOnView = () => {
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.intersectionRatio > 0.1) {
                setTimeout(() => {
                    entry.target.classList.add('is-animated');
                }, 500);
            }
        });
    }, {
        threshold: [0.1]
    });

    document.querySelectorAll('.component-trend-icon').forEach(icon => {
        observer.observe(icon);
    });
};

export { safeURL, detectIframeVideos, startGlobals, preloadImages, scrollHorizontalItems };
