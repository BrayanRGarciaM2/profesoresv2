<?php get_header();  ?>    

<div class="row">
  <?php if(isset_columna_lateral()): ?> <!-- Verifica si existe algún elemento en la barra lateral -->
  <div class="<?php echo apply_filters('clase-barra-lateral','col-md-4 col-lg-3 hidden-sm hidden-xs') ?>"> <!-- Inicio barra lateral -->
        <?php get_sidebar(); ?>	
    </div><!-- Fin barra lateral -->
  <?php endif; ?>
  
  <div class="<?php echo apply_filters('clase-barra-lateral','col-md-8 col-lg-9') ?>"><!-- Inicio centro -->
        <h1>Resultado:<?php the_search_query(); ?></h1><!-- Valor buscado -->
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>          
        <div class="row"> 
            <div class="col-md-12">
                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail('thumbnail'); ?>
                <?php endif; ?>
                <?php the_excerpt(); ?>
            </div>
        </div>
	<?php endwhile; ?>
        <?php get_navegacion(); ?>
        <?php else: ?>
		<?php get_contenido_no_existe(); ?>
	<?php endif; ?>
  </div><!-- Fin centro -->
</div>
        
<?php get_footer();


