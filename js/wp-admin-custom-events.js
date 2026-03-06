jQuery(document).ready(function($){
    
    //global actions and settings for wp-admin

    const location = String(window.location);
    const baseURL = location.split('wp-admin/')[0];
    const windowLocation = String(window.location);

    //---------------------------------------------------------//
    //--- ADD PERMALINK TO CUSTOM OPTIONS PAGES IN WP_ADMIN ---//
    //
    const getPermalinkPage = (slug = '') => {
        const html = `
            <div id="edit-slug-box" class="hide-if-no-js" style="padding-left:16px">
                <strong>Permalink:</strong>
                <span id="sample-permalink"><a href="${baseURL}${slug}/">${baseURL}<span id="editable-post-name">${slug}</span>/</a>
            </div>    
        `;
        return html;
    }
    if(location.indexOf('page=misinformation-landing') !== -1){
        const title = document.querySelector('.acf-field[data-name="title"]');
        if(!!title){
            title.insertAdjacentHTML('afterend',getPermalinkPage('misinformation'));
        }
    }
    if(location.indexOf('page=timeline-page') !== -1){
        const title = document.querySelector('.acf-field[data-name="title"]');
        if(!!title){
            title.insertAdjacentHTML('afterend',getPermalinkPage('timeline'));
        }
    }
    if(location.indexOf('page=news_archive') !== -1){
        const title = document.querySelector('.acf-field[data-name="title"]');
        if(!!title){
            title.insertAdjacentHTML('afterend',getPermalinkPage('news'));
        }
    }
    if(location.indexOf('page=data-interactive-landing') !== -1){
        const title = document.querySelector('.acf-field[data-name="data_interactive_landing_page_title"]');
        if(!!title){
            title.insertAdjacentHTML('afterend',getPermalinkPage('data-interactive'));
        }
    }
    if(location.indexOf('page=data-interactive-years-comparison') !== -1){
        const title = document.querySelector('.acf-field[data-name="data_interactive_years_comparison_title"]');
        if(!!title){
            title.insertAdjacentHTML('afterend',getPermalinkPage('data-interactive/years-comparison'));
        }
    }
    if(location.indexOf('post_type=data_interactive&page=sources') !== -1){
        const title = document.querySelector('.acf-field[data-name="data_interactive_sources_title"]');
        if(!!title){
            title.insertAdjacentHTML('afterend',getPermalinkPage('data-interactive/sources'));
        }
        const redirectField = document.querySelector('.acf-field[data-name="redirect_to_first_child"]');
        if(!!redirectField){
            redirectField.style.display = 'none';
        }
    }
    if(location.indexOf('page=resources') !== -1){
        const title = document.querySelector('.acf-field[data-name="title"]');
        if(!!title){
            title.insertAdjacentHTML('afterend',getPermalinkPage('medialibrary'));
        }
    }
    //
    //--- ADD PERMALINK TO CUSTOM OPTIONS PAGES IN WP_ADMIN ---//
    //---------------------------------------------------------//


    //------------------------------//
    //--- TIMELINE FILTERS LIMIT ---//
    //
    const maxTimelineFilters = 5;
    if(location.indexOf('taxonomy=timeline_filters&post_type=timeline') !== -1){
        setTimeout(() => {
            const max = maxTimelineFilters;
            const tagName = document.querySelector('#tag-name');
            let kayTimeout;
            let formStatus = true;
            let firstRun = false;
            let controlFormInterval;
            let j = 0;
            const changeFiledTagName = () => {
                if(!formStatus) return;
                clearInterval(controlFormInterval);
                controlFormEvent();
            }
            const disableForm = () => {
                tagName.value = '';
                document.querySelectorAll('#addtag input, #addtag textarea, #addtag select, #addtag button').forEach(el => {
                    el.setAttribute('disabled','disabled');
                    el.style.resize = 'none';
                });
                if(document.activeElement && !!document.activeElement){
                    document.activeElement.blur();
                }
                const formInvalid = document.querySelector('.form-invalid');
                if(!!formInvalid){
                    formInvalid.classList.remove('form-invalid');
                }
                document.querySelector('.form-wrap h2').innerHTML = '5 terms limit has been reached';
                formStatus = false;
            }
            const enableForm = () => {
                document.querySelectorAll('#addtag input, #addtag textarea, #addtag select, #addtag button').forEach(el => {
                    el.removeAttribute('disabled');
                    el.style.resize = 'auto';
                });
                document.querySelector('.form-wrap h2').innerHTML = 'Add New Term (max 5)';
                formStatus = true;
            }
            tagName.addEventListener('keydown', changeFiledTagName);
            tagName.addEventListener('focus', changeFiledTagName);
            const controlFormEvent = () => {
                const tr = document.querySelectorAll('#the-list tr.level-0');
                if(tr.length >= max){
                    disableForm();
                }else{
                    enableForm();
                }
            }
            const controlForm = () => {
                j = 0;
                clearInterval(controlFormInterval);
                controlFormInterval = setInterval(() => {
                    j++;
                    controlFormEvent();
                    if(j > 10){
                        clearInterval(controlFormInterval);
                    }
                },100);
            }
            document.querySelector('#posts-filter').addEventListener('submit', e => {
                controlForm();
            });
            document.addEventListener('mousedown',e => {
                if(e.target.matches('.delete-tag')){
                    controlForm();
                }
            });
            //
            controlFormEvent();
        },100);
    }
    const filterDropdown = document.querySelector('#timeline-add-filter');
    if(!!filterDropdown){
        const addButton = filterDropdown.querySelector('.acf-actions .acf-icon');
        let filterDropdownInterval;
        if(!!addButton){
            addButton.addEventListener('click', e => {
                //e.preventDefault();
                //e.stopImmediatePropagation();
                clearInterval(filterDropdownInterval);
                filterDropdownInterval  = setInterval(() => {
                    const select = document.querySelector('#term_parent');
                    const popup = document.querySelector('#acf-popup');
                    if(!!popup){
                        popup.style.opacity = 0;
                        popup.querySelector('form').addEventListener('submit', e => {
                            setTimeout(() => {
                                if(popup.querySelectorAll('#term_parent option').length >= maxTimelineFilters){//offset length = 1
                                    const close = popup.querySelector('.acf-icon');
                                    if(!!close){
                                        close.click();
                                    }
                                }
                            },100);
                        });
                    }
                    if(!!select){
                        if(select.querySelectorAll('option').length > maxTimelineFilters){//offset length = 1
                            const close = popup.querySelector('.acf-icon');
                            if(!!close){
                                close.click();
                            }
                            alert('Max '+maxTimelineFilters+' filters');
                        }else{
                            popup.style.opacity = 1;
                        }
                        clearInterval(filterDropdownInterval);
                    }
                },1);
            });
        }
    }
    //
    //--- TIMELINE FILTERS LIMIT ---//
    //------------------------------//
    //
});