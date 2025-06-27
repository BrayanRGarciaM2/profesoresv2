<?php  
/*
 Template Name: Sin barra lateral
 */
?>
<?php get_header();  ?>    

<div class="row">
  <div class="<?php echo apply_filters('clase-barra-lateral','col-md-12') ?>"><!-- Inicio centro -->

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <h1><?php the_title(); ?></h1>
	  	<?php the_content(); ?>
                <?php comments_template(); ?>

	<?php endwhile; ?>
        <?php else: ?>
		<?php get_contenido_no_existe(); ?>
	<?php endif; ?>
  </div><!-- Fin centro -->
</div>
        
<?php get_footer();


