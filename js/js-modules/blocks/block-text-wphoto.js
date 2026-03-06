import { ImagePreloader } from '../utils.js';
const startModule = (block)=> {
	block.classList.add('loaded');
	const imgs = block.querySelectorAll('.block-text-wphoto__img');
	imgs.forEach(element => {           
		new ImagePreloader(element.dataset.src,{
			onComplete: (data)=>{
				element.style.backgroundImage = `url('${data.src}')`;
				element.classList.add('loaded');
			}
		});
	});
}
export {startModule};