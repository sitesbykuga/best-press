<?php
/**
 * The template for displaying single posts
 *
 * @package Gridbox
 */

/*get_header(concurs); */
?>

<div class="main-concurs">
	<div class="bg-img">
		<img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/main-bg.jpg';?>" alt="">
	</div>   
	<div class="container">
		<div class="row justify-content-center">
			<div class="col">          
				<div class="tabs">
					<div style='text-align: right'>
						<div data-mobile-view="true" data-share-size="30" data-like-text-enable="false" data-background-alpha="0.0" data-pid="1776839" data-mode="share" data-background-color="#ffffff" data-share-shape="round" data-share-counter-size="12" data-icon-color="#ffffff" data-mobile-sn-ids="fb.vk.tw.wh.ok.vb." data-text-color="#000000" data-buttons-color="#1a1635" data-counter-background-color="#ffffff" data-share-counter-type="common" data-orientation="horizontal" data-following-enable="false" data-sn-ids="fb.vk.tw.mr.em.ok.gp." data-preview-mobile="false" data-selection-enable="false" data-exclude-show-more="false" data-share-style="0" data-counter-background-alpha="1.0" data-top-button="false" class="uptolike-buttons" >                
						</div>
					</div>

					<?php the_title( '<div class="main-title">', '</div>' ); ?>
					<?php	

					$field = get_field_object('tabs');
					$tabs = $field['value'];

					$str_razrab = 'Извините, данный раздел находится в разработке';
					
					if( $tabs ): ?>
						<ul class="tabs__caption">
							<?php foreach( $tabs as $tab ) :
								if ($tabs[0] == $tab): ?> <li class="active-style tabs-menu"><?php echo $field['choices'][ $tab ]; ?></li>
								<?php else: ?> <li class=tabs-menu><?php echo $field['choices'][ $tab ]; ?></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
					<?php foreach( $tabs as $tab ) :
						if ($tabs[0] == $tab): ?> 
							<div class="tabs__content active">
						<?php else: ?>	<div class="tabs__content">
						<?php endif;

						if ($tab == 'about_con'): ?><!--Раздел: О конкурсе -->
						
							<div class="tabs-overflow">
								<h2><?php the_field('about_subtitle'); ?></h2>

								<?php if( have_rows('about_text') ):
									while ( have_rows('about_text') ) : the_row(); ?>
										<p><?php the_sub_field('about_paragraph'); ?></p>
									<?php endwhile;
									else : ?> <p><?php echo $str_razrab; ?></p>
								<?php endif; ?>
							</div>	
						
						<?php elseif ($tab == 'order_con'): ?><!-- Раздел: Положение -->					
							<div class="tabs-overflow position">
								<h2><?php the_field('order_subtitle'); ?></h2>

								<?php if( have_rows('order_section') ):
									while ( have_rows('order_section') ) : the_row();?> 

										<h3 class=position-header><span class=position-span><?php the_sub_field('order_section_n') ;?>. <?php the_sub_field('order_section_title'); ?></span></h3>

										
											<!-- Раздел положения: Возраст участников-->
											<?php if (get_sub_field('order_section_n') == get_field('order_age_n')) : ?>
											<div class="position-block">
											<?php if( have_rows('order_age_text_before') ):
												while ( have_rows('order_age_text_before') ) : the_row(); ?>
													<p><?php the_sub_field('age_p_before'); ?></p>
												<?php endwhile;
											endif; ?>
											<ul>
												<?php if( have_rows('order_age') ):
													while ( have_rows('order_age') ) : the_row(); 
														$max_age = get_sub_field('order_max_age');														
														if ( ctype_digit(get_sub_field('order_min_age')) ):
															$max_age = ' - ' . $max_age;
														endif;

														$field_age = get_sub_field_object('order_age_postfix');
														$value_age = $field_age['value'];
														$age_group = get_sub_field('order_min_age') . $max_age . ' ' . $field_age['choices'][ $value_age ]; 
														?>															
														<li><?php echo $age_group ?></li>					
													<?php endwhile;
												endif; ?>
											</ul>
											<?php if( have_rows('order_age_text_after') ):
												while ( have_rows('order_age_text_after') ) : the_row(); ?>
													<p><?php the_sub_field('age_p_after'); ?></p>
												<?php endwhile;
											endif; ?>
											</div>
											<!-- Раздел положения: Темы конкурса-->
											<?php elseif (get_sub_field('order_section_n') == get_field('order_theme_n')) : ?>
											<div class="position-block theme">
											<?php if( have_rows('order_theme_text_before') ):
												while ( have_rows('order_theme_text_before') ) : the_row(); ?>
													<p><?php the_sub_field('theme_p_before'); ?></p>
												<?php endwhile;
											endif; ?>
											<?php if( have_rows('order_theme') ):
												while ( have_rows('order_theme') ) : the_row();
													$theme_group_title = get_sub_field('theme_group_title');													
													if (! empty($theme_group_title)):?>
														<div class="theme-header">
															<p class=theme-title style="margin-top: 5px;"><?php the_sub_field('theme_group_title'); ?></p>
															<?php  if (the_sub_field('date_begin_accept')): ?>
															<p class=theme-after>прием работ с <?php the_sub_field('date_begin_accept'); ?> по с <?php the_sub_field('date_end_accept'); ?></p>
															<?php endif; ?>
														</div>
														<div class="theme-block">
															<?php if( have_rows('order_themes') ):
																while ( have_rows('order_themes') ) : the_row(); ?>
																	<p><span class=nomination-title><?php the_sub_field('theme_title'); ?></span> <?php the_sub_field('theme_description'); ?></p>
																<?php endwhile;
															endif; ?>
														</div>
													<?php else : ?>	
														<div>
															<?php if( have_rows('order_themes') ):
																while ( have_rows('order_themes') ) : the_row(); ?>
																	<p><span class=nomination-title><?php the_sub_field('theme_title'); ?></span> <?php the_sub_field('theme_description'); ?></p>
																<?php endwhile;
															endif; ?>
														</div>
													<?php endif; ?>
													
												<?php endwhile; ?>											
											<?php endif; ?>

											<?php if( have_rows('order_theme_text_after') ):
												while ( have_rows('order_theme_text_after') ) : the_row(); ?>
													<p><?php the_sub_field('theme_p_after'); ?></p>
												<?php endwhile;
											endif; ?>
											</div>
											<!-- Раздел положения: Номинации-->
											<?php elseif (get_sub_field('order_section_n') == get_field('order_nomination_n')) : ?>
											<div class="position-block">											
											<?php if( have_rows('order_nomination') ):
												while ( have_rows('order_nomination') ) : the_row(); ?>
													<p><span class=nomination-title><?php the_sub_field('nomination_name'); ?></span> - <?php the_sub_field('nomination_description'); ?></p>

													<?php if( have_rows('nominaition_name_files') ): 
														$str = '<p class=m0><span class=nomination-namefile-title>Название файла:</span>';
														while ( have_rows('nominaition_name_files') ) : the_row(); 
															$str .= ' <span class=nomination-namefile-example>';
															$str .= get_sub_field('nominaition_name_file');
															$str .= '</span> ';
														endwhile;
														$str .= '</p>';	
														echo $str;  
													endif; ?>

													<?php if( have_rows('nominaition_name_files') ): 
														$str = '<p class=m0><span class=nomination-namefile-title>Например:</span>';
														while ( have_rows('nominaition_name_files') ) : the_row(); 
															$str .= ' <span class=nomination-namefile-example>';
															$str .= get_sub_field('nominaition_examp_file');
															$str .= '</span> ';
														endwhile;
														$str .= '</p>';	
														echo $str;  
													endif; ?>

												<?php endwhile;
											endif; ?>
											</div>
											<?php elseif( have_rows('order_section_text') ):?>
											<div class="position-block">												
												<?php while ( have_rows('order_section_text') ) : the_row(); ?>
													<p><?php the_sub_field('order_section_paragraph'); ?></p>
												<?php endwhile;?>
											</div>
											<?php else : ?> <div class="position-block"><p><?php echo $str_razrab; ?></p></div>
											<?php endif; ?>
										
									<?php endwhile;
									else : ?> <p><?php echo $str_razrab; ?></p>
								<?php endif; ?>

							</div>
						
						<?php elseif ($tab == 'news_con'): ?><!-- Раздел: Новости -->
					
							<div class="tabs-overflow">
              					<h2>Новости конкурса</h2>
              					<?php if( have_rows('con_news') ):
              						while ( have_rows('con_news') ) : the_row(); ?>
              							<div style="padding-bottom:10px; border-bottom: 2px solid #aeaeae">
              							<?php $news_img = get_sub_field('news_img');
              							if (!empty($news_img)) : ?>
              								<div class="container">
              									<div class="row">
											<div class="col-md-5 col-lg-4"><img src="<?php echo $news_img; ?>" style="width:100%; border-radius: 10px;"></div>
											<div class="col-md-7 col-lg-8">
              							<?php else: ?>
              								<div class="container">
              									<div class="row">
              								<div>
              							<?php endif;?>
              							<?php 
              								$news_date = the_sub_field('news_date');
              								$str = ($news_date == "") ? "" : ":";
              							?>
              							<p style="margin-bottom:10px"><span style="color:#777777"><?php the_sub_field('news_date'); echo $str;?></span> <span class=nomination-title><?php the_sub_field('news_title'); ?></span></p>
              							<?php if( have_rows('news_text') ): 
              								while ( have_rows('news_text') ) : the_row(); ?>
              									<p style="margin-bottom:10px"><?php the_sub_field('news_paragraph'); ?></p>
              								<?php endwhile;
              							endif; ?>
              							</div>
              							</div>
              							</div>
              							</div>
            						<?php endwhile;
            					endif; ?>
            				</div>
					
						<?php elseif ($tab == 'reglam_con'): ?><!--Раздел: Правила -->
						
							<div class="tabs-overflow reglam">
								<?php if( have_rows('reglam') ):
									while ( have_rows('reglam') ) : the_row(); ?>
										<h3 class=reglam-header><span class=reglam-span><?php the_sub_field('reglam_header'); ?></span></h3>
										<div class="reglam-block">
										<?php if( have_rows('reglam_text') ):
											while ( have_rows('reglam_text') ) : the_row(); ?>
												<p><?php the_sub_field('reglam_paragraph'); ?></p>
											<?php endwhile;
										endif; ?>
										</div>
									<?php endwhile;
									else : ?> <p><?php echo $str_razrab; ?></p>
								<?php endif; ?>
							</div>
							
						<?php elseif ($tab == 'app_con'): ?><!--Раздел: Заявка -->
							<div class="tabs-overflow">
								<h2>Подать заявку</h2>
              						<div class="oreder">
              							<?php if ( is_user_logged_in() ) {
              								$shortcode_app = get_field('application_shortcode');
              								echo do_shortcode($shortcode_app);
              							} else {
              								echo 'Вы не вошли в систему <br> '. do_shortcode('[loginform]');
              							}
              							?>
									</div>
							</div>
						<?php elseif ($tab == 'jury_con'): ?><!--Раздел: Жюри -->
							<div class="tabs-overflow reglam">
								<?php if( have_rows('jury') ):
									while ( have_rows('jury') ) : the_row(); ?>
										<h3><?php the_sub_field('jury_subtitle'); ?></h3>
										<?php if( have_rows('jury_text') ):
											while ( have_rows('jury_text') ) : the_row(); ?>
												<p><?php the_sub_field('jury_paragraph'); ?></p>
											<?php endwhile;
										endif; ?>
									<?php endwhile;?>
									<h3>Председатель жюри</h3>
              						<div class="container">
              							<div class="row">
              								<div class="col-md-3 col-12">
              									<img src="<?php echo CFS()->get( 'jury_foto' );?>" alt="" class=jury-img> 
              								</div>
              								<div class="col-md-9 col-12">

              									<p><span class=nomination-title><?php echo CFS()->get( 'fio_jury' );?></span> - <?php echo CFS()->get( 'jury_description' );?></p>
              								</div>
              							</div>
              						</div>
									<?php else : ?> <p><?php echo $str_razrab; ?></p>
								<?php endif; ?>
							</div>
						<?php elseif ($tab == 'winner_con'): ?><!--Раздел: Победители -->
							<div class="tabs-overflow reglam">
								<?php if( have_rows('winner_text') ):
									while ( have_rows('winner_text') ) : the_row(); ?>
										<p><?php the_sub_field('winner_paragraph'); ?></p>
									<?php endwhile;
								else : ?> <p><?php echo $str_razrab; ?></p>
								<?php endif; ?>
							</div>
						<?php elseif ($tab == 'sponsor_con'): ?><!--Раздел: Партнеры -->
							<div class="tabs-overflow reglam">
								<h2><?php the_field('sponsor_subtitle'); ?></h2>
								<?php if( have_rows('sponsor_text') ):
									while ( have_rows('sponsor_text') ) : the_row(); ?>
										<p><?php the_sub_field('sponsor_paragraph'); ?></p>
									<?php endwhile;
								else : ?> <p><?php echo $str_razrab; ?></p>
								<?php endif; ?>
							</div>
						<?php elseif ($tab == 'contacts_con'): ?><!--Раздел: Контакты -->
							<div class="tabs-overflow reglam">
								<?php if( have_rows('contact_text') ):
									while ( have_rows('contact_text') ) : the_row(); ?>
										<p><?php the_sub_field('contact_paragraph'); ?></p>
									<?php endwhile;
								else : ?> <p><?php echo $str_razrab; ?></p>
								<?php endif; ?>
							</div>
					<?php endif; ?>
				</div>
				<?php endforeach; ?>		
			<?php endif; ?>



