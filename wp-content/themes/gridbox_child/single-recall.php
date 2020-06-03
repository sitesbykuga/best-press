<?php
/*
Template Name: Шаблон страницы личного кабинета
Template Post Type: page
*/

get_header(); 
?>

	<div class="main-recall">  
    <div class="container">
      <div class="row justify-content-center">
        <div class="col">          
          <?php echo do_shortcode("[wp-recall]"); ?>
       </div>
     </div>
   </div>   
 </div>
	
<?php get_footer(); ?>
