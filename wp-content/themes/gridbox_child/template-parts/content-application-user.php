<?php
/**
 * Шаблон для отображения списка заявок обычному пользователю
 *
 * @package Gridbox
 */

?>
		<div class="row" style="border-bottom: 1px solid #aeaeae">
			<div class="col-sm-1 col-lg-1 app-status" style="text-align: left;">
				<?php $app_status = get_field('app_status');
				if ($app_status == 'Допущена') : ?>					
					<span style="color:#6BC641; font-size: 14px;"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
				<?php elseif ($app_status == 'Отправлена') : ?>	
					<span style="color:#F8B72F; font-size: 14px;"><i class="fa fa-paper-plane" aria-hidden="true"></i></span>
				<?php elseif ($app_status == 'Оценена' || $app_status == '1 место' || $app_status == '2 место' || $app_status == '3 место') : ?>	
					<span style="color:#274D91; font-size: 12px; border-radius: 50%; border: 1px solid #274D91; padding: 2px;"><b><?php the_field('app_point_avg'); ?></b></span>				
				<?php elseif ($app_status == 'Отклонена') : ?>	
					<span style="color:red; font-size: 14px;"><i class="fa fa-times-circle" aria-hidden="true"></i></span>	
				<?php elseif ($app_status == '') : ?>	
					<span style="color:#ffffff; font-size: 14px;"><i class="fa fa-times-circle" aria-hidden="true"></i></span>	
				<?php endif; ?>	
				<?php if ($app_status == '1 место' || $app_status == '2 место' || $app_status == '3 место') : ?>
					<span style="color:#274D91; font-size: 14px;"><i class="fa fa-trophy" aria-hidden="true"></i></span>	
				<?php endif; ?>	
				<?php $app_comment = get_field('app_comment');
				if (trim($app_comment) != '') : ?>	
					<span style="color:#583B7A; font-size: 14px;"><i class="fa fa-commenting" aria-hidden="true"></i></span>
				<?php endif; ?>
			</div>
			<div class="col-sm-3 col-lg-1 app-status"><strong class=col-md-hide>#&#8195;</strong><?php the_ID(); ?></div>
			<div class="col-sm-2 col-md-hide"></div>			
			<div class="col-sm-6 col-lg-2 app-status"><strong class=col-md-hide>Дата:&#8195;</strong><?php echo get_the_date(); ?></div>
			<div class="col-sm-6 col-lg-3"><strong class=col-md-hide>Работа:&#8195;</strong>
				<a href="#" class="button-app"><?php the_title(); ?></a></div>
			<div class="col-sm-6 col-lg-2"><strong class=col-md-hide>Конкурс:&#8195;</strong><?php the_field('app_concurs'); ?></div>
			<div class="col-sm-6 col-lg-3"><strong class=col-md-hide>Номинация:&#8195;</strong><?php the_field('app_nomination'); ?></div>
		</div>
		
		<div class="popup-app">
			<button class=popup-close>&times;</button>
			<div class=popup-content>
				<?php get_template_part( 'template-parts/content-single-application' ); ?>
			</div>
		</div>


