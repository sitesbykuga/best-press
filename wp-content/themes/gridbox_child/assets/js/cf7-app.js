/*Скрипт для динамического изменения полей в форме подачи заявки*/
function cf7_app(){
	var form = document.getElementsByName('_wpcf7')[0]
		, concurs = document.getElementsByName('cf7-concurs')[0]
		, nomination = document.getElementsByName('cf7-nomination')[0]
		, theme = document.getElementsByName('cf7-theme')[0]
		, concursOption = concurs.getElementsByTagName('option')
		, nominationOption = nomination.getElementsByTagName('option')
		, themeOption = theme.getElementsByTagName('option')
		, themeOptgroup = theme.getElementsByTagName('optgroup')
		, concursOptions = dataConcurs
		, selectedConcurs = dataConcurs['concurs'][0]['concurs']
		, selectedNomination = dataConcurs['nomination'][0]['theme']
		;

	console.log(dataConcurs);

	for (let i = concursOption.length-1; i > -1 ; i-- ) {
		concurs.removeChild(concursOption[i]);		
	};

	function clearOption(nomin = false){
		if (!nomin) {
			for (let i = nominationOption.length-1; i > -1 ; i-- ) {
				nomination.removeChild(nominationOption[i]);		
			};
		}

		for (let i = themeOptgroup.length-1; i > -1 ; i-- ) {
			theme.removeChild(themeOptgroup[i]);		
		};

		for (let i = themeOption.length-1; i > -1 ; i-- ) {
			theme.removeChild(themeOption[i]);		
		};
	};

	clearOption();

	for (let i = 0; i < concursOptions['concurs'].length; i++ ) {
		option = new Option(concursOptions['concurs'][i]['concurs'], concursOptions['concurs'][i]['concurs']);
		concurs.appendChild(option);
	};

	function setNomination(){
		for (let i = 0; i < concursOptions['nomination'].length; i++ ) {
			if (concursOptions['nomination'][i]['concurs'] == selectedConcurs){
				option = new Option(concursOptions['nomination'][i]['theme'], concursOptions['nomination'][i]['theme']);
				nomination.appendChild(option);
			}
		};
	};

	function splitDate(str){
		let dateSplit = str.split('.');
		for (let i = 0; i < dateSplit.length; i++){
			if (dateSplit[i][0] == '0'){
				let a = dateSplit[i];
				dateSplit[i] = a.slice(1);				
			}
			dateSplit[i] = +dateSplit[i];
		} 

		return dateSplit;
	}

	function setTheme(){
		let group = concursOptions['group']
			, groupDate = []
			, now = new Date()
			, now2 = new Date()
			, nowM = now2
			, nowP = now
			, p = now.getMonth()
			;
		;

		nowP.setMonth(p + 1);
		nowM.setMonth(p - 1);
		for (let i = 0; i < group.length; i++){
			if (typeof(group[i]['nomination']) != 'undefined' && group[i]['concurs'] == selectedConcurs) {
				let dB = splitDate(group[i]['name'])
				, dE = splitDate(group[i]['name_party'])
				, dBegin = new Date(dB[2], dB[1]-1, dB[0])
				, dEnd = new Date(dE[2], dE[1]-1, dE[0])
				;
				if ((nowP > dBegin && nowP < dEnd) || (nowM > dBegin && nowM < dEnd)) {
					groupDate.push(group[i]);
				}
			}

		}

		for (let j = 0; j < groupDate.length; j++ ) {
			if (concursOptions['group'][j]['concurs'] == selectedConcurs){
				let str = groupDate[j]['nomination']+' (' + groupDate[j]['name'] + ' - ' + groupDate[j]['name_party'] + ')';
				var opt = document.createElement('optgroup');
				opt.label = str;
				theme.appendChild(opt);
			}
			for (let i = 0; i < concursOptions['theme'].length; i++ ) {
				if (concursOptions['theme'][i]['concurs'] == selectedConcurs){
					let option = new Option(concursOptions['theme'][i]['theme'],concursOptions['theme'][i]['theme']);
					if ((concursOptions['theme'][i]['nomination'] == groupDate[j]['nomination']) 
						&& (concursOptions['theme'][i]['name'] == groupDate[j]['name']) 
						&& (concursOptions['theme'][i]['name_party'] == groupDate[j]['name_party'])){
						opt.appendChild(option);
					}
				}
			}
		};
		if (groupDate.length == 0){			
			for (let i = 0; i < concursOptions['theme'].length; i++ ) {
				if (concursOptions['theme'][i]['concurs'] == selectedConcurs){


					if (concursOptions['theme'][i]['nomination'] == ''){					
						let option = new Option(concursOptions['theme'][i]['theme'],concursOptions['theme'][i]['theme']);
						theme.appendChild(option);
					}
					if (concursOptions['theme'][i]['nomination'] == selectedNomination){
						let option = new Option(concursOptions['theme'][i]['theme'],concursOptions['theme'][i]['theme']);
						theme.appendChild(option);
					}
				}				
			}
		}
	};
	
	setNomination();
	setTheme();

	concurs.addEventListener('change', function(){
		for (let i = 0; i < this.options.length; i ++) {
			if (this.options[i].selected){	
				selectedConcurs = this.options[i].value;
				break;
			}
		}
		for (let i = 0; i < dataConcurs['nomination'].length; i ++) {
			if (dataConcurs['nomination'][i]['concurs'] == selectedConcurs){	
				selectedNomination = dataConcurs['nomination'][i]['theme'];
				break;
			}
		}
		console.log(selectedNomination);
		clearOption();
		setNomination();
		setTheme();		
	});

	nomination.addEventListener('change', function(){
		for (let i = 0; i < this.options.length; i ++) {
			if (this.options[i].selected){	
				selectedNomination = this.options[i].value;
				break;
			}
		}
		clearOption(true);		
		setTheme();		
	});


};
cf7_app();