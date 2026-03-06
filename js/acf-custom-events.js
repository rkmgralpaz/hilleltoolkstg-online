jQuery(document).ready(function($){

    //--- paths ---//

    var themeFolderName = 'hillel-combating-antisemitism';
    var themePath = String(window.location).split('wp-admin')[0]+'wp-content/themes/'+themeFolderName;
    var assetsFolder = themePath+'/assets/acf/';
    let noCacheVersion = '0001';

    const filterByType = function(){
        const base = String(window.location).split('wp-admin')[0];
        //
        const dataOnDemand = {};
        const url1 = base+'?get_tax_type=1';
        const xhttp1 = new XMLHttpRequest();
        xhttp1.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const result = this.responseText.split('<!-- TAX-TYPE -->');
                $('.acf-field[data-name="filter_by_type_on_demand"]').each(function(){
                    var input = $(this).find('input');
                    var value = input.val().split(';');
                    input.after(result[0]).css({display:'none'});
                    if(value.length > 1){
                        value = value[1];
                        input.parent().find('select option[value='+value+']').attr('selected','selected');
                    }
                });
                $('body').on('change','.acf-field[data-name="filter_by_type_on_demand"] select',function(){
                    const $this = $(this);
                    var value = $this.data('taxonomy')+';'+$this.val();
                    $this.parent().find('input').val(value);
                });
            }
        };
        xhttp1.open('GET', url1, true);
        xhttp1.send();
        //
        const dataUpcoming = {};
        const url2 = base+'?get_tax_type=0';
        const xhttp2 = new XMLHttpRequest();
        xhttp2.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const result = this.responseText.split('<!-- TAX-TYPE -->');
                $('.acf-field[data-name="filter_by_type_upcoming"]').each(function(){
                    var input = $(this).find('input');
                    var value = input.val().split(';');
                    input.after(result[0]).css({display:'none'});
                    if(value.length > 1){
                        value = value[1];
                        input.parent().find('select option[value='+value+']').attr('selected','selected');
                    }
                });
                $('body').on('change','.acf-field[data-name="filter_by_type_upcoming"] select',function(){
                    const $this = $(this);
                    const value = $this.data('taxonomy')+';'+$this.val();
                    $this.parent().find('input').val(value);
                });
            }
        };
        xhttp2.open('GET', url2, true);
        xhttp2.send();
    }
    filterByType();
    

    
    //--- global tabs ---//
    var globalTabsTargets = [];
    var globalTabsIndex = localStorage.getItem("globalTabsIndex") || 0;
    var globalTabsClean = function(index){
        globalTabsIndex = index;
        for(var i=0; i<globalTabsTargets.length; i++){
            globalTabsTargets[i].addClass('acf-hidden');
        }
    }
    $('#publish').click(function(){
        localStorage.setItem("globalTabsIndex", globalTabsIndex);
    });
    var globalsTabs = function(){
        $('.acf-tab-button').each(function(){
            var $this = $(this);
            var label = $this.text();
            if($this.hasClass('global-tab-readed')) return false;
            $this.addClass('global-tab-readed');
            if(label.indexOf('#global-tab:') !== -1){
                var params = label.split('#global-tab:');
                var ids = (params.length > 1) ? params[1].split(',') : [];
                var targetStr = [];
                ids.forEach(function(el) {
                    targetStr.push('#'+el);
                });
                var target = $(targetStr.join(', '));
                $this.text(params[0]);
                if(target.length){
                    globalTabsTargets.push(target);
                    $this.data('global-tab', target);
                    $this.click(function(){
                        globalTabsClean($this.parent().index());
                        var t = $this.data('global-tab')
                        t.removeClass('acf-hidden');
                    });
                }else{
                    $this.click(function(){
                        globalTabsClean($this.parent().index());
                    });
                }
            }else{
                $this.click(function(){
                    globalTabsClean($this.parent().index());
                });
            }
        });
        $('.acf-tab-button').eq(globalTabsIndex).click();
    }
    var hasTabs = $('.acf-tab-button').length;
    var tabCounter = 0;
    $('#page_template').change(function(){
        $('#normal-sortables').addClass('gt--hidden');
        $('body').append('<div id="global-tabs-preloader"></div>')
        setTimeout(function(){
            $('#normal-sortables').removeClass('gt--hidden');
            $('#global-tabs-preloader').remove();
            globalsTabs();
        },1000);        
    });
    $('body').append(`
    <style>
    #normal-sortables.gt--hidden{
        display: none !important;
    }
    #global-tabs-preloader{
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-20px,-20px);
        width: 40px;
        height: 40px;
        opacity: 0.7;
        background-image: url(${assetsFolder}acf-global-preloader.svg);
        background-size: contain;
    }
    </style>
    `)
    localStorage.removeItem("globalTabsIndex");
    globalsTabs();       
    //--- global tabs ---//

    //--- disabled elements ---//
    $('.acf-field-true-false.disabled').unbind();

    $('#page_template option').eq(0).text('(no template)');
    
    setTimeout(function(){
        if($('#page_template').length){
            $('#page_template').change(function(){
                if($('.post-type-page .acf-tab-button').length){
                    setTimeout(function(){
                        $('.post-type-page .acf-tab-button').eq(0).click();
                    },100);
                }
            });
        }
    },100);

    acf.add_action('load', function( $el ){   
        

        //$('.acf-field.disabled input').attr('disabled','disabled');
        $('.acf-field.disabled input').focus(function(){$(this.blur())});

        $('.acf-field-gallery .acf-gallery-add').text('Add Images');
        
        setTimeout(()=>{
            $('.acf-field-gallery.gallery-small-height .acf-gallery').css({height: 240})
        },1);

        //-------------------------------------------//
        //--- DISABLE EDIT SLUG FROM PAGE/POST ID ---//
        /*
        home: 2;
        */
        var disableEditSlug = [2];
        var winloc = String(window.location);
        for(var i=0; i<disableEditSlug.length; i++){
            if(winloc.indexOf('post='+disableEditSlug[i]+'&') !== -1){
                $('#edit-slug-buttons').remove();
                break;
            }
        }
        $('#adv-settings label[for="slugdiv-hide"]').css({display:'none'});
        //--- DISABLE EDIT SLUG FROM PAGE/POST ID ---//
        //-------------------------------------------//

        //-------------------------------//
        //--- REPEATER AUTOCOLLASIBLE ---//
        if($('.acf-field-repeater.auto-collapsible').length){
            setTimeout(function(){
                $('.acf-field-repeater.auto-collapsible .acf-row').addClass('-collapsed'); 
                $('.acf-field-repeater.auto-collapsible .acf-field-repeater:not(.auto-collapsible) .acf-row, .acf-field-repeater.auto-collapsible .acf-field:not(.acf-field-repeater):not(.auto-collapsible) .acf-row').removeClass('-collapsed');                
            },100);
        }
        //--- REPEATER AUTOCOLLASIBLE ---//
        //-------------------------------//
        
        //--------------------//
        //--- FLEX CONTENT ---//
        // refresh flex content row title (apply blur event to input, textarea and )
        //if($('.acf-field-flexible-content').length){
            
            $('.acf-field.acf-field-flexible-content.disable-native-controls').addClass('disable-drag');
            $('.acf-field.acf-field-flexible-content.disable-drag .acf-fc-layout-handle')
            .removeClass('ui-sortable-handle')
            .attr('title','')
            .unbind()
            .css({cursor:'default'})
            .click(function(){
                $('.acf-field.acf-field-flexible-content.disable-drag .ui-sortable')
                .unbind()
                .removeClass('ui-sortable');
                $('.acf-field.acf-field-flexible-content.disable-drag .ui-sortable-handle')
                .unbind()
                .removeClass('ui-sortable-handle');  
            });
            $('.acf-field.acf-field-flexible-content.disable-drag .ui-sortable')
            .unbind()
            .removeClass('ui-sortable');
            $('.acf-field.acf-field-flexible-content.disable-drag .ui-sortable-handle')
            .unbind()
            .removeClass('ui-sortable-handle');

            setTimeout(function(){
                $('.acf-field-flexible-content.auto-collapsible .layout').addClass('-collapsed');
                $('.acf-field-flexible-content.auto-collapsible .layout[data-layout="form"]').each(function(){
                    var $this = $(this);
                    var $switch = $this.find('.hide-txt-btn .acf-true-false .acf-switch');
                    if($switch.hasClass('-on')){
                        $this.find('.text-code').addClass('full-width');
                    }else{
                        $this.find('.text-code').removeClass('full-width');
                    }
                });
            },100);

            var flexThumb;
            $('body').append(`
            <style id="flex-content-thumb-preview-style">
                #flex-content-thumb-preview{
                    position: absolute;
                    left: 0;
                    top: 0;
                    /* transform: translateX(calc(-100% - 3px))  scale(0.95); */
                    transform: translateX(calc(-100% - 3px));
                    height: auto;
                    /* background: #1f2938; */
                    background: rgba(31, 41, 56, 0.8);
                    overflow: hidden;
                    /* box-shadow: 0 0 18px rgba(0,0,0,0.3); */
                    box-shadow: 0 0 25px rgba(0,0,0,0.5);
                    line-height: 0;
                    height: 150px;
                    visibility: hidden;
                    border-radius: 6px;
                    opacity: 0;
                    display: flex;
                    flex-direction: column;
                }
                #flex-content-thumb-preview.visible{
                    transition-property: opacity, transform;
                    transition-duration: 0.2s;
                    transition-timing-function: cubic-bezier(.08,.57,.54,1.02);
                    transform: translateX(calc(-100% - 3px)) scale(1);
                    visibility: visible;
                    overflow: visible;
                    opacity: 1;
                    height: auto;
                }
                #flex-content-thumb-preview img{
                    width: auto;
                    height: 100%;
                    height: 150px;
                    border-radius: 6px 6px 0 0;
                }
                #flex-content-thumb-preview .alt-text{
                    padding: 10px;
                    color: #eeeeee;
                    background: #1f2938;
                    border-radius: 0 0 6px 6px;
                    line-height: 1.5em;
                    width: auto;
                }
                #flex-content-thumb-preloader{
                    position: absolute;
                    left: 0;
                    top: 0;
                    transform: translateX(calc(-100% - 3px));
                    width: 20px;
                    height: 20px;
                    background-image: url(${assetsFolder}acf-flex-content-thumb-preloader.svg);
                    background-size: contain;
                    visibility: hidden;
                }
                #flex-content-thumb-preloader.visible{
                    visibility: visible;
                }
            </style>
            `);
            var flexThumbTimeout;
            var flexThumbTexts;
            $.ajax({
                url : assetsFolder+'acf-flex-content-thumb-alt-texts.json?version='+noCacheVersion,
                dataType: "text",
                success : function (data) {
                    flexThumbTexts = JSON.parse(data);
                }
            });
            var addFlexThumb = function($el){
                clearTimeout(flexThumbTimeout);
                $('#flex-content-thumb-preloader').remove();
                $('#flex-content-thumb-preview').remove();
                const thumbName = 'acf-flex-content-thumb-'+$el.data('layout').split('_').join('-');
                const image = assetsFolder+thumbName+'.jpg?version='+noCacheVersion;
                const $parent = $el.parent();
                const $parentParent = $parent.parent();
                const top = $parent.position().top;
                const position = Math.max(0, Math.min($parentParent.outerHeight()-140, top - 62));
                const thumbAltText = flexThumbTexts[thumbName] ? flexThumbTexts[thumbName] : '';
                let html = '<div id="flex-content-thumb-preview" style="top:'+position+'px"><img src="'+image+'" /><div class="alt-text">'+thumbAltText+'</di></div>';
                html += '<div id="flex-content-thumb-preloader" style="top:'+(top+5)+'px"></div>';
                const img = new Image();
                img.onload = function(){
                    $('#flex-content-thumb-preloader').remove();
                    $('#flex-content-thumb-preview').addClass('visible');
                    //
                    $('#flex-content-thumb-preloader').remove();
                    const $preview = $('#flex-content-thumb-preview');
                    $preview.addClass('visible');
                    let repos;
                    const pos2 = Math.max(0, Math.min($parentParent.outerHeight()));
                    const txtH = $preview.find('.alt-text').outerHeight();
                    repos = Math.min(Math.max(0, position - txtH / 2), $parentParent.outerHeight() - $preview.outerHeight() + 10);
                    $preview.css({top: repos});
                }
                img.src = image;
                $parentParent.append(html);
                flexThumbTimeout = setTimeout(function(){
                    $('#flex-content-thumb-preloader').addClass('visible');
                },300);
                //$parentParent.append('<div id="flex-content-thumb-preview" style="top:'+position+'px;background-image:url('+image+');"></div>');
            }
            var removeFlexThumb = function(){
                clearTimeout(flexThumbTimeout);
                flexThumbTimeout = setTimeout(function(){
                    $('#flex-content-thumb-preloader').remove();
                    $('#flex-content-thumb-preview').remove();
                },100);
            }
            $('body').on('mouseover focus','.acf-tooltip.acf-fc-popup.show-thumbs a',function(){
                removeFlexThumb();
                addFlexThumb($(this));
            }).on('mouseout','.acf-tooltip.acf-fc-popup.show-thumbs a',function(){
                removeFlexThumb();
            });

            $('.acf-field-flexible-content.show-thumbs .button-primary').click(function(){
                setTimeout(function(){
                    $('.acf-tooltip.acf-fc-popup').addClass('show-thumbs')
                },10);
            });
            
            $('body').on('blur','.acf-field-flexible-content input, .acf-field-flexible-content textarea',function(){
                let $this = $(this);
                let id = '#'+String($this.attr('id'));
                $('.acf-field-flexible-content').each(function(){
                    let $flex = $(this)
                    if($flex.find(id).length){
                        let $handle = $flex.find('.acf-fc-layout-handle');
                        $handle.click();
                        $handle.click();
                        return false;
                    }
                });
            });

            $(window).resize(function(){
                $('.acf-tooltip.acf-fc-popup').remove();
            });
            
            ACFinitTinymceEditor = function(){
                $('.acf-field-flexible-content .layout').each(function(){
                    var $currentModule = $(this);
                    if(!$currentModule.hasClass('ivan-loaded')){
                        $currentModule.addClass('ivan-loaded');
                        var $iframe = $currentModule.find('iframe');
                        if($iframe.length){
                            $iframe.contents().find("#tinymce").blur(function(){
                                var $target  = $currentModule.find('.acf-fc-layout-handle.ui-sortable-handle');
                                $target.click();
                                $target.click();
                            });    
                        }
                    }
                });
            }
            //
            //--- FLEX CONTENT SINGLE ---//
            let disableFlexContentSingle = false;
            $( "body" ).on( "click", ".acf-flex-content-multiple .acf-actions .button", function(e) {
                disableFlexContentSingle = true;
                setTimeout(function(){
                    disableFlexContentSingle = false;
                },150);
            });
            $( "body" ).on( "click", ".acf-flex-content-single .acf-actions .button", function() {
                if(disableFlexContentSingle) return false;
                const id = 'acf-fc-popup-tmp-'+Math.round(Math.random()*99999999);
                $('body').append('<style id="'+id+'">.acf-tooltip.acf-fc-popup{opacity:0}</style>');
                setTimeout(function(){
                    let $li = $('.acf-tooltip.acf-fc-popup ul li');
                    if($li.length){
                        $li.eq(0).children('a').click();
                    }
                    $('#'+id).remove();
                },100);
            });
            
        //}
        //--- FLEX CONTENT ---//
        //--------------------//

        //-----------------------------------//
        //--- LIST OF COLORS - ACF SELECT ---//
        listOfColorsACF.init();
        //--- LIST OF COLORS - ACF SELECT ---//
        //-----------------------------------//
        
        //---------------------------//
        //--- CUSTOM COLOR PICKER ---//
        customColorPicker.init();
        //--- CUSTOM COLOR PICKER ---//
        //---------------------------//
    });

    //---------------------------//
    //--- CUSTOM COLOR PICKER ---//
    const customColorPicker = {
        init: function(){
            if($('.custom-color-picker').length){
                $('body').append('<style>.custom-color-picker .wp-picker-holder .iris-palette.selected{box-shadow: 0px 0px 0px 2px #444444;}</style>');
                this.render();
            }
        },
        control: function(){
            this.render();
        },
        render: function(){
            $('.custom-color-picker').each(function(){
                let $this = $(this);
                if(!$this.data('custom-color-picker-loaded')){
                    let selectedColor = String($this.find('.wp-picker-input-wrap input').val()).toUpperCase();
                    $this.find('.iris-border, .iris-picker-inner, .iris-palette-container').css({postion:'relative',top:'auto',bottom:'auto',left:'auto',right:'auto', padding: 0, margin: 0});
                    $this.find('.wp-picker-input-wrap').css({display:'none',opacity:0});
                    $this.find('.wp-picker-container').css({width:'100%'});
                    $this.find('.wp-picker-holder .iris-square').css({display:'none',opacity:0});
                    $this.find('.wp-picker-holder .iris-slider').css({display:'none',opacity:0});
                    $this.find('.wp-picker-holder .iris-picker').css({width:'auto',height:30,display:'flex',padding:0,border:'none'});
                    $this.find('button.wp-color-result').css({display:'none',opacity:0});
                    $this.find('.iris-palette-container').css({top:'auto',bottom:'auto',left:'auto',right:'auto'});
                    $this.find('.iris-palette').each(function(){
                        let $iris = $(this);
                        if($iris.data('color').toUpperCase() === selectedColor.toUpperCase()){
                            $iris.addClass('selected');
                            //return false;
                        }
                        $iris.click(function(){
                            $(this).parent().find('.iris-palette').removeClass('selected');
                            $(this).addClass('selected');    
                        })
                        $iris.css({width:30,height:30,borderRadius:2, margin:'0px 3px 3px 0px'});
                    });
                    $this.data('custom-color-picker-loaded',true);
                }
            });
        }
    }
    acf.add_filter('color_picker_args', function( args, field ){
        let pickerList = [
            {
                class: 'custom-color-picker-1', 
                palettes: ['#F26200', '#F5F4F0', '#085C6C']
            }
        ];
        for(let i=0; i<pickerList.length; i++){
            if(field.hasClass(pickerList[i].class)){
                args.palettes = pickerList[i].palettes;
            }
        }
        // return
        return args;
    });
    //--- CUSTOM COLOR PICKER ---//
    //---------------------------//

    //-----------------------------------//
    //--- LIST OF COLORS - ACF SELECT ---//
    const listOfColorsACF = {
        $selected: '',
        iconHTML: '<i class="icon-color" style="width: 14px;height: 14px;background:{color};background-repeat:no-repeat;background-size:cover;line-height: 0;display: inline-block;margin-right: 5px;border-radius: 2px;vertical-align: text-top; box-shadow: 0px 0px 0px 1px #444444;"></i>',
        labelRender: function($dropdown, value){
            let selectedColor = String(value).split(';'); 
            selectedColor = selectedColor.length == 2 ? selectedColor[1] : '';
            let $this = $(this);
            let $selection = $dropdown.find('.select2-selection__rendered .acf-selection');
            if($selection.length){
                selectedColor = selectedColor.split('#transparent').join("url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAMAAADXqc3KAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAydpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDkuMC1jMDAxIDc5LmMwMjA0YjJkZWYsIDIwMjMvMDIvMDItMTI6MTQ6MjQgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCAyMDIzIE1hY2ludG9zaCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo4MjNGMkQ3OURENjQxMUVEOUE0NEQ5NDhBRkUyQTNFRSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo4MjNGMkQ3QURENjQxMUVEOUE0NEQ5NDhBRkUyQTNFRSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjgyM0YyRDc3REQ2NDExRUQ5QTQ0RDk0OEFGRTJBM0VFIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjgyM0YyRDc4REQ2NDExRUQ5QTQ0RDk0OEFGRTJBM0VFIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+2VO2MQAAAAZQTFRF////zMzMOOqqgwAAABxJREFUeNpiYIQCBiiA84eYBE6BISYxTOIDIMAAeWcBQZW5YTwAAAAASUVORK5CYII=')");
                let html = this.iconHTML.split('{color}').join(selectedColor);
                $selection.prepend(html);
            }
        },
        listRender: function(){
            $('.select2-container .select2-results__options li').each(function(i){
                let $this = $(this);
                let id = String($this.data('select2Id')).split('#');
                let color, html;
                if(id.length > 1){
                    if(id[1].indexOf('transparent') !== -1){
                        color = "url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAMAAADXqc3KAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAydpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDkuMC1jMDAxIDc5LmMwMjA0YjJkZWYsIDIwMjMvMDIvMDItMTI6MTQ6MjQgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCAyMDIzIE1hY2ludG9zaCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo4MjNGMkQ3OURENjQxMUVEOUE0NEQ5NDhBRkUyQTNFRSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo4MjNGMkQ3QURENjQxMUVEOUE0NEQ5NDhBRkUyQTNFRSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjgyM0YyRDc3REQ2NDExRUQ5QTQ0RDk0OEFGRTJBM0VFIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjgyM0YyRDc4REQ2NDExRUQ5QTQ0RDk0OEFGRTJBM0VFIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+2VO2MQAAAAZQTFRF////zMzMOOqqgwAAABxJREFUeNpiYIQCBiiA84eYBE6BISYxTOIDIMAAeWcBQZW5YTwAAAAASUVORK5CYII=')";
                    }else{
                        color = '#'+id[1];
                    }
                    html = listOfColorsACF.iconHTML.split('{color}').join(color);
                    $this.html(html+$this.text());
                }
            });
        },
        control: function(){
            this.init();
        },
        init:function(){
            let $colorList = $('.acf-field-select.list-of-colors');
            $('body').on("mousedown",'.acf-field-select.list-of-colors', function(e) {
                listOfColorsACF.$selected = $(this);
                listOfColorsACF.listRender();
            });
           /*  $('body').on("mouseup",'.select2-hidden-accessible', function(e) {
                listOfColorsACF.labelRender(listOfColorsACF.$selected, $(e.target).val());
            }); */
            $colorList.each(function(){
                let $this = $(this);
                if(!$this.data('list-color-loaded')){
                    let val = $this.find('.select2-hidden-accessible').val();
                    if(val){
                        listOfColorsACF.labelRender($this, val);   
                    }
                    $this.click(function(){
                        listOfColorsACF.$selected = $(this);
                        listOfColorsACF.listRender();
                        //$('.select2-container .select2-dropdown').css({opacity:0});
                        //setTimeout(()=>{
                            
                        //},0);
                    });
                    $this.on("change",'.select2-hidden-accessible', function(e) {
                        listOfColorsACF.labelRender(listOfColorsACF.$selected, $(this).val());
                    });
                    
                    $this.data('list-color-loaded',true);
                }
            });
            if(!listOfColorsACF.firstRun && $colorList.length){
                listOfColorsACF.firstRun = true;
                $('body').on('keyup','.select2-container .select2-dropdown .select2-search__field',function(e){
                    listOfColorsACF.listRender();
                });
            }
        }
    }
    //--- LIST OF COLORS - ACF SELECT ---//
    //-----------------------------------//
    
     
    //--- event when append rows (repeater and flex content)
    acf.add_action('append', function( $el ){
          
        let $last;
        let $parent = $el.parent().parent().parent().parent().find('.acf-flexible-content');//$('.wp-core-ui .button-primary:focus').parent().parent();
        if($parent.hasClass('acf-flexible-content')){
            $parent.find('.values.ui-sortable .layout').each(function(){
                $last = $(this);
            });
            if($last){
                $last.removeClass('-collapsed');
            }
        }
  
        listOfColorsACF.control();  
        customColorPicker.control();              
    });

    document.querySelectorAll('.year_post_incidents_data input').forEach(function(element){
        element.setAttribute('readonly', 'true');
        element.setAttribute('disabled', 'true');
    });
});







