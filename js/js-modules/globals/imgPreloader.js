const imgPreloader = () => {
    document.querySelectorAll('.img.fade-in-auto:not(.loading):not(.loaded)').forEach(el => {
        if(el.dataset.src && el.dataset.src != ''){
            el.classList.add('loading');
            const img = new Image();
            img.onload = () => {
                el.style.backgroundImage = `url(${img.src})`;
                el.classList.add('loaded');
                el.classList.remove('loading');
                if(el.parentNode.classList.contains('parent-fade-in-auto')){
                    el.parentNode.classList.add('loaded');
                }
            }
            img.src = el.dataset.src;
        }
    });
}

export {imgPreloader};