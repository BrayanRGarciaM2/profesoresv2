<?php get_header(); ?>    

<div class="row">
    <?php if (isset_columna_lateral()): ?> <!-- Verifica si existe algún elemento en la barra lateral -->
        <div class="<?php echo apply_filters('clase-barra-lateral', 'col-md-4 col-lg-3 hidden-sm hidden-xs') ?>"> <!-- Inicio barra lateral -->
            <?php get_sidebar(); ?>	
        </div><!-- Fin barra lateral -->
    <?php endif; ?>

    <?php if (isset_columna_lateral()): ?>  
        <div class="<?php echo apply_filters('clase-barra-lateral', 'col-md-8 col-lg-9') ?>"><!-- Inicio centro -->
    <?php else: ?> 
        <div class="<?php echo apply_filters('clase-barra-lateral', 'col-md-12') ?>"><!-- Inicio centro -->    
    <?php endif; ?>

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    
                <?php the_content(); ?>
                <?php 
                
                //comments_template(); 
                ?>

                <?php endwhile; ?>
            <?php else: ?>
                <?php get_contenido_no_existe(); ?>
            <?php endif; ?>
        </div><!-- Inicio centro -->
    </div>

    <?php
    get_footer();


    