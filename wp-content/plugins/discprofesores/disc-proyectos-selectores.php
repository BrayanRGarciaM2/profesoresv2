<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Busca por $id_proyecto todas las categorias que tiene asociado dicho proyecto.
 * @global type $wpdb
 * @param type $id_proyecto
 * @return type
 */
function disc_proyectos_darCategorias($id_proyecto)
{
    global $wpdb;
    
    $sql_query = 'SELECT DISTINCT name, tax.term_id AS idCat	'.
             'FROM '.$wpdb->term_relationships.' AS rel,'.
                     $wpdb->term_taxonomy.' AS tax,'.
                     $wpdb->terms.' AS ter '.
             'WHERE tax. taxonomy = "disc_proyectos_categorias" '.
                    'AND rel.object_id = '. $id_proyecto.' '.
                    'AND rel.term_taxonomy_id = tax.term_taxonomy_id '.
                    'AND tax.term_id = ter.term_id ORDER BY tax.count';
    $results = $wpdb->get_results($sql_query);
    return $results;
}

/**
 * Busca por $id_proyecto todos los grupos que tiene asociado dicho proyecto.
 * @global type $wpdb
 * @param type $id_proyecto
 * @return type
 */
function disc_proyectos_darGrupos($id_proyecto)
{
    global $wpdb;
    
    $sql_query = 'SELECT DISTINCT name, description, tax.term_id AS idGrupo	'.
             'FROM '.$wpdb->term_relationships.' AS rel,'.
                     $wpdb->term_taxonomy.' AS tax,'.
                     $wpdb->terms.' AS ter '.
             'WHERE tax. taxonomy = "disc_proyectos_grupos" '.
                    'AND rel.object_id = '. $id_proyecto.' '.
                    'AND rel.term_taxonomy_id = tax.term_taxonomy_id '.
                    'AND tax.term_id = ter.term_id ORDER BY tax.count';
    $results = $wpdb->get_results($sql_query);
    return $results;
}

/**
 * Busca por $id_proyecto todos los periodos que tiene asociado dicho proyecto.
 * @global type $wpdb
 * @param type $id_proyecto
 * @return type
 */
function disc_proyectos_darPeriodos($id_proyecto)
{
    global $wpdb;
    
    $sql_query = 'SELECT DISTINCT name, tax.term_id AS idPeriodo	'.
             'FROM '.$wpdb->term_relationships.' AS rel,'.
                     $wpdb->term_taxonomy.' AS tax,'.
                     $wpdb->terms.' AS ter '.
             'WHERE tax. taxonomy = "disc_proyectos_periodos" '.
                    'AND rel.object_id = '. $id_proyecto.' '.
                    'AND rel.term_taxonomy_id = tax.term_taxonomy_id '.
                    'AND tax.term_id = ter.term_id ORDER BY tax.count';
    $results = $wpdb->get_results($sql_query);
    return $results;
}