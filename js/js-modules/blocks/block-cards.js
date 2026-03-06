//import {helper,system,ImagePreloader, Animation} from '../utils.js';
import {system,swipeDetect,utils} from '../utils.js';
const startModule = (block)=>{
    setTimeout(() => {
        block.classList.add('loaded');
    },100);
    //
    let transitionTimeout;
    let transitionRunning = false;
    const transitionTime = utils.getCssVar(block,'--dur');
    const transitionTimeFraction = utils.getCssVar(block,'--dur-fr');//fraccion de la var --dur en modo desktop cuando hay una card volteada
    const cards = block.querySelectorAll('.block-cards__card');
    let mobileCards = [];
    const cardAreaBtn = block.querySelectorAll('.card__area-btn');
    const arrowsWrapper = block.querySelector('.block-cards__arrows-wrapper');
    let currentCard = 0;
    let cardSideAnimation = 0;
    const moreCardsBtn = block.querySelector('.block-cards__more-cards-btn');
    const cardFlippedNum = block.querySelectorAll('.block-cards__flipped-num');
    const desktopCounter = block.querySelector('.block-cards__desktop-counter');
    const extractWords = (text, num = 10) => {
        return text.split(/\s+/).slice(0, num).join(" ");
    }
    block.querySelector('.block-cards__arrow-btn-prev').addEventListener('click', e => {
        if(transitionRunning) return false;
        cardSideAnimation = -1;
        currentCard--;
        if(currentCard < 0){
            currentCard = cards.length-1;
        }
        /* if(cards[currentCard].classList.contains('block-cards--card-hidden')){
            paginate(-1);
        }
        cardAreaBtn[currentCard].click(); */
        const urlSegments = String(window.location).split('/');
        const url = String(window.location).split(urlSegments[urlSegments.length-2]+'/').join('')+cards[currentCard].dataset.slug;
        window.location = url; 
    });
    block.querySelector('.block-cards__arrow-btn-next').addEventListener('click', e => {
        if(transitionRunning) return false;
        cardSideAnimation = 1;
        currentCard++;
        if(currentCard >= cards.length){
            currentCard = 0;
        }
        /* if(cards[currentCard].classList.contains('block-cards--card-hidden')){
            paginate(1);
        }
        cardAreaBtn[currentCard].click(); */
        const urlSegments = String(window.location).split('/');
        const url = String(window.location).split(urlSegments[urlSegments.length-2]+'/').join('')+cards[currentCard].dataset.slug;
        window.location = url; 
    });
    //
    //---------------------------------------------------------//
    //--- Apply color palette to arrow buttons (flip cards) ---//
    //
    const availablePalette = [
        'theme',
        'theme--blue',
        'theme--pink',
        'theme--neutral',
        'theme--green',
        'theme--multicolor-light',
        'theme--multicolor-bright',
        'theme--multicolor-neutral',
        'theme--mode-neutral',
        'theme--mode-light',
        'theme--mode-bright',
        'theme--mode-dark'
    ];
    const applyColorPaletteToArrowButtons = () => {
        const el = block.querySelector('.card--flipped');
        const colorPalette = !!el && window.innerWidth < 1024 ? el.querySelector('.card__face').getAttribute('class').split('card__face card--front').join('').split('theme__text--primary').join('') : arrowsWrapper.dataset.defaultTheme;
        const classPalette = colorPalette.split(' ');
        setTimeout(() => {
            availablePalette.forEach(elem => {
                arrowsWrapper.classList.remove(elem);
            });
            classPalette.forEach(elem => {
                if(elem){
                    arrowsWrapper.classList.add(elem);
                }
            });
        },50);
    }
    let prevWinWidth = window.innerWidth;
    window.addEventListener('resize', e => {
        if((prevWinWidth < 1024 && window.innerWidth >= 1024) || prevWinWidth >= 1024 && window.innerWidth < 1024){
            applyColorPaletteToArrowButtons();
            prevWinWidth = window.innerWidth;
        }
        reposHeading();
    });
    const reposHeading = () => {
        const headingTop = document.querySelector('.block-heading');
        if(!!headingTop && window.innerWidth >= 768){
            headingTop.parentNode.style.height = headingTop.parentNode.clientHeight+'px';
            headingTop.parentNode.style.overflow = 'hidden';
            headingTop.parentNode.style.transition = 'all 0.45s';
            setTimeout(()=>{
                headingTop.parentNode.style.height = '0px';
            },50);
        }
    }
    //
    //--- Apply color palette to arrow buttons (flip cards) ---//
    //---------------------------------------------------------//
    //
    cards.forEach((el, i) => {
        el.style.zIndex = cards.length - i;
        mobileCards.push(el);
        const area = el.querySelector('.card__area-btn');

        if(el.classList.contains('card--displaced')){
            setTimeout(() => {
                area.click();
            },100);   
        }

        let linkDelayTimeout;

        area.addEventListener('click', e => {
            if(transitionRunning) return false;
            clearTimeout(transitionTimeout);
            transitionRunning = true;


            //--------------------------//

            clearTimeout(linkDelayTimeout);

            if(!document.body.classList.contains('type-cards-single')){

                e.preventDefault();

                block.classList.add('has-card-displaced');
                el.classList.add('card--displaced');

                let url = window.location+el.dataset.slug;
                window.scrollTo(0, 0);

                linkDelayTimeout = setTimeout(() => {
                    window.location = url;
                    linkDelayTimeout = setTimeout(() => {
                        block.classList.remove('has-card-displaced');
                        el.classList.remove('card--displaced');
                        transitionRunning = false;
                    },2000);
                },500);

                return false;
            }else{
                
                reposHeading();
            }

            //--------------------------//


            block.classList.add('block-cards--has-card-flipped', 'block-cards--transition-running');
            document.body.classList.add('has-card-flipped');
            const flipped = block.querySelector('.card--flipped');
            let delay = 0;
            if(!!flipped && cardSideAnimation == -1){
                block.classList.add('block-cards--remove-transitions-desktop');
                delay = 100;
            }else if(!!flipped && cardSideAnimation == 1){
                block.classList.add('block-cards--remove-transitions-desktop');
                delay = 100;
            }
            setTimeout(() => {
                if(!!flipped && cardSideAnimation == -1){
                    block.classList.add('block-cards--animate-from-left-desktop','block-cards--remove-transitions-desktop');
                    flipped.classList.add('card--out');
                }else if(!!flipped && cardSideAnimation == 1){
                    block.classList.add('block-cards--animate-from-right-desktop','block-cards--remove-transitions-desktop');
                    flipped.classList.add('card--out');
                }
                el.classList.add('card--in');
            },50);
            cardFlippedNum.forEach(elem => {
                let tmp1 = Number(el.dataset.cardNum);
                if(tmp1 < 10){
                    tmp1 = '0'+tmp1;
                }
                let tmp2 = cards.length;
                if(tmp2 < 10){
                    tmp2 = '0'+cards.length;
                }
                elem.textContent = tmp1+'/'+tmp2;
            });
            if(!!desktopCounter){
                let tmp1 = Number(el.dataset.cardNum);
                if(tmp1 < 10){
                    tmp1 = '0'+tmp1;
                }
                let tmp2 = cards.length;
                if(tmp2 < 10){
                    tmp2 = '0'+cards.length;
                }
                desktopCounter.textContent = tmp1+'/'+tmp2;
            }
            transitionTimeout = setTimeout(() => {
                if(!!flipped){
                    flipped.classList.remove('card--flipped');
                }
                el.classList.add('card--flipped');
                el.querySelector('.card__scroller').scrollTo(0, 0);
                currentCard = Number(el.dataset.cardNum)-1;
                //
                //
                applyColorPaletteToArrowButtons(el);
                arrowsWrapper.classList.add('arrows-wrapper--visible');
                //swapDepth2();//-- habilitando esta funcion se altera el orden de capas (en mobile) cada vez que se abre una nueva card
                //
                //
                const tmpTransitionTime = document.body.classList.contains('has-card-flipped-2') ? transitionTime / transitionTimeFraction : transitionTime;
                transitionTimeout = setTimeout(() => {
                    block.classList.remove('block-cards--transition-running');
                    document.body.classList.add('has-card-flipped-2');
                    cardSideAnimation = 0;
                    if(!!flipped){
                        block.classList.remove('block-cards--animate-from-left-desktop','block-cards--animate-from-right-desktop');
                        transitionTimeout = setTimeout(() => {
                            const cardIn = block.querySelector('.card--in');
                            const cardOut = block.querySelector('.card--out');
                            if(!!cardIn){
                                cardIn.classList.remove('card--in');
                            }
                            if(!!cardOut){
                                cardOut.classList.remove('card--out');
                            }

                            transitionTimeout = setTimeout(() => {
                                transitionRunning = false;    
                                block.classList.remove('block-cards--remove-transitions-desktop');
                                
                            },100);
                        },100);
                    }else{
                        block.classList.remove('block-cards--animate-from-left-desktop','block-cards--animate-from-right-desktop','block-cards--remove-transitions-desktop');
                        transitionRunning = false;
                    }
                },tmpTransitionTime);
            },delay);
        });
        swipeDetect(area, {
            preventScrolling: false,
            stopPropagation: true,
            handleswipe: (swipedir)=>{
                if(swipedir == 'left'){
                    mobileNextBtn.click();
                }else if(swipedir == 'right'){
                    mobilePrevBtn.click();
                }
            }
        });
    });
    block.querySelectorAll('.card__close-btn').forEach(el => {
        el.addEventListener('click', e => {
            if(transitionRunning) return false;
            clearTimeout(transitionTimeout);
            let urlSegments = String(document.referrer).split('/');
            if(document.referrer && urlSegments.length == 5){
                window.history.back();
            }else{
                urlSegments = String(window.location).split('/');
                const url = String(window.location).split(urlSegments[urlSegments.length-2]+'/').join('');
                window.location = url; 
            }
            /* 
            arrowsWrapper.classList.remove('arrows-wrapper--visible');
            block.classList.remove('block-cards--has-card-flipped');
            document.body.classList.remove('has-card-flipped-2','has-card-flipped');
            block.classList.add('block-cards--transition-running');
            el.parentNode.parentNode.parentNode.classList.remove('card--flipped');
            transitionRunning = true;
            transitionTimeout = setTimeout(() => {
                transitionRunning = false;
                block.classList.remove('block-cards--transition-running');
            },transitionTime); 
            */
        });
    });
    document.addEventListener('keyup', e => {
        if(e.key == 'Escape' && !!block.querySelector('.card--flipped')){
            block.querySelector('.card--flipped .card__close-btn').click();
        }
    });
    block.querySelectorAll('.block-cards__share-link').forEach(el => {
        const btn = el.querySelector('.share-link__btn');
        const parentElem = el.parentNode.parentNode.parentNode;
        const options = parentElem.querySelector('.block-cards__share-link-options');
        const titleStr = parentElem.querySelector('.title__str');
        const title = !!titleStr ? titleStr.textContent.replace(/\s+/g, ' ').trim() : '';
        let text = parentElem.querySelector('.face-back__text-right').textContent.replace(/\s+/g, ' ').trim();
        const numOfWords = 14;
        if(text.split(' ').length > numOfWords){
            text = extractWords(text, numOfWords)+'...';
        }
        el.addEventListener('mouseleave', e => {
            options.classList.remove('block-cards__share-link-options--visible');
        });
        let copyTimeout;
        options.querySelectorAll('button').forEach(opBtn => {
            opBtn.addEventListener('click', e => {
                const type = opBtn.dataset.type;
                //const sharedURL = `${window.location.origin}${window.location.pathname}${el.dataset.slug}/`;
                const sharedURL = window.location;
                if(type == 'facebook'){
                    window.open('https://www.facebook.com/sharer/sharer.php?u='+sharedURL,'_blank');
                }else if(type == 'twitter'){
                    window.open('https://twitter.com/intent/tweet?url='+sharedURL,'_blank');
                }else if(type == 'copy'){
                    clearTimeout(copyTimeout);
                    opBtn.classList.add('share-link-options__btn--hide');
                    opBtn.innerHTML = opBtn.dataset.txtCopied;
                    utils.copyTextToClipboard(sharedURL);
                    copyTimeout = setTimeout(() => {
                        opBtn.classList.remove('share-link-options__btn--hide');
                        copyTimeout = setTimeout(() => {
                            opBtn.classList.add('share-link-options__btn--hide');
                            opBtn.innerHTML = opBtn.dataset.txtDef;
                            copyTimeout = setTimeout(() => {
                                opBtn.classList.remove('share-link-options__btn--hide');
                            }, 50);
                        }, 1000);
                    }, 50);
                }
            });
        });
        const isAndroid = /Android/i.test(navigator.userAgent);
        const isIOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);
        btn.addEventListener('click', async () => {
            /*
            try {
                await navigator.share({
                    title: title,
                    text: text,
                    url: sharedURL, // URL con parámetro sin modificar la original
                });
            } catch (err) {
                console.error("No se pudo compartir", err);
            }
            */
            const sharedURL = `${window.location.origin}${window.location.pathname}${el.dataset.slug}/`;
            if(isAndroid || isIOS){
                navigator
                .share({
                    //title: title,
                    //text: text,
                    url: sharedURL
                })
                // Mensaje en Consola cuando se presiona el botón de compartir 
                .then(() => {
                    //console.log("Contenido Compartido !");
                }).catch(console.error);     
            }else{
                options.classList.add('block-cards__share-link-options--visible');
            }
        });
    });
    block.querySelectorAll('.block-cards__share-global').forEach(el => {
        const btn = el.querySelector('.block-cards__share-all-btn');
        const parentElem = el.parentNode;
        const options = parentElem.querySelector('.block-cards__share-link-options')
        const title = document.querySelector('.block-heading__title').textContent.replace(/\s+/g, ' ').trim();
        let text = document.querySelector('.block-heading__text').textContent.replace(/\s+/g, ' ').trim();
        const numOfWords = 14;
        if(text.split(' ').length > numOfWords){
            text = extractWords(text, numOfWords)+'...';
        }
        el.addEventListener('mouseleave', e => {
            options.classList.remove('block-cards__share-link-options--visible');
        });
        let copyTimeout;
        options.querySelectorAll('button').forEach(opBtn => {
            opBtn.addEventListener('click', e => {
                const type = opBtn.dataset.type;
                const sharedURL = `${window.location.origin}${window.location.pathname}`;
                if(type == 'facebook'){
                    window.open('https://www.facebook.com/sharer/sharer.php?u='+sharedURL,'_blank');
                }else if(type == 'twitter'){
                    window.open('https://twitter.com/intent/tweet?url='+sharedURL,'_blank');
                }else if(type == 'copy'){
                    clearTimeout(copyTimeout);
                    opBtn.classList.add('share-link-options__btn--hide');
                    opBtn.innerHTML = opBtn.dataset.txtCopied;
                    utils.copyTextToClipboard(sharedURL);
                    copyTimeout = setTimeout(() => {
                        opBtn.classList.remove('share-link-options__btn--hide');
                        copyTimeout = setTimeout(() => {
                            opBtn.classList.add('share-link-options__btn--hide');
                            opBtn.innerHTML = opBtn.dataset.txtDef;
                            copyTimeout = setTimeout(() => {
                                opBtn.classList.remove('share-link-options__btn--hide');
                            }, 50);
                        }, 1000);
                    }, 50);
                }
            });
        });
        const isAndroid = /Android/i.test(navigator.userAgent);
        const isIOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);
        btn.addEventListener('click', async () => {
            /*
            try {
                await navigator.share({
                    title: title,
                    text: text,
                    url: sharedURL, // URL con parámetro sin modificar la original
                });
            } catch (err) {
                console.error("No se pudo compartir", err);
            }
            */
            const sharedURL = `${window.location.origin}${window.location.pathname}`;
            if(isAndroid || isIOS){
                navigator
                .share({
                    //title: title,
                    //text: text,
                    url: sharedURL
                })
                // Mensaje en Consola cuando se presiona el botón de compartir 
                .then(() => {
                    //console.log("Contenido Compartido !");
                }).catch(console.error);     
            }else{
                options.classList.add('block-cards__share-link-options--visible');
            }
        });
    });
    /* block.querySelectorAll('.block-cards__copy-link').forEach(el => {
        const btn = el.querySelector('.copy-link__btn');
        const message = el.querySelector('.copy-link__message');
        let copyTimeout;
        btn.addEventListener('click', e => {
            clearTimeout(copyTimeout);
            message.classList.add('visible');
            //const url = String(window.location).split('#').join('') + '#/' + el.dataset.slug + '/';
            const url = String(window.location).split('#').join('') + el.dataset.slug + '/';
            utils.copyTextToClipboard(url);
            cardFlippedNum[1].classList.add('hide');
            copyTimeout = setTimeout(() => {
                message.classList.remove('visible');
                cardFlippedNum[1].classList.remove('hide');
            },1000);
        });
    }); */
    //
    let openedCard;
    const testDirectLink = () => {
        const url = String(window.location.hash).split('#');
        if(url.length == 2){
            const defaultURL = window.location;
            //location.replace("#"+url[1]); 
            //window.location = url[0]+'#';
            history.replaceState(null, "", defaultURL);
            location.replace(url[0]+'#'); 
            const slug = url[1].split('/').join('');
            let n = 0;
            let tmpCurrentPage;
            cards.forEach((el,i) => {
                if(el.dataset.slug == slug && el.classList.contains('block-cards--card-hidden')){
                    currentPage = Math.floor(i / itemsPerPage) - 1;
                    openedCard = el;
                }else if(el.dataset.slug == slug){
                    openedCard = el;
                }
            });
        }
    }
    //
    //pagination destop version only
    let currentPage = -1;
    const itemsPerPage = 4;
    const itemsTotal = cards.length;
    const totalPages = Math.ceil(itemsTotal / itemsPerPage);
    const paginate = (direction = 1) => {
        //
        block.classList.remove('block-cards--fade-in-cards');
        setTimeout(() => {
            currentPage += direction;
            if(currentPage >= totalPages){
                currentPage = 0;
            }else if(currentPage < 0){
                currentPage = totalPages - 1;
            }
            cards.forEach((el, i) => {
                el.classList.add('block-cards--card-hidden');
            });
            let j = 0;
            for(let i=0; i<itemsPerPage; i++){
                block.classList.remove('block-cards--total-'+j);
                const n = i + itemsPerPage * currentPage;
                if(!!cards[n]){
                    cards[n].classList.remove('block-cards--card-hidden');
                    j++;
                }
            }
            block.classList.add('block-cards--total-'+j);
            block.classList.add('block-cards--fade-in-cards');
        },100);
    }
    if(!!moreCardsBtn){
        moreCardsBtn.addEventListener('click', e => {
            const cardFlipped = block.querySelector('.card--flipped');
            if(!!cardFlipped){
                block.classList.remove('block-cards--more-cards-transition-running');
                block.classList.add('block-cards--more-cards-transition-running-flipped');
                cardFlipped.querySelector('.card__close-btn').click();
                setTimeout(() => {
                    block.classList.add('block-cards--more-cards-transition-running-flipped');
                    paginate();
                    setTimeout(() => {
                        block.classList.add('block-cards--more-cards-transition-running-flipped-fade-in');
                        setTimeout(() => {
                            block.classList.remove('block-cards--more-cards-transition-running-flipped','block-cards--more-cards-transition-running','block-cards--more-cards-transition-running-flipped-fade-in');
                        },300);
                    },100);
                },transitionTime);
            }else{
                block.classList.remove('block-cards--more-cards-transition-running-flipped','block-cards--more-cards-transition-running-flipped','block-cards--more-cards-transition-running-flipped-fade-in');
                block.classList.add('block-cards--more-cards-transition-running');
                paginate();
                setTimeout(() => {
                    //paginate();
                    block.classList.remove('block-cards--more-cards-transition-running');
                },100);
            }
        });
    }
    //
    const mobilePrevBtn = block.querySelector('.mobile-controls__prev-btn');
    const mobileNextBtn = block.querySelector('.mobile-controls__next-btn');
    let swapDepthRinnuing = 0;
    const setMobileControlsCardNum = () => {
        const total = mobileCards.length < 10 ? '0'+mobileCards.length : mobileCards.length;
        let cnum = Number(mobileCards[0].dataset.cardNum);
        if(cnum < 10){
            cnum = '0'+cnum;
        }
        cnum += '/'+total;
        block.querySelector('.mobile-controls__num').innerHTML = cnum;
    }
    const swapDepth2 = (param) => {
        // Esta funcion altera el orden de capas (en mobile) cada vez que se abre una nueva card
        if(swapDepthRinnuing && window.innerWidth >= 1024) return false;
        const current = block.querySelector('.card--flipped');
        let index; 
        mobileCards.forEach((el, i) => {
            if(el == current){
                el.style.zIndex = cards.length + 1;
                index = i;
            }else{
                el.style.zIndex = cards.length - i;
            }
        });
        mobileCards.splice(index,1);
        mobileCards = [current].concat(mobileCards);
        setMobileControlsCardNum();
    }
    const swapDepth = (param) => {
        if(swapDepthRinnuing) return false;
        swapDepthRinnuing = true;
        if(param){
            let first = mobileCards[0];
            first.classList.add('swapdepth-next-step-1');
            setTimeout(() => {
                first.classList.add('swapdepth-next-step-2');
                mobileCards.push(mobileCards.shift());
                mobileCards.forEach((el, i) => {
                    el.style.zIndex = cards.length - i;
                });
                setMobileControlsCardNum(); 
                setTimeout(() => {
                    first.classList.remove('swapdepth-next-step-1','swapdepth-next-step-2');
                    swapDepthRinnuing = false;
                },300);
            },300);
        }else{
            let last = mobileCards[mobileCards.length - 1];
            last.classList.add('swapdepth-prev-step-1');
            setTimeout(() => {
                last.classList.add('swapdepth-prev-step-2');
                mobileCards = [mobileCards.pop()].concat(mobileCards);
                mobileCards.forEach((el, i) => {
                    el.style.zIndex = cards.length - i;
                });
                setMobileControlsCardNum();
                setTimeout(() => {
                    last.classList.remove('swapdepth-prev-step-1','swapdepth-prev-step-2');
                    swapDepthRinnuing = false;
                },300);
            },300);
            
        }
    }
    mobilePrevBtn.addEventListener('click', e => {
        swapDepth(0);
    });
    mobileNextBtn.addEventListener('click', e => {
        swapDepth(1);
    });
    //
    setMobileControlsCardNum();
    //
    testDirectLink();
    paginate();
    if(!!openedCard){
        setTimeout(() => {
            window.scrollTo({
                top: utils.position(block).top,
                left: 0,
                behavior: 'smooth'
            });
            openedCard.querySelector('.card__area-btn').click();
        },100);
    }
}
export {startModule};