//import {helper,system,ImagePreloader, Animation} from '../utils.js';
const startModule = (block)=>{
    
    //
    const lottieXL = block.querySelector('.block-home-animation__lottie-xl');
    const lottieMD = block.querySelector('.block-home-animation__lottie-md');
    const lottieXS = block.querySelector('.block-home-animation__lottie-xs');
    let loadCounter = 0;
    const init = () => {
        loadCounter++;
        if(loadCounter >= 3){
            block.classList.add('loaded');
        }
    }
    //
    //--------------------//
    //--- ANIMATION XL ---//
    //
    const animationXL = lottie.loadAnimation({
        container: lottieXL, // the dom element that will contain the animation
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: lottieXL.dataset.src // the path to the animation json
    });
    /* animationXL.addEventListener('enterFrame', e => {
        console.log(e)
    }); */
    animationXL.addEventListener('loopComplete', e => {
        animationXL.goToAndPlay(285, true);
    });
    animationXL.addEventListener('DOMLoaded', init);
    //
    //--- ANIMATION XL ---//
    //--------------------//
    //
    //--------------------//
    //--- ANIMATION MD ---//
    //
    const animationMD = lottie.loadAnimation({
        container: lottieMD, // the dom element that will contain the animation
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: lottieMD.dataset.src // the path to the animation json
    });
    /* animationMD.addEventListener('enterFrame', e => {
        console.log(e)
    }); */
    animationMD.addEventListener('loopComplete', e => {
        animationMD.goToAndPlay(285, true);
    });
    animationMD.addEventListener('DOMLoaded', init);
    //
    //--- ANIMATION XS ---//
    //--------------------//
    //
    //--------------------//
    //--- ANIMATION XS ---//
    //
    const animationXS = lottie.loadAnimation({
        container: lottieXS, // the dom element that will contain the animation
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: lottieXS.dataset.src // the path to the animation json
    });
    /* animationXS.addEventListener('enterFrame', e => {
        console.log(e)
    }); */
    animationXS.addEventListener('loopComplete', e => {
        animationXS.goToAndPlay(225, true);
    });
    animationXS.addEventListener('DOMLoaded', init);
    //
    //--- ANIMATION XS ---//
    //--------------------//
    //
}
export {startModule};