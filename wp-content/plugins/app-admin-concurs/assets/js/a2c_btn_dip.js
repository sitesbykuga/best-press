jQuery(document).ready(function ($)  {
	var $btn = $('#a2c');
	$btn.click(function () {
		$target = $(event.target);

		if ($target.is('.btn_dip')) {

			var $popupContent = $btn.find('div.popup-content-dip')
			, $app_id = $('#app-id').val()
			, $app_status = $('#app-status').val()
			;

			var $data = {
				action: 'a2c_dip',
				app_id: $app_id,
				app_status: $app_status
			};

			jQuery.ajax({
				url: '//best-press.ru/wp-admin/admin-ajax.php'
				, type: 'POST'
				, data: $data
				, beforeSend: function () {
					$target.text('Сертификат формируется...');
					$popupContent.find('#last-div').remove();
				}
				, success: function(x) {					
					$popupContent.append(x);
					console.log(x);
					$target.text('Сформировать сертификат');
				}
			})
			.fail(function() { alert("Что-то пошло не так. Обратитесь в техническую поддержку"); })
			;
		};
	});
});