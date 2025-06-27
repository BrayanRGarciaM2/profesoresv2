<?php

/*
Plugin Name: DISC Catalogo de Profesores y Proyectos
Plugin URI: http://disc.catalogo.uniandes.edu.co
Description: Plugin para manejar la información de los profesores Y proyectos del DISC. Use el shortcode [disc-profesor usuario='loginUniandes' tipo='tipo' imagen='claseImagen' presentacion='presentacion'].El único campo obligatorio es usuario. Tipo={all, general, contacto, social, nombre, nombrem, intereses, cursos, formacion}. Imagen la clase que quiere asignar a la imagen, en caso de no ponerla no se pinta imagen. Prsentacion={tab} solo funciona en caso de tipo='all'. Ejemplo[disc-profesor usuario='mavillam' tipo='all' imagen='img-rounded' presentacion='tab'] Use [todos-profesores-disc periodo='' titulo=''] en el principal para consultar todos. Incluye ES y EN
Author: Álvaro Andrés Gómez D'Alleman - Equipo Websis: Diego Salinas, Oscar Garcés
Version: 2017.06.01
*/


/**
 * DISC_PROFESORES__Y_PROYECTOS_HOME_FILE = <ruta en server>...\wp-content\plugins\discprofesores\disc-profesores.php
 */
define('DISC_PROFESORES_Y_PROYECTOS_HOME_FILE', __FILE__);

/**
 * Registra los scripts del front
 */
function profesores_disc_scripts_and_styles() {

    //Scritps
    wp_enqueue_script('lang_prof_proy_disc_script', plugins_url( 'js/lang_disc_script.js', __FILE__ ) );
    wp_enqueue_script('discProfesoresProyetosCustomJs',plugins_url('js/custom.js', __FILE__), true);
    wp_enqueue_script('discProfesoresProyetosListJSv1.2.0',plugins_url('js/list.min.js', __FILE__), true, "1.2.0");
    //Stryles
  	wp_enqueue_style('profesores_y_proyectos_disc_style',plugins_url('css/style.css', __FILE__), true);
}

add_action( 'wp_enqueue_scripts', 'profesores_disc_scripts_and_styles' );

//----------------------------------------------------------------
//METODOS QUE SE ENCAGAN PRINCIPALMENTE DE LOGICA DEL PLUGIN
//----------------------------------------------------------------

//Clase para acceder al Active Directory. Dependencia
require_once ABSPATH . '/wp-content/plugins/active-directory-integration/ad_ldap/adLDAP.php';

//Catalogo de profesores
require_once 'disc-profesores-funciones.php';
require_once 'disc-profesores-selectores.php';

//Catalogo de proyectos de los profesores
require_once 'disc-proyectos-funciones.php';
require_once 'disc-proyectos-selectores.php';

//Manejador de permisos para operaciones sobre custom post types creados en el plugin
require_once 'disc-prof-proy_permissions-manager.php';

//----------------------------------------------------------------
// METODOS QUE SE ENCARGA PRINCIPALMENTE DE LA PRESENTACION DE LOS DATOS
//----------------------------------------------------------------
//Catalogo de profesores
require_once 'disc-profesores-pintores.php';

//Catalogo de proyectos de los profesores
require_once 'disc-proyectos-pintores.php';

//----------------------------------------------------------------
// CLASE CON LOGICA PARA DEBBUG
//----------------------------------------------------------------
include_once 'class-prof-proy-utilidades.php';
