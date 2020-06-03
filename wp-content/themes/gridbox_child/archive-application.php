<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Gridbox
 */

get_header();

if ( have_posts() ) : ?>

	<header class="page-header clearfix">

		<?php the_archive_title( '<h1 class="archive-title">', '</h1>' ); ?>
		<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>

	</header>

<?php endif; 

$user = wp_get_current_user();
if (in_array('administrator', $user->roles)) :?>

<section id="primary" class="content-archive content-area">
	<main id="main" class="site-main" role="main">
		<div class="container">
			<div class="row app-status">
				<span style="color:#F8B72F; font-size: 14px;"><i class="fa fa-paper-plane" aria-hidden="true"></i></span>&nbsp;-&nbsp;заявка отправлена на конкурс;&#8195;<span style="color:#6BC641; font-size: 14px;"><i class="fa fa-check-circle" aria-hidden="true"></i></span>&nbsp;-&nbsp;заявка допущена к участию в конкурсе;&#8195;<span style="color:#274D91; font-size: 12px; border-radius: 50%; border: 1px solid #274D91; padding: 2px;"><b>8.45</b></span>&nbsp;-&nbsp;средний балл среди выставленных оценок;&#8195;<span style="color:#274D91; font-size: 14px;"><i class="fa fa-trophy" aria-hidden="true"></i></span>&nbsp;-&nbsp;работа является победителем (призером) конкурса;&#8195;<span style="color:red; font-size: 14px;"><i class="fa fa-times-circle" aria-hidden="true"></i></span>&nbsp;-&nbsp;заявка отклонена;&#8195;<span style="color:#583B7A; font-size: 14px;"><i class="fa fa-commenting" aria-hidden="true"></i></span>&nbsp;-&nbsp;организатор оставил комментарий к работе
			</div>
			<div class="row">
				<div class="col-lg-1 col-md-unhide"><b>Статус</b></div>
				<div class="col-lg-1 col-md-unhide"><b>Номер</b></div>
				<div class="col-lg-2 col-md-unhide"><b>Дата</b></div>
				<div class="col-lg-3 col-md-unhide"><b>Название работы</b></div>
				<div class="col-lg-2 col-md-unhide"><b>Конкурс</b></div>
				<div class="col-lg-3 col-md-unhide"><b>Номинация</b></div>
			</div>

			<?php if(have_posts()) : ?>		
				<?php while (have_posts() ) : the_post();
					get_template_part( 'template-parts/content-application' );
				endwhile; ?>
				<?php gridbox_pagination(); ?>
				<?php
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif; ?>
		</div>
	</main><!-- #main -->
</section><!-- #primary -->
<?php else : ?>
	<div> У Вас недостаточно прав для просмотра данной информации</div>
<?php endif; ?>
<?php get_footer(); ?>
