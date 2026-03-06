//import {browserZoom,helper,system, utils, ImagePreloader} from './utils.js?v=032'
import {CookieManager,swipeDetect,helper} from './utils.js?v=032';
const startModule = (block) => {
    block.classList.add('loaded');
    initSearchForm(block);
    initViewButtons(block);
    initCards(block);
    initTopBarPosition(block);
    initFeatured(block);
    initFeaturedMobile(block);
    initFilters(block);
    animateCardsOnView(block);
}

const initFilters = (block) => {
    const scroller = block.querySelector('.page-cards-v2__filters-scroller');
    if(!!scroller){
        const value = sessionStorage.getItem('cardFilterScroll') ?? 0;
        scroller.scrollLeft = value;
        const saveScroll = () => {
            sessionStorage.setItem('cardFilterScroll', scroller.scrollLeft);
        }
        scroller.addEventListener('scroll', saveScroll);
        window.addEventListener('resize', saveScroll);
    }
    const viewBtn = block.querySelector('.page-cards-v2__view-btn--selected');
    const filterBtn = block.querySelector('.page-cards-v2__filters .btn--selected');
    if(!!viewBtn && !!filterBtn){
        viewBtn.addEventListener('click', e => {
            e.preventDefault();
            filterBtn.click();
        });
    }
}

const animateCardsOnView = (block) => {
    let delay;
    let total = 0;
    const observer = new IntersectionObserver(entries => {
        delay = 100;
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                delay += 50;
                entry.target.classList.add('page-cards-v2__item--loaded');
                entry.target.style.transitionDelay = delay+'ms';
                observer.unobserve(entry.target);
            }
        });
    },{
        rootMargin: '0px 0px 0px 0px',
    });
    block.querySelectorAll('.page-cards-v2__item:not(.page-cards-v2__item--not-fade)').forEach((el)=> {
        observer.observe(el);
    });
}
const initTopBarPosition = (block) => {
    //
    //--- settings ---//
    const enableOffsetY = true;// esta activa el desplazamiento de la topBar en el contrascroll
    //
    //
    const topBar = block.querySelector('.page-cards-v2__top-bar');
    const topBarInner = block.querySelector('.page-cards-v2__top-bar-inner');
    const topBarSpace = block.querySelector('.page-cards-v2__top-bar-space');
    const topBarFilterScroller = block.querySelector('.page-cards-v2__filters-scroller');
    const navMobileBtn = block.querySelector('.site-header__nav-mobile-btn');
    if(!topBar) return false;
    const maxScrollY = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight) - window.innerHeight;
    let prevScrollY = 0;
    let barOnTop = false;
    let prevTransform = 0;
    //
    const controlTopBarPosition = () => {
        let offsetY = Number(getComputedStyle(topBar).getPropertyValue('--top-bar-offset-y').replace(/[^\d.]/g, ''));
        if(isNaN(offsetY)){
            offsetY = 140;
        }
        //
        const winScrollY = Math.min(maxScrollY,window.scrollY);
        const direction = prevScrollY <= winScrollY;
        prevScrollY = winScrollY;
        //helper.log(window.scrollY,true)
        //
        const headerHide = document.body.classList.contains('header-hide');
        const boundingClientRect = topBar.getBoundingClientRect();
        //helper.log(boundingClientRect.top+' '+direction,true)
        if(direction && boundingClientRect.top <= 0 && headerHide){
            topBarInner.classList.add('page-cards-v2__top-bar-inner--add-transition');
            topBarInner.style.position = 'fixed';
            topBarInner.style.left = '0px';
            const top = Math.max(boundingClientRect.top,0);
            topBarInner.style.top = top+'px';
            topBarInner.style.transform = 'translateY(0px)';
            prevTransform = 0;
            //helper.log('A '+boundingClientRect.top+' '+direction,true)
        }else if(!direction && boundingClientRect.top <= offsetY && !headerHide){
            topBarInner.classList.add('page-cards-v2__top-bar-inner--add-transition');
            topBarInner.style.position = 'fixed';
            topBarInner.style.left = '0px';
            topBarInner.style.top = '0px';
            topBarInner.style.transform = `translateY(${offsetY}px)`;
            prevTransform = offsetY;
            //helper.log('B '+boundingClientRect.top+' '+direction,true)
        }else if(!direction && boundingClientRect.top > offsetY){
            topBarInner.classList.remove('page-cards-v2__top-bar-inner--add-transition');
            topBarInner.style.position = 'relative';
            topBarInner.style.left = 'inherit';
            topBarInner.style.top = 'inherit';
            topBarInner.style.transform = 'translateY(0px)';
            prevTransform = 0;
            //helper.log('C '+boundingClientRect.top+' '+direction,true)
        }

        //control de seguridad para contrascroll con la topbar fija
        if(prevTransform > 0 && direction && boundingClientRect.top > 0){
            topBarInner.style.position = 'fixed';
            topBarInner.style.left = '0px';
            const top = Math.max(boundingClientRect.top,0);
            topBarInner.style.top = top+'px';
            topBarInner.style.transform = 'translateY(0px)';
            //helper.log('D '+boundingClientRect.top+' '+direction,true)
        }
        
        controlLogo();
        
    }
    const controlLogo = () => {
        if(window.scrollY > 100){
            document.body.classList.add('hide-header-logo');
        }else{
            document.body.classList.remove('hide-header-logo');
        }
    }
    //
    if(enableOffsetY){
        controlTopBarPosition();
        window.addEventListener('scroll', controlTopBarPosition);
    }else{
        topBar.style.position = 'sticky';
        topBar.style.top = 0;
        topBar.style.zIndex = 95;
        window.addEventListener('scroll', controlLogo);
        controlLogo();
        controlNavBtn();
    }
}

const initFeaturedMobile = (block) => {
    const holder = block.querySelector('.page-cards-v2__view-mode-featured-holder');
    if(!holder) return false;
    const cards = block.querySelectorAll('.page-cards-v2__card');
    const cardsLayers = [];
    let j = 0;
    cards.forEach((el, i) => {
        j++;
        el.classList.add('page-cards-v2__card--m'+j, 'page-cards-v2__card--m-num-'+i);
        cardsLayers.push(el);
        if(j == 4){
            j = 0;
        }
    });
    //cardsLayers.reverse();
    const setZindex = () => {
        cardsLayers.forEach((el, i) => {
            el.style.zIndex = cards.length - i;
        });
    }
    setZindex();
    cardsLayers[0].classList.add('page-cards-v2__card--m-first');
    //
    let mobileTransitionRun;
    const prevBtn = block.querySelector('.page-cards-v2__view-mode-featured-mobile-prev-btn');
    const nextBtn = block.querySelector('.page-cards-v2__view-mode-featured-mobile-next-btn');
    if(!!prevBtn && !!nextBtn){
        prevBtn.addEventListener('click', e => {
            if(mobileTransitionRun) return false;
            mobileTransitionRun = true;
            const prevFirst = block.querySelector('.page-cards-v2__card--m-first');
            if(!!prevFirst){
                prevFirst.classList.remove('page-cards-v2__card--m-first');
            }
            const prevElement = cardsLayers[cardsLayers.length - 1];
            prevElement.classList.add('page-cards-v2__card--m-top-left');   
            setTimeout(() => {
                const lastElement = cardsLayers.pop(); // Remueve y obtiene el último elemento
                cardsLayers.unshift(lastElement); // Lo agrega al inicio
                setZindex();  
                cardsLayers[0].classList.add('page-cards-v2__card--m-first');
                setTimeout(() => {
                    prevElement.classList.remove('page-cards-v2__card--m-top-left');
                    mobileTransitionRun = false;
                }, 50);
            }, 400);
        });
        nextBtn.addEventListener('click', e => {
            if(mobileTransitionRun) return false;
            mobileTransitionRun = true;
            const prevFirst = block.querySelector('.page-cards-v2__card--m-first');
            if(!!prevFirst){
                prevFirst.classList.remove('page-cards-v2__card--m-first');
            }
            const prevElement = cardsLayers[0];
            prevElement.classList.add('page-cards-v2__card--m-top-left');   
            cardsLayers[1].classList.add('page-cards-v2__card--m-first');
            setTimeout(() => {
                const firstElement = cardsLayers.shift(); // Remueve y obtiene el primer elemento
                cardsLayers.push(firstElement);
                setZindex();  
                setTimeout(() => {
                    prevElement.classList.remove('page-cards-v2__card--m-top-left');
                    mobileTransitionRun = false;
                }, 50);
            }, 400);
        });
        swipeDetect('#view-mode-featured-holder', {
            preventScrolling: false,
            stopPropagation: true,
            handleswipe: (swipedir)=>{
                if(swipedir == 'left'){
                    nextBtn.click();
                }else if(swipedir == 'right'){
                    prevBtn.click();
                }
            }
        });
    }
}

const initFeatured = (block) => {

    //-----------------------------------//
    //--- featured desktop pagination ---//
    //
    // Función para generar una clave única basada en la URL actual
    const generatePageKey = () => {
        const pathname = window.location.pathname;
        const urlParams = new URLSearchParams(window.location.search);
        // Obtener el filtro o usar 'default' si no existe
        const filter = urlParams.get('filter') || 'default';   
        // Crear una clave única combinando pathname y filter
        return `page_${pathname.replace(/\//g, '_')}_${filter}`;
    }
    // Función para guardar el número de página
    const saveCurrentPage = (pageNumber) => {
        const key = generatePageKey();
        sessionStorage.setItem(key, pageNumber.toString());
        //console.log(`Página ${pageNumber} guardada con clave: ${key}`);
    }
    // Función para obtener el número de página guardado
    const getCurrentPage = () => {
        const key = generatePageKey();
        const savedPage = sessionStorage.getItem(key);
        return savedPage ? parseInt(savedPage, 10) : 1;
    }
    // Función para limpiar páginas guardadas (opcional)
    const clearPagesForCurrentPath = () => {
        const pathname = window.location.pathname;
        const keysToRemove = [];
        // Buscar todas las claves que coincidan con el pathname actual
        for (let i = 0; i < sessionStorage.length; i++) {
            const key = sessionStorage.key(i);
            if (key && key.startsWith(`page_${pathname.replace(/\//g, '_')}_`)) {
                keysToRemove.push(key);
            }
        }
        // Remover las claves encontradas
        keysToRemove.forEach(key => sessionStorage.removeItem(key));
        console.log(`Limpiadas ${keysToRemove.length} páginas para ${pathname}`);
    }
    // Función para obtener todas las páginas guardadas del path actual
    const getAllPagesForCurrentPath = () => {
        const pathname = window.location.pathname;
        const pages = {};   
        for (let i = 0; i < sessionStorage.length; i++) {
            const key = sessionStorage.key(i);
            if (key && key.startsWith(`page_${pathname.replace(/\//g, '_')}_`)) {
                const filter = key.split('_').pop();
                const pageNumber = parseInt(sessionStorage.getItem(key), 10);
                pages[filter] = pageNumber;
            }
        }
        return pages;
    }
    //
    //--- featured desktop pagination ---//
    //-----------------------------------//
    //
    const holder = block.querySelector('.page-cards-v2__view-mode-featured-holder');
    const cards = block.querySelectorAll('.page-cards-v2__card');
    const cardsPerPage = 4;
    const totalPages = Math.ceil(cards.length / cardsPerPage);
    let currentPage = getCurrentPage() ?? 1; 
    let transitionRun = false;
    let transitionTimeout;
    if(!holder) return false;
    const changeFeaturedPage = () => {
        holder.classList.remove('page-cards-v2__view-mode-featured-holder--fade-in');
        cards.forEach((el, i) => {
            el.classList.add('page-cards-v2__card--hidden','page-cards-v2__card--start-position', 'page-cards-v2__card--remove-transition');   
            for(let j=1; j<=cardsPerPage; j++){
                el.classList.remove('page-cards-v2__card--n'+j, 'page-cards-v2__card--1-perpage', 'page-cards-v2__card--2-perpage', 'page-cards-v2__card--3-perpage');
            }
        });
        setTimeout(() => {
            let n = 0;
            cards.forEach((el, i) => {
                if(i < cardsPerPage * currentPage && i >= cardsPerPage * (currentPage - 1)){
                    n ++;
                    el.classList.add('page-cards-v2__card--n'+n);
                }
            });
            cards.forEach((el, i) => {
                if(i < cardsPerPage * currentPage && i >= cardsPerPage * (currentPage - 1)){
                    el.classList.add('page-cards-v2__card--'+n+'-perpage');
                    el.classList.remove('page-cards-v2__card--hidden', 'page-cards-v2__card--remove-transition');
                }
            });
            setTimeout(() => {
                holder.classList.add('page-cards-v2__view-mode-featured-holder--fade-in');
                cards.forEach((el, i) => {
                    el.classList.remove('page-cards-v2__card--start-position');
                });
            }, 100);
        }, 100);
        if(totalPages < 2){
            const controls = block.querySelector('.page-cards-v2__view-mode-featured-desktop-controls')
            if(!!controls){
                controls.style.display = 'none';
            }
        }
    }
    changeFeaturedPage();
    //
    const prevBtnDesktop = block.querySelector('.page-cards-v2__view-mode-featured-desktop-prev-btn');
    if(!!prevBtnDesktop){
        prevBtnDesktop.addEventListener('click', e => {
            currentPage--;
            if(currentPage < 1){
                currentPage = totalPages;
            }
            saveCurrentPage(currentPage);
            changeFeaturedPage();
        });
    }
    const nextBtnDesktop = block.querySelector('.page-cards-v2__view-mode-featured-desktop-next-btn');
    if(!!nextBtnDesktop){
        nextBtnDesktop.addEventListener('click', e => {
            currentPage++;
            if(currentPage > totalPages){
                currentPage = 1;
            }
            saveCurrentPage(currentPage);
            changeFeaturedPage();
        });
    }
}

const initCards = (block) => {
    let transitionRun = false;
    let blockComputedStyle = getComputedStyle(block);
    let fadeOutDuration = Number(blockComputedStyle.getPropertyValue('--fade-out-duration').replace(/[^\d.]/g, ''));
    if(isNaN(fadeOutDuration)){
        fadeOutDuration = 500;
    }else if(fadeOutDuration < 10){
        fadeOutDuration = fadeOutDuration * 1000;
    }
    //block.querySelectorAll('.page-cards-v2__card a').forEach(el => {
    block.querySelectorAll('.page-cards-v2__item a').forEach(el => {
        el.addEventListener('click', e => {
            e.preventDefault();
            if(transitionRun) return false;
            transitionRun = true;
            const href = el.getAttribute('href');
            block.classList.add('page-cards-v2--fade-out');
            document.body.classList.add('footer-fade-out');
            setTimeout(() => {
                if(document.body.classList.contains('header-hide')){
                    CookieManager.set('headerHidden', 1, {maxAge:5});
                }
                CookieManager.set('prevCardsURL', window.location, {maxAge:5});
                window.location = href;
                setTimeout(() => {
                    block.classList.remove('page-cards-v2--fade-out');
                    document.body.classList.remove('footer-fade-out');
                    transitionRun = false;
                }, 1000);
            }, fadeOutDuration + 50);
        });
    });
}
const initViewButtons = (block) => {
    const holder = block.querySelector('.page-cards-v2__view-holder');
    if(!holder) return false;
    holder.addEventListener('click', e => {
        if(e.target.classList.contains('page-cards-v2__view-btn--selected')){
            e.preventDefault();
        }
    });
}
const initSearchForm = (block) => {
    const formDesktop = document.getElementById('cards-search-form-desktop');
    if(!formDesktop) return false;
    const openSearchFormBtn = document.getElementById('open-search-form-btn');
    const topBarInner = block.querySelector('.page-cards-v2__top-bar-inner');
    const searchFieldDesktop = document.getElementById('cards-search-field-desktop');
    const placeholderDesktop = searchFieldDesktop.placeholder;
    const colorArea = block.querySelector('.page-cards-v2__top-bar-color-area');
    const formDesktopWrapper = block.querySelector('.page-cards-v2__search-form-desktop-wrapper');
    const formDesktopCloseBtn = block.querySelector('.page-cards-v2__search-form-desktop-close-btn');
    const formDesktopField = block.querySelector('.page-cards-v2__search-form-desktop-field');
    const formDesktopSubmitBtn = block.querySelector('.page-cards-v2__search-form-desktop-submit-btn');
    //
    const openSearchFormMobileBtn = document.getElementById('open-search-form-mobile-btn');
    const searchFieldMobile = document.getElementById('cards-search-field-mobile');
    const placeholderMobile = searchFieldMobile.placeholder;
    const formMobileWrapper = block.querySelector('.page-cards-v2__search-form-mobile-wrapper');
    const formMobileCloseBtn = block.querySelector('.page-cards-v2__search-form-mobile-close-btn');
    const formMobile = block.querySelector('.page-cards-v2__search-form-mobile');
    const formMobileField = block.querySelector('.page-cards-v2__search-form-mobile-field');
    const formMobileSubmitBtn = block.querySelector('.page-cards-v2__search-form-mobile-submit-btn');
    //
    //--- get vars from css ---//
    //
    let formDesktopComputedStyle = getComputedStyle(formDesktopWrapper);
    let formDesktopWrapperDisplay =  formDesktopComputedStyle.getPropertyValue('--form-desktop-wrapper-display');
    let formDesktopWrapperExpandedWidth = formDesktopComputedStyle.getPropertyValue('--form-desktop-wrapper-expanded-width');
    let formDesktopExpandedWidth = formDesktopComputedStyle.getPropertyValue('--form-desktop-expanded-width');//'calc(100% - 64px)';
    let formDesktopWrapperLeft = formDesktopComputedStyle.getPropertyValue('--form-desktop-wrapper-left');//'50%';
    let formDesktopWrapperTransform = formDesktopComputedStyle.getPropertyValue('--form-desktop-wrapper-transform');//'translateX(-50%)';
    let formDesktopSubElementsOpacity = formDesktopComputedStyle.getPropertyValue('--form-desktop-expanded-sub-elements-opacity');
    //
    let formMobileComputedStyle;
    let formMobileWrapperWidth;
    let formMobileWrapperDisplay;
    let formMobileWrapperExpandedWidth;
    let formMobileExpandedWidth;
    let formMobileWrapperLeft;
    let formMobileWrapperTransform;
    let formMobileSubElementsOpacity;
    let formMobileWrapperExpandedLeft;
    let formMobileWrapperCollapsedLeft;
    //
    const getCssVars = () => {
        formDesktopComputedStyle = getComputedStyle(formDesktopWrapper);
        formDesktopWrapperDisplay =  formDesktopComputedStyle.getPropertyValue('--form-desktop-wrapper-display');
        formDesktopWrapperExpandedWidth = formDesktopComputedStyle.getPropertyValue('--form-desktop-wrapper-expanded-width');
        formDesktopExpandedWidth = formDesktopComputedStyle.getPropertyValue('--form-desktop-expanded-width');//'calc(100% - 64px)';
        formDesktopWrapperLeft = formDesktopComputedStyle.getPropertyValue('--form-desktop-wrapper-left');//'50%';
        formDesktopWrapperTransform = formDesktopComputedStyle.getPropertyValue('--form-desktop-wrapper-transform');//'translateX(-50%)';
        formDesktopSubElementsOpacity = formDesktopComputedStyle.getPropertyValue('--form-desktop-expanded-sub-elements-opacity');
        //
        formMobileComputedStyle = getComputedStyle(formMobileWrapper);
        formMobileWrapperWidth = formMobileComputedStyle.getPropertyValue('--form-mobile-wrapper-width');
        formMobileWrapperDisplay =  formMobileComputedStyle.getPropertyValue('--form-mobile-wrapper-display');
        formMobileWrapperExpandedWidth = formMobileComputedStyle.getPropertyValue('--form-mobile-wrapper-expanded-width');
        formMobileExpandedWidth = formMobileComputedStyle.getPropertyValue('--form-mobile-expanded-width');//'calc(100% - 64px)';
        formMobileWrapperLeft = formMobileComputedStyle.getPropertyValue('--form-mobile-wrapper-left');//'50%';
        formMobileWrapperTransform = formMobileComputedStyle.getPropertyValue('--form-mobile-wrapper-transform');//'translateX(-50%)';
        formMobileSubElementsOpacity = formMobileComputedStyle.getPropertyValue('--form-mobile-expanded-sub-elements-opacity');
        formMobileWrapperExpandedLeft = formMobileComputedStyle.getPropertyValue('--form-mobile-wrapper-expanded-left');
        formMobileWrapperCollapsedLeft = formMobileComputedStyle.getPropertyValue('--form-mobile-wrapper-collapsed-left');
    }
    getCssVars();
    //
    //--- resize ---//
    let desktopMQ = window.innerWidth >= 1024;
    window.addEventListener('resize',() => {
        getCssVars();//rewrite css vars
        //
        //reset position with change mq mobile to desktop
        if(!desktopMQ && window.innerWidth >= 1024){
            window.scrollTo(0, 0);
        }
        desktopMQ = window.innerWidth >= 1024;
    });
    //
    const openSearchDesktop = () => {
        //
        //--- transition js vars ---//
        const transitionTimeStep1 = 600;
        const transitionTimeStep2 = 400;
        const transitionTimeColorArea = 100;
        //
        //---transition step-1 ---//
        formDesktopWrapper.style.transition = `all ${transitionTimeStep1}ms ease`;
        formDesktop.style.transition = `all ${transitionTimeStep1}ms ease`;
        formDesktopCloseBtn.style.transition = `all ${transitionTimeStep1}ms ease`;
        formDesktopWrapper.style.left = openSearchFormBtn.getBoundingClientRect().left+'px';
        formDesktopWrapper.style.display = formDesktopWrapperDisplay;
        formDesktopWrapper.style.width = formDesktopWrapper.clientHeight+'px';
        formDesktopWrapper.style.left = formDesktopWrapperLeft;
        formDesktopWrapper.style.transform = formDesktopWrapperTransform;
        colorArea.style.transition = `opacity ${transitionTimeColorArea}ms ease-out`;
        colorArea.style.height = '100%';
        colorArea.style.opacity = 1;
        openSearchFormBtn.disabled = true;
        openSearchFormBtn.style.opacity = 0;
        setTimeout(() => {
            //
            //---transition step-2 ---//
            formDesktopWrapper.style.transition = `all ${transitionTimeStep2}ms ease`;
            formDesktop.style.transition = `all ${transitionTimeStep2}ms ease`;
            formDesktopCloseBtn.style.transition = `all ${transitionTimeStep2}ms ease`;
            formDesktopField.style.transition = `all 300ms ${transitionTimeStep2}ms ease`;
            formDesktopSubmitBtn.style.transition = `all 300ms ${transitionTimeStep2}ms ease`;
            formDesktopWrapper.style.width = formDesktopWrapperExpandedWidth;
            formDesktop.style.width = formDesktopExpandedWidth;
            formDesktopCloseBtn.style.opacity = formDesktopSubElementsOpacity;
            formDesktopField.style.opacity = formDesktopSubElementsOpacity;
            formDesktopSubmitBtn.style.opacity = formDesktopSubElementsOpacity;
            formDesktopField.placeholder = '';
            //
            setTimeout(() => {
                //
                //--- remove transitions prop ---//
                formDesktopWrapper.removeAttribute('style');
                formDesktop.removeAttribute('style');
                formDesktopCloseBtn.removeAttribute('style');
                formDesktopSubmitBtn.removeAttribute('style');
                formDesktopField.removeAttribute('style');
                //
                //--- apply searh top-bar class ---//
                block.classList.add('page-cards-v2--search-mode');
                //
                //--- focus search field ---//
                formDesktopField.focus();
                //
                resetSearchFormAndButtons();
                //
            }, transitionTimeStep2);    
            //
        }, transitionTimeStep1);
    }
    //
    openSearchFormBtn.addEventListener('click', e => {
        if(block.classList.contains('page-cards-v2--search-mode')) return false;
        openSearchDesktop();
    });
    //
    const openSearchMobile = () => {
        //
        //--- transition js vars ---//
        const transitionTimeStep1 = 400;
        //
        openSearchFormMobileBtn.style.display = 'none';
        formMobileWrapper.style.transition = `all ${transitionTimeStep1}ms ease`;
        formMobile.style.transition = `all ${transitionTimeStep1}ms ease`;
        formMobileCloseBtn.style.transition = `all ${transitionTimeStep1}ms ease`;
        formMobileField.style.transition = `all 300ms ${transitionTimeStep1}ms ease`;
        formMobileSubmitBtn.style.transition = `all 300ms ${transitionTimeStep1}ms ease`;
        formMobileWrapper.style.width = formMobileWrapperExpandedWidth;
        formMobileWrapper.style.left = formMobileWrapperExpandedLeft;
        formMobile.style.width = formMobileExpandedWidth;
        formMobileCloseBtn.style.opacity = formMobileSubElementsOpacity;
        formMobileField.style.opacity = formMobileSubElementsOpacity;
        formMobileSubmitBtn.style.opacity = formMobileSubElementsOpacity;
        formMobileField.placeholder = '';
        //
        setTimeout(() => {
            //
            //--- remove transitions prop ---//
            formMobileWrapper.removeAttribute('style');
            formMobile.removeAttribute('style');
            formMobileCloseBtn.removeAttribute('style');
            formMobileSubmitBtn.removeAttribute('style');
            formMobileField.removeAttribute('style');
            //
            //--- apply searh top-bar class ---//
            block.classList.add('page-cards-v2--search-mode');
            //
            //--- focus search field ---//
            formMobileField.focus();
            //
            resetSearchFormAndButtons();
            //
        }, transitionTimeStep1);    
        //
    }
    //
    openSearchFormMobileBtn.addEventListener('click', e => {
        if(block.classList.contains('page-cards-v2--search-mode')) return false;
        openSearchMobile();
    });
    //
    const resetSearchFormAndButtons = () => {
        colorArea.removeAttribute('style');
        openSearchFormMobileBtn.removeAttribute('style');
        openSearchFormMobileBtn.disabled = false;
        openSearchFormBtn.removeAttribute('style');
        openSearchFormBtn.disabled = false;
        formMobileCloseBtn.removeAttribute('style');
        formDesktopField.removeAttribute('style');
        formDesktopField.value = '';
        formMobileField.value = '';
        formMobileField.removeAttribute('style');
        formDesktopWrapper.removeAttribute('style');
    }
    //
    if(String(window.location).indexOf('search=') !== -1){
        const previousURL = CookieManager.get('previousURL');
        formDesktopCloseBtn.addEventListener('click', e => {
            e.stopPropagation();
            e.preventDefault();
            formDesktopWrapper.style.transition = 'all 0.1s';
            formDesktopWrapper.style.opacity = 0;
            setTimeout(() => {
                window.location = previousURL ? previousURL : String(window.location).split('?search')[0];
                setTimeout(() => {
                    resetSearchFormAndButtons();
                }, 1000);
            }, 100);
        });
        formDesktopCloseBtn.addEventListener('mousedown', e => {
            formMobileField.style.visibility = 'hidden';
        });
        formMobileCloseBtn.addEventListener('click', e => {
            formMobileWrapper.style.transition = `all 200ms 0ms ease`;
            formMobileWrapper.style.width = formMobileWrapperWidth;
            formMobileWrapper.style.left = formMobileWrapperCollapsedLeft;
            formMobileCloseBtn.style.display = 'none';
            setTimeout(() => {
                window.location = previousURL ? previousURL : String(window.location).split('?search')[0];
                setTimeout(() => {
                    resetSearchFormAndButtons();
                }, 1000);
            }, 200);
        });
    }else{
        CookieManager.remove('previousURL');   
        formDesktopCloseBtn.addEventListener('mousedown', e => {
            formDesktopField.style.opacity = 0;
        });
        formDesktopCloseBtn.addEventListener('click', e => {
            formDesktopWrapper.style.transition = 'all 0.1s';
            formDesktopWrapper.style.opacity = 0;
            setTimeout(() => {
                formDesktopWrapper.removeAttribute('style');
                openSearchFormBtn.disabled = false;
                openSearchFormBtn.removeAttribute('style');
                block.classList.remove('page-cards-v2--search-mode');
                colorArea.style.opacity = 0;
                setTimeout(() => {
                    colorArea.removeAttribute('style');
                },100);
            },100);
        });
        formDesktopCloseBtn.addEventListener('mousedown', e => {
            formMobileField.style.visibility = 'hidden';
        });
        formMobileCloseBtn.addEventListener('click', e => {
            formMobileWrapper.style.transition = `all 200ms 0ms ease`;
            formMobileWrapper.style.width = formMobileWrapperWidth;
            formMobileWrapper.style.left = formMobileWrapperCollapsedLeft;
            formMobileCloseBtn.style.display = 'none';
            formMobileField.style.visibility = 'hidden';
            setTimeout(() => {
                formMobileWrapper.removeAttribute('style');
                block.classList.remove('page-cards-v2--search-mode');
                resetSearchFormAndButtons();
            },200);
        });
    }
    //
    formDesktop.addEventListener('submit', function(e) {
        e.preventDefault();
        //
        if(String(window.location).indexOf('search=') === -1){
            //si no está en una página de search
            CookieManager.set('previousURL', window.location);
        }
        const searchValue = searchFieldDesktop.value;
        if(!searchValue) return false;
        const newUrl = buildUrlWithParams(searchValue);
        //
        window.location.href = newUrl;
    });
    searchFieldDesktop.addEventListener('focus', function(e) {
        searchFieldDesktop.placeholder = '';
    });
    searchFieldDesktop.addEventListener('blur', function(e) {
        searchFieldDesktop.placeholder = placeholderDesktop;
    });
    //
    formMobile.addEventListener('submit', function(e) {
        e.preventDefault();
        //
        if(String(window.location).indexOf('search=') === -1){
            //si no está en una página de search
            CookieManager.set('previousURL', window.location);
        }
        const searchValue = searchFieldMobile.value;
        if(!searchValue) return false;
        const newUrl = buildUrlWithParams(searchValue);
        //
        window.location.href = newUrl;
    });
    searchFieldMobile.addEventListener('focus', function(e) {
        searchFieldMobile.placeholder = '';
    });
    searchFieldMobile.addEventListener('blur', function(e) {
        searchFieldMobile.placeholder = placeholderMobile;
    });
    /* 
    formMobileWrapper.addEventListener('click', e => {
        e.stopPropagation();
    });
    document.addEventListener('click', e => {
        if(formMobileWrapper.clientWidth > 100 & String(window.location).indexOf('search=') === -1){
            formMobileCloseBtn.click();
        }
    }); 
    */
}
const buildUrlWithParams = (searchValue) => {
    const current = new URL(window.location);
    const newUrl = new URL(window.location.origin + window.location.pathname);
    // Configuración de parámetros
    const config = {
        keep: ['search','filters'],     // Mantener estos
        remove: ['view'],             // Eliminar estos siempre
        reset: []                         // Resetear estos al buscar
    };
    // Mantener parámetros específicos
    config.keep.forEach(param => {
        if (current.searchParams.has(param)) {
            newUrl.searchParams.set(param, current.searchParams.get(param));
        }
    });
    // Agregar búsqueda
    if (searchValue.trim()) {
        newUrl.searchParams.set('search', searchValue);
    }
    // Eliminar parámetros de reset
    config.reset.forEach(param => {
        newUrl.searchParams.delete(param);
    });
    //
    return newUrl.toString();
}
export {startModule};
