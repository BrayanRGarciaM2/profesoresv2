<?php

//Permite que el tema soporte imágenes destacadas
add_theme_support( 'post-thumbnails' );

/**
 * Permite que el tema pueda tener imagen en el header
 */
function inicializarHeader()
{
    $defaults = array(
	'default-image'          => '',
	'width'                  => 200,
	'height'                 => 200,
	'flex-height'            => false,
	'flex-width'             => false,
	'uploads'                => true,
	'random-default'         => false,
	'header-text'            => false,
	'default-text-color'     => '',
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
);
    add_theme_support( 'custom-header', $defaults );
}
add_action('init', 'inicializarHeader');

/**
 * Función que se invoca al momento de pintar un comentario de una entrada
 * @param type $comment el comentario que se desea pintar
 * @param type $args los argumentos (clase en la que se pinta el comentario)
 * @param type $depth profundiad a pintar
 */
function disctrap_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
        ?>
	<div <?php comment_class( empty( $args['has_children'] ) ? ' row fila-comentario' : 'row fila-comentario parent' ) ?> id="comment-<?php comment_ID() ?>">
            <div class=" col-sm-1 hidden-xs comment-author vcard">
                <?php if ( $args['avatar_size'] != 0 ) {echo get_avatar( $comment, $args['avatar_size'] );} ?>
            </div>
            <div class=" col-sm-11">
                <?php printf( __( '<b><cite class="fn">%s</cite> <span class="says">dice:</span></b>' ), get_comment_author_link() ); ?>
                <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
                <?php
                    printf( __('(%1$s - %2$s)'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Editar)' ), '  ', '' );
                 ?>
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <br />
		<em class="comment-awaiting-moderation texto-claro"><?php _e( 'Su comentario está en espera de ser moderado.' ); ?></em>
		<br />
            <?php endif; ?>

            <?php comment_text(); ?>
            <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div>
        </div>
<?php
}

/**
 * Función que se llama al terminar de pintar un comentario. Se implementa vacia para evitar que se pinten /div adicioanles
 * @param type $comment el comentario que se desea pintar
 * @param type $args los argumentos (clase en la que se pinta el comentario)
 * @param type $depth profundiad a pintar
 */
function disctrap_comment_end($comment, $args, $depth)
{
    //No se implementa nada para que no se adicionen div extra al comentario

}


/**
 * Función que devuelve la imagen de encabezado del tema. Si existe la pinta de lo contrario no hace nada.
 * Se realiza de esta manera para evitar el caso en que no existe la imagen y se pinta el icono de imagen no encontrada
 */
function disctrap_imagen_encabezado()
{
    if(get_header_image()): ?>
       <img class="img-circle img-disc-encabezado" src="<?php echo( get_header_image() ); ?>" align="middle"/>
    <?php endif;
}

/**
 * Registra los js necesarios para el tema, en particular el js de boostrap
 */
function disctrap_scripts_with_jquery()
{
	// Register the script like this for a theme:
	wp_register_script( 'custom-script', get_template_directory_uri() . '/bootstrap/js/bootstrap.js', array( 'jquery' ) );
	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'custom-script' );
}
add_action( 'wp_enqueue_scripts', 'disctrap_scripts_with_jquery' );


/**
* Registra los PHP y funciones extras en archivo de PHP
*/
function disctrap_require_files(){
  // Registra las funciones PHP para enmascarar el correo electrónico.
  require_once 'enmascarar_correo.php';
}
add_action( 'wp_enqueue_scripts', 'disctrap_require_files' );

/**
 * Registra los menús habilitados en el tema. existen dos el superior y el lateral
 */
function disctrap_register_menus()
{
    register_nav_menus(array('menu-principal'=>__('Principal')));
    register_nav_menus(array('menu-lateral'=>__('Lateral')));
    register_nav_menus(array('menu-principal-profesor'=>__('Principal Profesor')));
}
add_action('init', 'disctrap_register_menus');

/**
 * Inicializa las zonas de widgets disponibles en el tema.
 * Existen 5:
 *  Bajo la descripción del sitio. Pensado para las redes sociales
 *  Bajo el titulo del sitio a la derecha
 *  Bajo el título del sitio a la izquierda
 *  Lateral antes de la navegación
 *  Lateral después de la navegación
 */
function disctrap_widget_init()
{
    register_sidebar(array(
        'name' => __('Lateral superior', 'disctrap'),
        'id' => 'lateral_superior_disctrap',
        'before_widget' => '<div  id="%1$s" class="widget%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
    ));

    register_sidebar(array(
        'name' => __('Bajo titulo', 'disctrap'),
        'id' => 'bajo_titulo_disctrap',
        'before_widget' => '<div  id="%1$s" class="widget%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
    ));

    register_sidebar(array(
        'name' => __('Lateral inferior', 'disctrap'),
        'id' => 'lateral_inferior_disctrap',
        'before_widget' => '<div  id="%1$s" class="widget%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
    ));

    register_sidebar(array(
        'name' => __('Header izquierda', 'disctrap'),
        'id' => 'header_izquierda_disctrap',
        'before_widget' => '<div  id="%1$s" class="widget%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
    ));

    register_sidebar(array(
        'name' => __('Header derecha', 'disctrap'),
        'id' => 'header_derecha_disctrap',
        'before_widget' => '<div  id="%1$s" class="widget%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
    ));
}
add_action('init', 'disctrap_widget_init');

/**
 * Pinta el menú principal
 * Pinta los primeros dos niveles. Los siguientes niveles los pinta recursivamente un método de soporte
 */
function get_main_menu()
{
     $menu_name = 'menu-principal';

    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
	$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
        $menu_items = wp_get_nav_menu_items($menu->term_id, array( 'order' => 'DESC'));

      foreach( $menu_items as $item ):
        // set up title and url
        $title = $item->title;
        $link = $item->url;

        $hijos = darHijosMenu($menu_items, $item);

        if($item->menu_item_parent == 0 ):?>
            <?php if(count($hijos) > 0 ):?>
                <li class="dropdown">
                    <a href="<?php echo $link; ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $title; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach ($hijos as $hijo):
                            pintarHijo($menu_items, $hijo);
                        endforeach;?>
                    </ul>
                </li>

            <?php else:?>
               <li>
                <a href="<?php echo $link; ?>">
                    <?php echo $title; ?>
                </a>
            </li>
        <?php endif;?>
            <?php endif;?>
     <?php

      endforeach;

    } else {
	$menu_list = '<ul><li>No se ha definido el menú "' . $menu_name . '".</li></ul>';
    }

}

/**
 * Pinta el menú secundario
 * Pinta los dos primeros niveles. Los siguietnes niveles los pinta recursivamente un método de soporte
 */
function get_secondary_menu()
{
    $menu_name = 'menu-lateral';
    ?>
    <?php if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ): ?>

        <div id="menu-lateral sidebar-nav">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle boton-menu-movil-lateral" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                 Más opciones
                <span class="glyphicon glyphicon-menu-hamburger"></span>
                <span class="caret"></span>
                <span class="sr-only">Más opciones</span>
          </button>
        </div>
         <div class="navbar-collapse collapse sidebar-navbar-collapse">
        <div class="list-group panel">
        <?php
        $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
        $menu_items = wp_get_nav_menu_items($menu->term_id, array( 'order' => 'DESC'));

        foreach( $menu_items as $item ):
        // set up title and url
        $title = $item->title;
        $link = $item->url;

        $hijos = darHijosMenu($menu_items, $item);?>
        <?php if($item->menu_item_parent == 0 ):?>
        <?php if(count($hijos) == 0):?>

            <a href="<?php echo $link ?>" class="list-group-item" data-parent="#menu-lateral"><?php echo $title ?></a>
        <?php else: ?>
            <?php
                $identificador = str_replace(' ', '-', $title);
            ?>
            <a href="<?php echo '#'.$identificador ?>" class="list-group-item menu-disc-lateral-principal" data-toggle="collapse" data-parent="#menu-lateral"><?php echo $title ?><span class="caret"></span></a>
            <div class="collapse" id="<?php echo $identificador ?>">
                <?php foreach ($hijos as $hijo): ?>
                    <?php pintarHijoLateral($menu_items, $hijo, $identificador); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php endif; ?>
        <?php endforeach; ?>
        </div></div> </div>
    <?php endif; ?>
<?php
}

/**
* Pinta las diferentes páginas de un profesor en TABS.
*/
function get_primary_professor_tabs(){
  $menu_name = 'menu-principal-profesor';
  ?>
  <?php if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ): ?>
      <?php
      $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
      $menu_items = wp_get_nav_menu_items($menu->term_id, array( 'order' => 'DESC'));
      ?>
      <ul class="nav nav-tabs">
        <?php
        $inicio = 1;
        foreach( $menu_items as $item ):
          // set up title and url
          $title = $item->title;
          ?>
            <?php if($inicio==1): ?>
              <li class="active"><a data-toggle="tab" href="#<?php echo str_replace(' ', '',$title); ?>"><?php echo $title; ?></a></li>
            <?php else: ?>
              <li><a data-toggle="tab" href="#<?php echo str_replace(' ', '',$title); ?>"><?php echo $title; ?></a></li>
            <?php endif; ?>
            <?php ++$inicio; ?>
        <?php endforeach; ?>
      </ul>
      <div class="tab-content">
        <?php
          $inicio = 1;
        foreach ($menu_items as $item):
          $title = $item->title;
          $pageid = get_post_meta( $item->ID, '_menu_item_object_id', true );

          ?>

            <div id="<?php echo str_replace(' ', '',$title); ?>" class="tab-pane fade <?php echo ($inicio===1) ? 'in active': ''; ?>">
                <?php
                  $post = get_post($pageid);
                  $content = apply_filters('the_content', $post->post_content);
                  echo $content;
                ?>
            </div>

        <?php $inicio++; ?>
        <?php endforeach; ?>
      </div>
  <?php endif; ?>
<?php
}

/**
* Devuelve la página principal para los profesores
*/
function get_front_page(){
  $pageID = get_option('page_on_front');
  $post = get_post($pageid);
  $content = apply_filters('the_content', $post->post_content);
  echo $content;
}

/**
 * Recursivo para pintar los elementos del menú lateral (nivel >=2)
 * @param type $elementos todos los elementos que pertenecen al menú
 * @param type $hijo el elemento que se desea pintar
 * @param type $idpadre el identificador del padre. Es necesario para poder colapsar el elemento
 */
function pintarHijoLateral($elementos, $hijo, $idpadre)
{
     $hijos = darHijosMenu($elementos, $hijo);
     if(count($hijos) == 0): ?>
          <a href="<?php echo $hijo->url; ?>" class="list-group-item" data-parent="<?php echo '#'.$idpadre ?>"><?php echo $hijo->title; ?></a>
     <?php else: ?>
         <?php $identificador = str_replace(' ', '-', $hijo->title); ?>
          <a href="<?php echo '#'.$identificador ?>" class="list-group-item" data-toggle="collapse" data-parent="<?php echo '#'.$idpadre ?>"><?php echo $hijo->title; ?><span class="caret"></span></a>
            <div class="collapse" id="<?php echo $identificador ?>">
                <?php foreach ($hijos as $hijo)?>
                    <?php pintarHijoLateral($elementos, $hijo, $identificador); ?>
                <?phpendforeach; ?>
     <?php endif;
}

/**
 * Recursivo para pintar los elementos del menú principal (nivel >=2)
 * @param type $elementos todos los elementos que pertenecen al menú
 * @param type $hijo el elemento que se desea pintar
 */
function pintarHijo($elementos, $hijo)
{
     $hijos = darHijosMenu($elementos, $hijo);
      if(count($hijos) == 0): ?>
         <li>
            <a href="<?php echo $hijo->url; ?>">
                <?php echo $hijo->title; ?>
            </a>
        </li>
     <?php else: ?>
         <li class="dropdown-submenu">
            <a href="<?php echo $hijo->url; ?>"><?php echo $hijo->title; ?></a>
                <ul class="dropdown-menu">
                    <?php foreach($hijos as $hn2):
                        pintarHijo($elementos, $hn2);
                    endforeach;?>
                </ul>
     <?php endif;
}

/**
 * a partir de los elementos de un menú y un elemento padre devuelve los hijos directos
 * @param type $elementos
 * @param type $padre
 * @return array con los hijos del elemento padre
 */
function darHijosMenu($elementos, $padre)
{
    $hijos = array();
    foreach( $elementos as $item ):
        if($item->menu_item_parent == $padre->ID)
        {
            array_push($hijos, $item);
        }
    endforeach;
    return $hijos;
}



/**
 * Permite  modificar el texto 'Leer más' que se muestra en el resumen de las entradas
 * @param type $more el texto original
 * @return type 'Leer más...'
 */
function new_excerpt_more( $more ) {
	return ' <a class="read-more" href="' . get_permalink( get_the_ID() ) . '"> Leer más... </a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );


/**
 * Construye la navegación para mostrar cuando hay varios post en un search, archive, author
 */
function get_navegacion()
{
    $antes =  get_next_posts_link('Anteriores');
       $ahora =  get_previous_posts_link('Receintes'); ?>
        <div class='navigation'>
        <ul class="pager">
                <?php if(isset($antes)): ?>
                    <li class="previous"><span class='glyphicon glyphicon-step-backward'><?php echo $antes;  ?></span></li>
                <?php endif; ?>
                <?php if(isset($ahora)): ?>
                    <li class="next"><span class='glyphicon glyphicon-step-forward'><?php echo $ahora; ?></span></li>
                <?php endif; ?>
        </ul>
        </div>
 <?php
}

/**
 * Indica si hay algún elemento asignado a la columna lateral (wigets o menú)
 * @return boolean true en caso que al menos haya un elemento en la columna lateral
 */
function isset_columna_lateral(){
    $widget_superior = 'lateral_superior_disctrap';
    $widget_inferior = 'lateral_inferior_disctrap';
    $menu_lateral = 'menu-lateral';
    return (is_active_sidebar($widget_superior) || is_active_sidebar($widget_inferior) || has_nav_menu($menu_lateral));// ||
            //(( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_lateral ] )));
}

/**
 * Devuelve el texto que se debe mostrar cuando no existe resultado para una busqueda.
 * Incluye un formulario para buscar de nuevo
 */
function get_contenido_no_existe()
{?>
    <div class="row">
        <div class="col-md-6">
            <h1>Contenido no encontrado</h1>
            <p>Lo sentimos, no hemos encontrado el contenido</p>
            <p><a href="<?php echo home_url() ?>">Regresar a <span class="glyphicon glyphicon-home"></span> <?php echo get_bloginfo( 'name' ); ?></a></p>
        </div>
        <div class="col-md-6">
            <h1>Buscar algo más</h1>
            <?php get_form_buscar('form-inline', 50);?>
        </div>
    </div>
<?php }

/**
 * Devuelve un formulario de busqueda
 * @param type $claseForm la clase que debe tener el formulario
 * @param type $anchoBusqueda la longitud del campo de busqueda
 */
function get_form_buscar($claseForm, $anchoBusqueda=20)
{?>
    <form class="<?php echo $claseForm ?>" role="search" method="get" action="<?php echo esc_url( home_url( '/' ));?>">
        <div class="form-group">
            <input type="search"  size="<?php echo $anchoBusqueda ?>" class="form-control" placeholder="buscar" value="<?php echo get_search_query() ?>" name="s" id="s">
        </div>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
    </form>
<?php }

/**
 * Devuelve la información que se muestra bajo el título de un post
 */
function get_info_single()
{?>
     <p>
         <span class="glyphicon glyphicon-calendar"></span> <?php the_date('d-m-y'); ?>
         <span class="glyphicon glyphicon-user"></span>
         <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?></a>
     </p>
<?php }

/**
 * Devuelve la información de un autor que se muestra al final de una entrada
 */
function get_info_autor()
{?>
    <div class="panel panel-disc">
        <div class="panel-heading">Sobre el autor</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 64); ?>
                </div>
                <div class="col-md-10">
                    <h5> <?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' ) ); ?>"><span class="badge badge-disc"><?php the_author_posts(); ?></span></a></h5>
                    <p> <?php apply_filters('disc_author_single_description', the_author_meta('description'))?></p>
                </div>
            </div>
        </div>
   </div>

<?php }

/**
 * Devuelve la información que se muestra como encabezado al consultar por author
 */
function get_encabezado_autor()
{?>
    <div class="row">
        <div class="col-md-2">
            <?php echo get_avatar( get_the_author_meta( 'ID' ), 128); ?>
        </div>
        <div class="col-md-9 col-md-offset-1">
            <h1> <?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?> <span class="badge badge-disc"><?php the_author_posts(); ?></span></h1>
            <p><?php apply_filters('disc_author_single_description', the_author_meta('description'))?></p>
        </div>
    </div>
<?php }

/**
 * Devuelve el encabezado de la barra de menú. Esto es:
 * Menú oculto para mostrar en dispositivos pequeños, logo de la universidad y enlaces de la universidad
 */
function get_nav_bar_header()
{?>
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed boton-menu-movil" data-toggle="collapse" data-target="#menu-superior-sitio-disc" aria-expanded="false">
            <?php echo get_bloginfo( 'name' ); ?>
            <span class="glyphicon glyphicon-menu-hamburger"></span>
            <span class="caret"></span>
            <span class="sr-only">Navegar</span>
        </button>
        <a href="#" class="dropdown-toggle logo-uniandes" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></a>
            <ul class="dropdown-menu">
                <?php get_links_uniandes(); ?>
            </ul>
    </div>
<?php }

/**
 * Devuelve el listado de enlaces de la universidad.
 * Tiene un hook para pagregar más mas_links_uniandes
 */
function get_links_uniandes()
{?>
    <li><a href="https://www.uniandes.edu.co" target="_blank">Universidad de los Andes</a></li>
    <li><a href="https://ingenieria.uniandes.edu.co"  target="_blank">Facultad de Ingeniería</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="https://sicuaplus.uniandes.edu.co"  target="_blank">Sicua+</a></li>
    <li><a href="https://correo.uniandes.edu.co"  target="_blank">Correo</a></li>
    <li><a href="https://biblioteca.uniandes.edu.co"  target="_blank">Sistema de Bibliotecas</a></li>
    <?php do_action('mas_links_uniandes');?>
<?php }

/**
 * Devuelve los enlaces del departamento y el home del sitio
 */
function get_marca_home()
{?>
    <li><a class="nombre-depto" href="https://sistemas.uniandes.edu.co">Departamento de Ingeniería <br/> de Sistemas y Computación</a></li>
    <li><a href="<?php echo home_url() ?>"><span class="glyphicon glyphicon-home"></span> <?php echo get_bloginfo( 'name' ); ?></a></li>
<?php }

/**
 * Devuelve el menú de conexión al sitio.
 * Si el usuario está loggeado presenta los enlaces de administración. tiene un hook para agregar más mas_links_adminstrars
 * Si el usuario no está loggeado presenta el formulario de ingreso
 */
function get_menu_conectar(){?>
<?php if(is_user_logged_in()): ?>
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <span class="glyphicon glyphicon-user"></span><span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li><a href="<?php echo  get_edit_user_link( wp_get_current_user()->ID ) ?>"><?php echo (wp_get_current_user()->first_name!='') ?  wp_get_current_user()->first_name.' '. wp_get_current_user()->last_name :  wp_get_current_user()->nickname  ?></a></li>
        <li role="separator" class="divider"></li>
        <?php if ( current_user_can( 'manage_options' ) ): ?>
            <li><a href="<?php echo get_admin_url( ); ?>">Panel de control</a></li>
        <?php endif; ?>
        <li><a href="<?php echo  get_edit_user_link( wp_get_current_user()->ID ) ?>">Perfil</a></li>
        <?php do_action('mas_links_adminstrar');?>
        <li role="separator" class="divider"></li>
        <li><a href="<?php echo wp_logout_url(home_url()); ?>">Salir</a></li>
    </ul>
<?php else: ?>
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <span class="glyphicon glyphicon-user"></span><span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li>
            <?php get_form_ingresar('navbar-form navbar-left'); ?>
        </li>
    </ul>
<?php endif; ?>
<?php }

/**
 * Pinta un formulario de ingreso al sitio
 * @param String $claseForm la clase que debe tener el formulario
 */
function get_form_ingresar($claseForm)
{?>
<form class="<?php echo $claseForm ?>" role="form" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
    <div class="form-group">
        <label for="usr">Usuario:</label>
        <input type="text" class="form-control" name="log" id="user" required>
    </div>
    <div class="form-group">
        <label for="pwd">Clave:</label>
        <input type="password" class="form-control" name="pwd" id="pass" required>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="rememberme" value="forever"> Recordarme</label>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-disc" name="wp-submit">Ingresar</button>
        <input type="hidden" name="redirect_to" value="'<?php the_permalink(); ?> '" />
    </div>
</form>
<?php }

/**
 * Devuelve el titulo del sitio. Esto es:
 * Imagen de encabezado, nombre, descripción y widget
 */
function dar_titulo_sitio() {?>
<div class="container-fluid ">
    <div class="row">
        <div class="col-lg-offset-1 col-lg-2 col-md-offset-1 col-md-2 col-sm-4 hidden-xs">
            <?php disctrap_imagen_encabezado();?>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-8 col-sm-8">
          <h2><?php echo get_bloginfo( 'name' ); ?> <span style="font-size: 70%"><br /><?php echo get_bloginfo( 'description' );  ?></span></h2>
            <?php if(is_active_sidebar('bajo_titulo_disctrap')): ?>
              <?php dynamic_sidebar('bajo_titulo_disctrap'); ?>
            <?php endif;?>
        </div>
    </div>
    <div class="row">
        <?php if(is_active_sidebar('header_izquierda_disctrap')): ?>
            <div class="col-md-6 hidden-sm hidden-xs">
                <?php dynamic_sidebar('header_izquierda_disctrap'); ?>
            </div>
        <?php endif;?>
        <?php if(is_active_sidebar('header_derecha_disctrap')): ?>
            <div class="col-md-6 hidden-sm hidden-xs">
                <?php dynamic_sidebar('header_derecha_disctrap'); ?>
            </div>
        <?php endif;?>
    </div>
</div>
<?php }

function dar_footer_sitio(){  ?>
  <div class="jumbotron pie">
      <p>© <a href="https://sistemas.uniandes.edu.co">Departamento de Ingeniería de Sistemas y Computación</a> | <a href="https://ingenieria.uniandes.edu.co">Facultad de Ingeniería</a> | <a href="https://www.uniandes.edu.co">Universidad de los Andes</a> 2015 <?php if(date('Y')>2015){echo'-'.date('Y');} ?></p>
  </div>
<?php }
add_action('wp_footer','dar_footer_sitio', 100);

//-----------------------------------------------------------------------------------
// HOOKS  PARA CAMBIO DE CAPABILITIES
//-----------------------------------------------------------------------------------

// get the the role object
//$role_object = get_role( 'editor' );

// add $cap capability to this role object
//$role_object->add_cap( 'edit_theme_options' );

// remove $cap capability to this role object
//$role_object->remove_cap( 'edit_theme_options' );
