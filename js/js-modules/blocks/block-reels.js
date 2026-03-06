const startModule = (block)=>{
	const item = block.querySelectorAll('.block-reels__item');
	const itemWrapper = block.querySelectorAll('.block-reels__item-embed-wrapper')
	itemWrapper.forEach((el,i) => {	
		el.insertAdjacentHTML('beforeend',`<iframe frameborder="0" src="${el.dataset.src}" allowtransparency="true" allowfullscreen="true" frameborder="0" height="560" width="315" data-instgrm-payload-id="instagram-media-payload-${i}" scrolling="no" onload="onloadReelsIframe(this)"></iframe>`);
		//document.getElementById('cart').onload=function(){alert('loaded')};
	});
	//
	block.classList.add('loaded');
}
if(!window.onloadReelsIframe){
	window.onloadReelsIframe = function(target){
		setTimeout(() => {
			target.parentNode.classList.add('loaded');
		},500);
	}
}
export {startModule};