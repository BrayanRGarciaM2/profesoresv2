<?php get_header();  ?>    

<div class="row">
  <?php if(isset_columna_lateral()): ?> <!-- Verifica si existe algún elemento en la barra lateral -->
  <div class="<?php echo apply_filters('clase-barra-lateral','col-md-4 hidden-sm hidden-xs') ?>"> <!-- Inicio barra lateral -->
        <?php get_sidebar(); ?>	
    </div><!-- Fin barra lateral -->
  <?php endif; ?>
  
  <div class="<?php echo apply_filters('clase-barra-lateral','col-md-8') ?>"><!-- Inicio centro -->
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>  
            <div class="row"> 
                <div class="col-md-3">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail('thumbnail'); ?>
                    <?php endif; ?>
                </div>
                <div class="col-md-9">
                    <?php 
                        $id_prof = get_the_ID();
                        $nombre = get_post_meta($id_prof, 'nombre_mostrar', true);
                        $categorias  = darCategorias($id_prof);
                        $grupos  = darGrupos($id_prof);
                   ?>
                    <h2><a href="<?php echo get_home_url().'/'.get_the_title(); ?>"><?php echo $nombre; ?></a></h2>
                    <?php 
                        echo '<h4><span class="glyphicon glyphicon-bookmark"></span> Categoría:</h4>';
                        if($categorias)
                        {
                           echo '<ul style="list-style: none;">';
                           foreach ($categorias as $cat) {
                               echo '<li>'.$cat->name.'</li>';
                           }
                           echo '</ul>';
                        }
                         echo '<h4><i class="fa fa-users"></i> Grupo:</h4>';
                        if($grupos)
                        {
                           echo '<ul style="list-style: none;">';
                           foreach ($grupos as $grup) {
                               if($grup->description != '' && substr($grup->description, 0 ,4) =='http' )
                               {
                                   echo '<li><a href="'.$grup->description.'" target="_blank">'.$grup->name.'</a></li>';
                               }
                               else
                               {
                                    echo '<li>'.$grup->name.'</li>';
                               }


                           }
                           echo '</ul>';
                        }
                    ?>
                </div>
            </div>
   
	<?php endwhile; ?>
	<?php endif; ?>
      </div>
  </div><!-- Fin centro -->
</div>
        
<?php get_footer();
