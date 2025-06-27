<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//----------------------------------------------------------------
// SUB LOGICA PARA IMPLEMENTAR EL CATALOGO DE PROYECTOS DE LOS PROFESORES
//----------------------------------------------------------------

/**
 * Registra el tipo Proyecto DISC como un tipo de entrada (custom post type)
 */
add_action('init', 'crear_disc_proyectos');


/**
 * Crea el tipo de post personalizado para manejar proyectos de los profesores, si es red solo lo crea en el sitio principal
 * Crea las taxonomias relacionadas con los proyectos. Categoria de proyecto
 */
function crear_disc_proyectos()
{
    /**
     * Crea el tipo de post para manejar la información de los proyectos
     */
    $crear = creacionMU();
    if($crear)
    {
        register_post_type('disc_proyectos',array(
            'labels' => array(  'name' => 'Proyectos DISC',
                                'singular_name' => 'Proyecto',
                                'menu name' => 'Proyectos',
                                'all_items' => 'Proyectos',
                                'add_new' => 'Nuevo proyecto',
                                'add_new_item' => 'Nuevo proyecto',
                                'edit' => 'Editar',
                                'edit_item' => 'Editar proyecto',
                                'new_item' => 'Nuevo proyecto',
                                'view' => 'Ver',
                                'view_item' => 'Ver proyecto',
                                'search_items' => 'Buscar proyectos',
                                'not_found' => 'No se encontraron proyectos',
                                'not_found_in_trash' => 'No se encontraron proyectos en papelera'
                            ),
            'description' => 'Permite manejar información de un proyecto',
            'public' => true,
            'menu_position' => 5, //Debajo de posts
            'hierarchical'=>false,
            'supports' => array('title','revisions', 'page-attributes', 'thumbnail'), //No soporta el campo de edición para reemplzarlo por los elementos de un proyecto
            'menu_icon' => plugins_url('img'.DIRECTORY_SEPARATOR.'profesores_disc_16x16.png', __FILE__),
            'capability_type'     => array('disc_proyecto','disc_proyectos'),  //Este argumento nos permite pasar "capabilities" de lectura, editar y eliminar a roles que especifiquemos. (Ver archivo disc-prof-proy_permissions-manager.php )
            'capabilities' => array(
                'create_posts' => 'edit_disc_proyectos', // Removes support for the "Add New" function
                ),
            'map_meta_cap'        => true, //Esto anula el manejo de meta "capabilities" predeterminada, por lo que podemos utilizar nuestro propio manejador. Es importante tener en cuenta que al hacer esto elimina la posibilidad de que los administradores o editores puedan editar este tipo de post personalizado hasta que específicamente les concedamos permiso. (Ver archivo disc-prof-proy_permissions-manager.php )
            'has_archive' => false
            )
        );


        //Cateforia para clasificar los tipos de proyectos,
        //Por ejemplo tipo Tesis, Proyecto Integrador u otros Tipos

        register_taxonomy('disc_proyectos_categorias', 'disc_proyectos', array(
            'labels'=>array('name'=>'Categorías',
                                'singular_name'=>'Categoría',
                                'menu_name'=>'Categorías',
                                'all_items'=>'Todas las categorías',
                                'edit_item'=>'Editar categoría',
                                'update_item'=>'Actualizar categoría',
                                'add_new_item'=>'Agregar categoría',
                                'new_item_name'=>'Nueva categoría',
                                'search items'=>'Buscar categoría',
                                'popular_items'=>'Categorías comunes',
                                'choose_from_most_used'=>'Seleccionar de más usados',
                                'not_found'=>'No se encontraron categorías',
                                'parent_item'=>'Categoría padre',
                                'most_used'=>'Más usados'
                               ),
                    'show_tagcloud'=>false,
                    'show_ui'=>true,
                    'hierarchical'=>true,
                    'capabilities' => array (
                        'manage_terms' => 'edit_posts', //by default only 'administrator' and general 'editor'
                        'edit_terms' => 'edit_posts',
                        'delete_terms' => 'edit_posts',
                        'assign_terms' => 'edit_disc_proyectos'  // means 'administrator', 'editor',  and  'disc_proyectos_editor'
                        )
            )
        );

        //Grupos de investigacion, en general,  los mismos que aplican en profesores.

        register_taxonomy('disc_proyectos_grupos', 'disc_proyectos', array(
            'labels'=>array('name'=>'Grupos',
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
                    'hierarchical'=>true,
                    'capabilities' => array (
                        'manage_terms' => 'edit_posts', //by default only 'administrator' and general 'editor'
                        'edit_terms' => 'edit_posts',
                        'delete_terms' => 'edit_posts',
                        'assign_terms' => 'edit_disc_proyectos'  // means 'administrator', 'editor',  and  'disc_proyectos_editor' (ver disc-prof-proy_permissions-manager)
                        )
            )
        );

        //Periodos en los que se trabajo un proyecto

        register_taxonomy('disc_proyectos_periodos', 'disc_proyectos', array(
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
                    'hierarchical'=>true,
                    'capabilities' => array (
                        'manage_terms' => 'edit_posts', //by default only 'administrator' and general 'editor'
                        'edit_terms' => 'edit_posts',
                        'delete_terms' => 'edit_posts',
                        'assign_terms' => 'edit_disc_proyectos'  // means 'administrator', 'editor',  and  'disc_proyectos_editor' (ver disc-prof-proy_permissions-manager)
                        )
              )
        );
    }

}

/**
 *
 * @return \WP_Query
 */
function disc_proyectos_query_all_profesores(){
        $args = array(
            'post_type' => 'disc_profesores',
            'meta_key'=> 'apellido_prof_disc',
            'orderby' => 'meta_value',
            'order' => 'ASC',
        );

        $query = new WP_Query($args);
        return $query;

}

/**
 * Modifica el título de la caja para poner el nombre del proyecto
 * @global String $post_type el tipo del post
 * @param string $input el texto a filtrar
 * @return string el texto fitlrado
 */
function disc_proyectos_titulo($input)
{
    global $post_type;
    if(is_admin() && ('Enter title here' == $input || 'Introduce el título aquí' == $input)&& 'disc_proyectos' == $post_type)
    {
        $input = 'Ingrese el titulo de un nuevo proyecto aquí';
    }
    return $input;
}
add_filter('gettext', 'disc_proyectos_titulo');


//----------------------------------------------------------------------------
// Registra editor (conjuto de metaboxes) para crear/editar un  proyecto
//----------------------------------------------------------------------------


/**
 * Inicializa el editor de proyectos agregando metaboxes para la información específica
 */
add_action('add_meta_boxes', 'disc_proyectos_editor');

/**
 * Crea las metaboxes para ingresar la información del proyecto
 */
function disc_proyectos_editor()
{

    //Script utilizados por los metaboxes editores de un post tipo disc_proyectos.
    wp_enqueue_script('discProfesoresProyetosListJSv1.2.0',plugins_url('js/list.min.js', __FILE__), true, "1.2.0");
    wp_enqueue_script('discProfesoresProyetosCustomJs',plugins_url('js/custom.js', __FILE__), true);

    //Styles utilizados por los metaboxes editores de un post tipo disc_proyectos.
    wp_enqueue_style('admin_profesores_y_proyectos_disc_style',plugins_url('css/custom-admin-style.css', __FILE__), true);

    //Informacion básica del proyecto
    add_meta_box('disc_proyectos_meta_info', 'Información básica del proyecto', 'disc_proyectos_meta_info_func', 'disc_proyectos', 'normal', 'high');

    //Agrega metabox para incluir profesores participantes y seleccionar uno de ellos como lider de proyecto
    // Adicionalmente, estudiantes participantes.
    add_meta_box('disc_proyectos_participantes', 'Participantes en el proyecto', 'disc_proyectos_participantes_func', 'disc_proyectos', 'normal', 'high');

    // Campos creados con editor enriquecido (Metaboxes con editor WP)
    add_meta_box('disc_proyectos_descripcion_general_func', 'Descripción general del proyecto (En Español)', 'disc_proyectos_descripcion_general_func', 'disc_proyectos', 'normal', 'high');

    add_meta_box('disc_proyectos_estado_actual_func', 'Estado actual del proyecto (En Español)', 'disc_proyectos_estado_actual_func', 'disc_proyectos', 'normal', 'high');

    add_meta_box('disc_proyectos_objetivos_func', 'Objetivos del proyecto (En Español)', 'disc_proyectos_objetivos_func', 'disc_proyectos', 'normal', 'high');

    add_meta_box('disc_proyectos_resultados_func', 'Resultados del proyecto (En Español)', 'disc_proyectos_resultados_func', 'disc_proyectos', 'normal', 'high');

    //Campos creados con editor enriquecido para la informacion en INGLÉS (Metaboxes con editor WP)

    add_meta_box('disc_proyectos_descripcion_general_func_en', 'Descripción general del proyecto (En Inglés)', 'disc_proyectos_descripcion_general_func_en', 'disc_proyectos', 'normal', 'high');

    add_meta_box('disc_proyectos_estado_actual_func_en', 'Estado actual del proyecto (En Inglés)', 'disc_proyectos_estado_actual_func_en', 'disc_proyectos', 'normal', 'high');

    add_meta_box('disc_proyectos_objetivos_func_en', 'Objetivos del proyecto (En Inglés)', 'disc_proyectos_objetivos_func_en', 'disc_proyectos', 'normal', 'high');

    add_meta_box('disc_proyectos_resultados_func_en', 'Resultados del proyecto (En Inglés)', 'disc_proyectos_resultados_func_en', 'disc_proyectos', 'normal', 'high');

    if (DiscProfProyUtilidades::DiscProfProyUtilidades_debug_active())
    {
        add_meta_box('disc_proyectos_current_user', 'Usuario Actual', 'disc_proyectos_debug_current_user', 'disc_proyectos', 'normal', 'high');
    }

}


//----------------------------------------------------------------------------
// Implementacion de Metaboxes
//----------------------------------------------------------------------------

/**
 * Inicializa la metabox para ingresar la información general de un proyecto
 * @param WP_Post $proyecto_disc
 */
function disc_proyectos_meta_info_func($proyecto_disc)
{
    $estado_actividad = esc_html(get_post_meta($proyecto_disc->ID, 'estado_actividad_proyecto_disc', true));
    $desc_corta = esc_html(get_post_meta($proyecto_disc->ID, 'desc_corta_proyecto_disc', true));

    $desc_corta_en = esc_html(get_post_meta($proyecto_disc->ID, 'desc_corta_proyecto_disc_en', true));
    ?>
    <div  style="width: 100%">
        <div class="form-field form-required">
            <label class="label" for="estado_actividad_proyecto_disc"><h2>Estado de actividad (Activo/Cerrado)</h2></label>
            <select id="estado_actividad_proyecto_disc" style="margin-left: 20px;" name="estado_actividad_proyecto_disc">
                <?php
                $opciones_estado = array("Activo", "Cerrado");

                    foreach($opciones_estado as $opcion){
                       $is_selected=false;
                       if ($estado_actividad == $opcion) {
                        $is_selected = true;
                        }
                    ?>
                        <option value="<?php echo $opcion ?>" <?php if($is_selected) {echo 'selected'; }?> > <?php echo $opcion; ?></option>
                    <?php }
                ?>
            </select>
            <p class="description">El estado de actividad del proyecto (Activo / Cerrado) </p></br>
        </div>
        <div class="form-field form-required">
            <label class="label" for="desc_corta_proyecto_disc"><h2>Descripción corta (En Español):</h2></label>
            <textarea id="desc_corta_proyecto_disc" maxlength="300" name="desc_corta_proyecto_disc" placeholder="Descripción corta que se usará al publicar el proyecto (En Español)" rows="2"><?php echo $desc_corta; ?></textarea>
            <p class="description"> Una descripción corta del proyecto de máximo 300 carácteres</p>
        </div>
        <div class="form-field form-required">
            <label class="label" for="desc_corta_proyecto_disc_en"><h2>Descripción corta (En Inglés):</h2></label>
            <textarea id="desc_corta_proyecto_disc_en" maxlength="300" name="desc_corta_proyecto_disc_en" placeholder="Descripción corta que se usará al publicar el proyecto (En Inglés)" rows="2"><?php echo $desc_corta_en; ?></textarea>
            <p class="description"> Una descripción corta del proyecto en inglés, de máximo 300 carácteres</p>
        </div>
    </div>
    <?php
}


/**
 * Inicializa la metabox para ingresar la información general de un proyecto
 * @param WP_Post $proyecto_disc
 */
function disc_proyectos_participantes_func($proyecto_disc)
{
    //ID de profesor lider y arreglo de Ids con profesores participantes. (disc_profesores)
    $profesor_lider = get_post_meta($proyecto_disc->ID, 'profesor_lider_proyecto_disc', true);
    $profesores_participantes = get_post_meta($proyecto_disc->ID, 'profesores_participantes_proyecto_disc', true);
    $estudiantes_participantes = get_post_meta($proyecto_disc->ID, 'estudiantes_participantes_proyecto_disc', true);

    DiscProfProyUtilidades::debug_to_echo('IDs profesores participantes (debug)');
    DiscProfProyUtilidades::debug_to_echo_var_dump($profesores_participantes);
    DiscProfProyUtilidades::debug_to_echo('Login estudiantes participantes (debug)');
    DiscProfProyUtilidades::debug_to_echo_var_dump($estudiantes_participantes);
?>
     <div class="div-table">
        <div class="div-table-row">
             <div class="div-table-col">
                 <div id="div_profesor_lider_proyecto_disc" class="form-field form-required">
                    <h3>Lider de proyecto</h3>
                    <p class="description"> Elija un profesor lider de proyecto</p>
                        <select id="profesor_lider_proyecto_disc"
                                style="margin-left: 10px;"
                                name="profesor_lider_proyecto_disc"
                                onselect="testLeaderInParicipants()"
                                onchange="testLeaderInParicipants()">
                        <option value="-1" > <?php echo "No seleccionado"; ?></option>

                    <?php

                    $the_query = disc_proyectos_query_all_profesores();


                    if ($the_query->have_posts()) :
                        while ($the_query->have_posts()) :
                            $the_query->the_post();
                            $id_profesor = get_the_ID();

                            $username = get_the_title();
                            $nombre = get_post_meta($id_profesor, 'nombre_mostrar', true);
                            $representacion = $nombre .' ('.$username.') ';

                            $is_selected = false;
                            if ($profesor_lider == $id_profesor)
                            {
                                $is_selected=true;
                            }

                            ?>

                        <option value="<?php echo $id_profesor ?>" <?php echo $is_selected?'selected':''; ?> > <?php echo $representacion; ?></option>
                    <?php endwhile; ?>
                    <?php endif;?>
                    <?php
                    /* Restore original Post Data
                    * NB: Because we are using new WP_Query we aren't stomping on the
                    * original $wp_query and it does not need to be reset with
                    * wp_reset_query(). We just need to set the post data back up with
                    * wp_reset_postdata().
                    */
                    wp_reset_postdata();
                    ?>
                        </select>
                </div>
            </div>

            <div class="div-table-col">
                <div class="form-field form-required">
                    <h3>Agregar profesores:</h3>
                    <p class="description">Seleccione de la siguiente lista de profesores, los que participan en el proyecto <b>(Están ordenados por apellido)</b></p>
                    <p id="lider-test" style="display: none; color: maroon" class="description">Desc</p>
                    <div id="profesores_list">
                        <div >
                            <div style="margin: 20px 0px;">
                                <div><h4 style="text-align: center;">Buscar para Agregar/Quitar: </h4></div>
                                <div style="display: table; width: 100%;">
                                    <div style="display: table-cell;"><input type="text" id="search-field-participantes" class="search form-control"  placeholder="Nombre o usuario de correo"></div>
                                    <div  style="display: table-cell; width: 90px;"><button id="clear-search-text" type="button" style="font-size: smaller">Limpiar texto</button></div>
                                </div>
                            </div>
                        </div>
                        <ul class="list" style="list-style-type:none; padding: 0px; overflow-y: auto; max-height: 500px;">
                    <?php
                    if ($the_query->have_posts()) :
                        while ($the_query->have_posts()) :
                            $the_query->the_post();
                            $id_profesor = get_the_ID();

                            $username = get_the_title();
                            $nombre = get_post_meta($id_profesor, 'nombre_mostrar', true);
                            $representacion = $nombre .' ('.$username.') ';

                            $is_participante = false;
                            if (in_array($id_profesor, $profesores_participantes))
                            {
                                $is_participante=true;
                            }

                            ?>
                    <li>
                        <div class="checkbox">
                            <label class="label_profesor"><input type="checkbox" <?php echo $is_participante? 'checked':''; ?>
                                          id="checkbox_profesor_<?php echo $id_profesor ?>"
                                          onchange="onCheckedChangeListParticipantes()"
                                          name="profesores_participantes_proyecto_disc[]"
                                          value="<?php echo $id_profesor ?>"/><?php echo $representacion ?></label>
                        </div>
                    </li>
                    <?php endwhile; ?>
                    </ul>
                    </div>
                    <?php endif;?>
                    <?php
                    /* Restore original Post Data
                    * NB: Because we are using new WP_Query we aren't stomping on the
                    * original $wp_query and it does not need to be reset with
                    * wp_reset_query(). We just need to set the post data back up with
                    * wp_reset_postdata().
                    */
                    wp_reset_postdata();
                    ?>
                   </div>
                </div>
            </div>

          <hr>

            <div class="div-table-row">
              <div class="div-table-col">
                <div class="form-field form-required">
                  <h3>Agregar estudiantes:</h3>
                  <div class="form-field">
                      <p class="description">Login de los estudiantes separados por comas</p></br>
                      <input id="estudiantes_participantes_proyecto_disc" type="text" maxlength="80" placeholder="Login" name="estudiantes_participantes_proyecto_disc" value="<?php echo $estudiantes_participantes; ?>"/>
                  </div>
                </div>
              </div>
              <div class="div-table-col">
                <div class="form-field form-required">
                  <h3>Listado de estudiantes:</h3>
                  <div>
                    <?php $estudiantes_participantes = explode(",",$estudiantes_participantes);
                          $estudiantes_participantes2 = array(array('username' => $estudiantes_participantes[0], 'display_name' => 'Oscar Kiyo' ), array('username' => $estudiantes_participantes[1], 'display_name' => 'Oscar Kiyo 2' ));
                    ?>
                    <?php foreach ($estudiantes_participantes2 as $estudiante): ?>

                      <div class="checkbox">
                          <label class="label_estudiante"><input type="checkbox" id="checkbox_estudiante_<?php echo $estudiante['username']?>"
                                        name="estudiantes_participantes_proyecto_disc[]"
                                        value="<?php echo $estudiante['username'] ?>"/><?php echo $estudiante['display_name'] ?></label>
                      </div>
                    <?php endforeach;?>
                  </div>
                </div>
              </div>
            </div>
         </div>
<script>

    var profesoresList = functionListProfesoresParticipantes();
    <?php if(!empty($profesor_lider)){
    ?>
    var id_profesor_lider_temp = <?php echo $profesor_lider ?>;
    <?php } else{?>
    var id_profesor_lider_temp = -1;
    <?php }
    ?>

    function onCheckedChangeListParticipantes(){
        testLeaderInParicipants();
        resetListProfesoresParticipantes();
    }
    /**
     * Valida que el lider de proyecto sea agregado como participante del proyecto.
     * De no estar agregado despliega un mensaje al usuario
     * @returns {undefined}
     */
    function testLeaderInParicipants() {
        var selectLider = document.getElementById("profesor_lider_proyecto_disc");
        var valueSelected = selectLider.options[selectLider.selectedIndex].value;
        var textSelected = selectLider.options[selectLider.selectedIndex].text;

        console.log('Lider:'+textSelected+' = '+valueSelected);

        //este codigo comentado no sirvió, el formulario de wordpress no identifica los checks agregados por js y no persisten.
        /**
        var oldLider = id_profesor_lider_temp;
        id_profesor_lider_temp = valueSelected;

        //Actualiza nuevo lider en lista de checkbox (lo deja checkeado sin posibilidad de desabilidtar)
        var checkboxProfesor = document.getElementById("checkbox_profesor_"+id_profesor_lider_temp);
        checkboxProfesor.checked = true;
        checkboxProfesor.disabled = true;

        //Habilita el anterior profesor que era lider para hacer check o uncheck
        if(oldLider!==-1)
        {
            var checkboxProfesorOLD = document.getElementById("checkbox_profesor_"+oldLider);
            checkboxProfesorOLD.disabled = false;
        }*/

        //En remplazo se  hizo este codigo para poner un mensaje de alerta al usuario y que este agregue el lider a profesoser participantes:
        var oldLider = id_profesor_lider_temp;
        id_profesor_lider_temp = valueSelected;

        var descProfesor = document.getElementById("lider-test");

        if (id_profesor_lider_temp.toString()!== "-1")
        {
            var checkboxProfesor = document.getElementById("checkbox_profesor_" + id_profesor_lider_temp);
            //Diferente de null quiere decir que aparece en la lista de filtrado, y diferente de false es que esta seleccionado.
            if( checkboxProfesor!==null && checkboxProfesor.checked===false){
            descProfesor.innerHTML = "*Debe agregar al lider <b>" + textSelected+ "</b> a profesores participantes";
            descProfesor.style.display = 'block';
            }
            else
            {
                descProfesor.text = "DESC";
                descProfesor.style.display = 'none';
            }
        }
        else
        {
             descProfesor.innerHTML = "<b>*Debe seleccionar un lider de proyecto</b>";
             descProfesor.style.display = 'block';
        }

    }

    /**
     * Filtra la lista de profesores para agregarlos mas facilmente.
     * @returns {undefined}
     */
    function functionListProfesoresParticipantes(){

        var options = {
          valueNames: [ 'label_profesor' ]
        };

        var profesoresList = new List('profesores_list', options);

        jQuery('#clear-search-text').click(function() {
            jQuery('#search-field-participantes').val('');
            profesoresList.search();
        });

        return profesoresList;

    }

    function resetListProfesoresParticipantes(){
        jQuery('#search-field-participantes').val('');
        profesoresList.search();
    }

    addOnloadEvent(functionListProfesoresParticipantes());
    addOnloadEvent(testLeaderInParicipants());

</script>
    <?php
}


/**
 * Inicializa la metabox para ingresar la descripcion general de un proyecto disc
 * @param WP_Post $proyecto_disc
 */
function disc_proyectos_descripcion_general_func($proyecto_disc)
{
    $descripcion_general_proyecto_disc = get_post_meta($proyecto_disc->ID, 'descripcion_general_proyecto_disc', true);
    ?>
    <div  style="width: 100%">

        <div class="form-field form-required">
            <p>Se recomienda utilizar a lo sumo 3 parrafos descriptivos del proyecto</p>
            <?php
                wp_editor($descripcion_general_proyecto_disc, 'descripcion_general_proyecto_disc', array( 'textarea_rows' => 10, 'editor_class' => 'at-wysiwyg' ))
            ?>
        </div>
    </div>
    <?php
}


/**
 * Inicializa la metabox para ingresar la descripcion general de un proyecto disc EN INGLÉS
 * @param WP_Post $proyecto_disc
 */
function disc_proyectos_descripcion_general_func_en($proyecto_disc)
{
    $descripcion_general_proyecto_disc_en = get_post_meta($proyecto_disc->ID, 'descripcion_general_proyecto_disc_en', true);
    ?>
    <div  style="width: 100%">

        <div class="form-field form-required">
            <p>Se recomienda utilizar a lo sumo 3 parrafos descriptivos del proyecto</p>
            <?php
                wp_editor($descripcion_general_proyecto_disc_en, 'descripcion_general_proyecto_disc_en', array( 'textarea_rows' => 10, 'editor_class' => 'at-wysiwyg' ))
            ?>
        </div>
    </div>
    <?php
}

/**
 * Inicializa la metabox para ingresar una descripcion del estado actual de un proyecto disc
 * @param WP_Post $proyecto_disc
 */
function disc_proyectos_estado_actual_func($proyecto_disc)
{
    $estado_actual_proyecto_disc = get_post_meta($proyecto_disc->ID, 'estado_actual_proyecto_disc', true);
    ?>
    <div  style="width: 100%">

        <div class="form-field form-required">
            <p>Se recomienda utilizar a lo sumo 3 parrafos que describan el estado actual del proyecto</p>
            <?php
                wp_editor($estado_actual_proyecto_disc, 'estado_actual_proyecto_disc', array( 'textarea_rows' => 10, 'editor_class' => 'at-wysiwyg' ))
            ?>
        </div>
    </div>
    <?php
}

/**
 * Inicializa la metabox para ingresar una descripcion del estado actual de un proyecto disc EN INGLÉS
 * @param WP_Post $proyecto_disc
 */
function disc_proyectos_estado_actual_func_en($proyecto_disc)
{
    $estado_actual_proyecto_disc_en = get_post_meta($proyecto_disc->ID, 'estado_actual_proyecto_disc_en', true);
    ?>
    <div  style="width: 100%">

        <div class="form-field form-required">
            <p>Se recomienda utilizar a lo sumo 3 parrafos que describan el estado actual del proyecto</p>
            <?php
                wp_editor($estado_actual_proyecto_disc_en, 'estado_actual_proyecto_disc_en', array( 'textarea_rows' => 10, 'editor_class' => 'at-wysiwyg' ))
            ?>
        </div>
    </div>
    <?php
}


/**
 * Inicializa la metabox para ingresar los objetivos propuestos de un proyecto disc
 * @param WP_Post $proyecto_disc
 */
function disc_proyectos_objetivos_func($proyecto_disc)
{
    $objetivos_proyecto_disc = get_post_meta($proyecto_disc->ID, 'objetivos_proyecto_disc', true);
    ?>
    <div  style="width: 100%">

        <div class="form-field form-required">
            <p>Se recomienda usar una lista de elementos (objetivos) </p>
            <?php
                wp_editor($objetivos_proyecto_disc, 'objetivos_proyecto_disc', array( 'textarea_rows' => 10, 'editor_class' => 'at-wysiwyg' ))
            ?>
        </div>
    </div>
    <?php
}


/**
 * Inicializa la metabox para ingresar los objetivos propuestos de un proyecto disc EN INGLÉS
 * @param WP_Post $proyecto_disc
 */
function disc_proyectos_objetivos_func_en($proyecto_disc)
{
    $objetivos_proyecto_disc_en = get_post_meta($proyecto_disc->ID, 'objetivos_proyecto_disc_en', true);
    ?>
    <div  style="width: 100%">

        <div class="form-field form-required">
            <p>Se recomienda usar una lista de elementos (objetivos) </p>
            <?php
                wp_editor($objetivos_proyecto_disc_en, 'objetivos_proyecto_disc_en', array( 'textarea_rows' => 10, 'editor_class' => 'at-wysiwyg' ))
            ?>
        </div>
    </div>
    <?php
}


/**
 * Inicializa la metabox para ingresar los resultados esperados de un proyecto disc
 * @param WP_Post $proyecto_disc
 */
function disc_proyectos_resultados_func($proyecto_disc)
{
    $resultados_proyecto_disc = get_post_meta($proyecto_disc->ID, 'resultados_proyecto_disc', true);
    ?>
    <div  style="width: 100%">

        <div class="form-field form-required">
            <p>Se recomienda utilizar un par de parrafos descriptivos o una lista de elelmentos</p>
            <?php
                wp_editor($resultados_proyecto_disc, 'resultados_proyecto_disc', array( 'textarea_rows' => 10, 'editor_class' => 'at-wysiwyg' ))
            ?>
        </div>
    </div>
    <?php
}


/**
 * Inicializa la metabox para ingresar los resultados esperados de un proyecto disc EN INGLÉS
 * @param WP_Post $proyecto_disc
 */
function disc_proyectos_resultados_func_en($proyecto_disc)
{
    $resultados_proyecto_disc_en = get_post_meta($proyecto_disc->ID, 'resultados_proyecto_disc_en', true);
    ?>
    <div  style="width: 100%">

        <div class="form-field form-required">
            <p>Se recomienda utilizar un par de parrafos descriptivos o una lista de elelmentos</p>
            <?php
                wp_editor($resultados_proyecto_disc_en, 'resultados_proyecto_disc_en', array( 'textarea_rows' => 10, 'editor_class' => 'at-wysiwyg' ))
            ?>
        </div>
    </div>
    <?php
}


/**
 * Agrega la acción para que se guarde la nueva metadata de un proyecto
 */
add_action('save_post', 'disc_proyectos_guardar', 10, 2);

/**
 * Guarda la información del proyecto
 * @param int $proyecto_id
 * @param WP_Post $nuevo_proyecto
 */
function disc_proyectos_guardar($proyecto_id, $nuevo_proyecto)
{
    DiscProfProyUtilidades::debug_to_console("Guardar post disc_proyectos_guardar llamado, ID generado = " . $proyecto_id);

    if($nuevo_proyecto->post_type == 'disc_proyectos')
    {

        if (disc_proyectos_validate_permissions_current_user($proyecto_id))
        {
            DiscProfProyUtilidades::debug_to_console("Entro a disc_proyectos_guardar y SI está autorizado");
            $current_user = wp_get_current_user();
            DiscProfProyUtilidades::show_info_notice('Buen dia '. $current_user->display_name, "Editor de proyecto autorizado");


            //Datos Básicos
            if(isset($_POST['estado_actividad_proyecto_disc']) && $_POST['estado_actividad_proyecto_disc'] != '')
            {
                update_post_meta($proyecto_id, 'estado_actividad_proyecto_disc', $_POST['estado_actividad_proyecto_disc']);
            }
            if(isset($_POST['desc_corta_proyecto_disc']) && $_POST['desc_corta_proyecto_disc'] != '')
            {
                update_post_meta($proyecto_id, 'desc_corta_proyecto_disc', $_POST['desc_corta_proyecto_disc']);
            }
            //Datos Básicos que aplican en INGLÉS
            if(isset($_POST['desc_corta_proyecto_disc_en']) && $_POST['desc_corta_proyecto_disc_en'] != '')
            {
                update_post_meta($proyecto_id, 'desc_corta_proyecto_disc_en', $_POST['desc_corta_proyecto_disc_en']);
            }

            //Metabox profesores y estudiantes paticipantes
            if(isset($_POST['profesor_lider_proyecto_disc']) && $_POST['profesor_lider_proyecto_disc'] != '')
            {
                update_post_meta($proyecto_id, 'profesor_lider_proyecto_disc', $_POST['profesor_lider_proyecto_disc']);
            }
            if(isset($_POST['profesores_participantes_proyecto_disc']) && $_POST['profesores_participantes_proyecto_disc'] != '')
            {
                $profesores_participantes = $_POST['profesores_participantes_proyecto_disc'];
                update_post_meta($proyecto_id, 'profesores_participantes_proyecto_disc', $profesores_participantes);
            }
            if(isset($_POST['estudiantes_participantes_proyecto_disc']) && $_POST['estudiantes_participantes_proyecto_disc'] != '')
            {
              update_post_meta($proyecto_id,'estudiantes_participantes_proyecto_disc', $_POST['estudiantes_participantes_proyecto_disc']);

            }

            //Metaboxes con editor para informacion del proyecto
            if(isset($_POST['descripcion_general_proyecto_disc']) && $_POST['descripcion_general_proyecto_disc'] != '')
            {
                update_post_meta($proyecto_id, 'descripcion_general_proyecto_disc', $_POST['descripcion_general_proyecto_disc']);
            }
            if(isset($_POST['estado_actual_proyecto_disc']) && $_POST['estado_actual_proyecto_disc'] != '')
            {
                update_post_meta($proyecto_id, 'estado_actual_proyecto_disc', $_POST['estado_actual_proyecto_disc']);
            }
            if(isset($_POST['objetivos_proyecto_disc']) && $_POST['objetivos_proyecto_disc'] != '')
            {
                update_post_meta($proyecto_id, 'objetivos_proyecto_disc', $_POST['objetivos_proyecto_disc']);
            }
            if(isset($_POST['resultados_proyecto_disc']) && $_POST['resultados_proyecto_disc'] != '')
            {
                update_post_meta($proyecto_id, 'resultados_proyecto_disc', $_POST['resultados_proyecto_disc']);
            }

            //Metaboxes con editor para informacion del proyecto en INGLÉS
            if(isset($_POST['descripcion_general_proyecto_disc_en']) && $_POST['descripcion_general_proyecto_disc_en'] != '')
            {
                update_post_meta($proyecto_id, 'descripcion_general_proyecto_disc_en', $_POST['descripcion_general_proyecto_disc_en']);
            }
            if(isset($_POST['estado_actual_proyecto_disc_en']) && $_POST['estado_actual_proyecto_disc_en'] != '')
            {
                update_post_meta($proyecto_id, 'estado_actual_proyecto_disc_en', $_POST['estado_actual_proyecto_disc_en']);
            }
            if(isset($_POST['objetivos_proyecto_disc_en']) && $_POST['objetivos_proyecto_disc_en'] != '')
            {
                update_post_meta($proyecto_id, 'objetivos_proyecto_disc_en', $_POST['objetivos_proyecto_disc_en']);
            }
            if(isset($_POST['resultados_proyecto_disc_en']) && $_POST['resultados_proyecto_disc_en'] != '')
            {
                update_post_meta($proyecto_id, 'resultados_proyecto_disc_en', $_POST['resultados_proyecto_disc_en']);
            }

        }
        else{
            DiscProfProyUtilidades::debug_to_console("Entro a disc_proyectos_guardar pero NO está autorizado, Intentó guardar pero no se guardan cambios");

            DiscProfProyUtilidades::show_error_notice( 'Permisos Insuficientes', 'NO se guardaron los cambios');

            $titutlo = 'El usuario ' . $current_user->display_name . ' NO está autorizado para editar este proyecto';
            $mensaje = 'Solo el lider de proyecto o el asistente asignado pueden editar un proyecto.';

            DiscProfProyUtilidades::show_error_notice_not_dismissible($titutlo, $mensaje);

            return false;
        }
    }
}

// run the action
//do_action( 'pre_post_update', $post_id, $data );

// define the pre_post_update callback
function disc_proyectos_validate_pre_update($proyecto_id, $data) {

    DiscProfProyUtilidades::debug_to_console('Validando permisos PRE actualizacion' . $proyecto_id);

    global $pagenow;
    if (( $pagenow == 'post.php' ) && (get_post_type() == 'disc_proyectos')) {
        $current_user = wp_get_current_user();

        $titulo = 'Permisos insuficientes del usuario para editar este proyecto' . $current_user->display_name;
        $mensaje = 'Los cambios NO fueron guardados.';
        DiscProfProyUtilidades::show_error_notice($titulo, $mensaje);
    }
}

// add the action
//add_action( 'pre_post_update', 'disc_proyectos_validate_pre_update', 10, 2 );
//add_action( 'pre_post_update', 'disc_proyectos_validate_pre_update' );
//add_action( 'edit_post', 'disc_proyectos_validate_pre_update' );
//add_action( 'post_updated ', 'disc_proyectos_validate_pre_update' );

/**
 * Metodo que valida en la pagina de edicion de un proyecto si el usuario actual puede editar dicho proyecto.
 * Muestra un aviso informativo o de error al usuario dependiendo de Si tiene o No tiene permisos de edicion, respectivamente.
 * @global type $pagenow
 */
function disc_proyectos_show_admin_notice_permissions_current_user_error() {

    DiscProfProyUtilidades::debug_to_console('Validando permisos para presentar notice si se requiere');

    global $pagenow;
    if (( $pagenow == 'post.php' ) && (get_post_type() == 'disc_proyectos')) {

    // something is editing a page
    DiscProfProyUtilidades::debug_to_echo_with_code_box('Post Type= '. get_post_type() . ', GET params ='.  json_encode($_GET));
    DiscProfProyUtilidades::debug_to_echo('Actual Post ID =' . get_the_ID());

    $id_proyecto = get_the_ID();
    $autorizado = disc_proyectos_validate_permissions_current_user($id_proyecto);
    $current_user = wp_get_current_user();

    if  ($autorizado)
    {
        DiscProfProyUtilidades::show_info_notice('Buen dia '. $current_user->display_name, "Editor de proyecto autorizado");
    }
    else
    {
        $titutlo = 'El usuario ' . $current_user->display_name . ' NO está autorizado para editar este proyecto';
        $mensaje = 'Solo el lider de proyecto o el asistente asignado pueden editar un proyecto.';

        DiscProfProyUtilidades::show_error_notice_not_dismissible($titutlo, $mensaje);
    }

    }
}
add_action( 'admin_notices', 'disc_proyectos_show_admin_notice_permissions_current_user_error' );


/**
 *
 */
function disc_proyectos_debug_current_user(){

    $current_user = wp_get_current_user();
    /**
     * @example Safe usage: $current_user = wp_get_current_user();
     * if ( !($current_user instanceof WP_User) )
     *     return;
     */
    DiscProfProyUtilidades::debug_to_echo('Debug variables: <br />');
    DiscProfProyUtilidades::debug_to_echo('Username: ' . $current_user->user_login . '<br />');
    DiscProfProyUtilidades::debug_to_echo( 'User email: ' . $current_user->user_email . '<br />');
    DiscProfProyUtilidades::debug_to_echo( 'User first name: ' . $current_user->user_firstname . '<br />');
    DiscProfProyUtilidades::debug_to_echo( 'User last name: ' . $current_user->user_lastname . '<br />');
    DiscProfProyUtilidades::debug_to_echo( 'User display name: ' . $current_user->display_name . '<br />');
    DiscProfProyUtilidades::debug_to_echo( 'User ID: ' . $current_user->ID . '<br />');
    DiscProfProyUtilidades::debug_to_echo( 'User Level: ' .  esc_attr($current_user->user_level) . '<br />');

}

//Filter para agregar templates de single y archive.
add_filter('template_include', 'template_disc_proyectos', 1);

/**
 * Template para visualizar:
 * Un solo proyecto con todos sus campos/caracteristicas(Single) o
 * Multiples proyectos cuando se hacen busquedas por campos (Archive)
 *
*/
function template_disc_proyectos($ruta_template)
{
    if(get_post_type() == 'disc_proyectos')
    {
        if(is_single())
        {
            if($proyecto_en_tema = locate_template(array('single-disc_proyectos.php')))
            {
                $ruta_template = $proyecto_en_tema;
            }
            else
            {
                $ruta_template = plugin_dir_path(__FILE__).'/single-disc_proyectos.php';
            }
        }
        else if(is_archive())
        {
            if($proyecto_en_tema = locate_template(array('archive-disc_proyectos.php')))
            {
                $ruta_template = $proyecto_en_tema;
            }
            else
            {
                $ruta_template = plugin_dir_path(__FILE__).'/archive-disc_proyectos.php';
            }
        }
    }
    return $ruta_template;
}

add_shortcode('multiples-proyectos-disc', 'shortcode_multiples_proyectos_disc');

/**
 * Logica para el shortcode [multiples-proyectos-disc ...atts...] donde atts son un conjunto de tuplas
 * llave='valor' para filtrar los proyectos a presentar.
 * Dentro de las tuplas se encuentra el profesor. Este método sirve para mostrar los proyectos de un determinado profesor.
 * TODO: Sólo está filtrando si el profesor es líder. No dentro de los participantes
 * @param type $atts "arreglo" de atributos obtenidos de la declaracion del shortcode [multiples-proyectos-disc ...]
 */
function shortcode_multiples_proyectos_disc($atts)
{
    $array_atributos = shortcode_atts(array(
      'grupo' =>'',
      'categoria'=>'',
      'periodo' => '',
      'estado'=>'',
      'profesor'=>''
    ), $atts);
    extract($array_atributos);

    $con_filtro = $profesor ? false : true;

    DiscProfProyUtilidades::debug_to_echo($array_atributos);

    $idActual = get_current_blog_id();
    irASitioPrinicipal();

    //Arreglo de parametros para filtrar y organizar la busqueda de disc_proyectos
    //de acuerdo a los atributos obtenidos en el shortcode.
    $params = array('post_type' => 'disc_proyectos',);

    //Filtro para la busqueda
    if($grupo && $grupo != '')
    {
         $params['disc_proyectos_grupos'] = $grupo;
    }
    if($categoria && $categoria != '')
    {
         $params['disc_proyectos_categorias'] = $categoria;
    }
    if($periodo && $periodo != '')
    {
         $params['disc_proyectos_periodos'] = $periodo;
    }
    if($estado && $estado != '')
    {
        $params['meta_key'] = 'estado_actividad_proyecto_disc';
        $params['meta_value'] = $estado;

    }
    if($profesor && $profesor != '')
    {
      $wp_profesor = dar_profesor_por_usuario($profesor);
      $params['meta_key'] = 'profesor_lider_proyecto_disc';
      $params['meta_value'] = $wp_profesor ? $wp_profesor->ID : 'none';
    }

    //Otros parametros de la busqueda.
    $params['orderby'] ='title';
    $params['order'] ='ASC';

    $query = new WP_Query($params);

    disc_proyectos_pintarMultiplesProyectos($query, $con_filtro);

    /* Restore original Post Data
     * NB: Because we are using new WP_Query we aren't stomping on the
     * original $wp_query and it does not need to be reset with
     * wp_reset_query(). We just need to set the post data back up with
     * wp_reset_postdata().
     */
    wp_reset_postdata();
    volverAOriginal($idActual);
}
