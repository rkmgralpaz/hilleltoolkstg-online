import { ImagePreloader } from './utils.js?v=032';

const startModule = (block) => {
    block.classList.add('loaded');

    const preloadImages = (container) => {
        const imgs = container.querySelectorAll('.image');
        imgs.forEach((element) => {
            const imageChild = element.querySelector('div');
            if (!imageChild) return;

            new ImagePreloader(element.dataset.src, {
                onComplete: (data) => {
                    imageChild.style.backgroundImage = `url('${data.src}')`;
                    element.classList.add('image--loaded');
                    element.removeAttribute('data-src');
                }
            });
        });
    };

    preloadImages(block);

    const attachIconToLastWord = () => {
        // Seleccionar todos los elementos relevantes
        const titleSelectors = ['.news__featured-item-title', '.news__item-title'];
        titleSelectors.forEach((selector) => {
            const titleElements = block.querySelectorAll(selector);

            titleElements.forEach((titleElement) => {
                // Buscar el ícono correspondiente en cada tipo de título
                const iconSelector = selector === '.news__featured-item-title'
                    ? '.news__featured-item-title-icon'
                    : '.news__item-title-icon';

                const iconElement = titleElement.querySelector(iconSelector);
                if (iconElement) {
                    const titleText = titleElement.textContent.trim();
                    const words = titleText.split(' ');
                    const lastWord = words.pop();
                    const newContent = `${words.join(' ')} <span class="last-word">${lastWord}${iconElement.outerHTML}</span>`;
                    titleElement.innerHTML = newContent;
                }
            });
        });
    };

    const attachIconToBlurb = () => {
        const featuredItems = block.querySelectorAll('.news__featured-item');
        const targetItems = [featuredItems[0], featuredItems[2]].filter(Boolean);

        targetItems.forEach((item) => {
            const blurbElement = item.querySelector('.news__featured-item-blurb');
            const iconElement = item.querySelector('.news__featured-item-title-icon');

            if (blurbElement && iconElement) {
                const blurbText = blurbElement.textContent.trim();
                const words = blurbText.split(' ');
                const lastWord = words.pop();
                const newContent = `${words.join(' ')} <span class="last-word">${lastWord}${iconElement.outerHTML}</span>`;
                blurbElement.innerHTML = newContent;
            }
        });
    };

    attachIconToLastWord();
    attachIconToBlurb();

    let isLoading = false;
    let currentPage = 1;

    const loadMorePosts = () => {
        const nextPageLink = document.querySelector('.next-page-url');
        const nextPageText = nextPageLink.querySelector('.btn__text');
        const container = document.querySelector('.news__posts-items');
        if (!nextPageLink || isLoading || !container) return;

        currentPage++;

        const currentParams = new URLSearchParams(window.location.search);
        const nextPageUrl = new URL(nextPageLink.href.replace(/\/page\/\d+\//, `/page/${currentPage}/`));

        currentParams.forEach((value, key) => {
            nextPageUrl.searchParams.set(key, value);
        });

        isLoading = true;
        nextPageText.textContent = 'Loading...';

        fetch(nextPageUrl.toString())
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newPostsHTML = doc.querySelector('.news__posts-items').innerHTML;
                container.insertAdjacentHTML('beforeend', newPostsHTML);

                preloadImages(container);

                const newItems = Array.from(container.querySelectorAll('.news__posts-item')).slice(-10);
                newItems.forEach((item) => {
                    item.classList.add('loaded', 'animate-loaded');
                });

                const newNextPageLink = doc.querySelector('.next-page-url');
                if (newNextPageLink) {
                    nextPageLink.href = newNextPageLink.href.replace(/paged=\d+/, `paged=${currentPage + 1}`);
                    nextPageText.textContent = 'Load more';
                } else {
                    nextPageLink.remove();
                }

                startItemTags();

                isLoading = false;
            })
            .catch(error => {
                console.error('Error loading more posts:', error);
                isLoading = false;
                nextPageText.textContent = 'Load more';
            });
    };

    const nextPageButton = document.querySelector('.next-page-url');
    if (nextPageButton) {
        nextPageButton.addEventListener('click', (event) => {
            event.preventDefault();
            loadMorePosts();
        });
    }

    const checkboxes = block.querySelectorAll('.news__filters-list input[type="checkbox"]');
    const searchInput = block.querySelector('.news__filters-search-input');
    const clearButton = document.querySelector('.clear-search-button');

    //-----------------------//
    //--- ivan 2025-01-08 ---//
    //upgrade search behavior
    const placeholder = searchInput.getAttribute('placeholder');
    checkboxes.forEach(el => {
        const parent = el.parentNode;
        if(el.checked){
            parent.classList.add('news__filter--selected');
        }else{
            parent.classList.remove('news__filter--selected');
        }
    });
    searchInput.addEventListener('focus', e => {
        searchInput.removeAttribute('placeholder');
    });
    searchInput.addEventListener('blur', e => {
        searchInput.setAttribute('placeholder',placeholder);
    });
    //--- ivan 2025-01-08 ---//
    //-----------------------//

    //-----------------------//
    //--- ivan 2025-01-10 ---//
    const startItemTags = () => {
        const itemTags = document.querySelectorAll('.news__item-tag:not(.news__item-tag--loaded)');
        const newsFilters = document.querySelectorAll('.news__filter');
        itemTags.forEach(el => {
            el.addEventListener('click', e => {
                e.preventDefault();
                const location = String(window.location).split('?')[0]+'?news-tag='+el.dataset.value;
                window.location = location;
            });
            el.classList.add('news__item-tag--loaded');
            newsFilters.forEach(filter => {
                const filterInput = filter.querySelector('input');
                if(filterInput.value == el.dataset.value){
                    let itemTagClassNum = '';//esta clase aplica el color del tag
                    for(let i=1; i<20; i++){
                        if(filter.classList.contains('news__filter--num-'+i)){
                            itemTagClassNum = 'news__item-tag--num-'+i;
                            break;
                        }
                    }
                    el.classList.add(itemTagClassNum);
                }
            });
        });
    }
    startItemTags();
    //--- ivan 2025-01-10 ---//
    //-----------------------//

    const updateUrl = () => {
        const selectedTags = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        const searchQuery = searchInput.value.trim();

        const params = new URLSearchParams();
        if (selectedTags.length) {
            params.set('news-tag', selectedTags.join(',')); // Une con comas
        }
        if (searchQuery) {
            params.set('search', searchQuery);
        }

        const newUrl = `${window.location.pathname}?${params.toString()}`;
        /* 
        window.history.pushState({}, '', newUrl.replace(/%2C/g, ',')); // Actualiza la URL visible
        // Recarga la página para que los cambios se reflejen
        window.location.reload(); 
        */

        //-----------------------//
        //--- ivan 2025-01-10 ---//
        // le comenté el window.history.pushState() y window.location.reload() porque no recargaba la página al usar las flechas del navegador        
        window.location = newUrl.replace(/%2C/g, ',');
        //--- ivan 2025-01-10 ---//
        //-----------------------//
    };

    if (searchInput && clearButton) {
        if (searchInput.value.trim() !== '') {
            clearButton.style.display = 'block';
        }

        clearButton.addEventListener('click', () => {
            searchInput.value = '';
            searchInput.focus();
            clearButton.style.display = 'none';

            const baseUrl = window.location.pathname;
            history.replaceState(null, '', baseUrl);
            window.location.reload();
        });

        searchInput.addEventListener('input', () => {
            clearButton.style.display = searchInput.value.trim() !== '' ? 'block' : 'none';
        });
    }
    searchInput.addEventListener('input', () => {
        if (searchInput.value.trim() !== '') {
            checkboxes.forEach((checkbox) => {
                checkbox.checked = false;
            });
        }
    });

    searchInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            updateUrl();
        }
    });

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                searchInput.value = '';
            }
            updateUrl();
        });

        checkbox.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            }
        });

        checkbox.addEventListener('focus', () => {
            checkbox.parentElement.classList.add('focus-visible');
        });
        checkbox.addEventListener('blur', () => {
            checkbox.parentElement.classList.remove('focus-visible');
        });
    });


    handleSearchToggle();


    const wrapLinksInDivs = () => {
        
        const featuresContainer = document.querySelector('.news__features');

        if (featuresContainer && featuresContainer.classList.contains('news__feature--template-2')) {
            //const links = featuresContainer.querySelectorAll('a');
            const wrappers = featuresContainer.querySelectorAll('.news__item-wrapper')
            
            if (wrappers.length > 0) {
                // Crear divs para envolver los enlaces
                const div1 = document.createElement('article');
                const div2 = document.createElement('article');
                const div3 = document.createElement('article');

                // Agregar clases opcionales a los divs (si lo necesitas)
                div1.classList.add('news__features-group');
                div2.classList.add('news__features-group');
                div3.classList.add('news__features-group');
                div1.classList.add('news__features-group-1');
                div2.classList.add('news__features-group-2');
                div3.classList.add('news__features-group-3');

                // Envolver los enlaces en los divs correspondientes
                wrappers.forEach((wrapper, index) => {
                    if (index < 2) {
                        div1.appendChild(wrapper.querySelector('a'));
                    } else if (index === 2) {
                        div2.appendChild(wrapper);
                    } else {
                        div3.appendChild(wrapper.querySelector('a'));
                    }
                });

                // Limpiar el contenedor original y agregar los nuevos divs
                featuresContainer.innerHTML = ''; // Eliminar contenido previo
                featuresContainer.appendChild(div1);
                featuresContainer.appendChild(div2);
                featuresContainer.appendChild(div3);
            }
        }
    };



    wrapLinksInDivs();


};

export { startModule };


const handleSearchToggle = () => {
    const searchContainer = document.querySelector('.news__filters-search');
    const searchInput = document.querySelector('.news__filters-search-input');
    const clearButton = document.querySelector('.clear-search-button');

    const toggleOpenClass = () => {
        /* if (window.innerWidth < 1120) {
            if (searchInput.value.trim() !== '') {
                searchContainer.classList.add('open');
                clearButton.style.display = 'block';
            } else {
                searchContainer.classList.remove('open');
                clearButton.style.display = 'none';
            }
        } else {
            searchContainer.classList.remove('open');
        } */
        if (window.innerWidth < 1120) {
            if (searchInput.value.trim() !== '' || document.activeElement == searchInput) {
                searchContainer.classList.add('open');
                clearButton.style.display = 'block';
            } else {
                searchContainer.classList.remove('open');
                clearButton.style.display = 'none';
            }
        } else {
            searchContainer.classList.remove('open');
        }
        if (searchInput.value === '') {
            clearButton.style.display = 'none';
        }
    };

    searchContainer.addEventListener('click', e => {
        e.stopPropagation();
        if (window.innerWidth < 1120 && !searchContainer.classList.contains('open')) {
            //searchInput.value = '';
            searchContainer.classList.add('open');
        }
    });
    document.addEventListener('click', e => {
        if (window.innerWidth < 1120 && searchContainer.classList.contains('open')) {
            searchContainer.classList.remove('open');
        }
    });

    searchInput.addEventListener('blur', toggleOpenClass);

    //searchInput.addEventListener('input', toggleOpenClass);

    window.addEventListener('resize', toggleOpenClass);
    toggleOpenClass();
};

