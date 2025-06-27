<?php get_header();  ?>

<div class="row">
  <?php if(isset_columna_lateral()): ?> <!-- Verifica si existe algún elemento en la barra lateral -->
  <div class="<?php echo apply_filters('clase-barra-lateral','col-md-4 col-lg-3 hidden-sm hidden-xs') ?>"> <!-- Inicio barra lateral -->
        <?php get_sidebar(); ?>
    </div><!-- Fin barra lateral -->
  <?php endif; ?>

  <div class="<?php echo apply_filters('clase-barra-lateral','col-md-8 col-lg-9') ?>"><!-- Inicio centro -->
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
                <?php get_info_single(); ?>
                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail('medium'); ?>
                <?php endif; ?>
                <?php the_content(); ?>
                <p><?php the_tags('<span class="glyphicon glyphicon-tag"></span>  ', ' | ', '');?></p>
                <p><span class="glyphicon glyphicon-file"></span>  <?php the_category( ' | ');?></p>
                <?php get_info_autor(); ?>
                <?php comments_template(); ?>

	<?php endwhile; ?>
        <?php else: ?>
		<?php get_contenido_no_existe(); ?>
	<?php endif; ?>
  </div><!-- Fin centro -->
</div>

<?php get_footer();
