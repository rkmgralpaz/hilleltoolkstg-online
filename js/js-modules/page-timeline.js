import {SerialImageLoader} from './utils.min.js?v=032';
import { scrollHorizontalItems } from './globals.js?v=032';
import { recurringTabKey } from './utils.js';
const startModule = (block)=>{
    //
    const scrollButtons = block.querySelector('.page-timeline__scroll-buttons');
    const filterBtn = block.querySelectorAll('.timeline__filters .btn');
    const jumpBtn = block.querySelectorAll('.timeline__jumps .btn');
    const scroller = block.querySelector('.page-timeline__scroller');
    const itemsWrapper = block.querySelector('.page-timeline__items-wrapper')
    const items = block.querySelectorAll('.page-timeline__item');
    const dotsLineMobileV2 = block.querySelector('.page-timeline__dots-line-mobile-v2');
    //
    const imagesObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {      
            if(!entry.target.dataset.initialized){
                entry.target.dataset.initialized = 1;
                const image = new Image();
                image.onload = function(){
                    entry.target.style.backgroundImage = `url(${entry.target.dataset.src})`;
                    entry.target.parentNode.classList.add('item-image--loaded');
                }
                image.src = entry.target.dataset.src;
            }
        });
    }, {
        rootMargin: '0px 0px 0px 0px', 
    });
    block.querySelectorAll('.image__img').forEach((el)=>{
        imagesObserver.observe(el);
    }); 
    /* const loader = new SerialImageLoader('.image__img',{
        onLoadImage: (e) => {
            //console.log(e);
            e.target.style.backgroundImage = `url(${e.src})`;
            e.target.parentNode.classList.add('item-image--loaded');
        },
        onLoadError: (e) => {
            //console.log(e);
        },
        onComplete: (e) => {
            //console.log(e);
        }
    }); */
    //
    scrollHorizontalItems({
        nextPrevWrapper: block.querySelector('.page-timeline__scroll-buttons'), 
        nextBtn: block.querySelector('.scroll-buttons__btn.btn--right'),
        prevBtn: block.querySelector('.scroll-buttons__btn.btn--left'),
        scroller: scroller,
        items: items,
        snapToNextElement: true,
    });
    //
    const addFilter = (filter) => {
        let prevArrowsStatus = block.classList.contains('page-timeline--no-images');
        let hasImages = false;
        block.classList.remove('page-timeline--no-images');
        items.forEach(el => {
            if(el.dataset.filterNum == filter){
                el.classList.remove('hide');
                if(!!el.querySelector('.item__image')){
                    hasImages = true;
                }
            }else{
                el.classList.add('hide');
            }
        });
        if(!hasImages){
            block.classList.add('page-timeline--no-images');
        }
        if(hasImages == prevArrowsStatus){
            scrollButtons.classList.remove('scroll-buttons--opacity-1');
        }else{
            scrollButtons.classList.add('scroll-buttons--opacity-1');
        }
        block.classList.add('page-timeline--opacity-0');
        scroller.scrollLeft = 0;
        setTimeout(() => {
            block.classList.remove('page-timeline--opacity-0');
        },100);
        window.dispatchEvent(new Event('resize'));
    }
    const removeFilter = () => {
        block.classList.add('page-timeline--opacity-0');
        block.classList.remove('page-timeline--no-images');
        items.forEach(el => {
            el.classList.remove('hide');
        });
        scroller.scrollLeft = 0;
        window.dispatchEvent(new Event('resize'));
        setTimeout(() => {
            block.classList.remove('page-timeline--opacity-0');
        },100);
    }
    //
    filterBtn.forEach(el => {
        el.addEventListener('click', e => {
            const isSelected = el.classList.contains('btn--selected');
            const selected = block.querySelector('.timeline__filters .btn.btn--selected');
            if(isSelected){
                el.classList.remove('btn--selected');
                removeFilter();
            }else if(!!selected){
                selected.classList.remove('btn--selected');
                el.classList.add('btn--selected');
                addFilter(el.dataset.filter);
            }else{
                el.classList.add('btn--selected');
                addFilter(el.dataset.filter);
            }
            let offsetY = document.querySelector('.block-bannerv').offsetHeight;
            if(window.innerWidth < 786 && window.scrollY > offsetY){
                window.scrollTo({
                    top: offsetY,
                    left: 0,
                    behavior: 'smooth'
                });
            }
        });
    });
    //
    jumpBtn.forEach(el => {
        el.addEventListener('click', e => {
            items.forEach(elem => {
                if(!!block.querySelector('.btn--tag.btn--selected')){
                    /* block.classList.remove('page-timeline--no-images');
                    items.forEach(el => {
                        el.classList.remove('hide');
                    });
                    window.dispatchEvent(new Event('resize')); */
                    block.querySelector('.btn--tag.btn--selected').click();
                }
                //
                let hit = el.dataset.id == elem.dataset.id;
                if(hit && window.innerWidth < 768){
                    //elem.scrollIntoView({ behavior: "smooth", block: "end", inline: "nearest" });
                    let offsetY = document.querySelector('.block-bannerv').offsetHeight;
                    window.scrollTo({
                        top: elem.offsetTop + offsetY,
                        left: 0,
                        behavior: 'smooth'
                    });
                }else if(hit){
                    const offsetX = window.innerWidth < 1024 ? 0 : block.querySelector('.scroll-buttons__btn').offsetWidth + 20; 
                    scroller.scrollTo({
                        behavior: 'smooth',
                        left: elem.getBoundingClientRect().left + scroller.scrollLeft - offsetX,
                    });
                    const offsetY = window.innerWidth < 1024 ? -87 : 0;
                    if(window.scrollY < block.offsetTop + offsetY){
                        window.scrollTo({
                            top: block.offsetTop + offsetY,
                            left: 0,
                            behavior: 'smooth'
                        });
                    }
                    return false;
                }
            });
        });
    });
    //
    const modal = block.querySelector('.timeline__image-modal');
    const modalContainer = block.querySelector('.image-modal__container');
    const modalCloseBtn = block.querySelector('.image-modal__close-btn');
    const modalImage = block.querySelector('.image-modal__img');
    const modalCaption = block.querySelector('.image-modal__img-caption');
    const modalOpen = (img,src,caption = '') => {
        if(!img || !src) return false;
        document.body.classList.add('image-modal--open');
        setTimeout(() => {
            block.querySelector('.image-modal__img').innerHTML = `<img src="${src}" />`;
            block.querySelector('.image-modal__img-caption').innerHTML = caption;
            block.querySelectorAll('.image-modal__img-caption a').forEach(elem => {
                const href = elem.getAttribute('href');
                const target = href.indexOf('campus4all') === -1 && href.indexOf('mailto') === -1 ? '_blank' : '';
                elem.setAttribute('target',target);
            });
            modal.classList.add('image-modal--visible');
            modalImg = block.querySelector('.image-modal__img img');
            modalResize();
            recurringTabKey.addGroup('modal',modal);
            modalCloseBtn.focus();
            setTimeout(() => {
                modalResize();
            },300);
        },100);
    }
    const modalResize = () => {
        if(!modalImg) return false;
        const height = window.innerHeight -  modalCaption.offsetHeight -  modalCloseBtn.offsetHeight - 150;
        modalImg.style.height = height+'px';
        modalImg.style.width = 'auto';
        modalImg.style.marginLeft = '0px';
        if(modalImg.clientWidth > window.innerWidth){
            modalImg.style.height = 'auto';
            modalImg.style.width = 'calc(100% - 30px)';
            modalImg.style.marginLeft = '15px';
        }
    }
    let modalImg;
    let prevFocus;
    window.addEventListener('resize',modalResize);
    modalCloseBtn.addEventListener('click', e => {
        e.stopPropagation();
        document.body.classList.remove('image-modal--open');
        modal.classList.add('image-modal--fade-out');
        setTimeout(() => {
            modalImg.remove();
            modal.classList.remove('image-modal--visible','image-modal--fade-out');
            recurringTabKey.removeGroup('modal');
            if(prevFocus){
                prevFocus.focus();
            }
        },150);
    });
    modal.addEventListener('click', e => {
        modalCloseBtn.click();
    });
    modal.addEventListener('click', e => {
        modalCloseBtn.click();
    });
    modalImage.addEventListener('click', e => {
        e.stopPropagation();
    });
    modalCaption.addEventListener('click', e => {
        e.stopPropagation();
    });
    block.querySelectorAll('.item__image').forEach(el => {
        el.addEventListener('click', e => {
            const img = el.querySelector('.image__img');
            if(!!img){
                prevFocus = el;
                const src = img.dataset.src;
                const caption = el.querySelector('.image__caption').innerHTML;
                modalOpen(img,src,caption);
            }
        });
    });
    //
    const dotsLineMobileV2Resize = () => {
        let height = 0;
        items.forEach((el,i) => {
            if(i < items.length-1){
                height += el.offsetHeight;
            }
        });
        dotsLineMobileV2.style.height = height+'px';
    }
    window.addEventListener('resize',dotsLineMobileV2Resize);
    dotsLineMobileV2Resize();
    //
    block.classList.add('loaded');
    //
}
export {startModule};
