function a2c_form_res(){
	var studio = listEvent
		, studioSelect = document.getElementById('event_title')
		, studioOption = studioSelect.getElementsByTagName('option')
		;

		
	for (let i = studioOption.length-1; i > -1 ; i-- ) {
		studioSelect.removeChild(studioOption[i]);		
	};

	for (let i = 0; i < studio.length; i++ ) {
		option = new Option(studio[i], studio[i]);
		studioSelect.appendChild(option);
	};
};

a2c_form_res();