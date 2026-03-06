import {recurringTabKey, helper} from './utils.js?v=032';
const startHeader = (block)=>{
    //
    const siteNav = document.querySelector('#site-nav');
    const navMobileBtn = block.querySelector('.site-header__nav-mobile-btn');
    const firstLevelBtn = block.querySelectorAll('.site-nav__first-level-btn');
    const logo = block.querySelector('.site-header__logo');
    const logoNavMobile = block.querySelector('.site-nav-mobile__logo');
    const logoNavMobileWrapper = block.querySelector('.site-nav-mobile__logo-wrapper');
    const logoLottiePlayer = logo.querySelector(".site-header__lottie-player");
    const mqMobile = 1024;
    const secondaryNavMobile = block.querySelector('.site-secondary-nav-mobile');
    let scrollMaxY = window.scrollMaxY || (document.documentElement.scrollHeight - document.documentElement.clientHeight);
    let scrollTop = 0;
    let scrollIsTop = 1;
    let prevScrollTop = 0;
    let headerHide = 0;
    //
    block.querySelectorAll('.site-secondary-nav-desktop').forEach(el => {
        el.innerHTML = secondaryNavMobile.innerHTML.split('-mobile').join('-desktop');
    });
    const collapseAllMobileNavItems = () => {
        firstLevelBtn.forEach(el => {
            el.classList.remove('expanded');
            el.removeAttribute('style');
        });
        document.querySelectorAll('.second-level-wrapper--expanded').forEach(el => {
            el.classList.remove('second-level-wrapper--expanded');
            el.removeAttribute('style');
        });
    }
    
    const calcHeightDesktopNav = () => {
        let height = 0;
        const wrap = document.querySelectorAll('.site-nav__second-level-wrapper');
        if(window.innerWidth < mqMobile){
            wrap.forEach(el => {
                el.removeAttribute('style');
            });
        }else{
            wrap.forEach(el => {
                el.removeAttribute('style');
                if(el.clientHeight > height){
                    height = el.clientHeight;
                }
            });
            //height += 90;
            height += 100;
            height += 'px';
            wrap.forEach(el => {
                el.style.height = height;
            });
        }
    }

    const resize = () => {
        if(window.innerWidth < mqMobile && !document.body.classList.contains('nav-mobile-mode')){
            document.body.classList.remove('nav-desktop-mode','nav-desktop-open');
            document.body.classList.add('nav-mobile-mode');
            document.querySelectorAll('.site-nav__second-level-wrapper').forEach(el => {
                el.removeAttribute('style');
            });
        }else if(window.innerWidth >= mqMobile && !document.body.classList.contains('nav-desktop-mode')){
            document.body.classList.add('nav-desktop-mode');
            document.body.classList.remove('nav-mobile-mode','nav-mobile-open');
            navMobileBtn.classList.remove('nav-mobile-btn--inverted');
            logoNavMobile.classList.remove('logo--inverted');
            collapseAllMobileNavItems();
            recurringTabKey.removeAllGroups();
            logo.removeAttribute('tabindex');
        }
        calcHeightDesktopNav();
    }
    calcHeightDesktopNav();
    //
    resize();
    navMobileBtn.addEventListener('click',e => {
        collapseAllMobileNavItems();
        document.body.classList.toggle('nav-mobile-open');
        navMobileBtn.classList.toggle('nav-mobile-btn--inverted');
        logoNavMobile.classList.toggle('logo--inverted');
        //if(document.body.classList.contains('nav-mobile-open')){
            siteNav.scrollTo({top:0});
        //}
        scrollMaxY = window.scrollMaxY || (document.documentElement.scrollHeight - document.documentElement.clientHeight);
        scrollTop = Math.min(scrollMaxY,Math.max(0,window.scrollY));
        if(document.body.classList.contains('nav-mobile-open')){
            logo.setAttribute('tabindex',-1);
            recurringTabKey.addGroup('mobileNav', block);
        }else{
            recurringTabKey.removeGroup('mobileNav');
            logo.removeAttribute('tabindex');
        }
    });
    window.addEventListener('resize', resize);
    //
    logoNavMobileWrapper.addEventListener('click', e => {
        const href = logoNavMobileWrapper.dataset.href;
        if(href == window.location){
            navMobileBtn.click();
        }else{
            window.location = href;
        }
    });
    //  
    /* const logoLottieHolder = block.querySelector('.site-header__logo-lottie');
    const logoDefault = block.querySelector('.site-header__logo-default');
    const logoLottie = lottie.loadAnimation({
        container: logoLottiePlayer, // the dom element that will contain the animation
        renderer: 'svg',
        loop: false,
        autoplay: false,
        path: logo.dataset.src // the path to the animation json
    });
    //alert(logo.dataset.src)
    logoLottie.setSpeed(2);
    logoLottie.addEventListener('DOMLoaded', e => {
        const path = logoLottiePlayer.querySelectorAll('path');
        path.forEach((el,i) => {
            //apply logo colors from css vars 
            if(i == 0 || i == 4 || i == 7 || i == 12 || i == 15){
                el.style.fill = 'var(--logo-color-bg)';
            }else{
                el.style.fill = 'var(--logo-color)';
            }
            el.style.transition = 'var(--logo-svg-path-transition)';
        });
        logoDefault.remove();
    }); */
    //
    const pageTimeline = document.querySelector('.page-timeline');
    const pageCardList = document.querySelector('.page-cards-v2');
    const pageCardTopBar = document.querySelector('.page-cards-v2__top-bar');
    const pageCardSingle = document.querySelector('.page-cards-single-v2__content');
    const navMobileIcon = document.querySelector('.site-header__nav-mobile-btn');

    window.addEventListener('scroll', e => {
        scrollTop = Math.min(scrollMaxY,Math.max(0,window.scrollY));

        const pageTimelineMobile = pageTimeline && window.innerWidth < 768;

        if(scrollTop > 0 && scrollIsTop){
            scrollIsTop = 0;
            document.body.classList.add('scrolled');
            //logoLottie.setDirection(1);
            //logoLottie.play();
        }else if(scrollTop == 0 && !scrollIsTop){
            scrollIsTop = 1;
            document.body.classList.remove('scrolled');
            //logoLottie.setDirection(-1);
            //logoLottie.play();
        }
       
        if(pageTimelineMobile){
            if(headerHide && scrollTop <= 0){
                document.body.classList.remove('header-hide');
                headerHide = 0;
            }else if(!headerHide && scrollTop > 0){
                document.body.classList.add('header-hide');
                headerHide = 1;
            }
            if(prevScrollTop > scrollTop){
                navMobileIcon.classList.remove('site-header__nav-mobile-btn--hide');
            }else if(prevScrollTop < scrollTop){
                navMobileIcon.classList.add('site-header__nav-mobile-btn--hide');
            }
        }else{
            if(headerHide && prevScrollTop > scrollTop){
                document.body.classList.remove('header-hide');
                headerHide = 0;
            }else if(!headerHide && prevScrollTop < scrollTop){
                document.body.classList.add('header-hide');
                headerHide = 1;
            }

        }
        if(!!pageCardList && window.innerWidth < 768){
            const boundingClientRect = pageCardTopBar.getBoundingClientRect();
            if(boundingClientRect.top < 68){
                navMobileIcon.classList.add('site-header__nav-mobile-btn--hide');
            }else{
                navMobileIcon.classList.remove('site-header__nav-mobile-btn--hide');
            }
        }else if(!!pageCardSingle && window.innerWidth < 1024){
            const boundingClientRect = pageCardSingle.getBoundingClientRect();
            if(boundingClientRect.top < 87){
                navMobileIcon.classList.add('site-header__nav-mobile-btn--hide');
            }else{
                navMobileIcon.classList.remove('site-header__nav-mobile-btn--hide');
            }
        }
        

        prevScrollTop = scrollTop;
    });
    //
    let desktopNavTimeout;
    let wrapperDesktopTransitionTime = getComputedStyle(siteNav).getPropertyValue('--second-level-wrapper-desktop-transition-time');
    if(wrapperDesktopTransitionTime.indexOf('ms') !== -1){
        wrapperDesktopTransitionTime = Number(parseFloat(wrapperDesktopTransitionTime));
    }else{
        wrapperDesktopTransitionTime = Number(parseFloat(wrapperDesktopTransitionTime)) * 1000;
    }
    //
    let navMobileTransitionTime = getComputedStyle(siteNav).getPropertyValue('--nav-mobile-transition-time');
    if(navMobileTransitionTime.indexOf('ms') !== -1){
        navMobileTransitionTime = Number(parseFloat(navMobileTransitionTime));
    }else{
        navMobileTransitionTime = Number(parseFloat(navMobileTransitionTime)) * 1000;
    }
    //
    //--- trigger close desktop nav when focused element outside nav ---
    document.querySelectorAll('a,button').forEach(elem => {
        elem.addEventListener('focus', e => {
            if(document.body.classList.contains('nav-desktop-open-2')){
                const navClickable = siteNav.querySelectorAll('a,button');
                let hit = false;
                navClickable.forEach(el => {
                    if(el == document.activeElement){
                        hit = true;
                    }
                });
                if(!hit && !navMobileBtn.clientHeight){
                    e = new MouseEvent('mouseleave', { view: window, cancelable: true, bubbles: true });
                    block.dispatchEvent(e);
                    return false;
                }
            }
        });
    });
    //
    block.addEventListener('mouseleave', e => {
        document.body.classList.remove('nav-desktop-open-2');
        if(!document.body.classList.contains('nav-desktop-mode')) return false;
        clearTimeout(desktopNavTimeout);
        const visible = document.querySelector('.second-level-wrapper--visible');
        if(!!visible){
            visible.classList.add('second-level-wrapper--transition');
            visible.classList.remove('second-level-wrapper--fade-in');
            logo.classList.remove('logo--inverted','logo--large');
            siteNav.classList.remove('site-nav--inverted','site-nav--fixed');
            //visible.querySelector('.site-secondary-nav-desktop').classList.remove('site-secondary-nav-desktop--visible','site-secondary-nav-desktop--transition');
            block.querySelectorAll('.site-secondary-nav-desktop').forEach(el => {
                el.classList.remove('site-secondary-nav-desktop--visible','site-secondary-nav-desktop--transition');
            });
            desktopNavTimeout = setTimeout(() => {
                document.body.classList.remove('nav-desktop-open');
                document.querySelectorAll('.site-nav__second-level-wrapper').forEach(el => {
                    el.classList.remove('second-level-wrapper--visible', 'second-level-wrapper--transition', 'second-level-wrapper--fade-in');
                });
            }, wrapperDesktopTransitionTime+10);
            block.querySelectorAll('.site-nav__first-level-btn').forEach(elem => {
                elem.classList.remove('hover');
            });
            if(scrollTop > 0){
                //logoLottie.setDirection(1);
                //logoLottie.play();
            }
        }
    });
    firstLevelBtn.forEach(el => {
        const childLinks = el.parentNode.querySelectorAll('.site-nav__second-level-a');
        if(!document.body.classList.contains('page-home')){
            const loc = String(window.location).split('#')[0];
            childLinks.forEach(elem => {
                const href = elem.getAttribute('href');
                if(loc == href || href.indexOf(loc) !== -1 || loc.indexOf(href) !== -1){
                    el.classList.add('selected');//-->marca el item seleccionado
                    elem.classList.add('selected');//-->marca el subitem seleccionado
                }
            });
        }
        el.addEventListener('click', e => {
            if(!document.body.classList.contains('touch-device') && !navMobileBtn.clientHeight && !!childLinks[0] && window.location != childLinks[0].getAttribute('href')){
                window.location = childLinks[0].getAttribute('href');
            }
        });
        el.addEventListener('focus', e => {
            if(document.body.classList.contains('touch-device')) return false;
            e = new MouseEvent('mouseover', { view: window, cancelable: true, bubbles: true });
            el.dispatchEvent(e);
        });
        el.addEventListener('mouseover', e => {
            document.body.classList.add('nav-desktop-open-2');
            if(!document.body.classList.contains('nav-desktop-mode')) return false;
            clearTimeout(desktopNavTimeout);
            const navIsOpen = document.body.classList.contains('nav-desktop-open');
            logo.classList.add('logo--inverted','logo--large');
            siteNav.classList.add('site-nav--inverted','site-nav--fixed');
            block.querySelectorAll('.site-nav__first-level-btn').forEach(elem => {
                elem.classList.remove('hover');
            });
            el.classList.add('hover');
            document.querySelectorAll('.site-nav__second-level-wrapper').forEach(elem => {
                elem.classList.remove('second-level-wrapper--visible', 'second-level-wrapper--transition', 'second-level-wrapper--fade-in');
            });
            const wrapper = el.parentNode.querySelector('.site-nav__second-level-wrapper');
            if(navIsOpen){
                wrapper.classList.remove('second-level-wrapper--transition');
                wrapper.classList.add('second-level-wrapper--visible','second-level-wrapper--fade-in');
                wrapper.querySelector('.site-secondary-nav-desktop').classList.add('site-secondary-nav-desktop--visible');
            }else{
                wrapper.classList.add('second-level-wrapper--visible','second-level-wrapper--transition');
                wrapper.querySelector('.site-secondary-nav-desktop').classList.add('site-secondary-nav-desktop--visible','site-secondary-nav-desktop--transition');
                desktopNavTimeout = setTimeout(() => {
                    wrapper.classList.add('second-level-wrapper--fade-in');
                    document.body.classList.add('nav-desktop-open');
                },50);
                if(scrollTop > 0){
                    //logoLottie.setDirection(-1);
                    //logoLottie.play();
                }
            }
        });
        
        el.addEventListener('click', e => {
            if(!document.body.classList.contains('nav-mobile-mode')) return false;
            clearTimeout(desktopNavTimeout);
            const wrapper = el.parentNode.querySelector('.site-nav__second-level-wrapper');
            const ul = wrapper.querySelectorAll('ul');
            el.classList.toggle('expanded');
            wrapper.classList.toggle('second-level-wrapper--expanded');
            if(el.classList.contains('expanded')){
                logo.classList.remove('logo--inverted','logo--large');
                let height = 0;
                ul.forEach(el => {
                    height += el.offsetHeight;
                });
                wrapper.style.height = height+'px';
                desktopNavTimeout = setTimeout(() => {
                    wrapper.style.height = 'auto';    
                },navMobileTransitionTime+10);
            }else{
                logo.classList.remove('logo--inverted','logo--large');
                wrapper.style.height = wrapper.offsetHeight+'px';
                desktopNavTimeout = setTimeout(() => {
                    wrapper.style.height = '0';
                },50);
            }
        });
    });
    block.classList.add('loaded');
}
const startModule = (block)=>{
    startHeader(block);
    const ulNav = block.querySelector('.site-nav__first-level-ul');
    if(!!ulNav){
        const resize = () => {
            ulNav.style.setProperty('--bg-nav-width', (ulNav.clientWidth+52)+'px');
        }
        window.addEventListener('resize', resize);
        resize();
    }
}
export {startModule};


