import {browserZoom,helper,system, utils} from './utils.js?v=032';
const startFooter = (block)=>{
    block.classList.add('loaded');
}
const startModule = (param)=>{
    startFooter();
}
export {startModule};