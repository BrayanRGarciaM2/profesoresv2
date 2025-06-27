<?php get_header();  ?>    

<div class="row">
  <?php if(isset_columna_lateral()): ?> <!-- Verifica si existe algún elemento en la barra lateral -->
  <div class="<?php echo apply_filters('clase-barra-lateral','col-md-4 hidden-sm hidden-xs') ?>"> <!-- Inicio barra lateral -->
        <?php get_sidebar(); ?>	
    </div><!-- Fin barra lateral -->
  <?php endif; ?>
  
  <div class="<?php echo apply_filters('clase-barra-lateral','col-md-8') ?>"><!-- Inicio centro -->
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <?php 
                $id_proyecto = get_the_ID();   
                disc_proyectos_pintarAllSingle($id_proyecto, 'img-rounded');?>
                <br /><br />
	<?php endwhile; ?>
        <?php else: ?>
		<?php 
                //Funcion del template disctrap
                get_contenido_no_existe(); 
                ?>
	<?php endif; ?>
  </div><!-- Fin centro -->
</div>
        
<?php get_footer();
