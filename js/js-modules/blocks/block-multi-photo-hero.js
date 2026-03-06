const startModule = (block)=>{
  
    block.classList.add('loaded');
    
    const imageList = [];
    const imagesForPreload = block.querySelectorAll('.image-for-preload');
    const images = block.querySelectorAll('.images__image');
    const totalImagesDesktop = 3;
    const totalImagesMobile = 3;
    const animated = block.classList.contains('block-multi-photo-hero--animated') && imagesForPreload.length > 5;
    let animatedFirstRun = false;
    let imgLoadedCounter = 0;
    let widthMobileMode = parseInt(getComputedStyle(block).getPropertyValue('--width-mobile-mode'));
    if(isNaN(widthMobileMode)){
        widthMobileMode = 1120;
    }
    let imageTransitionDelay = parseFloat(getComputedStyle(block).getPropertyValue('--image-transition-delay'));
    let imageTransitionTime = parseFloat(getComputedStyle(block).getPropertyValue('--image-transition-time'));
    if(imageTransitionDelay < 10){
        imageTransitionDelay = imageTransitionDelay * 1000;
    }
    if(imageTransitionTime < 10){
        imageTransitionTime = imageTransitionTime * 1000;
    }
    const intervalTime = imageTransitionTime + imageTransitionDelay;
    let imagesVisible = window.innerWidth < widthMobileMode ? totalImagesMobile : totalImagesDesktop;
    let indexDesktop = totalImagesDesktop-1;
    let indexMobile = totalImagesMobile-1;
    let n = totalImagesDesktop-1;
    const changeImage = () => {
        indexDesktop++;
        if(indexDesktop >= totalImagesDesktop){
            indexDesktop = 0;
        }
        indexMobile++;
        if(indexMobile >= totalImagesMobile){
            indexMobile = 0;
        }
        let currentImage; 
        if(window.innerWidth < widthMobileMode){
            //mobile
            currentImage = images[indexMobile];
        }else{
            //desktop
            currentImage = images[indexDesktop];
        }
        currentImage.classList.remove('images__image--visible');
        n++;
        if(n >= imageList.length){
            n = 0;
        }
        const img = new Image();
        img.onload = () => {
            currentImage.style.backgroundImage = `url(${imageList[n]})`;
            setTimeout(() => {
                currentImage.classList.add('images__image--visible');
                currentImage.classList.toggle('images__image--t2');
            },100);
        }
        img.src = imageList[n];
        setTimeout(() => {
            changeImage();
        },intervalTime);
    }
    block.querySelector('.images-for-preload').remove();
    imagesForPreload.forEach(el => {
        imageList.push(el.dataset.src);
    });
    images.forEach((el, i) => {
        const src = imageList[i];
        const img = new Image();
        img.onload = () => {
            el.style.backgroundImage = `url(${src})`;
            el.classList.add('image__img--loaded');
            imgLoadedCounter++;
            if(animated && imgLoadedCounter >= images.length && !animatedFirstRun){
                animatedFirstRun = true;
                setTimeout(() => {
                    changeImage();
                },intervalTime);
            }
        }
        img.src = src;
        setTimeout(() => {
            el.classList.add('images__image--visible');
        }, i * 100);
    });
}
export {startModule};