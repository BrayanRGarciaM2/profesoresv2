<?php

/*
Plugin Name: DISC consulta de académia
Plugin URI: http://sistemas.uniandes.edu.co
Description: Plugin consultar información desde academia institucional [disc-academia-publicaciones usuario='usuariouniandes'] [disc-academia-doctorandos usuario='usuariouniandes']. Este script carga todos las publicaciones. Mejora necesaria: Lazy load de las publicaciones.
Author: Álvaro Andrés Gómez D'Alleman, Oscar Garcés
Author URI: https://sistemas.uniandes.edu.co/~alvar-go
Version: 2017.03.27
*/
// Variable Global. Array de Tipos
/*$tipos =  array(1=>'Software',
                2=>'Patente y Solicitud de Patente',
                3=>'Otro',
                4=>'Propuesta a Colciencias (o entidades afines)',
                5=>'Intercambio',
                6=>'Evento',
                7=>'Propuesta internacional de investigación',
                8 => '',
                9=>'Artículo',
                10=>'Libro',
                11=>'Capítulo de libro',
                12=>'Capítulo en Memoria',
                13=>'Caso de Estudio',
                14=>'Otra Producción Bibliográfica',
                15=>'Otra Producción Técnica (No patentable)',
                16=>'Obra Literaria (Libro)',
                17=>'Obra Literaria (En antología)',
                18=>'Obra de Arte Escénico',
                19=>'Obra Musical',
                20=>'Proyecto Audiovisual',
                21=>'Obra de Arte',
                22=>'Proyecto de Diseño',
                23=>'Producción de Audio',
                24=>'Curaduría',
                25=>'Producción Periodística',
                26=>'Columna de Opinión',
                27=>'',
                28=>'Tesis');*/
$tipos =  array('SOFTWARE'=>'Software',
                2=>'Patente y Solicitud de Patente',
                3=>'Otro',
                'PROPOSAL'=>'Propuesta a Colciencias (o entidades afines)',
                //5=>'Intercambio',
                'EVENT'=>'Evento',
                7=>'Propuesta internacional de investigación',
                'ARTICLE'=>'Artículo',
                'BOOK'=>'Libro',
                'INBOOK'=>'Capítulo de libro',
                'INPROCEEDING'=>'Capítulo en Memoria',
                13=>'Caso de Estudio',
                14=>'Otra Producción Bibliográfica',
                //15=>'Otra Producción Técnica (No patentable)',
                //16=>'Obra Literaria (Libro)',
                //17=>'Obra Literaria (En antología)',
                //18=>'Obra de Arte Escénico',
                //19=>'Obra Musical',
                //20=>'Proyecto Audiovisual',
                //21=>'Obra de Arte',
                //22=>'Proyecto de Diseño',
                //23=>'Producción de Audio',
                //24=>'Curaduría',
                //25=>'Producción Periodística',
                26=>'Columna de Opinión',
                'THESIS'=>'Tesis');

$profesor = "professors?username=";
$cursos = "courses";
$productos = "products";
$url_consulta_academia = "https://academia.uniandes.edu.co/WebServicesAcademy/api/";
$url_consulta_academia_api = $url_consulta_academia."professors/%1s/%2s";
$estados_publicaciones = array('aceptado' => 'ACCEPTED',
                               'rechazado' =>'REJECTED',
                               'proceso' => 'IN_PROCESS',
                               'todos' => 'TODOS' );

/**
 * Solcita agregar el estilo del plugin
 */
add_action( 'wp_enqueue_scripts', 'disc_academia_public_disc_script');

/**
 * Agrega el estilo del plugin
 */
function disc_academia_public_disc_script()
{
    wp_enqueue_style('discAcademiaPublicStyle',plugins_url('css/style.css', __FILE__), true);
    wp_enqueue_script('discAcademiaScript',plugins_url('js/disc-academia.js', __FILE__), true);
}

// Academia Publicaciones
require_once 'disc-academia-publicaciones-funciones.php';
require_once 'disc-academia-publicaciones-pintores.php';

// Academia Doctorandos
require_once 'disc-academia-doctorandos-funciones.php';
require_once 'disc-academia-doctorandos-pintores.php';
