jQuery(document).ready(function ($)  {
	var $btn = $('#a2c');
	$btn.click(function () {
		$target = $(event.target);
		if ($target.is('.btn_sum_concurs')) {
			var $id_concurs = $target.attr( "data-concurs-id" )
			, $data = {
				action: 'a2c_summarizing',
				id_concurs: $id_concurs
			};
			jQuery.ajax({
				url: '//best-press.ru/wp-admin/admin-ajax.php'
				, type: 'POST'
				, data: $data
				, beforeSend: function () {
					$target.text('Идет подведение итогов...');
				}
				, success: function(x) {
					$target.text('Определить победителей');	
					console.log(x);				
				}
			})
			.done(function() { alert("Подведение итогов завершено успешно"); })
			.fail(function() { alert("Что-то пошло не так. обратитесь в техническую поддержку"); })
			;
		};
	});
});