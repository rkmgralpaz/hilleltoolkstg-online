import {ImagePreloader} from '../utils.js';
const startModule = (block)=> {
	block.classList.add('loaded');

	const cover = block.querySelector('.video__cover');
	const coverImg = block.querySelector('.video__cover-image');
	const iframe = block.querySelector('.video__iframe');

	if (!cover || !coverImg || !iframe) {
		return;
	}

	const originalVimeoUrl = iframe.getAttribute('src');
	const videoId = transformVimeoUrl(originalVimeoUrl);

	if (videoId) {

		if (!coverImg.hasAttribute('data-src')) {
			getVimeoThumbnail(videoId, thumbnailUrl => {
				coverImg.style.backgroundImage = `url('${thumbnailUrl}')`;
				cover.classList.add('loaded');
			});
		} else {
			new ImagePreloader(coverImg.dataset.src, {
				onComplete: (data) => {
					coverImg.style.backgroundImage = `url('${data.src}')`;
					cover.classList.add('loaded');
				}
			});
		}

		const iframeUrl = `https://player.vimeo.com/video/${videoId}?autoplay=0&muted=0`;
		iframe.setAttribute('src', iframeUrl);

		cover.addEventListener('click', function() {
			iframe.setAttribute('src', `https://player.vimeo.com/video/${videoId}?autoplay=1&muted=0`);
			
			cover.classList.add('hide');
			iframe.style.display = 'block';
			setTimeout(() => {
				cover.style.display = 'none';
			}, 300);
		});
	}

}

function transformVimeoUrl(vimeoUrl) {
    const regex = /vimeo\.com\/(\d+)/;
    const match = vimeoUrl.match(regex);
    if (match && match[1]) {
        const videoId = match[1];
        return videoId;
    } else {
        console.error('No se pudo extraer el ID del video de la URL proporcionada.');
        return null;
    }
}

function getVimeoThumbnail(videoId, callback) {
    fetch(`https://vimeo.com/api/v2/video/${videoId}.json`)
        .then(response => response.json())
        .then(data => {
            if (data && data[0]) {
                const thumbnailUrl = data[0].thumbnail_large;
                callback(thumbnailUrl);
            } else {
                console.error('No se pudo obtener la información del video de Vimeo.');
            }
        })
        .catch(error => {
            console.error('Error al solicitar la API de Vimeo:', error);
        });
}

export {startModule};