import { system } from '../utils.js';
const startModule = (block)=> {

	setTimeout(() => {
        block.classList.add('loaded');
    } , 100);

	
	const selectContainers = document.querySelectorAll('.quiz__select');
	
	selectContainers.forEach(selectContainer => {
		const selectElement = selectContainer.querySelector('select');
		const labelElement = selectContainer.querySelector('.quiz__select-label');
		
		selectElement.addEventListener('change', () => {
			const selectedOption = selectElement.options[selectElement.selectedIndex].text;
			
			if (selectElement.value !== "0") {
				labelElement.textContent = selectedOption;
			} else {
				const defaultText = labelElement.getAttribute('data-default');
				labelElement.textContent = defaultText;
			}
		});
	});

	let submitSatatus = true;

	const submitForm = () => {
	  if(incidentSelect.selectedIndex > 0 && submitSatatus) {

		submitSatatus = false;
		
		let params = '?incident='+incidentSelect.value;
		
		let fieldset = [];
		selectContainers.forEach(selectContainer => {
			const selectElement = selectContainer.querySelector('select');
			const value = selectElement.selectedIndex > 0 ? selectElement.options[selectElement.selectedIndex].text : '—';
			fieldset.push(value);
		});
		params += '&fieldset='+fieldset.join(';');
		
		const sendingScreen = block.querySelector('.block-quiz__sending');
		sendingScreen.classList.add('block-quiz__sending--visible');

		setTimeout(() => {
			sendXhttp({
				url: baseURL+"quiz_form/"+params,
				method: 'GET',
				complete: (responseText) => {
					if(responseText){
						window.location = responseText;
					}else{
						alert('no results');
					}
					setTimeout(() => {
						block.querySelectorAll('select').forEach(el => {
							el.selectedIndex = 0;
							const event = new MouseEvent('change', { view: window, cancelable: true, bubbles: true });
							el.dispatchEvent(event);
						});
						sendingScreen.classList.remove('block-quiz__sending--visible');
						submitSatatus = true;
					},1300);
				}
			});
		},500);
		
	  }else{
		alert('Please fill in “Incident Type”');
	  }
	}
	document.querySelector('#quiz-form button[type="submit"]').addEventListener('click',e => {
	  if(system.safari){
		e.preventDefault();
		submitForm();
	  }
	  if(e.pageX){
		//save action here!
	  }
	});
	document.querySelector('#quiz-form').addEventListener('submit', e => {
	  e.preventDefault();
	  submitForm();
	});
	document.querySelectorAll('.custom-select select').forEach(el => {
	  el.addEventListener('focus', e => {
		el.parentNode.classList.add('focused');
	  });
	  el.addEventListener('blur', e => {
		el.parentNode.classList.remove('focused');
	  });
	  el.addEventListener('change', e => {
		let html = e.target.querySelector('option:checked').innerHTML;
		if(e.target.classList.contains('lowercase')){
		  html = html.toLowerCase();
		}
		e.target.parentNode.querySelector('.custom-select-label').innerHTML = html;
	  });
	  el.addEventListener('keydown', e => {
		if(e.key == "Enter"){
		  e.preventDefault();
		}
	  });
	  el.addEventListener('keyup', e => {
		if(e.key == "Enter"){
		  e.preventDefault();
		}
	  });
	});
  
	const baseURL = String(window.location).split(window.location.host)[0]+window.location.host+'/';
	const experienceSelect = document.querySelector('#experience-select');
	const incidentSelect = document.querySelector('#incident-select');
	const affectedSelect = document.querySelector('#affected-select');
	const placeSelect = document.querySelector('#place-select');
	const committedSelect = document.querySelector('#committed-select');
	
	const sendXhttp = (params) => {
	  if(xhttp){
		xhttp.abort();
	  }
	  xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		  params.complete(this.responseText);
		}
	  };
	  xhttp.open(params.method, params.url, true);
	  xhttp.send();
	}
	let xhttp;

	experienceSelect.selectedIndex = 0;
	incidentSelect.selectedIndex = 0;
	affectedSelect.selectedIndex = 0;
	placeSelect.selectedIndex = 0;
	committedSelect.selectedIndex = 0;

  //--- community-form ---//
  //----------------------//




}

export {startModule};