<?php
/**
 * Шаблон для отображения списка заявок администратору или члену жюри
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
				<!--<a href="#" class="button-app">--><?php /*the_title();*/ ?><!--</a>-->
				<?php the_title( sprintf( '<a href="%s" rel="bookmark" target="_blank">', esc_url( get_permalink() ) ), '</a>' ); ?></div>
			<div class="col-sm-6 col-lg-5"><strong class=col-md-hide>Конкурс - Номинация (Возрастная группа):&#8195;</strong>
			<?php 
				
				global $wpdb;

				$arr_age = array();

				$post_id = get_the_ID();
				$id_concurs = get_field('app_id_concurs');

				if( have_rows('order_age', $id_concurs) ):
					while ( have_rows('order_age', $id_concurs) ) : 
						the_row(); 
						$max_age = get_sub_field('order_max_age', $id_concurs);	
						$min_age = get_sub_field('order_min_age', $id_concurs);												
						if ( $min_age == 'до' ):
							$min_age = 0;
						elseif ( $min_age == 'старше' ) : 
							$min_age = $max_age;
							$max_age = 100;
						endif;

						if ( ctype_digit(get_sub_field('order_min_age')) ):
							$max_age_str = ' - ' . $max_age;
						endif;

						$field_age = get_sub_field_object('order_age_postfix');
						$value_age = $field_age['value'];
						$age_group = get_sub_field('order_min_age') . $max_age_str . ' ' . $field_age['choices'][ $value_age ];

						array_push($arr_age, array('min' => $min_age, 'max' => $max_age, 'title' => $age_group));
					endwhile;
				else :
					array_push($arr_age, array('min' => 0, 'max' => 100));
				endif;

				$age = $wpdb->get_results("select distinct meta_value from wp_postmeta where meta_key like 'app_age' and post_id = '" . $post_id . "'");
    			foreach ($arr_age as $age_gr) :
    				if (($age{0}->meta_value >= $age_gr['min']) && ($age{0}->meta_value <= $age_gr['max'])) :
    					$app_age_group = $age_gr['title'];
    					break;
    				else : $app_age_group = 'Вне возрастной группы';
    				endif;    				
    			endforeach;	
    		?>			
			<?php echo get_field('app_concurs') . " - " . get_field('app_nomination') . " (" . $app_age_group . ")"; ?></div>
			<!-- <div class="col-sm-6 col-lg-3"><strong class=col-md-hide>Номинация:&#8195;</strong><?php /*the_field('app_nomination'); */?></div> -->
		</div>



