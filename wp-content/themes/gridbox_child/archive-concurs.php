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
			<div class="row">
				<div class="col-lg-3 col-md-unhide"><b>Конкурс</b></div>
				<div class="col-lg-3 col-md-unhide"><b>Прием заявок</b></div>
				<div class="col-lg-3 col-md-unhide"><b>Работа жюри</b></div>
				<div class="col-lg-3 col-md-unhide"><b>Итоги</b></div>
			</div>

			<?php if(have_posts()) : ?>		
				<?php while (have_posts() ) : the_post();
					get_template_part( 'template-parts/content-concurs-lk' );
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
