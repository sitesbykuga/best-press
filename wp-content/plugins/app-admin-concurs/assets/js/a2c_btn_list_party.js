jQuery(document).ready(function ($)  {
	var $btn = $('#a2c');
	$btn.click(function () {
		$target = $(event.target);

		if ($target.is('.btn_list_party')) {
			var $popupContent = $btn.find('div.popup-content-list')
			, $id_concurs = $popupContent.attr( "data-concurs-id" )
			, $listInput = $btn.find('.list-input')
			, $listInputChecked = []
			;
			var i = j = k = 0;
			$.each($listInput, function(key, value) {
				if ((($(value).attr('name') == 'app_second_name_party') && $(value).prop("checked")) || 
					(($(value).attr('name') == 'app_name_party') && $(value).prop("checked")) || 
					(($(value).attr('name') == 'app_otch_party') && $(value).prop("checked"))
					) { i++;};
				if ((($(value).attr('name') == 'app_second_name_pr') && $(value).prop("checked")) || 
					(($(value).attr('name') == 'app_name_pr') && $(value).prop("checked")) || 
					(($(value).attr('name') == 'app_otchestvo_pr') && $(value).prop("checked"))
					) { j++;};
				if ((($(value).attr('name') == 'app_second_name_dir') && $(value).prop("checked")) || 
					(($(value).attr('name') == 'app_name_dir') && $(value).prop("checked")) || 
					(($(value).attr('name') == 'app_otchestvo_dir') && $(value).prop("checked"))
					) { k++;};
			});
			$.each($listInput, function(key, value) {
				if (i>1 && ($(value).attr('name') == 'app_fio_party')) {
					$(value).prop("checked", true );
				};
				if (j>1 && ($(value).attr('name') == 'app_fio_pred')) {
					$(value).prop("checked", true );
				};
				if (k>1 && ($(value).attr('name') == 'app_fio_dir')) {
					$(value).prop("checked", true );
				};
			});

			$.each($listInput, function(key, value) {
				if ($(value).prop("checked")) {
					$listInputChecked.push($(value).attr('name'));
				}				
			});

			var $data = {
				action: 'a2c_listparty',
				id_concurs: $id_concurs,
				attr: $listInputChecked
			};

			jQuery.ajax({
				url: '//best-press.ru/wp-admin/admin-ajax.php'
				, type: 'POST'
				, data: $data
				, beforeSend: function () {
					$target.text('Список формируется...');
				}
				, success: function(x) {					
					alert("Составление списка завершено успешно");
					var a         = document.createElement('a');
					var s = saveTotal(x);
					a.href        = "data:attachment/csv;utf-8," +  encodeURI(s);
					a.target      = '_blank';
					a.download    = 'Список участников.csv';
					$popupContent.append(a);
					a.click();
				}
			})
			.fail(function() { alert("Что-то пошло не так. Обратитесь в техническую поддержку"); })
			;
		};
	});
});

  function saveTotal(array){
    var csvRows = array.split('*+*');
    for (let i = 0; i < csvRows.length; i++) {
    	var row = csvRows[i].split('**++**');
    	csvRows[i] = row.join(';'); 
    	csvRows[i] += '\r\n';
    } 
    csvRows = csvRows.join('');
	//csvRows = csvRows.replace(/&quot;/g, '"');
    return csvRows;

  }