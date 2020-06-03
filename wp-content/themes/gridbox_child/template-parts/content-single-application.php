<?php
/**
 * Шаблон для отображения заявки
 *
 * @package Gridbox
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		

		<?php echo '<span class=sub-title>#' . get_the_ID() . '</span>'; the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php 
			$user = wp_get_current_user();
			$id_concurs = get_field('app_id_concurs');
			$is_summarizing = get_field('summarizing', $id_concurs);
			if ((in_array('administrator', $user->roles) || in_array('juri', $user->roles)) && !$is_summarizing) :?> 
				<a class="link-button tabs-menu button-app" href="#">Оценить работу</a>
			<?php endif; unset($user);?>

	</header><!-- .entry-header -->

	<div class="entry-content clearfix">
		<div class="container">
			<div class="row" style="box-shadow: 0 0 10px rgba(0,0,0,0.5); border-radius: 10px; padding: 10px; text-align: center;"><p class="subtitle-row"><span class="required-field">Уважаемые участники конкурса!</span> <br>Если Вам необходимо внести изменения в заявку для корректного формирования сертификата/диплома/благодарственного письма, просим писать администратору во вкладке личного кабинета "Написать администратору"! При обращении к администратору укажите № заявки и причину обращения. Спасибо за понимание.</p>
			</div>
		</div>
		<div class="container">			
			<div class="row" style="margin: 15px;"></div>
			<div class="row">
				<div class="col-2 col-hide"></div>
				<div class="col-xl-4 col-md-6"><p class="title-row">Статус</p></div>
				<div class="col-xl-4 col-md-6 value-row"><p><?php the_field('app_status');?></p></div>
				<div class="col-2 col-hide"></div>
			</div>
			<?php $app_point_avg = get_field('app_point_avg');
			if (!empty($app_point_avg)) : ?>				
				<div class="row">
					<div class="col-2 col-hide"></div>
					<div class="col-xl-4 col-md-6"><p class="title-row">Средний балл</p></div>
					<div class="col-xl-4 col-md-6 value-row"><p><?php the_field('app_point_avg');?></p></div>
					<div class="col-2 col-hide"></div>
				</div>
			<?php endif; ?>
			<?php $app_comment = get_field('app_comment');
			if (!empty($app_comment)) : ?>				
				<div class="row">
					<div class="col-2 col-hide"></div>
					<div class="col-xl-4 col-md-6"><p class="title-row">Комментарий организатора</p></div>
					<div class="col-xl-4 col-md-6 value-row"><p><?php the_field('app_comment');?></p></div>
					<div class="col-2 col-hide"></div>
				</div>
			<?php endif; ?>
			<?php 
				$white_base64 = 'data:image/jpg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMDAsKCwsNDhIQDQ4RDgsLEBYQERMUFRUVDA8XGBYUGBIUFRT/2wBDAQMEBAUEBQkFBQkUDQsNFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBT/wAARCAJbAwQDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD9U6KKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD/9k=';
				$app_status = get_field('app_status');
				
				$fio = get_field('app_name_party') . ' ' . get_field('app_second_name_party');
				$fio_dir2 = get_field('app_name_dir') . ' ' . get_field('app_otchestvo_dir') . ' ' . get_field('app_second_name_dir');
				$fio_dir = trim($fio_dir2);
				unset($fio_dir2);
				$nomination = '"' . get_field('app_nomination') . '"';
				$app_activity_place = trim(get_field('app_activity_place'));
				$app_class = trim(get_field('app_class'));
				if (!empty($app_activity_place) && !empty($app_class)) :
					$app_edu = '(' . get_field('app_activity_place') . ', ' . get_field('app_class') . ')';
				elseif (!empty($app_activity_place) && empty($app_class)) :
					$app_edu = '(' . get_field('app_activity_place') .')';
				else: $app_edu = '';
				endif;
				unset($app_activity_place);
				unset($app_class);

				$app_post_dir = get_field('app_post_dir');

				if (!empty($app_post_dir)) :
					$app_post_dir = '(' . $app_post_dir . ')';
				else: $app_post_dir = '';
				endif;  

				if( have_rows('diploma', $id_concurs) ):
					while ( have_rows('diploma', $id_concurs) ) : 
					the_row(); 
					$diploma_status = get_sub_field('diploma_status');

					if ($is_summarizing && $diploma_status == $app_status) :
						$diploma_party_img = get_sub_field('diploma_party_img');
							$diploma_party_img = (empty($diploma_party_img)) ? $white_base64 : $diploma_party_img;
							$type = pathinfo($diploma_party_img, PATHINFO_EXTENSION);
							$data = file_get_contents($diploma_party_img);
							$base64_party = 'data:image/' . $type . ';base64,' . base64_encode($data);
							unset($type);
							unset($data);	
							unset($diploma_party_img);	
						$diploma_text_before_fio = get_sub_field('diploma_text_before_fio');	
						$diploma_text_before_nomination = get_sub_field('diploma_text_before_nomination');

						$diploma_dir_img = get_sub_field('diploma_dir_img');
							$diploma_dir_img = (empty($diploma_dir_img)) ? $white_base64 : $diploma_dir_img;
							$type_dir = pathinfo($diploma_dir_img, PATHINFO_EXTENSION);
							$data_dir = file_get_contents($diploma_dir_img);
							$base64_dir = 'data:image/' . $type_dir . ';base64,' . base64_encode($data_dir);
							unset($type_dir);
							unset($data_dir);	
							unset($diploma_dir_img);
						$diploma_text_before_fio_dir = get_sub_field('diploma_text_before_fio_dir');
						$diploma_text_before_fio_party = get_sub_field('diploma_text_before_fio_party');
						$diploma_text_before_nomination_dir = get_sub_field('diploma_text_before_nomination_dir');

						$diploma_text_after_stamp = get_sub_field('diploma_text_after_stamp');	
						$diploma_footer = get_sub_field('diploma_footer');	
						if ($app_status == 'Оценена') : 
							$str = 'Сертификат участника';
							$str_dir = 'Сертификат руководителя'; 
						elseif ($app_status == '1 место' || $app_status == '2 место' || $app_status == '3 место') :
							$str = 'Диплом';
							$str_dir = 'Благодарственное письмо руководителя';
						endif;?>	
						<div class="row" style="box-shadow: 0 0 10px rgba(0,0,0,0.5); border-radius: 10px; padding: 10px; text-align: center;"><p class="subtitle-row"><span class="required-field">Внимание!</span> Для того, чтобы открыть или скачать сертификат/диплом/благодарственное письмо, необходимо нажать по соответствующей ссылке ЛЕВОЙ кнопкой мыши.<br> Если ничего не произошло - попробуйте обновить текущую страницу и подождать, пока она полностью загрузится. <br>Если после проделанных действий ни открыть, ни скачать сертификат не удалось, обратитесь к администратору. При обращении к администратору укажите № заявки и причину обращения</span></p></div>		
						<div id=pdfmake-link>
						<div class="row">
							<div class="col-2 col-hide"></div>
							<div class="col-xl-4 col-md-6"><p class="title-row"><?php echo $str; ?></p></div>
							<div class="col-xl-4 col-md-6 value-row"><p id=diploma_data data-app-id='<?php echo get_the_ID();?>' data-status='<?php echo $app_status; ?>' data-img='<?php echo $base64_party; ?>' data-text_before_fio='<?php echo $diploma_text_before_fio; ?>' data-text_before_nomination='<?php echo $diploma_text_before_nomination; ?>' data-text_after_stamp='<?php echo $diploma_text_after_stamp; ?>' data-footer='<?php echo $diploma_footer; ?>' data-fio='<?php echo $fio; ?>' data-nomination='<?php echo $nomination; ?>' data-edu='<?php echo $app_edu; ?>' data-post_dir='<?php echo " " . $app_post_dir; ?>' data-fio_dir='<?php echo $fio_dir; ?>' data-img_dir='<?php echo $base64_dir; ?>'  data-diploma_text_before_fio_dir='<?php echo $diploma_text_before_fio_dir; ?>' data-diploma_text_before_fio_party='<?php echo $diploma_text_before_fio_party; ?>' data-diploma_text_before_nomination_dir='<?php echo $diploma_text_before_nomination_dir; ?>'><a href=# id=ser_uch_open>Открыть</a> / <a href=# id=ser_uch_download>Скачать</a></p></div>
							<div class="col-2 col-hide"></div>
						</div>
						<?php if (!empty($fio_dir)) : ?>
							<div class="row">
								<div class="col-2 col-hide"></div>
								<div class="col-xl-4 col-md-6"><p class="title-row"><?php echo $str_dir; ?></p></div>
								<div class="col-xl-4 col-md-6 value-row"><p><a href=# id=ser_dir_open>Открыть</a> / <a href=# id=ser_dir_download>Скачать</a></p></div>
								<div class="col-2 col-hide"></div>
							</div>
						<?php endif;
						unset($diploma_status);
						unset($diploma_party_img);
						unset($diploma_party_img);
						unset($base64_party);
						unset($diploma_text_before_fio);
						unset($diploma_text_before_nomination);
						unset($diploma_text_before_fio_dir);
						unset($diploma_text_before_fio_party);
						unset($diploma_text_before_nomination_dir);
						unset($diploma_text_after_stamp);
						unset($str);
						unset($str_dir);

						endif; 
					endwhile;
				endif;
				unset($app_status);
				unset($fio);
				unset($fio_dir);
				unset($app_edu);
				unset($app_post_dir);
				unset($white_base64);
				unset($id_concurs);
				unset($is_summarizing);?>
			</div>	
			<div class="row">
				<div class="col-2 col-hide"></div>
				<div class="col-xl-4 col-md-6"><p class="title-row">Название конкурса</p></div>
				<div class="col-xl-4 col-md-6 value-row"><p><?php the_field('app_concurs');?></p></div>
				<div class="col-2 col-hide"></div>
			</div>
			<div class="row">
				<div class="col-12 sub-title">Конкурсная работа</div>
			</div>
			<div class="row">
				<div class="col-2 col-hide"></div>
				<div class="col-xl-4 col-md-6"><p class="title-row">Название работы</p></div>
				<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_title'); ?></div>
				<div class="col-2 col-hide"></div>
			</div>
			<div class="row">
				<div class="col-2 col-hide"></div>
				<div class="col-xl-4 col-md-6">
					<p class="title-row">Номинация</p></div>
				<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_nomination'); ?></div>
				<div class="col-2 col-hide"></div>
			</div>
			<div class="row">
				<div class="col-2 col-hide"></div>
				<div class="col-xl-4 col-md-6">
					<p class="title-row">Тема</p></p></div>
				<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_theme'); ?></div>
				<div class="col-2 col-hide"></div>
			</div>
			<?php $app_free_theme = get_field('app_free_theme');
			if (!empty($app_free_theme)) : ?>
				<div class="row">
					<div class="col-2 col-hide"></div>
					<div class="col-xl-4 col-md-6">
						<p class="title-row">Наименование свободной темы</p></div>
					<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_free_theme'); ?></div>
					<div class="col-2 col-hide"></div>					
				</div>
			<?php endif; ?>

			<?php 
				$file1_description = array(
					'Стихотворение' => 'Текст стихотворения',
					'Статья' => 'Текст статьи с иллюстрациями',
					'Плакат (графический дизайн)' => 'Изображение',
					'Видеоролик' => 'Видео',
					'Фотография' => 'Изображение',
					'Плакат (рисунок)' => 'Изображение',
					'Рисунок' => 'Изображение',
					'Сказка' => 'Документ',
					'Рассказ, эссе' => 'Документ',
					'Эссе' => 'Документ',
					'Фотография' => 'Изображение',
					'Изобразительное искусство' => 'Изображение',
					'Декоративно-прикладное творчество' => 'Изображение',
					'Художественное слово' => 'Видео',
					'Вокал' => 'Видео',
					'Исполнительское мастерство' => 'Видео',
					'Хореография' => 'Видео'
				);
			foreach ($file1_description as $key => $v) :
				if (get_field('app_nomination') == $key) :?>
					<div class="row">
						<div class="col-2 col-hide"></div>
						<div class="col-xl-4 col-md-6">
							<p class="title-row"><?php echo $v ?></p></div>
						<div class="col-xl-4 col-md-6 value-row"><a href=<?php echo '"'.get_field('app_file1').'"'; ?> target="_blank">Файл 1</a></div>
						<div class="col-2 col-hide"></div>
					</div>
				<?php endif;
			endforeach;

			$file2_description = array(
					'Стихотворение' => 'Музыкальное сопровождение',
					'Статья' => 'Текст статьи'
				);

			foreach ($file2_description as $key => $v) :
				if (get_field('app_nomination') == $key) :?>
					<div class="row">
						<div class="col-2 col-hide"></div>
						<div class="col-xl-4 col-md-6">
							<p class="title-row"><?php echo $v ?></p></div>
						<div class="col-xl-4 col-md-6 value-row"><a href=<?php echo '"'.get_field('app_file2').'"'; ?> target="_blank">Файл 2</a></div>
						<div class="col-2 col-hide"></div>
					</div>
				<?php endif;
			endforeach;

			$file3_description = array(
					'Статья' => 'Иллюстрации к статье'
				);

			foreach ($file3_description as $key => $v) :
				if (get_field('app_nomination') == $key) :?>
					<div class="row">
						<div class="col-2 col-hide"></div>
						<div class="col-xl-4 col-md-6">
							<p class="title-row"><?php echo $v ?></p></div>
						<div class="col-xl-4 col-md-6 value-row"><a href=<?php echo '"'.get_field('app_file3').'"'; ?> target="_blank">Файл 3</a></div>
						<div class="col-2 col-hide"></div>
					</div>
				<?php endif;
			endforeach;?>		

	<div class="row">
		<div class="col-12 sub-title">Информация об участнике</div>
	</div>

	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Фамилия</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_second_name_party'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Имя</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_name_party'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Отчество</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_otch_party'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Дата рождения</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_birthday'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Возраст на момент подачи заявки</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_age'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Контактный телефон</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_tel_party'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Электронная почта</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_email'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Ссылки на профили в социальных сетях</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_link_social'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Учебное заведение/место работы</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_activity_place'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Класс/курс/должность</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_class'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Уровень образования</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_edu'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Интересы участника</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_hobby'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>

	<div class="row">
		<div class="col-12 sub-title">Место проживания участника</div>
	</div>

	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Регион</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_region'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Город/Муниципальный район</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_city'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Район города/населенный пункт</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_np'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>

	<div class="row">
		<div class="col-12 sub-title">Законный представитель</div>
	</div>
	
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Фамилия</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_second_name_pr'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Имя</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_name_pr'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Отчество</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_otchestvo_pr'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Контактный телефон</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_tel_pr'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Электронная почта</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_email_pr'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>

	<div class="row">
		<div class="col-12 sub-title">Руководитель</div>
	</div>

	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Фамилия</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_second_name_dir'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Имя</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_name_dir'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Отчество</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_otchestvo_dir'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Место работы и занимаемая должность</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_post_dir'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Контактный телефон</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_tel_dir'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Электронная почта</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php the_field('app_email_dir'); ?></div>
		<div class="col-2 col-hide"></div>
	</div>

	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Согласие на обработку персональных данных Организатором Конкурса</p></div>
		<div class="col-xl-4 col-md-6 value-row">
			<?php 
			echo (get_field('app_reglam_personal_data') == 1) ? 'Согласен' : 'Не согласен'?></div>
		<div class="col-2 col-hide"></div>
	</div>
	<div class="row">
		<div class="col-2 col-hide"></div>
		<div class="col-xl-4 col-md-6">
			<p class="title-row">Согласие на публикацию конкурсной работы</p></div>
		<div class="col-xl-4 col-md-6 value-row"><?php 
			echo (get_field('app_copyright') == 1) ? 'Согласен' : 'Не согласен'?></div>
		<div class="col-2 col-hide"></div>
	</div>

</div>

<div class="popup-app">
	<button class=popup-close>&times;</button>
	<div class=popup-content>
		<div class="container">
			<div class="concurs-name" name="<?php the_field('app_concurs'); ?>" stile="display:none"></div>
			<div class="row">
				<span class=sub-title># <?php the_ID() ?></span>
				<p class="sub-title" style="color:black;"><?php the_title() ?></p>
			</div>
			<div class="row">	
				<div class="col-4"><p class="title-row">Статус</p></div>
				<div class="col-8 value-row"><?php the_field('app_status');?></div>	
			</div>
			<?php $app_point_avg = get_field('app_point_avg');
			if (!empty($app_point_avg)) : ?>				
				<div class="row">	
					<div class="col-4"><p class="title-row">Средний балл</p></div>
					<div class="col-8 value-row"><?php the_field('app_point_avg'); ?></div>	
				</div>
			<?php endif; ?>
			<div class="row">	
				<div class="col-4"><p class="title-row">Ранее выставленные оценки</p></div>	
			</div>
			<div class="row">
				<div class="value-row">	
					<?php $app_old_rating = get_field('app_old_rating');
					echo (!empty($app_old_rating)) ? $app_old_rating : 'Ранее работа не была оценена'; ?>
				</div>
			</div>
			<div class="row">	
				<div class="col-4"><p class="title-row">Оценить работу</p></div>	
			</div>
			<div class="row">
				<div class="value-row">
					<?php echo do_shortcode('[contact-form-7 id="3656"]'); /*3656*/?>
				</div>
			</div>
		</div>
	</div>
</div>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php gridbox_entry_tags(); ?>


	</footer><!-- .entry-footer -->

</article>
