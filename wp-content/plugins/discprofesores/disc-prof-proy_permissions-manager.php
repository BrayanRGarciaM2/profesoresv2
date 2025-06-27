<?php

/*
 * Funciones encargadas de manejar los permisos de los usuarios sobre este plugin,
 * asigna quien puede:
 * 
 * 1) Hacer opeacciones (crud y otras capabilities en wp) 
 * sobre el custom post type dis_profesores.
 * 2) Hacer opeacciones (crud y otras capabilities en wp)
 *  sobre el custom post type disc_proyectos.
 * 
 *  */

//------------------------------------------------------------------------------------
// Gestion de roles para disc_proyectos
//------------------------------------------------------------------------------------


/**
 * Agrega el rol de editor de proyectos. Todo lider de un proyecto sera
 * editor de sus propios proyectos.
 */
function disc_proyectos_add_project_editor_role() {
    add_role('disc_proyectos_editor', 'Editor Proyectos', array(
        'read' => true,
        'edit_posts' => false,
        'delete_posts' => false,
        'publish_posts' => false,
        'upload_files' => true,
            )
    );
}

//Hook para agregar un rol al activar el plugin.
register_activation_hook(DISC_PROFESORES_Y_PROYECTOS_HOME_FILE, 'disc_proyectos_add_project_editor_role');

/**
 * Funcion que agrega capacidades para 'disc_proyectos_editor', 'editor', 'administrator' sobre post disc_proyectos.
 */
function  disc_proyectos_add_role_caps() {

    // Agrega los roles en este array, para agregar capabilities de administracion al custom post type disc_proyectos.
    $roles = array('disc_proyectos_editor', 'editor', 'administrator');

    // Itera sobre cada rol y les asigna las "capabilities" asociadas al custom post type desado.
    foreach ($roles as $the_role) {

        $role = get_role($the_role);

        $role->add_cap('read');
        $role->add_cap('read_disc_proyecto');
        $role->add_cap('read_private_disc_proyectos');
        $role->add_cap('edit_disc_proyecto');
        $role->add_cap('edit_disc_proyectos');
        $role->add_cap('edit_others_disc_proyectos');
        $role->add_cap('edit_private_disc_proyectos');
        $role->add_cap('edit_published_disc_proyectos');
        if($the_role=='editor' || $the_role =='administrator')
        {
            $role->add_cap('publish_disc_proyectos');
        }
        else
        {
            $role->remove_cap('publish_disc_proyectos');
        }
        $role->add_cap('delete_disc_proyectos');
        $role->add_cap('delete_others_disc_proyectos');
        $role->add_cap('delete_private_disc_proyectos');
        $role->add_cap('delete_published_disc_proyectos');
        
    }
}

// Agrega capabilities al role creado, con el que se manejan los disc_proyectos y a los roles superiores (editor y administrador)
add_action('admin_init', 'disc_proyectos_add_role_caps', 999);

function disc_proyectos_is_administrator(){
    return disc_proyectos_validar_rol_usuario()==4;
}

function disc_proyectos_is_general_editor(){
    return disc_proyectos_validar_rol_usuario()==3;
}

function disc_proyectos_is_project_editor(){
    return disc_proyectos_validar_rol_usuario()==2;
}

/**
 * Metodo que valida si un usuario tiene permisos para CREAR un post de tipo disc_proyetos. 
 * @return type
 */
function disc_proyectos_user_can_create_posts(){
    return disc_proyectos_validar_rol_usuario() >= 3;
}

/**
 * Metodo que valida si un usuario tiene permisos para EDITAR un post de tipo disc_proyetos. 
 * @param type $proyecto_id
 * @return boolean
 */
function disc_proyectos_validate_permissions_current_user($proyecto_id){
    
    $current_user = wp_get_current_user();
    $autorizado = false;
    $id_profesor_lider = get_post_meta($proyecto_id, 'profesor_lider_proyecto_disc', true);
    $post_profesor_lider = get_post($id_profesor_lider);
    $username_profesor = $post_profesor_lider->post_title;
    
    DiscProfProyUtilidades::debug_to_console("Validando autorizacion del usuario...");
    if (disc_proyectos_is_administrator() || disc_proyectos_is_general_editor())
    {
        DiscProfProyUtilidades::debug_to_console("Es admin o editor general");
        $autorizado=true;
    }
    else if (disc_proyectos_is_project_editor() && $username_profesor == $current_user->user_login )
    {
        DiscProfProyUtilidades::debug_to_console("Es editor de proyecto y lider");
        $autorizado=true;
    }
    DiscProfProyUtilidades::debug_to_console($autorizado?'Es un usuario Autorizado':'Es un usuario NO Autorizado');
    return $autorizado;
}

/**
 * Verifica si un usuario puede resrvar y retorna un codigo asi:
 * 0 = Si el usuario no esta autenticado
 * 1 = Si el usuario esta autenticado, pero no tiene los permisos necesarios para realizar reservas. (Colaborador, author o suscriptor)
 * 2 = Si el usuario esta autenticado, y es un usuario 'disc_proyectos_editor' --> Puede solo puede editar proyectos donde es lider o asistente editor.
 * 3 = Si el usuario esta autenticado, y es un usuario Editor                   --> Puede editar cualquier post o custom post y sus derivados
 * 4 = Si el usuario esta autenticado, y es un usuario Administrador            --> Puede editar cualquier post o custom post y sus derivados. Ademas de asignar roles de 'disc_proyectos_editor' y crear proyetos.
 * @return int codigo de autorizacion o no
 */
function  disc_proyectos_validar_rol_usuario() {

    $rta = 1;

    if (!is_user_logged_in()) {
        $rta = 0;
        return $rta;
    } else {
        global $current_user;
        get_currentuserinfo();
        $usuario = esc_attr($current_user->user_level);
        if ($usuario == 10) {
            // Contenido para los usuarios cuyo nivel sea 10, es decir, administradores:
            $rta = 4;
        } elseif ($usuario == 7) {
            // Contenido para los usuarios cuyo nivel sea 7, es decir, editores:
            $rta = 3;
        } elseif (current_user_can('disc_proyectos_editor')) {
            // Contenido para los usuarios cuyo rol sea disc_proyectos_editor, es decir, Editores de Proyecto:
            $rta = 2;
        }
        return $rta;
    }

    return $rta;
}

//------------------------------------------------------------------------------------
// Validación de permisos para CREAR post disc_proyectos (sólo administradores y editores generales)
//------------------------------------------------------------------------------------

/**
 * Ocultar submenu  para agrgar un nuevo disc_proyecto en usuarios que NO son administradores o editores generales.
 * (Oculta el submenu del menu lateral de administracion)
 */
function disc_proyectos_disable_new_post_menu_for_unauthorized() {
    
    DiscProfProyUtilidades::debug_to_console('disc_proyectos_disable_new_post_menu_for_unauthorized');
    if( !disc_proyectos_user_can_create_posts() ){  
    // Hide sidebar link
    //global $submenu;
    //print_r($submenu);
    //$submenu['edit.php?post_type=disc_proyectos'][10] = array();
    remove_submenu_page( 
    'edit.php?post_type=disc_proyectos',
    'post-new.php?post_type=disc_proyectos'
    );
    }
}

add_action("admin_init", 'disc_proyectos_disable_new_post_menu_for_unauthorized' );

/**
 * Redirecciona peticiones a agregar nuevo disc_pryecto a la pagina de edicion 
 * (evita que disc_project_editors puedan crear proyectos poniendo la url directa)
 */
function disc_proyectos_block_create_post_link_for_project_editors()
{
    if(isset($_GET['post_type']) && $_GET["post_type"] == "disc_proyectos" && !disc_proyectos_user_can_create_posts() ){     
        wp_redirect("edit.php?post_type=disc_proyectos");
    }
}

add_action("load-post-new.php", 'disc_proyectos_block_create_post_link_for_project_editors', 1);

/**
 * Esconde el boton nuevo post, de la barra superior de administracion, para usuarios que no tienen permisos 
 * de agregar post tipo disc_proyectos
 * 
 */
function disc_proyectos_hide_add_new_post_button() {
    
   DiscProfProyUtilidades::debug_to_console('disc_proyectos_hide_add_new_post_button');
    
   //DiscProfProyUtilidades::debug_to_console(get_post_type());
   //DiscProfProyUtilidades::debug_to_echo('var_dump GET');
   // var_dump($_GET);
    
   // DiscProfProyUtilidades::debug_to_echo('var_dump POST');
   //var_dump($_POST);
    
    if( get_post_type() == "disc_proyectos" && !disc_proyectos_user_can_create_posts() ){     
        DiscProfProyUtilidades::debug_to_console('Escondiendo boton Add New Post');
        echo '<style type="text/css">
            .wrap h1 a.page-title-action{display:none;}
            </style>';
    }
    //Add this to hide admin menu link if disc_proyectos_disable_new_post_menu_for_unauthorized fails
    //#adminmenu ul li a[href*="post-new.php?post_type=disc_proyectos"]{display:none;}

}
add_action('admin_head','disc_proyectos_hide_add_new_post_button');
//add_action('_admin_menu','disc_proyectos_hide_add_new_post_button');

function sample_admin_notice_my_error() {
    $class = 'notice notice-error';
    $message = 'Irks! An error has occurred, ' . 'Post Type= '. get_post_type() . ', GET params ='.  json_encode($_GET);

    printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
}
//add_action( 'admin_notices', 'sample_admin_notice_my_error' );