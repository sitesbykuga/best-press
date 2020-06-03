/*Форма оценивания работ членами жюри*/

function cf7_rating(){
	var rowCheck = document.getElementsByClassName('cf7-check-row')[0]
		, rowPoint = document.getElementsByClassName('cf7-point-row')[0]
		, concursOptions = ratingConcurs
		, selectedConcurs = document.getElementsByClassName('concurs-name')[0].getAttribute('name')
		, arrayCheck = []
		, arrayPoint = []
		, submit = document.getElementsByClassName('wpcf7-submit')[0]
		;

	console.log(concursOptions);
	console.log(selectedConcurs);

	function getArrayCheckAndPoint(){
		for (let i = 0; i < concursOptions.length; i++){
			if (concursOptions[i]['concurs'] == selectedConcurs && concursOptions[i]['nomination'] == 'rating_access') {
				arrayCheck = concursOptions[i]['theme'].split('*+*');
			}

			if (concursOptions[i]['concurs'] == selectedConcurs && concursOptions[i]['nomination'] == 'rating_point') {
				arrayPoint = concursOptions[i]['theme'].split('*+*');
			}
		}
	}

	function addCheckAndpoint(){

		rowCheck.removeChild(rowCheck.children[0]);
		rowPoint.removeChild(rowPoint.children[0]);	

		for (let i = 0; i < arrayCheck.length; i++){
			
			let cf7_check_title = document.createElement('input');
			cf7_check_title.className = "wpcf7-form-control wpcf7dtx-dynamictext wpcf7-dynamichidden";
			cf7_check_title.setAttribute('type', 'hidden');
			cf7_check_title.setAttribute('name', 'cf7-check-title-'+i);
			cf7_check_title.setAttribute('value', arrayCheck[i]);
			cf7_check_title.setAttribute('aria-invalid', 'false');

			let span_cf7_check_title = document.createElement('span');
			span_cf7_check_title.className = "wpcf7-form-control-wrap cf7-check-title";
			span_cf7_check_title.appendChild(cf7_check_title);

			let p = document.createElement('p');
			p.className = "title-row";
			p.innerHTML = arrayCheck[i];
			p.appendChild(span_cf7_check_title);

			let div_cf7_check_title = document.createElement('div');
			div_cf7_check_title.className = "col-md-9 div-cf7-check-title";
			div_cf7_check_title.appendChild(p);
			
			let input = document.createElement('input');
			input.setAttribute('type', 'checkbox');
			input.setAttribute('name', 'cf7-check-'+i);
			input.setAttribute('value', '1');
			input.setAttribute('aria-invalid', 'false');
			input.checked = true;

			let wpcf7_list_item = document.createElement('span');
			wpcf7_list_item.className = "wpcf7-list-item";
			wpcf7_list_item.appendChild(input);

			let optional = document.createElement('span');
			optional.className = "wpcf7-form-control wpcf7-acceptance optional";
			optional.appendChild(wpcf7_list_item);

			let cf7_check = document.createElement('span');
			cf7_check.className = "wpcf7-form-control-wrap cf7-check";
			cf7_check.appendChild(optional);

			let div_cf7_check = document.createElement('div');
			div_cf7_check.className = "col-md-3 value-row div-cf7-check";
			div_cf7_check.appendChild(cf7_check);


			let row = document.createElement('div');
			row.className = "row";
  			row.appendChild(div_cf7_check_title);
  			row.appendChild(div_cf7_check);

  			rowCheck.appendChild(row);
		}

		for (let i = 0; i < arrayPoint.length; i++){

			let cf7_point_title = document.createElement('input');
			cf7_point_title.className = "wpcf7-form-control wpcf7dtx-dynamictext wpcf7-dynamichidden";
			cf7_point_title.setAttribute('type', 'hidden');
			cf7_point_title.setAttribute('name', 'cf7-point-title-'+i);
			cf7_point_title.setAttribute('value', arrayPoint[i]);
			cf7_point_title.setAttribute('aria-invalid', 'false');

			let span_cf7_point_title = document.createElement('span');
			span_cf7_point_title.className = "wpcf7-form-control-wrap cf7-point-title";
			span_cf7_point_title.appendChild(cf7_point_title);

			let p = document.createElement('p');
			p.className = "title-row";
			p.innerHTML = arrayPoint[i];
			p.appendChild(span_cf7_point_title);

			let div_cf7_point_title = document.createElement('div');
			div_cf7_point_title.className = "col-md-9 div-cf7-point-title";
			div_cf7_point_title.appendChild(p);
			
			let input = document.createElement('input');
			input.className = "wpcf7-form-control wpcf7-number wpcf7-validates-as-number";
			input.setAttribute('type', 'number');
			input.setAttribute('name', 'cf7-point-'+i);
			input.setAttribute('value', '0');
			input.setAttribute('min', '0');
			input.setAttribute('aria-invalid', 'false');

			let cf7_point = document.createElement('span');
			cf7_point.className = "wpcf7-form-control-wrap cf7-point";
			cf7_point.appendChild(input);

			let div_cf7_point = document.createElement('div');
			div_cf7_point.className = "col-md-3 value-row div-cf7-point";
			div_cf7_point.appendChild(cf7_point);


			let row = document.createElement('div');
			row.className = "row";
  			row.appendChild(div_cf7_point_title);
  			row.appendChild(div_cf7_point);

  			rowPoint.appendChild(row);
		}
	}

	getArrayCheckAndPoint();
	addCheckAndpoint();

	submit.addEventListener('click', () => {
        let timeOut = setTimeout(() => {location.reload();}, 1000);
	})

};

cf7_rating();