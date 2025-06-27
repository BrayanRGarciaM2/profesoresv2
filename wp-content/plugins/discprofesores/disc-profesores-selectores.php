<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//----------------------------------------------------------------
//METODOS QUE SE ENCAGAN PRINCIPALMENTE DE LOGICA DE CONSULTA DE DATOS 
//----------------------------------------------------------------

function darCategorias($id_prof)
{
    global $wpdb;
    
    $sql_query = 'SELECT DISTINCT name, tax.term_id AS idCat	'.
             'FROM '.$wpdb->term_relationships.' AS rel,'.
                     $wpdb->term_taxonomy.' AS tax,'.
                     $wpdb->terms.' AS ter '.
             'WHERE tax. taxonomy = "disc_profesores_categorias" '.
                    'AND rel.object_id = '. $id_prof.' '.
                    'AND rel.term_taxonomy_id = tax.term_taxonomy_id '.
                    'AND tax.term_id = ter.term_id ORDER BY tax.count';
    $results = $wpdb->get_results($sql_query);
    return $results;
}

function darGrupos($id_prof)
{
    global $wpdb;
    
    $sql_query = 'SELECT DISTINCT name, description, tax.term_id AS idGrupo	'.
             'FROM '.$wpdb->term_relationships.' AS rel,'.
                     $wpdb->term_taxonomy.' AS tax,'.
                     $wpdb->terms.' AS ter '.
             'WHERE tax. taxonomy = "disc_profesores_grupos" '.
                    'AND rel.object_id = '. $id_prof.' '.
                    'AND rel.term_taxonomy_id = tax.term_taxonomy_id '.
                    'AND tax.term_id = ter.term_id ORDER BY tax.count';
    $results = $wpdb->get_results($sql_query);
    return $results;
}

function darGruposInfoAdicional($term_id)
{
    $t_id = $term_id;
    $term_meta = get_option('taxonomy_'.$t_id);
    return $term_meta;
}

function darCategoriasInfoAdicional($term_id)
{
    $t_id = $term_id;
    $term_meta = get_option('taxonomy_'.$t_id);
    return $term_meta;
}

