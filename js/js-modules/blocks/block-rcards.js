import { scrollHorizontalItems } from '../globals.js';
const startModule = (block)=>{

    setTimeout(() => {
        block.classList.add('loaded');
    } , 100);

	const blockRcardsInner = block.querySelector('.block-rcards-inner');
	if (!blockRcardsInner) return;

	const dataTheme = blockRcardsInner.getAttribute('data-theme');

	// Verificar si el valor comienza con “theme--multicolor”
	let clases = [];
	if (dataTheme.startsWith('theme--multicolor')) {
		clases = ['theme--multicolor-mode-blue', 'theme--multicolor-mode-green', 'theme--multicolor-mode-pink'];
	} else {
		clases = ['theme--mode-light', 'theme--mode-neutral', 'theme--mode-bright', 'theme--mode-dark'];
	}

	const rcardBoxes = block.querySelectorAll('.rcards__box');
	rcardBoxes.forEach((box, index) => {
		const claseAAgregar = clases[index % clases.length]; 
		box.classList.add('theme', dataTheme, claseAAgregar);
	});

	if(!!block.querySelector('.block-rcards--row')){
		const nextPrevWrapper = block.querySelector('.block-rcards-scroll-arrows');
		const nextBtn = block.querySelector('.block-rcards-scroll-next');
		const prevBtn = block.querySelector('.block-rcards-scroll-prev');
		const scroller = block.querySelector('.rcards');
		const items = block.querySelectorAll('.rcards__box');
		nextPrevWrapper.classList.add('active');
		scrollHorizontalItems({
			nextPrevWrapper: nextPrevWrapper, 
			nextBtn: nextBtn,
			prevBtn: prevBtn,
			scroller: scroller,
			items: items
		});
	}
   
}
export {startModule};