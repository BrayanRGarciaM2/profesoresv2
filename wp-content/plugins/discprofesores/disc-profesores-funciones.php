<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//----------------------------------------------------------------
//METODOS QUE SE ENCAGAN PRINCIPALMENTE DE LOGICA DEL PLUGIN
//----------------------------------------------------------------

/**
 * Registra el tipo profesor DISC como un tipo de entrada
 */
add_action('init', 'crear_disc_profesores');

/**
 * Crea el tipo de post personalizado para manejar profesores, si es red solo lo crea en el sitio principal
 * Crea las taxonomias relacionadas con los profesores. Categorías y Grupos
 */
/**
 * Crea el tipo de post personalizado para manejar profesores, si es red solo lo crea en el sitio principal
 * Crea las taxonomias relacionadas con los profesores. Categorías y Grupos
 */
function crear_disc_profesores()
{
    /**
     * Crea el tipo de post para manejar la información de los profesores
     */
    $crear = creacionMU();
    if($crear)
    {
        register_post_type('disc_profesores',array(
            'labels' => array(  'name' => 'Profesores DISC',
                                'singular_name' => 'Profesor',
                                'menu name' => 'Profesores',
                                'all_items' => 'Profesores',
                                'add_new' => 'Nuevo profesor',
                                'add_new_item' => 'Nuevo profesor',
                                'edit' => 'Editar',
                                'edit_item' => 'Editar profesor',
                                'new_item' => 'Nuevo profesor',
                                'view' => 'Ver',
                                'view_item' => 'Ver profesor',
                                'search_items' => 'Buscar profesores',
                                'not_found' => 'No se encontraron profesores',
                                'not_found_in_trash' => 'No se encontraron profesores en papelera'
                            ),
            'description' => 'Permite manejar información de un profesor',
            'public' => true,
            'menu_position' => 5, //Debajo de posts
            'hierarchical'=>false,
            'supports' => array('title','revisions', 'page-attributes', 'thumbnail'), //No soporta el campo de edición para reemplzarlo por los elementos de un curso
            'menu_icon' => plugins_url('img'.DIRECTORY_SEPARATOR.'profesores_disc_16x16.png', __FILE__),
            'has_archive' => true)
        );

        register_post_type('disc_prof_catedra',array(
            'labels' => array(  'name' => 'Profesores DISC Catedra',
                                'singular_name' => 'Profesor',
                                'menu name' => 'Profesores',
                                'all_items' => 'Profesores',
                                'add_new' => 'Nuevo profesor',
                                'add_new_item' => 'Nuevo profesor de cátedra',
                                'edit' => 'Editar',
                                'edit_item' => 'Editar profesor de cátedra',
                                'new_item' => 'Nuevo profesor de cátedra',
                                'view' => 'Ver',
                                'view_item' => 'Ver profesor de cátedra',
                                'search_items' => 'Buscar profesores de cátedra',
                                'not_found' => 'No se encontraron profesores de cátedra',
                                'not_found_in_trash' => 'No se encontraron profesores de cátedra en papelera'
                            ),
            'description' => 'Permite manejar información de un profesor de cátedra',
            'public' => true,
            'menu_position' => 5, //Debajo de posts
            'hierarchical'=>false,
            'supports' => array('title','revisions', 'page-attributes', 'thumbnail'), //No soporta el campo de edición para reemplzarlo por los elementos de un curso
            'menu_icon' => plugins_url('img'.DIRECTORY_SEPARATOR.'profesores_disc_16x16.png', __FILE__),
            'has_archive' => true)
          );


        register_taxonomy('disc_profesores_grupos', 'disc_profesores', array(
            'labels'=>array(    'name'=>'Grupos',
                                'singular_name'=>'Grupo',
                                'menu_name'=>'Grupos de investigación',
                                'all_items'=>'Todos los grupos',
                                'edit_item'=>'Editar grupo',
                                'update_item'=>'Actualizar grupo',
                                'add_new_item'=>'Agregar grupo',
                                'new_item_name'=>'Nuevo grupo',
                                'search items'=>'Buscar grupo',
                                'popular_items'=>'Grupos comunes',
                                'choose_from_most_used'=>'Seleccionar de más usados',
                                'not_found'=>'No se encontraron grupos',
                                'parent_item'=>'Grupo padre',
                                'most_used'=>'Más usados'
                            ),
           'show_tagcloud'=>false,
           'show_ui'=>true,
           'hierarchical'=>true
            )
        );

        register_taxonomy('disc_profesores_categorias', 'disc_profesores', array(
            'labels'=>array(    'name'=>'Categorías',
                                'singular_name'=>'Categoría',
                                'menu_name'=>'Categorías',
                                'all_items'=>'Todas las categorías',
                                'edit_item'=>'Editar categoría',
                                'update_item'=>'Actualizar categoría',
                                'add_new_item'=>'Agregar categoría',
                                'new_item_name'=>'Nuevo categoría',
                                'search items'=>'Buscar categoría',
                                'popular_items'=>'Categorías comunes',
                                'choose_from_most_used'=>'Seleccionar de más usados',
                                'not_found'=>'No se encontraron categorías',
                                'parent_item'=>'Categoría padre',
                                'most_used'=>'Más usados'
                            ),
            'show_tagcloud'=>false,
            'show_ui'=>true,
            'hierarchical'=>true
            )
        );

        register_taxonomy('disc_catedra_categorias', 'disc_prof_catedra', array(
            'labels'=>array(    'name'=>'Categorías Catedras',
                                'singular_name'=>'Categoría',
                                'menu_name'=>'Categorías',
                                'all_items'=>'Todas las categorías',
                                'edit_item'=>'Editar categoría',
                                'update_item'=>'Actualizar categoría',
                                'add_new_item'=>'Agregar categoría',
                                'new_item_name'=>'Nuevo categoría',
                                'search items'=>'Buscar categoría',
                                'popular_items'=>'Categorías comunes',
                                'choose_from_most_used'=>'Seleccionar de más usados',
                                'not_found'=>'No se encontraron categorías',
                                'parent_item'=>'Categoría padre',
                                'most_used'=>'Más usados'
                            ),
            'show_tagcloud'=>false,
            'show_ui'=>true,
            'hierarchical'=>true
            )
        );

        register_taxonomy('disc_profesores_periodos', array('disc_profesores','disc_prof_catedra'), array(
            'labels'=>array('name'=>'Periodos',
                                'singular_name'=>'Periodo',
                                'menu_name'=>'Periodos',
                                'all_items'=>'Todos los periodos',
                                'edit_item'=>'Editar periodo',
                                'update_item'=>'Actualizar periodo',
                                'add_new_item'=>'Agregar periodo',
                                'new_item_name'=>'Nuevo periodo',
                                'search items'=>'Buscar periodo',
                                'popular_items'=>'Periodos comunes',
                                'choose_from_most_used'=>'Seleccionar de más usados',
                                'not_found'=>'No se encontraron periodos',
                                'parent_item'=>'Periodo padre',
                                'most_used'=>'Más usados'
                            ),
            'show_tagcloud'=>false,
            'show_ui'=>true,
            'hierarchical'=>true
            )
        );
    }

}

/**
 * Verifica si se encuentra en un multisitio y si está en el sitio principal
 * @return boolean true si está en el sitio principal, false en caso contrario
 */
function creacionMU()
{
    $crear = true;
    if(is_multisite() && !is_main_site())
    {
        $crear = false;
    }
    return $crear;
}

/**
 * Modifica el título de la caja para poner el nombre del profesor
 * @global String $post_type el tipo del post
 * @param string $input el texto a filtrar
 * @return string el texto fitlrado
 */
function disc_profesores_titulo($input)
{
    global $post_type;
    if(is_admin() && ('Enter title here' == $input || 'Introduce el título aquí' == $input)&& ('disc_profesores' == $post_type || 'disc_prof_catedra' == $post_type))
    {
        $input = 'Ingrese el login Uniandes del profesor';
    }
    return $input;
}
add_filter('gettext', 'disc_profesores_titulo');

/**
 * Inicializa el editor de profesores agregando metaboxes para la información específica
 */
add_action('add_meta_boxes', 'disc_profesores_editor');

/**
 * Crea las metaboxes para ingresar la información del profesor
 */
function disc_profesores_editor()
{
    add_meta_box('disc_profesores_meta_info', 'Información básica del profesor', 'disc_profesores_meta_info_func', array('disc_profesores','disc_prof_catedra'), 'normal', 'high');
    add_meta_box('disc_profesores_formacion', 'Formación académica del profesor(ES)', 'disc_profesores_formacion_func', array('disc_profesores','disc_prof_catedra'), 'normal', 'high');
    add_meta_box('disc_profesores_intereses', 'Intereses y líneas de investigación del profesor(ES)', 'disc_profesores_intereses_func', 'disc_profesores', 'normal', 'high');
    add_meta_box('disc_profesores_cursos', 'Cursos del profesor(ES)', 'disc_profesores_cursos_func', array('disc_profesores','disc_prof_catedra'), 'normal', 'high');
    //Información del profesor en inglés
    add_meta_box('disc_profesores_formacion_en', 'Formación académica del profesor(EN)', 'disc_profesores_formacion_en_func', array('disc_profesores','disc_prof_catedra'), 'normal', 'high');
    add_meta_box('disc_profesores_intereses_en', 'Intereses y líneas de investigación del profesor(EN)', 'disc_profesores_intereses_en_func', 'disc_profesores', 'normal', 'high');
    add_meta_box('disc_profesores_cursos_en', 'Cursos del profesor(EN)', 'disc_profesores_cursos_en_func', array('disc_profesores','disc_prof_catedra'), 'normal', 'high');
}

/**
 * Inicializa la metabox para ingresar la información general del profesor
 * @param WP_Post $profesor_disc
 */
function disc_profesores_meta_info_func($profesor_disc)
{
  $nombre = esc_html(get_post_meta($profesor_disc->ID, 'nombre_prof_disc', true));
  $apellido = esc_html(get_post_meta($profesor_disc->ID, 'apellido_prof_disc', true));
  $nombre_mostrar = esc_html(get_post_meta($profesor_disc->ID, 'nombre_mostrar', true));
  $facebook = esc_html(get_post_meta($profesor_disc->ID, 'facebook', true));
  $twitter = esc_html(get_post_meta($profesor_disc->ID, 'twitter', true));
  $google = esc_html(get_post_meta($profesor_disc->ID, 'google', true));
  $linkedin = esc_html(get_post_meta($profesor_disc->ID, 'linkedin', true));
  $googlescholar = esc_html(get_post_meta($profesor_disc->ID, 'googlescholar', true));
  $researchgate = esc_html(get_post_meta($profesor_disc->ID, 'researchgate', true));
  $dblp = esc_html(get_post_meta($profesor_disc->ID, 'dblp', true));
  $oficina = esc_html(get_post_meta($profesor_disc->ID, 'oficina', true));
  $correo = esc_html(get_post_meta($profesor_disc->ID, 'correo', true));
  $extension = esc_html(get_post_meta($profesor_disc->ID, 'extension', true));
  ?>
  <div  style="width: 100%">
      <div class="form-field form-required">
          <label class="label-required" for="nombre_prof_disc"><h2>Nombre:</h2></label>
          <input id="nombre_prof_disc" type="text" maxlength="80" placeholder="Nombre del profesor" name="nombre_prof_disc" value="<?php echo $nombre; ?>"/>
          <p class="description">El nombre completo del profesor</p><br/>
      </div>
      <div class="form-field form-required">
          <label class="label-required" for="apellido_prof_disc"><h2>Apellido:</h2></label>
          <input id="apellido_prof_disc" type="text" maxlength="80" placeholder="Apellido del profesor" name="apellido_prof_disc" value="<?php echo $apellido; ?>"/>
          <p class="description">El apellido del profesor</p><br/>
      </div>
      <div class="form-field">
          <label class="label" for="nombre_mostrar"><h2>Nombre para mostrar:</h2></label>
          <input id="nombre_mostrar" type="text" maxlength="80" placeholder="Nombre para mostrar del profesor" name="nombre_mostrar" value="<?php echo $nombre_mostrar; ?>"/>
          <p class="description">El nombre del profesor como desea que sea mostrado</p></br>
      </div>


      <table style="width: 100%; overflow-x:auto;overflow-y:auto;" >
          <tr>
              <td style="width: 50%; vertical-align: top;">
                  <h2>Información contacto Uniandes</h2>
                  <div class="infoUniandes">

                    <?php if($profesor_disc->post_type == 'disc_profesores') : ?>

                      <div class="form-field" >
                          <label class="label" for="oficina"><h4>Oficina:</h4></label>
                          <input id="oficina" type="text" maxlength="80" placeholder="ML yyy" name="oficina" value="<?php echo $oficina; ?>" />
                          <p>En caso de dejar vacio el campo no se mostrará al publicar la información general del profesor</p>
                      </div>

                      <div class="form-field" >
                          <label class="label" for="extension"><h4>Extensión:</h4></label>
                          <input id="extension" type="text" maxlength="80" placeholder="yyyy" name="extension" value="<?php echo $extension; ?>" />
                          <p>En caso de dejar vacio el campo no se mostrará al publicar la información general del profesor</p>
                      </div>

                    <?php endif; ?>

                      <div class="form-field" >
                          <label class="label" for="correo"><h4>Correo:</h4></label>
                          <input id="correo" style="width: 90%" type="mail" size="80" placeholder="usuario@uniandes.edu.co" name="correo" value="<?php echo $correo; ?>" />
                          <p>En caso de dejar vacio el campo no se mostrará al publicar la información general del profesor</p>
                      </div>
                  </div>
              </td>
              <td style="width: 50%">
                  <h2>Redes sociales</h2>
                  <div class="redes">
                      <div class="form-field" >
                          <label class="label" for="facebook"><h4>Facebook:</h4></label>
                          <input id="facebook" type="text" maxlength="80" placeholder="Usuario Facebook" name="facebook" value="<?php echo $facebook; ?>"/>
                          <p>En caso de dejar vacio el campo no se mostrará al publicar la información general del profesor</p>
                      </div>
                      <div class="form-field" >
                          <label class="label" for="twitter"><h4>Twitter:</h4></label>
                          <input id="twitter" type="text" maxlength="80" placeholder="Usuario Twitter" name="twitter" value="<?php echo $twitter; ?>"/>
                          <p>En caso de dejar vacio el campo no se mostrará al publicar la información general del profesor</p>
                      </div>
                      <div class="form-field">
                          <label class="label" for="google"><h4>Google+:</h4></label>
                          <input id="google" type="text" maxlength="80" placeholder="Enlace completo perfil Google+" name="google" value="<?php echo $google; ?>"/>
                          <p>En caso de dejar vacio el campo no se mostrará al publicar la información general del profesor</p>
                      </div>
                      <div class="form-field" >
                          <label class="label" for="linkedin"><h4>LinKedIn:</h4></label>
                          <input id="linkedin" type="text" maxlength="80" placeholder="Enlace completo perfil LinkedIn" name="linkedin" value="<?php echo $linkedin; ?>"/>
                          <p>En caso de dejar vacio el campo no se mostrará al publicar la información general del profesor</p>
                      </div>
                      <div class="form-field" >
                          <label class="label" for="googlescholar"><h4>Google Scholar:</h4></label>
                          <input id="googlescholar" type="text" maxlength="80" placeholder="Enlace completo perfil de google scholar" name="googlescholar" value="<?php echo $googlescholar; ?>"/>
                          <p>En caso de dejar vacio el campo no se mostrará al publicar la información general del profesor</p>
                      </div>
                      <div class="form-field" >
                          <label class="label" for="researchgate"><h4>Research Gate:</h4></label>
                          <input id="researchgate" type="text" maxlength="80" placeholder="Enlace completo perfil de Research Gate" name="researchgate" value="<?php echo $researchgate; ?>"/>
                          <p>En caso de dejar vacio el campo no se mostrará al publicar la información general del profesor</p>
                      </div>
                      <div class="form-field" >
                          <label class="label" for="dblp"><h4>DBLP:</h4></label>
                          <input id="dblp" type="text" maxlength="80" placeholder="Enlace completo perfil de DBLP" name="dblp" value="<?php echo $dblp; ?>"/>
                          <p>En caso de dejar vacio el campo no se mostrará al publicar la información general del profesor</p>
                      </div>
                   </div>
              </td>
          </tr>
      </table>
  </div>
  <?php
}

/**
 * Inicializa la metabox para ingresar la formación del profesor
 * @param WP_Post $profesor_disc
 */
function disc_profesores_formacion_func($profesor_disc)
{
    $formacion_profesor_disc = get_post_meta($profesor_disc->ID, 'formacion_profesor_disc', true);
    ?>
    <div  style="width: 100%">

        <div class="form-field form-required">
            <p>Se recomienda usar una lista de elementos</p>
            <?php
                wp_editor($formacion_profesor_disc, 'formacion_profesor_disc', array( 'textarea_rows' => 10, 'editor_class' => 'at-wysiwyg' ))
            ?>
        </div>
    </div>
    <?php
}

/**
 * Inicializa la metabox para ingresar los intereses y líneas de investigación  del profesor
 * @param WP_Post $profesor_disc
 */
function disc_profesores_intereses_func($profesor_disc)
{
    $intereses_profesor_disc = get_post_meta($profesor_disc->ID, 'intereses_profesor_disc', true);
    ?>
    <div  style="width: 100%">

        <div class="form-field form-required">
            <p>Se recomienda usar una lista de elementos</p>
            <?php
                wp_editor($intereses_profesor_disc, 'intereses_profesor_disc', array( 'textarea_rows' => 10, 'editor_class' => 'at-wysiwyg' ))
            ?>
        </div>
    </div>
    <?php
}

/**
 * Inicializa la metabox para ingresar los cursos dictados por el profesor
 * @param WP_Post $profesor_disc
 */
function disc_profesores_cursos_func($profesor_disc)
{
    $cursos_profesor_disc = get_post_meta($profesor_disc->ID, 'cursos_profesor_disc', true);
    ?>
    <div  style="width: 100%">

        <div class="form-field form-required">
            <p>Se recomienda usar una lista de elementos por semestre</p>
            <?php
                wp_editor($cursos_profesor_disc, 'cursos_profesor_disc', array( 'textarea_rows' => 20, 'editor_class' => 'at-wysiwyg' ))
            ?>
        </div>
    </div>
    <?php
}

/**
 * Inicializa la metabox para ingresar los cursos dictados por el profesor eb inglés
 * @param WP_Post $profesor_disc
 */
function disc_profesores_cursos_en_func($profesor_disc)
{
    $cursos_profesor_disc_en = get_post_meta($profesor_disc->ID, 'cursos_profesor_disc_en', true);
    ?>
    <div  style="width: 100%">

        <div class="form-field form-required">
            <p>Se recomienda usar una lista de elementos por semestre</p>
            <?php
                wp_editor($cursos_profesor_disc_en, 'cursos_profesor_disc_en', array( 'textarea_rows' => 20, 'editor_class' => 'at-wysiwyg' ))
            ?>
        </div>
    </div>
    <?php
}

/**
 * Inicializa la metabox para ingresar la formación del profesor
 * @param WP_Post $profesor_disc
 */
function disc_profesores_formacion_en_func($profesor_disc)
{
    $formacion_profesor_disc_en = get_post_meta($profesor_disc->ID, 'formacion_profesor_disc_en', true);
    ?>
    <div  style="width: 100%">

        <div class="form-field form-required">
            <p>Se recomienda usar una lista de elementos</p>
            <?php
                wp_editor($formacion_profesor_disc_en, 'formacion_profesor_disc_en', array( 'textarea_rows' => 10, 'editor_class' => 'at-wysiwyg' ))
            ?>
        </div>
    </div>
    <?php
}

/**
 * Inicializa la metabox para ingresar los intereses y líneas de investigación  del profesor eb inglés
 * @param WP_Post $profesor_disc
 */
function disc_profesores_intereses_en_func($profesor_disc)
{
    $intereses_profesor_disc_en = get_post_meta($profesor_disc->ID, 'intereses_profesor_disc_en', true);
    ?>
    <div  style="width: 100%">

        <div class="form-field form-required">
            <p>Se recomienda usar una lista de elementos</p>
            <?php
                wp_editor($intereses_profesor_disc_en, 'intereses_profesor_disc_en', array( 'textarea_rows' => 10, 'editor_class' => 'at-wysiwyg' ))
            ?>
        </div>
    </div>
    <?php
}


/**
 * Agrega la acción para que se guarde la nueva metadata del profesor
 */
add_action('save_post', 'disc_profesores_guardar', 10, 2);

/**
 * Guarda la información del profesor
 * @param int $profesor_id
 * @param WP_Post $nuevo_profesor
 */
function disc_profesores_guardar($profesor_id, $nuevo_profesor)
{
    if($nuevo_profesor->post_type == 'disc_profesores' ||  $nuevo_profesor->post_type == 'disc_prof_catedra')
    {
        if(isset($_POST['nombre_prof_disc']) && $_POST['nombre_prof_disc'] != '')
        {
            update_post_meta($profesor_id, 'nombre_prof_disc', $_POST['nombre_prof_disc']);
        }
        if(isset($_POST['apellido_prof_disc']) && $_POST['apellido_prof_disc'] != '')
        {
            update_post_meta($profesor_id, 'apellido_prof_disc', $_POST['apellido_prof_disc']);
        }
        if(isset($_POST['nombre_mostrar']) && $_POST['nombre_mostrar'] != '')
        {
            update_post_meta($profesor_id, 'nombre_mostrar', $_POST['nombre_mostrar']);
        }
        if(isset($_POST['facebook']) && $_POST['facebook'] != '')
        {
            update_post_meta($profesor_id, 'facebook', $_POST['facebook']);
        }
        if(isset($_POST['twitter']) && $_POST['twitter'] != '')
        {
            update_post_meta($profesor_id, 'twitter', $_POST['twitter']);
        }
        if(isset($_POST['google']) && $_POST['google'] != '')
        {
            update_post_meta($profesor_id, 'google', $_POST['google']);
        }
        if(isset($_POST['linkedin']) && $_POST['linkedin'] != '')
        {
            update_post_meta($profesor_id, 'linkedin', $_POST['linkedin']);
        }
        if(isset($_POST['googlescholar']) && $_POST['googlescholar'] != '')
        {
            update_post_meta($profesor_id, 'googlescholar', $_POST['googlescholar']);
        }
        if(isset($_POST['researchgate']) && $_POST['researchgate'] != '')
        {
            update_post_meta($profesor_id, 'researchgate', $_POST['researchgate']);
        }
        if(isset($_POST['dblp']) && $_POST['dblp'] != '')
        {
            update_post_meta($profesor_id, 'dblp', $_POST['dblp']);
        }
        if(isset($_POST['formacion_profesor_disc']) && $_POST['formacion_profesor_disc'] != '')
        {
            update_post_meta($profesor_id, 'formacion_profesor_disc', $_POST['formacion_profesor_disc']);
        }
        if(isset($_POST['intereses_profesor_disc']) && $_POST['intereses_profesor_disc'] != '')
        {
            update_post_meta($profesor_id, 'intereses_profesor_disc', $_POST['intereses_profesor_disc']);
        }
        if(isset($_POST['cursos_profesor_disc']) && $_POST['cursos_profesor_disc'] != '')
        {
            update_post_meta($profesor_id, 'cursos_profesor_disc', $_POST['cursos_profesor_disc']);
        }
        if(isset($_POST['oficina']) && $_POST['oficina'] != '')
        {
            update_post_meta($profesor_id, 'oficina', $_POST['oficina']);
        }
        if(isset($_POST['correo']) && $_POST['correo'] != '')
        {
            update_post_meta($profesor_id, 'correo', $_POST['correo']);
        }
        if(isset($_POST['extension']) && $_POST['extension'] != '')
        {
            update_post_meta($profesor_id, 'extension', $_POST['extension']);
        }
        if(isset($_POST['formacion_profesor_disc_en']) && $_POST['formacion_profesor_disc_en'] != '')
        {
            update_post_meta($profesor_id, 'formacion_profesor_disc_en', $_POST['formacion_profesor_disc_en']);
        }
        if(isset($_POST['intereses_profesor_disc_en']) && $_POST['intereses_profesor_disc_en'] != '')
        {
            update_post_meta($profesor_id, 'intereses_profesor_disc_en', $_POST['intereses_profesor_disc_en']);
        }
        if(isset($_POST['cursos_profesor_disc_en']) && $_POST['cursos_profesor_disc_en'] != '')
        {
            update_post_meta($profesor_id, 'cursos_profesor_disc_en', $_POST['cursos_profesor_disc_en']);
        }
    }
}

/**
 * Agrega el shortcode para poder recuperar la información del profesor
 */
add_shortcode('disc-profesor', 'info_profesor_disc');

/**
 * Procesa la información del shortcode
 * Usuario: Entrada obligatoria. El username del profesor.
 * tipo: El tipo de resultado que se requiere. [all, nombre, nombreM (nombre a mostrar), formacion, intereses, cursos, general, contacto, social, categoría, grupo]
 * presentación: Tabs. Muestra las opciones en tabs.
 * Catedra: Por defecto, False. False, muestra la información de los profesores de planta. True. Muestra la información de los profesores de Cátedra.
 *  lang: Por defecto, es (Español). en (Inglés). Se puede extender a otros idiomas.
 * @param array $atts
 */
function info_profesor_disc($atts)
{
      extract(shortcode_atts(array( 'usuario'=>'',
                                    'tipo'  =>'',
                                    'imagen'=>'',
                                    'presentacion'=>'',
                                    'catedra'=>'false',
				    'desplegar_titulo'=>'true',
      				    'lang'=>'es'),
              $atts));
      $idActual = get_current_blog_id();
      irASitioPrinicipal();

      if(($catedra === 'false')){
      	$pag = get_page_by_title($usuario, OBJECT, 'disc_profesores');
			}else{
				$pag = get_page_by_title($usuario, OBJECT, 'disc_prof_catedra');
			}

      if( $pag ){

          $id_prof = $pag->ID;
          if($tipo == 'all')
          {
              pintarAll($id_prof, $imagen, $presentacion, $catedra);
          }
          else if($tipo == 'nombre')
          {
              pintarNombre($id_prof, $imagen);
          }
          else if($tipo == 'nombrem')
          {
              pintarNombreMostrar($id_prof, $imagen);
          }
          else if($tipo == 'formacion')
          {
              $lang == 'es' ? pintarFormacion($id_prof): pintarFormacion_en($id_prof);
          }
          else if($tipo == 'intereses')
          {
             $lang == 'es' ? pintarIntereses($id_prof, $desplegar_titulo) : pintarIntereses_en($id_prof,$desplegar_titulo);
          }
          else if($tipo == 'cursos')
          {
              $lang == 'es' ? pintarCursos($id_prof) : pintarCursos_en($id_prof);
          }
          else if($tipo == 'general')
          {
              $lang == 'es' ? pintarGeneral($id_prof, $imagen, $desplegar_titulo): pintarGeneral_en($id_prof, $imagen, $desplegar_titulo);
          }
          else if($tipo == 'contacto')
          {
              $lang == 'es' ? pintarContacto($id_prof, $imagen, $desplegar_titulo) : pintarContacto_en($id_prof, $imagen, $desplegar_titulo);
          }
          else if($tipo == 'social')
          {
	      pintarSocial($id_prof, $imagen, $desplegar_titulo); 
          }
          else if($tipo == 'categoria')
          {
              pintarCategoria($id_prof);
          }
          else if($tipo == 'grupo')
          {
              $lang == 'es' ? pintarGrupo($id_prof, $desplegar_titulo) : pintarGrupo_en($id_prof, $desplegar_titulo);
          }
      }

        else{?>
        <p>No se encontró información del profesor: <?php echo $usuario; ?></p>
        <?php }

      volverAOriginal($idActual);
}


/**
 * si es red cambia al sitio principal para recuperar los profesores
 */
function irASitioPrinicipal()
{
    if(is_multisite())
    {
        $sitios = wp_get_sites();
        foreach ($sitios as $sitio)
        {
            if(is_main_site($sitio['blog_id']))
            {
                switch_to_blog($sitio['blog_id']);
                break;
            }
        }
    }
}

/**
 * Si está en red vuelve al sitio que usó el shortcode
 * @param int $id del blog donde se está usando el shortcode
 */
function volverAOriginal($id){
    if(is_multisite())
    {
        switch_to_blog($id);
    }

}

add_filter('template_include', 'template_disc_profesores', 1);
function template_disc_profesores($ruta_template)
{
    if(get_post_type() == 'disc_profesores' || get_post_type() == 'disc_prof_catedra'  )
    {
        if(is_single())
        {
            if($profesor_en_tema = locate_template(array('single-disc_profesores.php')))
            {
                $ruta_template = $profesor_en_tema;
            }
            else
            {
                $ruta_template = plugin_dir_path(__FILE__).'/single-disc_profesores.php';
            }
        }
        else if(is_archive())
        {
            if($profesor_en_tema = locate_template(array('archive-disc_profesores.php')))
            {
                $ruta_template = $profesor_en_tema;
            }
            else
            {
                $ruta_template = plugin_dir_path(__FILE__).'/archive-disc_profesores.php';
            }
        }
    }
    return $ruta_template;
}


add_shortcode('todos-profesores-disc', 'func_todos_prof_disc');

/**
 * Periodo: Periodo del cual quiere realizar la consulta de los profesores.
 * Titulo: Tipo de título HTML para imprimir el Listado de los profesores.
 * Grupo: Grupo de investigación del que se desea consultar los profesores.
 * Categoría: Categoría de los profesores a consultar.
 * Catedra: Si se desea incluir en la consulta los profesores de cátedra. 1. Solo profesores de planta.
 * 2. Solo profesores de cátedra. 3. Incluir todos los profesores.
 * Columna: Número de Columnas de profesores.
 * visualizacion: 'Tarjetas' o en 'Lista'
 * @param type $atts que responde al shortcode que pinta todos los profesores según ciertos filtros
 */
function func_todos_prof_disc($atts)
{

    extract(shortcode_atts(array( 'periodo'=>'',
                                  'titulo'=>'',
                                  'grupo'=>'',
                                  'categoria'=>'',
                                  'catedra'=>'1',
                                  'columna'=>'1',
                                  'visualizacion'=>'tarjeta'
                                ), $atts));

    if($titulo && $titulo != '')
    {
        echo '<'.$titulo.'>'.get_the_title().'</'.$titulo.'>';
    }
    if($periodo && $periodo != '')
    {
         $params['disc_profesores_periodos'] = $periodo;
    }
    if($grupo && $grupo != '')
    {
         $params['disc_profesores_grupos'] = $grupo;
    }
    if($categoria && $categoria != '')
    {
         $params['disc_profesores_categorias'] = $categoria;
    }
    $params['meta_key'] ='apellido_prof_disc';
    $params['orderby'] ='meta_value';
    $params['order'] ='ASC';

    switch($catedra){
      case '1':
          $post_types = array('post_type' => array('disc_profesores'),);
          break;
      case '2':
          $post_types = array('post_type' => array('disc_prof_catedra'),);
          break;
      case '3':
          $post_types = array('post_type' => array('disc_profesores','disc_prof_catedra'),);
    }

    pintarListadoProfesores($params, $post_types, $columna, $visualizacion);



  }

/**
 * agrega campos adicionales a la pantalla de creación de grupos
 */
function disc_profesores_grupos_meta_field()
{?>
        <div class="form-field">
            <label  for="nombre_grupo_en">Nombre en inglés:</label>
            <input type="text" name="nombre_grupo_en" id="nombre_grupo_en" value="">
            <p class="description">Ingrese el nombre del grupo en inglés</p>
        </div>
<?php }
 add_action( 'disc_profesores_grupos_add_form_fields',  'disc_profesores_grupos_meta_field',10,2);

 /**
  * Agrega campos a la pantalla de edición del grupo
  * @param type $term el termino que se está editando
  */
 function disc_profesores_grupos_edit_meta_field($term)
 {
     $t_id = $term->term_id;
     $term_meta = get_option('taxonomy_'.$t_id); ?>
        <tr class="form-field">
            <th scope="row" valign="top" ><label for="nombre_grupo_en">Nombre grupo inglés</label></th>
            <td>
                <input type="text" name="nombre_grupo_en" id="nombre_grupo_en" value="<?php  if($term_meta && $term_meta['nombre_grupo_en']){ echo esc_attr($term_meta['nombre_grupo_en']);} else{ echo ''; }?>">
                <p class="description">Nombre del grupo en inglés</p>
            </td>
        </tr>
 <?php }
 add_action('disc_profesores_grupos_edit_form_fields','disc_profesores_grupos_edit_meta_field',10,2);

 /**
  * Función que se ejecuta al momento de guardar o editar un grupo
  * @param int $term_id id del grupo que se va a salvar
  */
 function save_taxonomy_custom_disc_profesores_grupos_meta($term_id)
 {
     $infoGrupo = array();
     $t_id = $term_id;
     if(isset($_POST['nombre_grupo_en']))
     {
         $infoGrupo['nombre_grupo_en'] = $_POST['nombre_grupo_en'];
     }
     update_option('taxonomy_'.$t_id, $infoGrupo);
 }
 add_action('edited_disc_profesores_grupos', 'save_taxonomy_custom_disc_profesores_grupos_meta', 10, 2);
 add_action('create_disc_profesores_grupos', 'save_taxonomy_custom_disc_profesores_grupos_meta', 10, 2);


 /**
 * agrega campos adicionales a la pantalla de creación de categorias
 */
function disc_profesores_categorias_meta_field()
{?>
        <div class="form-field">
            <label  for="nombre_cat_en">Nombre categoría inglés:</label>
            <input type="text" name="nombre_cat_en" id="nombre_cat_en" value="">
            <p class="description">Ingrese el nombre de la categoría en inglés</p>
        </div>
<?php }
 add_action( 'disc_profesores_categorias_add_form_fields',  'disc_profesores_categorias_meta_field',10,2);
 add_action( 'disc_catedra_categorias_add_form_fields',  'disc_profesores_categorias_meta_field',10,2);

 /**
  * Agrega campos a la pantalla de edición de la categoria
  * @param type $term el termino que se está editando
  */
 function disc_profesores_catgorias_edit_meta_field($term)
 {
     $t_id = $term->term_id;
     $term_meta = get_option('taxonomy_'.$t_id); ?>
        <tr class="form-field">
            <th scope="row" valign="top" ><label for="nombre_cat_en">Nombre categoría inglés</label></th>
            <td>
                <input type="text" name="nombre_cat_en" id="nombre_cat_en" value="<?php  if($term_meta && $term_meta['nombre_cat_en']){ echo esc_attr($term_meta['nombre_cat_en']);} else{ echo ''; }?>">
                <p class="description">Ingrese el nombre de la categoría en inglés</p>
            </td>
        </tr>
 <?php }
 add_action('disc_profesores_categorias_edit_form_fields','disc_profesores_catgorias_edit_meta_field',10,2);
add_action('disc_catedra_categorias_edit_form_fields','disc_profesores_catgorias_edit_meta_field',10,2);

 /**
  * Función que se ejecuta al momento de guardar o editar una catgoria
  * @param int $term_id id de la categoría que se va a salvar
  */
 function save_taxonomy_custom_disc_profesores_categorias_meta($term_id)
 {
     $infoCat = array();
     $t_id = $term_id;
     if(isset($_POST['nombre_cat_en']))
     {
         $infoCat['nombre_cat_en'] = $_POST['nombre_cat_en'];
     }
     update_option('taxonomy_'.$t_id, $infoCat);
 }
 add_action('edited_disc_profesores_categorias', 'save_taxonomy_custom_disc_profesores_categorias_meta', 10, 2);
 add_action('create_disc_profesores_categorias', 'save_taxonomy_custom_disc_profesores_categorias_meta', 10, 2);
 add_action('edited_disc_catedra_categorias', 'save_taxonomy_custom_disc_profesores_categorias_meta', 10, 2);
 add_action('create_disc_catedra_categorias', 'save_taxonomy_custom_disc_profesores_categorias_meta', 10, 2);

 /*
 * Solucion temporal a bug encontrado en la actualizacion a la version 4.4.1 de worpress
 * El problema se resume en que el atributo src de las imagenes usa urls con https y el atributo srcset usa urls con http. Como resultado no se cargan * * las imágenes correctamente.
 * La solucion consiste en un filter agregado a la funcion wp_calculate_image_srcset
 * Force URLs in srcset attributes into HTTPS scheme.
 * This is particularly useful when you're running a Flexible SSL frontend like Cloudflare
 */
function ssl_srcset( $sources ) {
  foreach ( $sources as &$source ) {
    $source['url'] = set_url_scheme( $source['url'], 'https' );
  }

  return $sources;
}
add_filter( 'wp_calculate_image_srcset', 'ssl_srcset' );


/**
* Método que permite retornar el POST de un profesor (post_type).
* @param $login del profesor para realizar la búsqueda del POST
*/
function dar_profesor_por_usuario($login)
{

  $args = array(
  'post_type'   => 'disc_profesores',
  'title' => $login
  );
DiscProfProyUtilidades::debug_to_console($login);

$the_query = new WP_Query( $args );
$rta = NULL;
if($the_query->have_posts())
{
  while ($the_query->have_posts()) : $the_query -> the_post();
  $rta = $the_query->post;
  endwhile;
}

  wp_reset_postdata();
  return $rta;
}
