<?php
/*
Template Name: Форма заявки 
*/
acf_form_head();
get_header(); ?>

	<section id="primary" class="content-single content-area">
		<main id="main" class="site-main" role="main">
				
		<?php while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'single' );
			if ( is_user_logged_in() ) { 
			?>
			<form id="application" class="acf-form" action="" method="post">
			<div id="field-group-1">
				<h2>Конкурс</h2>
			<?php
				acf_form(array(
    				'form' => false,
					'post_id'		=> 'new_post',
					'new_post'		=> array(
						'post_type'		=> 'application',
						'post_status'		=> 'publish'
					),
    				'field_groups' => array('3059'),
					'label_placement' => 'top',
				));
			?>
			</div>

			<div id="field-group-2">
				<h2>Конкурсная работа</h2>
			<?php
				acf_form(array(
    				'form' => false,
					'post_id'		=> 'new_post',
					'new_post'		=> array(
						'post_type'		=> 'application',
						'post_status'		=> 'publish'
					),
    				'field_groups' => array('3092'),
					'label_placement' => 'top',
				));
			?>
			</div>
				
			<div id="field-group-3">
				<h2>Информация об участнике</h2>
			<?php
				acf_form(array(
    				'form' => false,
					'post_id'		=> 'new_post',
					'new_post'		=> array(
						'post_type'		=> 'application',
						'post_status'		=> 'publish'
					),
    				'field_groups' => array('3080'),
					'label_placement' => 'top',
				));
			?>
			</div>	
				
			<div id="field-group-4">
				<h2>Место проживания участника</h2>
			<?php
				acf_form(array(
    				'form' => false,
					'post_id'		=> 'new_post',
					'new_post'		=> array(
						'post_type'		=> 'application',
						'post_status'		=> 'publish'
					),
    				'field_groups' => array('3106'),
					'label_placement' => 'top',
				));
			?>
			</div>
				
			<div id="field-group-5">
				<h2>Законный представитель</h2>
			<?php
				acf_form(array(
    				'form' => false,
					'post_id'		=> 'new_post',
					'new_post'		=> array(
						'post_type'		=> 'application',
						'post_status'		=> 'publish'
					),
    				'field_groups' => array('3110'),
					'label_placement' => 'top',
				));
			?>
			</div>
				
			<div id="field-group-6">
				<h2>Руководитель</h2>
			<?php
				acf_form(array(
    				'form' => false,
					'post_id'		=> 'new_post',
					'new_post'		=> array(
						'post_type'		=> 'application',
						'post_status'		=> 'publish'
					),
    				'field_groups' => array('3116'),
					'label_placement' => 'top',
					'submit_value'	=> 'Подать заявку'
				));
			?>
			</div>

			<div class="acf-form-submit">
    
    			<input type="submit" class="acf-button button button-primary button-large" value="Подать заявку">
    			<span class="acf-spinner"></span>

			</div>
				
		<?php } else {
				echo 'Вы не вошли в систему <br> '. do_shortcode('[loginform]');
			}
			
			endwhile; ?>
		
		</main><!-- #main -->
	</section><!-- #primary -->
	
	<?php get_sidebar(); ?>
	
<?php get_footer(); ?>

