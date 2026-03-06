//version 1.1.7 (Javascript ES6)
//
//------------------//
//--- SET STYLES ---//
//------------------//
HTMLElement.prototype.setStyles = function(obj){ 
    for (let k in obj){
        this.style[k] = typeof obj[k] == 'number' && k != 'opacity' ? obj[k]+'px' : obj[k];
    }
}
HTMLElement.prototype.setStyle = HTMLElement.prototype.setStyles;
SVGElement.prototype.setStyles = function(obj){ 
    for (let k in obj){
        this.style[k] = typeof obj[k] == 'number' && k != 'opacity' ? obj[k]+'px' : obj[k];
    }
}
SVGElement.prototype.setStyle = SVGElement.prototype.setStyles;
//-------------//
//--- UTILS ---//
//-------------//
const utils = {
    setStyles: function(elements, styles){
        let el = typeof elements === "string" ? document.querySelectorAll(elements) : elements;
        if( el instanceof NodeList ){
            el.forEach((e) => e.setStyles(styles));
        }else if (el instanceof HTMLCollection) {
            for (let i = el.length-1; i >= 0; i--) {
                el[i].setStyles(styles);
            }
        }else if(!!el){
            el.setStyles(styles);
        }
    },
    remove: function(elements){
        let el = typeof elements === "string" ? document.querySelectorAll(elements) : elements;
        if( el instanceof NodeList ){
            el.forEach((e) => e.remove());
        }else if (el instanceof HTMLCollection) {
            for (let i = el.length-1; i >= 0; i--) {
                el[i].parentNode.removeChild(el[i]);
            }
        }else if(!!el){
            el.remove();
        }
    },
    addClass: function(elements,classes){
        let el = typeof elements === "string" ? document.querySelectorAll(elements) : elements;
        if(classes instanceof Array){
            if( el instanceof NodeList || el instanceof HTMLCollection){
                for (let i = 0; i < el.length; i++) {
                    el[i].classList.add(...classes);
                }
            }else if(!!el){
                el.classList.add(...classes);
            }
        }else{
            if( el instanceof NodeList || el instanceof HTMLCollection){
                for (let i = 0; i < el.length; i++) {
                    el[i].classList.add(classes);
                }
            }else if(!!el){
                el.classList.add(classes);
            }
        }
    },
    removeClass: function(elements,classes){
        let el = typeof elements === "string" ? document.querySelectorAll(elements) : elements;
        if(classes instanceof Array){
            if( el instanceof NodeList || el instanceof HTMLCollection){
                for (let i = 0; i < el.length; i++) {
                    el[i].classList.remove(...classes);
                }
            }else if(!!el){
                el.classList.remove(...classes);
            }
        }else{
            if( el instanceof NodeList || el instanceof HTMLCollection){
                for (let i = 0; i < el.length; i++) {
                    el[i].classList.remove(classes);
                }
            }else if(!!el){
                el.classList.remove(classes);
            }
        }
    },
    getCssVar: function(elem, variable){
        let result = '';
        if(!!elem){
            result = getComputedStyle(elem).getPropertyValue(variable);
        }
        if(result.indexOf('px') !== -1){
            result = Number(result.split('px').join(''));
        }else if(result.indexOf('ms') !== -1){
            result = Number(result.split('ms').join(''));
        }else if(result.indexOf('s') !== -1){
            result = Number(result.split('s').join('')) * 1000;
        }else if(!isNaN(Number(result))){
            result = Number(result);
        }
        return result;
    },
    linkify: (str, _settings) => {
        let settings = {
            mailto: true,
            url: true,
            target: '',
        }
        utils.extend(settings, _settings);
        let result = str;
        if(settings.url){
            // http://, https://, ftp://
            let urlPattern = /\b(?:https?|ftp):\/\/[a-z0-9-+&@#\/%?=~_|!:,.;]*[a-z0-9-+&@#\/%=~_|]/gim;
            // www. sans http:// or https://
            let pseudoUrlPattern = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
            result = result
            .replace(urlPattern, '<a href="$&" target="'+settings.target+'">$&</a>')
            .replace(pseudoUrlPattern, '$1<a href="http://$2" target="'+settings.target+'" >$2</a>');
        }
        if(settings.mailto){
            // Email addresses
            let emailAddressPattern = /[\w.]+@[a-zA-Z_-]+?(?:\.[a-zA-Z]{2,6})+/gim;
            result = result.replace(emailAddressPattern, '<a href="mailto:$&">$&</a>');
        }
        return result;  
    },
    parsePseudoTags: (str) => {
        let tags = ['a','div','span','b','i','strong','em','br','u','hr','sup','sub'];
        let result = str;
        tags.forEach((el) => {
            result = result.split('[/'+el+']').join('</'+el+'>').split('['+el+' ').join('<'+el+' ').split('['+el+']').join('<'+el+'>').split('"] ').join('"]').split("'] ").join("']").split('"]').join('">').split("']").join("'>");
        });
        return result;
    },
    validateEmail: (str) => {
        var re = /\S+@\S+\.\S+/;
        return re.test(str);
    },
    getTransitionPropeties: function(element, forceTimeAsMillisecondsNumber){
        const el = typeof element === "string" ? document.querySelector(element) : element;
        const result = {};
        if(!!el){
            const computedStyle = window.getComputedStyle(el);
            result.transitionDuration = computedStyle.getPropertyValue('transition-duration');
            result.transitionDelay = computedStyle.getPropertyValue('transition-delay');
            result.transitionProperty = computedStyle.getPropertyValue('transition-property');
            result.transitionTimingFunction = computedStyle.getPropertyValue('transition-timing-function');
        }
        if(result.transitionDuration && forceTimeAsMillisecondsNumber){
            result.transitionDuration = result.transitionDuration.indexOf('ms') !== -1 ? Number(result.transitionDuration.replace(/[^\d.]/g, '')) : Number(result.transitionDuration.replace(/[^\d.]/g, '')) * 1000; 
        }
        if(result.transitionDelay && forceTimeAsMillisecondsNumber){
            result.transitionDelay = result.transitionDelay.indexOf('ms') !== -1 ? Number(result.transitionDelay.replace(/[^\d.]/g, '')) : Number(result.transitionDelay.replace(/[^\d.]/g, '')) * 1000; 
        }
        return result;
    },
    hitTest: function(el1, el2){
        //--- beta ---//
        let result = false;
        if(!!el1 && !!el2){
            let docElem = document.documentElement;
            let box1 = el1.getBoundingClientRect();
            let top1 = box1.top + window.scrollY - docElem.clientTop;
            let left1 = box1.left + window.scrollX - docElem.clientLeft;
            let size1 = utils.getSize(el1);
            let box2 = el2.getBoundingClientRect();
            let top2 = box2.top + window.scrollY - docElem.clientTop;
            let left2 = box2.left + window.scrollX - docElem.clientLeft;
            let size2 = utils.getSize(el2);
            let hitX =  (left1 <= left2 && left1 + size1.outerWidth >= left2) || (left2 <= left1 && left2 + size2.outerWidth >= left1);
            let hitY =  (top1 <= top2 && top1 + size1.outerHeight >= top2) || (top2 <= top1 && top2 + size2.outerHeight >= top1);
            result = hitX && hitY;
        }
        return result;
    },
    documentSize: function(){
        const body = document.body;
        const html = document.documentElement;
        const width = Math.max(body.scrollWidth, body.offsetWidth, html.clientWidth, html.scrollWidth, html.offsetWidth);
        const height = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);
        return {width:width,height:height}
    },
    getOuterWidth: function(el, exclude){
        let width, style, paddingLeft, paddingRight, marginLeft, marginRight, borderLeft, borderRight;
        width = el.clientWidth;
        style = getComputedStyle(el);
        paddingLeft = parseFloat(style.paddingLeft);
        paddingRight = parseFloat(style.paddingRight);
        marginLeft = parseFloat(style.marginLeft);
        marginRight = parseFloat(style.marginRight);
        borderLeft = parseFloat(style.getPropertyValue('border-left-width'));
        borderRight = parseFloat(style.getPropertyValue('border-right-width'));
        if(!exclude){
            width += borderLeft + borderRight + marginLeft + marginRight;
        }else if(typeof exclude === 'string'){
            let c1 = String(exclude).toLowerCase() == 'padding';
            let c2 = String(exclude).toLowerCase() == 'margin';
            let c3 = String(exclude).toLowerCase() == 'border';
            if(c1){
                width += borderLeft + borderRight + marginLeft + marginRight - paddingLeft - paddingRight;
            }else if(c2){
                width += borderLeft + borderRight;
            }else if(c3){
                width += marginLeft + marginRight - paddingLeft - paddingRight;
            }
        }else if(exclude instanceof Array){
            width = width-paddingLeft-paddingRight;
            let propList = [
                {name: 'paddingleft', value: paddingLeft},
                {name: 'paddingright', value: paddingRight},
                {name: 'marginleft', value: marginLeft},
                {name: 'marginright', value: marginRight},
                {name: 'borderleft', value: borderLeft},
                {name: 'borderright', value: borderRight}
            ];
            propList.forEach((p) => {
                let hit = true;
                exclude.forEach((e) => {
                    if(String(e).toLowerCase().replace('-','') == p.name){
                        hit = false
                        return false;
                    }
                });
                if(hit){
                    width += p.value;
                }
            });
        }
        return width;
    },
    outerWidth: function(elements,exclude) {
        let el = typeof elements === "string" ? document.querySelectorAll(elements) : elements;
        let width;
        if( el instanceof NodeList || el instanceof HTMLCollection){
            width = [];
            for (let i = 0; i < el.length; i++) {
                width.push(utils.getOuterWidth(el[i], exclude));
            }
        }else if(!!el){
            width = utils.getOuterWidth(el, exclude);
        }
        return width;
    },
    getOuterHeight: function(el, exclude){
        let height, style, paddingTop, paddingBottom, marginTop, marginBottom, borderTop, borderBottom;
        height = el.clientHeight;
        style = getComputedStyle(el);
        paddingTop = parseFloat(style.paddingTop);
        paddingBottom = parseFloat(style.paddingBottom);
        marginTop = parseFloat(style.marginTop);
        marginBottom = parseFloat(style.marginBottom);
        borderTop = parseFloat(style.getPropertyValue('border-top-width'));
        borderBottom = parseFloat(style.getPropertyValue('border-bottom-width'));
        if(!exclude){
            height += borderTop + borderBottom + marginTop + marginBottom;
        }else if(typeof exclude === 'string'){
            let c1 = String(exclude).toLowerCase() == 'padding';
            let c2 = String(exclude).toLowerCase() == 'margin';
            let c3 = String(exclude).toLowerCase() == 'border';
            if(c1){
                height += borderTop + borderBottom + marginTop + marginBottom - paddingTop - paddingBottom;
            }else if(c2){
                height += borderTop + borderBottom;
            }else if(c3){
                height += marginTop + marginBottom - paddingTop - paddingBottom;
            }
        }else if(exclude instanceof Array){
            height = height-paddingTop-paddingBottom;
            let propList = [
                {name: 'paddingtop', value: paddingTop},
                {name: 'paddingbottom', value: paddingBottom},
                {name: 'margintop', value: marginTop},
                {name: 'marginbottom', value: marginBottom},
                {name: 'bordertop', value: borderTop},
                {name: 'borderbottom', value: borderBottom}
            ];
            propList.forEach((p) => {
                let hit = true;
                exclude.forEach((e) => {
                    if(String(e).toLowerCase().replace('-','') == p.name){
                        hit = false
                        return false;
                    }
                });
                if(hit){
                    height += p.value;
                }
            });
        }
        return height;
    },
    outerHeight: function(elements, exclude) {
        let el = typeof elements === "string" ? document.querySelectorAll(elements) : elements;
        let height;
        if( el instanceof NodeList || el instanceof HTMLCollection){
            height = [];
            for (let i = 0; i < el.length; i++) {
                height.push(utils.getOuterHeight(el[i], exclude));
            }
        }else if(!!el){
            height = utils.getOuterHeight(el, exclude);
        }
        return height;
    },
    getSize: function(el){
        let width = el.clientWidth;
        let height = el.clientHeight;
        let style = getComputedStyle(el);
        let paddingTop = parseFloat(style.paddingTop);
        let paddingBottom = parseFloat(style.paddingBottom);
        let paddingLeft = parseFloat(style.paddingLeft);
        let paddingRight = parseFloat(style.paddingRight);
        let marginTop = parseFloat(style.marginTop);
        let marginBottom = parseFloat(style.marginBottom);
        let marginLeft = parseFloat(style.marginLeft);
        let marginRight = parseFloat(style.marginRight);
        let borderLeft = parseFloat(style.getPropertyValue('border-left-width'));
        let borderRight = parseFloat(style.getPropertyValue('border-right-width'));
        let borderTop = parseFloat(style.getPropertyValue('border-top-width'));
        let borderBottom = parseFloat(style.getPropertyValue('border-bottom-width'));
        return {
            width: width-paddingLeft-paddingRight,
            height: height-paddingTop-paddingBottom, 
            innerWidth: width,
            innerHeight: height,
            outerWidth: width+borderLeft+borderRight+marginLeft+marginRight,
            outerHeight: height+borderTop+borderBottom+marginTop+marginBottom, 
            paddingTop: paddingTop,
            paddingBottom: paddingBottom,
            paddingLeft: paddingLeft,
            paddingRight: paddingRight,
            marginTop: marginTop,
            marginBottom: marginBottom,
            marginLeft: marginLeft,
            marginRight: marginRight,
            borderLeft: borderLeft,
            borderRight: borderRight,
            borderTop: borderTop,
            borderBottom: borderBottom
        }
    },
    size: function(elements) {
        let el = typeof elements === "string" ? document.querySelectorAll(elements) : elements;
        if( el instanceof NodeList || el instanceof HTMLCollection){
            let size = [];
            for (let i = 0; i < el.length; i++) {
                size.push(utils.getSize(el[i]));
            }
        }else if(!!el){
            size = utils.getSize(el);
        }
        return size;
    },
    getTranslateXY: function(element) {
        const style = window.getComputedStyle(element)
        const matrix = new DOMMatrixReadOnly(style.transform)
        return {
            translateX: matrix.m41,
            translateY: matrix.m42
        }
    },
    position: function(el, offset) {
        if(!el) return false;
        let result = {};
        if(offset){
            const box = el.getBoundingClientRect();
            result = {
                top: box.top + window.scrollY,
                left: box.left + window.scrollX
            }
        }else{
            const {top, left} = el.getBoundingClientRect();
            const {marginTop, marginLeft} = getComputedStyle(el);
            result = {
                top: top - parseInt(marginTop, 10),
                left: left - parseInt(marginLeft, 10)
            }
        }
        return result;
    },
    scrollTo: function(target, params) {
        if(!target || !params) return false;
        const top = Math.round(Number(params.top) || 0);
        const left = Math.round(Number(params.left) || 0);
        const behavior = params.behavior || 'smooth';
        const complete = params.complete && typeof params.complete === 'function' ? params.complete : function(){};
        window.utilsEventScrollTmp123 = ()=>{
            const scrollTop =  window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;    
            const scrollLeft =  window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft || 0;
            if(scrollTop == top && scrollLeft == left){
                complete();
                window.removeEventListener('scroll', utilsEventScrollTmp123);
                delete window.utilsEventScrollTmp123;
            }
        }
        target.addEventListener('scroll', utilsEventScrollTmp123);
        target.scrollTo({
            top: top,
            left: left,
            behavior: behavior,
        });
    },
    extend: function(out) {
        out = out || {};
        for (var i = 1; i < arguments.length; i++) {
            if (!arguments[i]){
                continue;
            }
            for (var key in arguments[i]) {
                if (arguments[i].hasOwnProperty(key)){
                    out[key] = arguments[i][key];
                }
            }
        }
        return out;
    },
    deepExtend: function(out) {
        out = out || {};
        for (let i = 1; i < arguments.length; i++) {
            let obj = arguments[i];
            if (!obj){
                continue;
            } 
            for (let key in obj) {
                if (obj.hasOwnProperty(key)) {
                    if (typeof obj[key] === "object" && obj[key] !== null) {
                        if (obj[key] instanceof Array){
                            out[key] = obj[key].slice(0);
                        }else{
                            out[key] = utils.deepExtend(out[key], obj[key]);
                        }
                    }else{
                        out[key] = obj[key];
                    }
                }
            }
        }
        return out;
    },
    hex2rgb: function(c){
        let color = String(c);
        if(color[0] != '#' && color.length != 4 && color.length != 7) return false;
        if(color.length == 4){
            color = color[1]+color[1]+color[2]+color[2]+color[3]+color[3];
        }
        return `rgb(${color.match(/\w\w/g).map(x=>+`0x${x}`)})`;
    },
    rgb2hex: function(c){
        return '#'+(String(c).match(/\d+/g).map(x=>(+x).toString(16).padStart(2,0)).join``).substring(0,6);
    },
    copyTextToClipboard: (text) => {
        if (!navigator.clipboard) {
            utils.fallbackCopyTextToClipboard(text);
            return;
        }
        navigator.clipboard.writeText(text).then(function() {
            console.log('Async: Copying to clipboard was successful!');
        }, function(err) {
            console.error('Async: Could not copy text: ', err);
        });
    },
    fallbackCopyTextToClipboard: (text) => {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        // Avoid scrolling to bottom
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            console.log('Fallback: Copying text command was ' + msg);
        } catch (err) {
            console.error('Fallback: Oops, unable to copy', err);
        }
        document.body.removeChild(textArea);
    }
}
//--------------------//
//--- SWIPE DETECT ---//
//--------------------//
function swipeDetect(elements, params){
    const startSwiptEvents = function(el, params){
        let touchsurface = el,
        swipedir,
        startX,
        startY,
        distX,
        distY,
        threshold = params.threshold || 75, //required min distance traveled to be considered swipe
        restraint = params.restraint || 75, // maximum distance allowed at the same time in perpendicular direction
        allowedTime = params.allowedTime || 300, // maximum time allowed to travel that distance
        elapsedTime = 0,
        startTime = 0,
        preventScrolling = params.preventScrolling || false,
        stopPropagation = params.stopPropagation || false,
        touchstart = params.touchstart || function(){},
        touchmove = params.touchmove || function(){},
        touchend = params.touchend || function(){},
        handleswipe = params.handleswipe || function(swipedir){}
        //
        touchsurface.addEventListener('touchstart', function(e){
            const touchobj = e.changedTouches[0];
            swipedir = 'none';
            distX = 0;
            distY = 0;
            startX = touchobj.pageX;
            startY = touchobj.pageY;
            startTime = new Date().getTime(); // record time when finger first makes contact with surface
            if(preventScrolling){
                e.preventDefault();
            }
            if(stopPropagation){
                e.stopPropagation();
            }
            touchstart(e,{
                swipedir: swipedir,
                startX: startX,
                startY: startY,
                distX: distX,
                distY: distY,
                threshold: threshold,
                elapsedTime: elapsedTime,
                startTime: startTime,
                allowedTime: allowedTime,
                preventScrolling: preventScrolling,
                stopPropagation: stopPropagation
            });
        }, {passive:false});
        touchsurface.addEventListener('touchmove', function(e){
            if(preventScrolling){
                e.preventDefault();
            }
            if(stopPropagation){
                e.stopPropagation();
            }
            handler(e,touchmove);
        }, {passive:false});
        touchsurface.addEventListener('touchend', function(e){
            if(preventScrolling){
                e.preventDefault();
            }
            if(stopPropagation){
                e.stopPropagation();
            }
            handler(e,touchend, true);
        }, {passive:false});
        const handler = function(e, callback, touchend = false){
            const touchobj = e.changedTouches[0]
            distX = touchobj.pageX - startX // get horizontal dist traveled by finger while in contact with surface
            distY = touchobj.pageY - startY // get vertical dist traveled by finger while in contact with surface
            elapsedTime = new Date().getTime() - startTime // get time elapsed
            if (elapsedTime <= allowedTime){ // first condition for awipe met
                if (Math.abs(distX) >= threshold && Math.abs(distY) <= restraint){ // 2nd condition for horizontal swipe met
                    swipedir = (distX < 0)? 'left' : 'right' // if dist traveled is negative, it indicates left swipe
                }
                else if (Math.abs(distY) >= threshold && Math.abs(distX) <= restraint){ // 2nd condition for vertical swipe met
                    swipedir = (distY < 0)? 'up' : 'down' // if dist traveled is negative, it indicates up swipe
                }
                callback(e,{
                    swipedir: swipedir,
                    startX: startX,
                    startY: startY,
                    distX: distX,
                    distY: distY,
                    threshold: threshold,
                    elapsedTime: elapsedTime,
                    startTime: startTime,
                    allowedTime: allowedTime,
                    preventScrolling: preventScrolling,
                    stopPropagation: stopPropagation
                });
                if(touchend){
                    handleswipe(swipedir);
                }
            }else{
                callback(e,{
                    swipedir: 'none',
                    startX: startX,
                    startY: startY,
                    distX: distX,
                    distY: distY,
                    threshold: threshold,
                    elapsedTime: elapsedTime,
                    startTime: startTime,
                    allowedTime: allowedTime,
                    preventScrolling: preventScrolling,
                    stopPropagation: stopPropagation
                });
            }
        }
    }
    //
    let el = typeof elements === "string" ? document.querySelectorAll(elements) : elements;
    if( el instanceof NodeList ){
        el.forEach((e) => startSwiptEvents(e,params));
    }else if (el instanceof HTMLCollection) {
        for (let i = el.length-1; i >= 0; i--) {
            startSwiptEvents(el[i],params);
        }
    }else if(!!el){
        startSwiptEvents(el,params);
    }
}


//---------------//
//--- COOKIES ---//
//
// JavaScript Cookie Manager
const CookieManager = {
    // Create or update a cookie
    set: function(name, value, options = {}) {
        let cookieString = `${encodeURIComponent(name)}=${encodeURIComponent(value)}`;
        // Configurar opciones
        if (options.expires) {
            if (options.expires instanceof Date) {
                cookieString += `; expires=${options.expires.toUTCString()}`;
            } else if (typeof options.expires === 'number') {
                // Si es un número, se interpreta como días
                const date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
                cookieString += `; expires=${date.toUTCString()}`;
            }
        }
        
        if (options.maxAge) {
            cookieString += `; max-age=${options.maxAge}`;
        }
        
        if (options.path) {
            cookieString += `; path=${options.path}`;
        }
        
        if (options.domain) {
            cookieString += `; domain=${options.domain}`;
        }
        
        if (options.secure) {
            cookieString += `; secure`;
        }
        
        if (options.sameSite) {
            cookieString += `; samesite=${options.sameSite}`;
        }
        
        if (options.httpOnly) {
            cookieString += `; httponly`;
        }
        
        document.cookie = cookieString;
        return true;
    },
    // Get cookie value
    get: function(name) {
        const nameEQ = encodeURIComponent(name) + "=";
        const cookies = document.cookie.split(';');
        
        for (let i = 0; i < cookies.length; i++) {
            let cookie = cookies[i];
            while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1, cookie.length);
            }
            if (cookie.indexOf(nameEQ) === 0) {
                return decodeURIComponent(cookie.substring(nameEQ.length, cookie.length));
            }
        }
        return null;
    },
    // Delete cookie
    remove: function(name, options = {}) {
        // Para eliminar, establecemos la fecha de expiración en el pasado
        const deleteOptions = {
            ...options,
            expires: new Date(0)
        };
        return this.set(name, '', deleteOptions);
    },
    // Check if a cookie exists
    exists: function(name) {
        return this.get(name) !== null;
    },
    // Get all cookies as an object
    getAll: function() {
        const cookies = {};
        const cookieArray = document.cookie.split(';');
        
        for (let i = 0; i < cookieArray.length; i++) {
            const cookie = cookieArray[i].trim();
            if (cookie) {
                const [name, value] = cookie.split('=');
                if (name && value) {
                    cookies[decodeURIComponent(name)] = decodeURIComponent(value);
                }
            }
        }
        return cookies;
    },
    // Clear all cookies
    clear: function() {
        const cookies = this.getAll();
        for (const name in cookies) {
            this.remove(name);
        }
    },
    // Get name of all cookies
    getNames: function() {
        return Object.keys(this.getAll());
    },
    // Count number of cookies
    count: function() {
        return this.getNames().length;
    }
};
// Helper function to create cookies with JSON
const JSONCookie = {
    set: function(name, obj, options) {
        return CookieManager.set(name, JSON.stringify(obj), options);
    },
    
    get: function(name) {
        const value = CookieManager.get(name);
        if (value) {
            try {
                return JSON.parse(value);
            } catch (e) {
                return null;
            }
        }
        return null;
    }
};
//
//--- COOKIES ---//
//---------------//


//-----------------//
//--- ANIMATION ---//
//-----------------//
function Animation(element, animationParams){
    let target = typeof element === "string" ? document.querySelector(element) : element;
    if(!target) return false;
    if(!animationParams || !typeof animationParams === 'object') return false;
    let params = animationParams;
    let animate = target.animate(params.keyframes, params.options);
    let fps = 1000/60;
    let reverseMode = false;
    let progressInterval;
    let getData = () => {
        return {
            target: target,
            params: params,
            playState: animate.playState,
            reverseMode: reverseMode
        }
    }
    let progress = () => {
        let evt = params.onprogress || params.onProgress;
        if(!evt || !typeof evt === 'function'){
            return false;
        }
        evt(getData());
        let currentTime = Math.max(0,animate.currentTime-params.options.delay);
        if(currentTime == 0 && reverseMode || animate.currentTime < 0){
            clearInterval(progressInterval);
            animate.onfinish();
        }
    }
    let resetProgress = () => {
        clearInterval(progressInterval);
        if(animate.currentTime){
            progress(getData());
        }
        progressInterval = setInterval(() => {
            progress(getData());
        }, fps);
    }
    animate.onfinish = (e) => {
        let evt = params.onfinish || params.onFinish;
        clearInterval(progressInterval);
        if(evt && typeof evt === 'function'){
            evt(getData());
        }
    }
    this.pause = () =>{
        animate.pause();
        clearInterval(progressInterval);
        let evt = params.onpause || params.onPause;
        if(evt && typeof evt === 'function'){
            evt(getData());
        }
    }
    this.play = () =>{
        animate.play();
        resetProgress();
        let evt = params.onplay || params.onPlay;
        if(evt && typeof evt === 'function'){
            evt(getData());
        }
    }
    this.cancel = () => {
        animate.cancel();
        clearInterval(progressInterval);
        let evt = params.oncancel || params.onCancel;
        if(evt && typeof evt === 'function'){
            evt(getData());
        }
    }
    this.playState = ()=>{
        return animate.playState;
    }
    this.togglePlay = () => {
        if(animate.playState == 'running'){
            this.pause();
        }else if(animate.playState != 'finished'){
            this.play();
        }
    }
    this.reverse = () => {
        animate.reverse();
        resetProgress();
        reverseMode = !reverseMode;
        if(params.onreverse){
            params.onreverse(getData());
        }
    }
    this.currentTime = () =>{
        return Math.max(0,animate.currentTime-params.options.delay);
    }
    this.getData = getData;
    //
    resetProgress();
    let srt = params.onstart || params.onStart;
    if(srt && typeof srt === 'function'){
        srt(getData());
    }
    //
    return this;
}
//--------------------//
//--- BROWSER ZOOM ---//
//--------------------//
const browserZoom = {
    init: (onChange, includeTouchDevices) => {
        if(browserZoom.started) return false;
        const touch = navigator.userAgent.match(/(iPad|iPhone|iPod)/) || 'ontouchstart' in window || window.ontouchstart;
        if(!includeTouchDevices && touch) return false;
        //
        browserZoom.started = true;
        if( typeof onChange === 'function'){
            browserZoom.onChange = onChange;
        }else{
            browserZoom.onChange = () => {};
        }
        //
        let ratio;
        if(Boolean(window.localStorage.getItem('devicePixelRatio'))){
            ratio = Number(window.localStorage.getItem('devicePixelRatio'));
        }else{
            ratio = window.devicePixelRatio;
            window.localStorage.setItem('devicePixelRatio',window.devicePixelRatio)
        }
        const safari = navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0;
        const firefox = navigator.userAgent.match(/firefox|fxios/i);
        //
        const ffoxFix = (value) => {
            let result = value;
            if(value > 70 && value < 87){
                result = 80;
            }else if(value >= 87 && value < 97){
                result = 90;
            }else if(value > 105 && value < 117){
                result = 110;
            }else if(value >= 117 && value < 124){
                result = 120;
            }else if(value > 128 && value < 137){
                result = 133;
            }else if(value > 145 && value < 155){
                result = 150;
            }else if(value > 165 && value < 173){
                result = 170;
            }else if(value > 231 && value < 255){
                result = 240;
            }else if(value > 297 && value < 312){
                result = 300;
            }else if(value > 370 && value < 405){
                result = 400;
            }else if(value > 450){
                result = 500;
            }
            return result;
        }
        const pageZoom = () => {
            let zoom = 0;
            if(touch){
                zoom = window.visualViewport.scale * 100;
            }else if(safari){
                zoom = Math.round((window.outerWidth / window.innerWidth)*100);
            }else{
                zoom = Math.round((window.devicePixelRatio * 100) / ratio);
            }
            if(firefox && !touch){
                zoom = ffoxFix(zoom);
            }
            return zoom;
        }
        browserZoom.getLevel = () => {
            return browserZoom.level;
        }
        let browserZoomLevel = pageZoom();
        browserZoom.prevLevel = -1;
        browserZoom.level = browserZoomLevel;
        browserZoom.onChange(browserZoomLevel);
        if(touch){
            let move = false;
            window.addEventListener('touchmove', () => {
                move = true;
                browserZoomLevel = pageZoom();
                if(browserZoom.prevLevel != browserZoomLevel){
                    browserZoom.level = browserZoomLevel;
                    browserZoom.prevLevel = browserZoomLevel;
                    browserZoom.onChange(browserZoomLevel);
                }
            });
            window.addEventListener('touchend', () => {
                if(move){
                    move = false;
                    browserZoomLevel = pageZoom();
                }
                if(browserZoom.prevLevel != browserZoomLevel && move){
                    browserZoom.level = browserZoomLevel;
                    browserZoom.prevLevel = browserZoomLevel;
                    browserZoom.onChange(browserZoomLevel);
                }
            });
            setTimeout(()=>{
                window.dispatchEvent(new Event('touchmove'));
            },87);
        }else{
            window.addEventListener('resize', () => {
                browserZoomLevel = pageZoom();
                if(browserZoom.prevLevel != browserZoomLevel){
                    browserZoom.level = browserZoomLevel;
                    browserZoom.prevLevel = browserZoomLevel;
                    browserZoom.onChange(browserZoomLevel);
                }
            });
        }
    }
}
//-----------------------//
//--- IMAGE PRELOADER ---//
//-----------------------//
function ImagePreloader(_images, params){
    let images;
    if(typeof _images === "string"){
        images = [_images];
    }else{
        images = _images;
    }
    if(!Array.isArray(images)) return false;
    let sources = [];
    let total = 0;
    let completed = 0;
    let loaded = 0;
    let percent = 0;
    let errors = 0;
    
    let i = 0;
    let src = '';
    this.getData = ()=>{
        let result = {
            total: total,
            loaded: loaded,
            errors: errors,
            completed: completed,
            percent: percent,
            sources: sources,
        }
        if(total == 1){
            result.src = sources[0].src
        }
        return result;
    }
    const loadImage = ()=>{
        const src = String(sources[i].src);
        const srcL = src.toLowerCase();
        let img = new Image();
        let n = i;
        img.onload = function(){
            completed ++;
            test(n,true);
        }
        img.onerror = function(){
            completed ++;
            test(n,false);
        }
        img.src = src;
        i++;
    }
    const test = (n, success)=>{
        if(sources[n].statusNumber != 0) return false;
        sources[n].loaded = success;
        if(success){
            loaded++;
            sources[n].status = 'loaded';
            sources[n].statusNumber = 1;
        }else{
            errors++;
            sources[n].status = 'error';
            sources[n].statusNumber = -1;
        }
        percent = 100/total*completed;
        if(!params) return false;
        let evt = params.onprogress || params.onProgress;
        if(evt && typeof evt === 'function'){
            evt(this.getData());
        }
        if(!success){
            let evt = params.onerror || params.onError;
            if(evt && typeof evt === 'function'){
                evt(this.getData());
            }
        }
        if(total > 0 && total == completed){
            let evt = params.oncomplete || params.onComplete;
            if(evt && typeof evt === 'function'){
                evt(this.getData());
            }
        }else if(i<total){
            loadImage();
        }
    }
    images.forEach((el,index)=>{
        const src = String(el);
        const srcL = src.toLowerCase();
        if(srcL != '' && (srcL.indexOf('.jpg') !== -1 || srcL.indexOf('.webp') !== -1 || srcL.indexOf('.png') !== -1 || srcL.indexOf('.jpeg') !== -1 || srcL.indexOf('.gif') !== -1 || srcL.indexOf('.svg') !== -1)){
            sources.push({src:src,index:index,loaded:false,status:'loading',statusNumber:0});
        }
    });
    total = sources.length;
    if(total == 0){
        console.log('ImagePreloader error: has not sources to load.');
        let evt = params.onerror || params.onError;
        if(evt && typeof evt === 'function'){
            evt(this.getData());
        }
        evt = params.oncomplete || params.onComplete;
        if(evt && typeof evt === 'function'){
            evt(this.getData());
        }
    }else{
        loadImage();
    }
    return this;
}
//---------------------------//
//--- SERIAL IMAGE LOADER ---//
//---------------------------//
function SerialImageLoader(_images, _params){
    const params = _params ? _params : {};
    let images;
    if(typeof _images === "string"){
        images = document.querySelectorAll(_images);
    }else if( _images instanceof NodeList || _images instanceof HTMLCollection){
        images = _images;
    }else if(!!_images){
        images = [_images];
    }else{
        images = [];
    }
    if(!images.length) return false;
    let n = 0;
    let timeout;
    let data = {
        total: images.length,
        loaded: 0,
        error: 0
    };
    const loadNextImage = () => {
        clearTimeout(timeout);
        n++;
        if(n < images.length){
            loadImg();
        }else{
            let evt = params.oncomplete || params.onComplete;
            if(evt && typeof evt === 'function'){
                const allImages = [];
                const allSrc = [];
                images.forEach(el => {
                    allImages.push(el);
                    allSrc.push(el.dataset.src);
                });
                data = {
                    target: allImages,
                    src: allSrc,
                    total: images.length,
                    loaded: 0,
                    error: 0
                };
                evt(data);
            }
        }
    }
    const loadImg = () => {
        clearTimeout(timeout);
        if(!images[n].dataset.src && images[n].dataset.url){
            images[n].dataset.src = images[n].dataset.url;
        }
        if(images[n].dataset.src){
            timeout = setTimeout(() => {
                data.error ++;
                let evt = params.onloaderror || params.onloadError || params.onLoadError;
                if(evt && typeof evt === 'function'){
                    evt({
                        target: images[n],
                        src: images[n].dataset.src,
                        total: images.length,
                        loaded: data.loaded,
                        error: data.error
                    });
                }
                loadNextImage();
            },1000);
            const img = new Image();
            img.onload = function(){
                data.loaded ++;
                let evt = params.onloadimage || params.onloadImage || params.onLoadImage;
                if(evt && typeof evt === 'function'){
                    evt({
                        target: images[n],
                        src: images[n].dataset.src,
                        total: images.length,
                        loaded: data.loaded,
                        error: data.error
                    });
                }
                loadNextImage();
            }
            img.src = images[n].dataset.src;
        }else{
            loadNextImage();
        }
    }
    loadImg();
}

//-------------------------//
//--- RECURRING TAB KEY ---//
//-------------------------//
const recurringTabKey = {
    obj: [],
    initialized: false,
    docKeyDown: null,
    docKeyUp: null,
    addGroup: function(name, $_firstSelector, $_lastSelector){
        let exist = -1;
        let $firstSelector, $lastSelector, $tmpSelector, list;
        if($_firstSelector instanceof Array){
            list = $_firstSelector;
        }else{
            $firstSelector = typeof $_firstSelector === "string" ? document.querySelector($_firstSelector) : $_firstSelector;
            $lastSelector = typeof $_lastSelector === "string" ? document.querySelector($_lastSelector) : $_lastSelector;
        }
        if(!name || (!$firstSelector && !list)){
            return false;
        }
        if(!$lastSelector && !list){
            //https://zellwk.com/blog/keyboard-focusable-elements/
            $tmpSelector = $firstSelector.querySelectorAll('a[href]:not([tabindex="-1"]), button:not([tabindex="-1"]), input:not([tabindex="-1"]), textarea:not([tabindex="-1"]), select:not([tabindex="-1"]), details:not([tabindex="-1"]), [tabindex]:not([tabindex="-1"])');
            $firstSelector = $tmpSelector[0];
            $lastSelector = $tmpSelector[$tmpSelector.length-1];
        }
        if(!recurringTabKey.initialized){
            recurringTabKey.init();
        }
        for(let i=0; i < recurringTabKey.obj.length; i++){
            if(name == recurringTabKey.obj[i]['name']){
                exist = i;
                break;
            }
        }
        if(exist > -1 && list){
            recurringTabKey.obj[exist].list = list;
        }else if(exist > -1){
            recurringTabKey.obj[exist].firstSelector = $firstSelector;
            recurringTabKey.obj[exist].lastSelector = $lastSelector;
            recurringTabKey.obj[exist].list = null;
        }else if(list){
            recurringTabKey.obj.push({name:name, list:list});
        }else{
            recurringTabKey.obj.push({name:name,firstSelector:$firstSelector, lastSelector:$lastSelector, list: null});
        }
    },
    removeGroup: function(name){
        for(let i=0; i < recurringTabKey.obj.length; i++){
            if(name == recurringTabKey.obj[i]['name']){
                recurringTabKey.obj.splice(i, 1); 
                i--; 
            }
        }
        if(recurringTabKey.obj.length == 0 && recurringTabKey.docKeyDown){
            recurringTabKey.clearEvents();
        }
    },
    removeAllGroups: function(name){
        recurringTabKey.obj = new Array();
    },
    clearEvents: function(){
        if(recurringTabKey.obj.length){
            document.addEventListener('keydown', recurringTabKey.docKeyDown, true);
            document.addEventListener('keyup', recurringTabKey.docKeyUp, true);
            recurringTabKey.initialized = false;
            recurringTabKey.docKeyDown = null;
            recurringTabKey.docKeyUp = null;
        }
    },
    init: function(){
        recurringTabKey.keyPressed = {};
        recurringTabKey.initialized = true;
        document.addEventListener('keydown', recurringTabKey.docKeyDown = (e) => {
            recurringTabKey.keyPressed[e.key.toLowerCase()] = true;
            let focused = document.activeElement;
            for(let i=0; i < recurringTabKey.obj.length; i++){
                let list = recurringTabKey.obj[i].list;
                if(list){
                    for(let j=0; j<list.length; j++){
                        if(recurringTabKey.keyPressed.tab && !recurringTabKey.keyPressed.shift && list[j] === focused){
                            e.preventDefault();
                            let n = j+1;
                            if(n >= list.length){
                                n = 0;
                            }
                            list[n].focus();
                            break;
                        }else if(recurringTabKey.keyPressed.tab && recurringTabKey.keyPressed.shift && list[j] === focused){
                            e.preventDefault();
                            let n = j-1;
                            if(n < 0){
                                n = list.length-1;
                            }
                            list[n].focus();
                            break;
                        }
                    }
                }else if(recurringTabKey.keyPressed.tab && !recurringTabKey.keyPressed.shift && recurringTabKey.obj[i].lastSelector === document.activeElement){
                    recurringTabKey.obj[i].firstSelector.focus();
                    e.preventDefault();
                }else if(recurringTabKey.keyPressed.tab && recurringTabKey.keyPressed.shift && recurringTabKey.obj[i].firstSelector === document.activeElement){
                    recurringTabKey.obj[i].lastSelector.focus();
                    e.preventDefault();
                }
            }
        },true);
        document.addEventListener('keyup', recurringTabKey.docKeyUp = (e) => {
            recurringTabKey.keyPressed[e.key.toLowerCase()] = false;
        },true);
    }
}
//--------------//
//--- HELPER ---//
//--------------//
var helper = {
    empty: true,
    status: 0,
    clear: function(){
        if(this.holder){
            this.empty = true;
            this.holder.innerHTML = '';
        }
    },
	log: function(text, clear){
        if(!this.target){
            let pos = Number(localStorage.getItem('helper123pos'));
            let keyPressed = {};
            let changepos = () => {
                this.status = 1;
                if(pos == 2){
                    this.target.style.top = '0';
                    this.target.style.bottom = 'auto';
                    this.target.style.left = 'auto';
                    this.target.style.right = '0';
                }else if(pos == 3){
                    this.target.style.top = 'auto';
                    this.target.style.bottom = '0';
                    this.target.style.left = 'auto';
                    this.target.style.right = '0';
                }else if(pos == 4){
                    this.target.style.top = 'auto';
                    this.target.style.bottom = '0';
                    this.target.style.left = '0';
                    this.target.style.right = 'auto';
                }else if(pos == 1){
                    this.target.style.top = '0';
                    this.target.style.bottom = 'auto';
                    this.target.style.left = '0';
                    this.target.style.right = 'auto';
                }
            }
            if(isNaN(pos) || pos == 0){
                pos = 1;
                localStorage.setItem('helper123pos', 1);
                
            }
            document.body.insertAdjacentHTML('beforeend','<div id="helper-123" style="box-shadow:0 0 30px rgba(0,0,0,0.5);z-index:1000000;border-radius:3px;display:none;position:fixed;top:0px;padding: 20px 0;background:#0059ff;color:white;border: solid 1px white"><div id="helper-123-close-btn" style="line-height:0;padding:6px 3px;color:white;cursor:pointer;user-select:none;position:absolute;top:2px;right:2px;font-family:sans-serif;font-size:12px">x</div><div id="helper-123-holder" style="min-width:200px;max-width:500px;width:100%;overflow:auto;max-height:250px;padding: 0 30px"></div></div>');
            this.target = document.querySelector('#helper-123');
            this.holder = document.querySelector('#helper-123-holder');
            document.querySelector('#helper-123-close-btn').addEventListener('click', (e) => {
                e.stopImmediatePropagation();
                this.hide();
            });
            this.holder.addEventListener('scroll',function(e){
                e.preventDefault();
            });
            document.addEventListener('keydown',(e) => {
                keyPressed[e.key.toLowerCase()] = true;
            });  
            document.addEventListener('keyup',(e) => {
                if(keyPressed.shift && keyPressed.p && helper.status){
                    pos ++;
                    if(pos > 4){
                        pos = 1;
                    }
                    localStorage.setItem('helper123pos', pos);
                    changepos();
                }
                if(keyPressed.shift && keyPressed.c && helper.status){
                    helper.clear();
                }
                if(keyPressed.shift && keyPressed.h && helper.status){
                    helper.hide();
                }
                if(keyPressed.shift && keyPressed.s){
                    helper.show();
                }
                keyPressed[e.key.toLowerCase()] = false;
            });
            changepos();        
        }
        this.status = 1;
		this.target.style.display = 'block';
        if(this.empty || clear){
            this.holder.innerHTML = text;
        }else{
            this.holder.innerHTML += '<br>'+text;
            this.holder.scrollTop = 9999;
        }
        this.empty = false;
	},
	show: function(){
		if(!!this.target){
            this.target.style.display = 'block';
            this.status = 1;
        }
	},
    hide: function(){
		if(!!this.target){
            this.target.style.display = 'none';
            this.status = 0;
        }
	}
}
//--------------//
//--- SYSTEM ---//
//--------------//
const system = {
    prefersReducedMotion: window.matchMedia(`(prefers-reduced-motion: reduce)`) === true || window.matchMedia(`(prefers-reduced-motion: reduce)`).matches === true,
	touchDevice: navigator.userAgent.match(/(iPhone|iPod|iPad|Android)/) && 'ontouchstart' in window,
	ios: (()=>{
		let version = -1;
		if (/(iPhone|iPod|iPad)/i.test(navigator.userAgent)){
			version = Number(String(navigator.userAgent.split("OS ")[1]).split("_")[0]);
		}
		return version;
	})(),
    isAppleDevice: (()=>{
        /* macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'],
        windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'],
        iosPlatforms = ['iPhone', 'iPad', 'iPod'], */
        let list = ['Mac OS', 'Macintosh', 'MacIntel', 'iPhone', 'iPad', 'iPod'];
        let result = false;
        list.filter((value)=>{
            if(window.navigator.userAgent.indexOf(value) !== -1){
                result = true;
            }
        });
        return result;
    })(),
	iphone: navigator.userAgent.match(/(iPhone|iPod)/),
	ipad: navigator.userAgent.match(/(iPad)/),
	isOpera: navigator.userAgent.indexOf("Opera"),
	ieOld: navigator.userAgent.indexOf('MSIE') !== -1,
	isIE: navigator.userAgent.indexOf('Trident/') !== -1,
    webkit: navigator.userAgent.toLocaleLowerCase().indexOf('webkit') !== -1,
    safari: navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0,
	isPhone: (Math.min(screen.width,screen.height) < 768 || navigator.userAgent.match(/(iPhone|iPod)/)) && ('ontouchstart' in window || window.ontouchstart),
	android: navigator.userAgent.toLocaleLowerCase().indexOf('android') !== -1,
    isES6: (function(){
        try{
            Function("() => {};"); return true;
        }
        catch(exception){
            return false;
        }
    })(),
}
export {utils,swipeDetect,Animation,browserZoom,ImagePreloader,SerialImageLoader,recurringTabKey,helper,system, CookieManager, JSONCookie};

//---------------------//
//--- DOCUMENTATION ---//
//---------------------//

/*

//--- SET STYLES (PROTOTYPE) ---//

element.setStyles({properties})

element.setStyles({
    width: 200,
    opacity: 0.5,
    marginTop: 30,
    backgroundColor: 'red'
});

//--- UTILS ---//

target: String (querySelectorAll), NodeList (querySelectorAll, getElementsByName), HTMLCollection (getElementsByTagName, getElementsByClassName), Element (querySelector, getElementById)
classes: String, Array
properties: Object
excludedProperties: String ('margin', 'padding', 'border') or Array ['padding-top','padding-right','padding-bottom','padding-left','margin-top','margin-right','margin-bottom','margin-left','border-top','border-right','border-bottom','border-left']
//
utils.setStyles(target, {properties})
utils.remove(target)
utils.addClass(target, classes);
utils.linkify(str, settings); -> settings = {mailto: true, url: true, target: ''} -> return HTML String
utils.parsePseudoTags(str); -> return HTML String HTML // available tags ['a','div','span','b','i','strong','em','br','u','hr','sup','sub'], 
utils.validateEmail(str); -> return HTML String 
utils.getTransitionPropeties(element, forceTimeAsMillisecondsNumber); -> return {transitionDelay, transitionDuration, transitionProperty, transitionTimingFunction}
utils.hitTest(target1, target2); return true or false
utils.position(target, offset|Boolean); return {top,left}
utils.scrollTo(target, x-coord, y-coord); or utils.scrollTo(target, {
    top: Num, // Y axis px
    left: Num, // X axis px
    behavior: String,// 'smooth' or 'instant' or 'auto'
    complete: function(){} // callback on complete
});
utils.getDocumentSize(); return {width,height}
utils.outerWidth(target, excludedProperties); return width or [width,width...] 
utils.outerHeight(target, excludedProperties); return height or [height,height...] 
utils.size(target); -> return {
    width, //Get the current computed width for the first element in the set of matched elements or set the width of every matched element.
    height, //Get the current computed height for the first element in the set of matched elements or set the height of every matched element.
    innerWidth, //Get the current computed inner width (including padding but not border) for the first element in the set of matched elements or set the inner width of every matched element.
    innerHeight, //Get the current computed inner height (including padding but not border) for the first element in the set of matched elements or set the inner height of every matched element.
    outerWidth, //Get the current computed outer width (including padding, border, and margin) for the first element in the set of matched elements or set the outer width of every matched element.
    outerHeight, //Get the current computed outer height (including padding, border, and margin) for the first element in the set of matched elements or set the outer height of every matched element.
    paddingTop,
    paddingBottom,
    paddingLeft,
    paddingRight,
    marginTop,
    marginBottom,
    marginLeft,
    marginRight,
    borderLeft,
    borderRight,
    borderTop,
    borderBottom
} or [{width, height...},{width, height...}...]
utils.extend({obj1},{obj2},{objN}...);
utils.deepExtend({obj1},{obj2},{objN}...);
utils.copyTextToClipboard(String);

//--- SWIPE DETECT ---//

swipeDetect(element|selector, {
    threshold: 75, //required min distance traveled to be considered swipe (default 75[px])
    restraint: 75, //maximum distance allowed at the same time in perpendicular direction (default 75[px])
    allowedTime: 300, //maximum time allowed to travel that distance (default 300[ms])
    preventScrolling: false, //prevent scrolling -> can also be controlled individually from 'touchstart', 'touchmove' or 'touchend' events
    stopPropagation: false, //prevent propagation of touch events -> can also be controlled individually from 'touchstart', 'touchmove' or 'touchend' events
    //
    //--- simple swipe event ---//
    handleswipe = function(swipedir){}, // simple usage with only one event -> returns only swipe direction
    //
    //--- to delegate events or more complex and specific usage use this events and not 'handleswipe' ---//
    touchstart = function(e,params){}, //handle the 'touchstart' event specifically -> returns element object and all params 
    touchmove = function(e,params){}, //handle the 'touchmove' event specifically -> returns element object and all params
    touchend = function(e,params){}, //handle the 'touchend' event specifically -> returns element object and all params
});
//--- usage #1 (quick usage with 'handleswipe' event only)
swipeDetect('#selector', {
    preventScrolling: false,
    stopPropagation: true,
    handleswipe: (swipedir)=>{
        console.log(swipedir);
    }
});
//
//--- usage #2 (full usage with all touch events)
//
// example with event delegation 
swipeDetect(document, {
    //preventScrolling: true,
    //stopPropagation: true,
    allowedTime: 2000,
    touchstart: (e,params)=>{
        //some here
    },
    touchmove: (e,params)=>{
        //some here
        e.preventDefault();//prevent scrolling from touchmove specific event
    },
    touchend: (e,params)=>{
        if(e.target.matches('#selector') && params.swipedir != 'none'){
            console.log(params.swipedir);
        }
    },
});


//--- COOKIES ---//

// 1. Create a simple cookie
CookieManager.set('user', 'John');
// 2. Create a cookie with options
CookieManager.set('session', 'abc123', {
    expires: 7, // Expires in 7 days
    path: '/',
    secure: true,
    sameSite: 'strict'
});
// 3. Get a cookie
const user = CookieManager.get('user');
console.log(user); // 'John'
// 4. Check if a cookie exists
if (CookieManager.exists('session')) {
    console.log('Session is active');
}
// 5. Get all cookies
const allCookies = CookieManager.getAll();
console.log(allCookies);
// 6. Remove a cookie
CookieManager.remove('user');
// 7. Clear all cookies
// CookieManager.clear();

//--- JSONCOOKIE ---//

JSONCookie.set('configuracion', {
    tema: 'oscuro',
    idioma: 'es',
    notificaciones: true
});
const config = JSONCookie.get('configuracion');
console.log(config); // { tema: 'oscuro', idioma: 'es', notificaciones: true }

//--- ANIMATION ---//

let animationExample = new Animation(HtmlElements || String,{
    keyframes: [
        { opacity: 0, transform: 'rotate(0deg)' },
        { opacity: 1, transform: 'rotate(90deg)' }
    ],
    options: {
        duration: 1000,
        iterations: 1,
        easing: "ease-out",
        delay: 0
    },
    onStart: (e) => {
        console.log('start');
    },
    onProgress: (e) => {
        let computedStyle = window.getComputedStyle(e.target);
        console.log(computedStyle.getPropertyValue('opacity'));
    },
    onFinish: (e) => {
        if(animation2.currentTime() == animation2.getData().params.options.duration){
            e.target.classList.add('fade-in');
        }
        console.log(animation.getData());
    }
});
animationExample.play();
animationExample.pause();
animationExample.togglePlay();
animationExample.cancel();
animationExample.reverse();
animationExample.getData(); // return -> {target,params,playState,reverseMode}
animationExample.currentTime() // return current time Number

//--- BROWSER ZOOM ---//

browserZoom.init(onchange:Function,includeTouchDevices:Boolean) 
browserZoom.getLevel(); return zoom level percent
browserZoom.level; zoom level percent

//--- IMAGE PRELOADER ---//

let enqueueExample = new ImagePreloader(Array || String,{
    onProgress: (data)=>{
        
    },
    onComplete: (data)=>{
        
    }
}); 
enqueueExample.getData();// return data object
// data -> {
    total: Number,
    loaded: Number,
    errors: Number,
    completed: Number,
    percent: Number,
    src, (available only when is a single image)
    sources: {
        src: String, (image path)
        index:Number,
        loaded:Boolean,
        status:String, ('loading', 'loaded', 'error')
        statusNumber:Number (0 || 1 || -1)
    },
}

const serialLoaderExample = new SerialImageLoader('.image__img',{
    onLoadImage: (e) => {
        //console.log(e);
        //e.target = element
        //e.src = img src (String)
        //e.total: total images,
        //e.loaded = total load successful
        //e.error = total loads error
    },
    onLoadError: (e) => {
        //console.log(e);
        //e.target = element
        //e.src = img src (String)
        //e.total: total images,
        //e.loaded = total load successful
        //e.error = total loads error
    },
    onComplete: (e) => {
        //console.log(e);
        //e.target = all elements (Array)
        //e.src = all img src (Array)
        //e.total: total images,
        //e.loaded = total load successful
        //e.error = total loads error
    }
});

//--- RECURRING TAB KEY ---//

first_element: Elements Array or Element or String (querySelector)
last_element: Element or String (querySelector)//is ignored when first element is Array
recurringTabKey.addGroup('group_name', first_element, last_element);
recurringTabKey.addGroup('group_name', first_element);// if last is undefined find focusable childs from first_element
recurringTabKey.removeGroup('group_name');
recurringTabKey.removeAllGroups();
recurringTabKey.clearEvents();//remove key events

//--- HELPER ---//

helper.log(content, clear[true/false]); Shift + p to change position
helper.log('hola mundo');
helper.log('hola mundo', true);
helper.clear();//Shift + c 
helper.hide();//Shift + h
helper.show();//Shift + s

//--- SYSTEM ---//

return:
system.touchDevice
system.ios
system.iphone
system.ipad
system.isAppleDevice
system.isOpera
system.ieOld
system.isIE
system.webkit
system.safari
system.isPhone
system.android
system.isES6

*/