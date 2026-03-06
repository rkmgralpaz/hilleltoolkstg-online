import { ImagePreloader } from '../utils.js';
const startModule = (block)=>{
	block.classList.add('loaded');
	const image = block.querySelectorAll('.block-landing__image-bg');
    image.forEach(element => {
        new ImagePreloader(element.dataset.src, {
            onComplete: (data)=>{
                element.style.backgroundImage = `url('${data.src}')`;
                element.classList.add('loaded');
            }
        });
    });
}
export {startModule};