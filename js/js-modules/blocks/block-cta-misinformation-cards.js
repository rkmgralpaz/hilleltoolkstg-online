import { ImagePreloader } from '../utils.js';
import {swipeDetect,utils} from '../utils.js';
const startModule = (block)=>{

    block.classList.add('loaded');

    let currentCard;

    let mobileCards = [];
    const cards = block.querySelectorAll('.block-bannerh__card');
    cards.forEach((el,i) => {
        el.parentNode.style.zIndex = cards.length-i; 
        mobileCards.push(el.parentNode);
    });

    const arrowLeft = block.querySelector('.cards-arrows__arrow-btn-prev');
    const arrowRight = block.querySelector('.cards-arrows__arrow-btn-next');

    //
    let swapDepthRinnuing = 0;
    const swapDepth = (param) => {
        if(swapDepthRinnuing) return false;
        swapDepthRinnuing = true;
        if(param){
            let first = mobileCards[0];
            first.classList.add('swapdepth-next-step-1');
            setTimeout(() => {
                mobileCards.push(mobileCards.shift());
                mobileCards.forEach((el, i) => {
                    el.style.zIndex = cards.length - i;
                });
                setTimeout(() => {
                    first.classList.add('swapdepth-next-step-2');
                    setTimeout(() => {
                        first.classList.remove('swapdepth-next-step-1','swapdepth-next-step-2');
                        swapDepthRinnuing = false;
                    },300);
                },100);
            },300);
        }else{
            let last = mobileCards[mobileCards.length - 1];
            last.classList.add('swapdepth-prev-step-1');
            setTimeout(() => {
                mobileCards = [mobileCards.pop()].concat(mobileCards);
                mobileCards.forEach((el, i) => {
                    el.style.zIndex = cards.length - i;
                });
                setTimeout(() => {
                    last.classList.add('swapdepth-prev-step-2');
                    setTimeout(() => {
                        last.classList.remove('swapdepth-prev-step-1','swapdepth-prev-step-2');
                        swapDepthRinnuing = false;
                    },300);
                },100);
            },300);
        }
    }
    arrowLeft.addEventListener('click', e => {
        swapDepth(0);
    });
    arrowRight.addEventListener('click', e => {
        swapDepth(1);
    });
    //block.querySelector('.block-bannerh__cards-arrows').style.zIndex = cards.length+1; 
    const area = block.querySelector('.block-bannerh__right');
    if(!!area){
        swipeDetect(area, {
            preventScrolling: false,
            stopPropagation: true,
            handleswipe: (swipedir)=>{
                if(swipedir == 'left'){
                    arrowRight.click();
                }else if(swipedir == 'right'){
                    arrowLeft.click();
                }
            }
        });
    }
}
export {startModule};