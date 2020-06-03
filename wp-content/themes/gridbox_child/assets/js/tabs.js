(function($) {
		$(function() {

			$('ul.tabs__caption').on('click', 'li:not(.active)', function() {
				$(this)
				.addClass('active-style').siblings().removeClass('active-style')
				.closest('div.tabs').find('div.tabs__content').removeClass('active').eq($(this).index()).addClass('active');
			});

		});
	})(jQuery);

