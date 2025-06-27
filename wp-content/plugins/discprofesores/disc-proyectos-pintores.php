<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//----------------------------------------------------------------
// METODOS QUE SE ENCARGAN PRINCIPALMENTE DE LA PRESENTACION DE LOS DATOS DE PROYECTOS
// SHORTCODES, SINGLE Y ARCHIVE.
//----------------------------------------------------------------

/**
 * Metodo que se encarga de pintar toda la informacion para un SOLO custom post type disc_proyecto
 * ( vista Single post de wordpress ). Es la vista single para un post type disc_proyectos
 * El metodo provee un selector de idioma para presentar contenido en español (por defecto) o inglés
 * @param type $id_proyecto ID del post tipo disc_proyectos con el proyecto a pintar
 * @param String $imagen clase de la imagen
 */
function disc_proyectos_pintarAllSingle($id_proyecto, $imagen) {

    DiscProfProyUtilidades::debug_to_echo(" disc_proyectos_pintarAllSingle, ID proyecto = " . $id_proyecto);

    $title = get_the_title();
    ?>
	<div class="col-md-12 col-sm-6">
	   <?php if($_SERVER['HTTP_REFERER']): ?>
		<a class="btn btn-info" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">  Volver  </a>
		<hr>
	   <?php endif; ?>    
	</div>
    <h2> <?php echo  $title; ?> </h2>
    <div class="row">
	   <div class="col-md-9 hidden-sm hidden-xs"></div>
            <div class="col-md-3 col-sm-9">
                <div class="dropdown">
                    <button id="bt_idioma_proyecto_disc" class="btn btn-disc dropdown-toggle" type="button" data-toggle="dropdown">
                        <img id="img_idioma_proyecto_disc" src="<?php echo plugins_url( 'img/ES.png', __FILE__ ) ?>"/>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick="cambiarIdiomaProyecto('ES')">ES <img src="<?php echo plugins_url( 'img/ES.png', __FILE__ ) ?>"/></a></li>
                        <li><a href="#" onclick="cambiarIdiomaProyecto('EN')">EN <img src="<?php echo plugins_url( 'img/EN.png', __FILE__ ) ?>"/></a></li>
                    </ul>
               </div>
            </div>
    </div>
    <div class="info_proyecto_es" style="display:inline;">
        <div>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#general">Información general</a></li>
                <li><a data-toggle="tab" href="#descripcion">Descripción</a></li>
                <li><a data-toggle="tab" href="#estado-actual">Estado Actual</a></li>
                <li><a data-toggle="tab" href="#objetivos">Objetivos</a></li>
                <li><a data-toggle="tab" href="#resultados">Resultados</a></li>
            </ul>
            <div class="tab-content">
                <div id="general" class="tab-pane fade in active">
                    <?php disc_proyectos_pintarGeneralSingle($id_proyecto, $imagen); ?>
                </div>
                <div id="descripcion" class="tab-pane fade">
                    <h2>Descripción</h2>
                    <?php disc_proyectos_pintarDescripcion($id_proyecto); ?>
                </div>
                <div id="estado-actual" class="tab-pane fade">
                    <h2>Estado Actual</h2>
                    <?php disc_proyectos_pintarEstadoActual($id_proyecto); ?>
                </div>
                <div id="objetivos" class="tab-pane fade">
                    <h2>Objetivos</h2>
                    <?php disc_proyectos_pintarObjetivos($id_proyecto); ?>
                </div>
                <div id="resultados" class="tab-pane fade">
                    <h2>Resultados</h2>
                    <?php disc_proyectos_pintarResultados($id_proyecto); ?>
                </div>
            </div>
        </div>
        <hr>
        <div>
            <h2>Participantes</h2>
            <h3>Profesores</h3>
            <?php disc_proyectos_pintarProfesoresAsociados($id_proyecto); ?>
            <h3>Estudiantes</h3>
            <?php// disc_proyectos_pintarEstudiantesAsociados($id_proyecto); ?>
        </div>
    </div>
    <div class="info_proyecto_en" style="display:none;">
        <div>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#generalinformation">General Information</a></li>
                <li><a data-toggle="tab" href="#description">Description</a></li>
                <li><a data-toggle="tab" href="#current-status">Current Status</a></li>
                <li><a data-toggle="tab" href="#goals">Goals</a></li>
                <li><a data-toggle="tab" href="#results">Results</a></li>
            </ul>
            <div class="tab-content">
                <div id="generalinformation" class="tab-pane fade in active">
                    <?php disc_proyectos_pintarGeneralSingle_en($id_proyecto, $imagen); ?>
                </div>
                <div id="description" class="tab-pane fade">
                    <h2>Description</h2>
                    <?php disc_proyectos_pintarDescripcion_en($id_proyecto); ?>
                </div>
                <div id="current-status" class="tab-pane fade">
                    <h2>Current Status</h2>
                    <?php disc_proyectos_pintarEstadoActual_en($id_proyecto); ?>
                </div>
                <div id="goals" class="tab-pane fade">
                    <h2>Goals</h2>
                    <?php disc_proyectos_pintarObjetivos_en($id_proyecto); ?>
                </div>
                <div id="results" class="tab-pane fade">
                    <h2>Results</h2>
                    <?php disc_proyectos_pintarResultados_en($id_proyecto); ?>
                </div>
            </div>
        </div>
        <hr>
        <div>
            <h2>Involved in the project</h2>
            <h3>Teachers</h3>
            <?php disc_proyectos_pintarProfesoresAsociados($id_proyecto); ?>
        </div>
    </div>
    <?php
}

/**
 * Pinta solo la info general del proyecto esto incluye:
 * (logo/imagen del proyecto, periodoes, categorias, grupos de investigacion asociados, descripcion corta y estado de actividad)
 * @param int $id_proyecto ID del post tipo disc_proyectos con el proyecto a pintar
 * @param String $imagen clase de la imagen
 */
function disc_proyectos_pintarGeneralSingle($id_proyecto, $imagen) {

    $img = wp_get_attachment_url(get_post_thumbnail_id($id_proyecto));

    if ($imagen != '' && $img) {
        ?>
        <div class="row">
            <div class="col-sm-4">
                <br />
                <img src="<?php echo $img; ?>" alt="proyecto" class="<?php echo $imagen; ?>" style="max-width: 300px;" width="100%"/>
            </div>
            <div class="col-sm-8">
        <?php disc_proyectos_pintarGeneralNoImg($id_proyecto); ?>
            </div>
        </div>
        <?php
            } else {
                disc_proyectos_pintarGeneralNoImg($id_proyecto);
            }
        }
/**
 * Hace lo mismo que disc_proyectos_pintarGeneralSingle(...) pero con informacion EN INGLÉS
 * @param type $id_proyecto
 * @param type $imagen
 */
function disc_proyectos_pintarGeneralSingle_en($id_proyecto, $imagen) {

    $img = wp_get_attachment_url(get_post_thumbnail_id($id_proyecto));

    if ($imagen != '' && $img) {
        ?>
        <div class="row">
            <div class="col-sm-4">
                <br />
                <img src="<?php echo $img; ?>" alt="proyecto" class="<?php echo $imagen; ?>" style="max-width: 300px;"  width="100%"/>
            </div>
            <div class="col-sm-8">
        <?php disc_proyectos_pintarGeneralNoImg_en($id_proyecto); ?>
            </div>
        </div>
        <?php
            } else {
                disc_proyectos_pintarGeneralNoImg_en($id_proyecto);
            }
        }

/**
 * Pinta la información general de un proyecto tipo textual
 * (taxonomias y datos basicos que no contienen textos enquriquecidos/htmls)
 * @param int $id_proyecto ID del post tipo disc_proyectos con el proyecto a pintar
 */
function disc_proyectos_pintarGeneralNoImg($id_proyecto) {
    //Datos tipo taxonomia
    $categorias = disc_proyectos_darCategorias($id_proyecto);
    $grupos = disc_proyectos_darGrupos($id_proyecto);
    $periodos = disc_proyectos_darPeriodos($id_proyecto);

    //Datos de campos basicos del proyecto
    $estado_actividad = get_post_meta($id_proyecto, 'estado_actividad_proyecto_disc', true);
    $desc_corta = get_post_meta($id_proyecto, 'desc_corta_proyecto_disc', true);

    ?>

    <h4><span class="glyphicon glyphicon-bookmark"></span> Categoría:</h4>
    <?php if ($categorias) : ?>
        <ul style="list-style: none;">
        <?php foreach ($categorias as $cat) : ?>
            <li> <?php echo  $cat->name ?></li>
        <?php endforeach;?>
        </ul>
    <?php else : ?>
        <p><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sin categorias asociadas</em></p>
    <?php endif; ?>

    <h4><i class="fa fa-users"></i> Grupo:</h4>
    <?php if ($grupos) : ?>
        <ul style="list-style: none;">
        <?php foreach ($grupos as $grup) : ?>
            <?php if ($grup->description != '' && substr($grup->description, 0, 4) == 'http') : ?>
                <li><a href="<?php echo $grup->description ?>" target="_blank"><?php echo $grup->name ?></a></li>
            <?php else : ?>
                <li> <?php echo $grup->name ?> </li>
            <?php endif; ?>
        <?php endforeach;?>
        </ul>

    <?php else : ?>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>Sin grupos asociados</em></p>
    <?php endif; ?>
    <h4><span class="glyphicon glyphicon-time"></span>  Tiempo:</h4>
    <?php if ($periodos) : ?>
        <ul style="list-style: none;">
        <?php foreach ($periodos as $periodo) : ?>
            <li> <?php echo  $periodo->name ?></li>
        <?php endforeach;?>
        </ul>
    <?php else : ?>
        <p><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sin periodos asociados</em></p>
    <?php endif; ?>
        <h4><span class="glyphicon glyphicon-dashboard"></span>  Estado:</h4>
    <?php if ($estado_actividad && trim($estado_actividad) != '') : ?>
        <h5 style="color: <?php echo disc_proyectos_get_color_estado($estado_actividad)?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="glyphicon glyphicon-flash"></span> Proyecto <?php echo $estado_actividad ?></b></h5>
    <?php endif; ?>
    <div>
        <p><?php echo $desc_corta ?></p>
    </div>
    <?php
}
/**
 * Hace lo mismo que disc_proyectos_pintarGeneralNoImg(...) pero con informacion EN INGLÉS
 * @param type $id_proyecto
 */
function disc_proyectos_pintarGeneralNoImg_en($id_proyecto) {
    //Datos tipo taxonomia
    $categorias = disc_proyectos_darCategorias($id_proyecto);
    $grupos = disc_proyectos_darGrupos($id_proyecto);
    $periodos = disc_proyectos_darPeriodos($id_proyecto);

    //Datos de campos basicos del proyecto
    $estado_actividad = get_post_meta($id_proyecto, 'estado_actividad_proyecto_disc', true);
    $estado_actividad_en = disc_proyectos_get_estado_en_ingles($estado_actividad);

    $desc_corta_en = get_post_meta($id_proyecto, 'desc_corta_proyecto_disc_en', true);

    ?>

    <h4><span class="glyphicon glyphicon-bookmark"></span> Category:</h4>
    <?php if ($categorias) : ?>
        <ul style="list-style: none;">
        <?php foreach ($categorias as $cat) : ?>
            <li> <?php echo  $cat->name ?></li>
        <?php endforeach;?>
        </ul>
    <?php else : ?>
        <p><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No categories </em></p>
    <?php endif; ?>

    <h4><i class="fa fa-users"></i> Research group:</h4>
    <?php if ($grupos) : ?>
        <ul style="list-style: none;">
        <?php foreach ($grupos as $grup) : ?>
            <?php if ($grup->description != '' && substr($grup->description, 0, 4) == 'http') : ?>
                <li><a href="<?php echo $grup->description ?>" target="_blank"><?php echo $grup->name ?></a></li>
            <?php else : ?>
                <li> <?php echo $grup->name ?> </li>
            <?php endif; ?>
        <?php endforeach;?>
        </ul>

    <?php else : ?>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>No Research groups </em></p>
    <?php endif; ?>
    <h4><span class="glyphicon glyphicon-time"></span>  Timeline:</h4>
    <?php if ($periodos) : ?>
        <ul style="list-style: none;">
        <?php foreach ($periodos as $periodo) : ?>
            <li> <?php echo  $periodo->name ?></li>
        <?php endforeach;?>
        </ul>
    <?php else : ?>
        <p><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No periods</em></p>
    <?php endif; ?>
        <h4><span class="glyphicon glyphicon-dashboard"></span>  Status:</h4>
    <?php if ($estado_actividad && trim($estado_actividad) != '') : ?>
        <h5 style="color: <?php echo disc_proyectos_get_color_estado($estado_actividad)?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="glyphicon glyphicon-flash"></span> Project <?php echo $estado_actividad_en ?></b></h5>
    <?php endif; ?>
    <div>
        <p><?php echo $desc_corta_en ?></p>
    </div>
    <?php
}

/**
 * Retorna el label para el estado de actividad de un proyecto en inglés.
 * @param type $estado_es label del estdao en español
 * @return boolean|string estado en inglés o false si no lo reconoce.
 */
function disc_proyectos_get_estado_en_ingles($estado_es){


    if ($estado_es=='Activo')
    {
        return 'Active';
    }
    elseif ($estado_es=='Cerrado') {

        return 'Closed';
    }
    else{
        return false;
    }
}

/**
 * Pinta la información de descripcion de un proyecto
 * @param int $id_proyecto ID del post tipo disc_proyectos con el proyecto a pintar
 */
function disc_proyectos_pintarDescripcion($id_proyecto) {
    $metacampo = get_post_meta($id_proyecto, 'descripcion_general_proyecto_disc', true);
    if (trim($metacampo) != '') {
        ?>
    <div><?php echo $metacampo; ?></div>
    <?php
    }
}

/**
 * Pinta la información de descripcion de un proyecto EN INGLÉS
 * @param int $id_proyecto ID del post tipo disc_proyectos con el proyecto a pintar
 */
function disc_proyectos_pintarDescripcion_en($id_proyecto) {
    $metacampo = get_post_meta($id_proyecto, 'descripcion_general_proyecto_disc_en', true);
    if (trim($metacampo) != '') {
        ?>
    <div><?php echo $metacampo; ?></div>
    <?php
    }
}

/**
 * Pinta la información de la descripcion del estado actual de un proyecto
 * @param int $id_proyecto ID del post tipo disc_proyectos con el proyecto a pintar
 */
function disc_proyectos_pintarEstadoActual($id_proyecto) {
    $metacampo = get_post_meta($id_proyecto, 'estado_actual_proyecto_disc', true);
    if (trim($metacampo) != '') {
        ?>
        <div><?php echo $metacampo; ?></div>
    <?php
    }
}

/**
 * Pinta la información de la descripcion del estado actual de un proyecto EN INGLÉS
 * @param int $id_proyecto ID del post tipo disc_proyectos con el proyecto a pintar
 */
function disc_proyectos_pintarEstadoActual_en($id_proyecto) {
    $metacampo = get_post_meta($id_proyecto, 'estado_actual_proyecto_disc_en', true);
    if (trim($metacampo) != '') {
        ?>
        <div><?php echo $metacampo; ?></div>
    <?php
    }
}

/**
 * Pinta la información de objetivos de un proyecto
 * @param int $id_proyecto ID del post tipo disc_proyectos con el proyecto a pintar
 */
function disc_proyectos_pintarObjetivos($id_proyecto) {
    $metacampo = get_post_meta($id_proyecto, 'objetivos_proyecto_disc', true);
    if (trim($metacampo) != '') {
        ?>
        <div><?php echo $metacampo; ?></div>
    <?php
    }
}

/**
 * Pinta la información de objetivos de un proyecto EN INGLÉS
 * @param int $id_proyecto ID del post tipo disc_proyectos con el proyecto a pintar
 */
function disc_proyectos_pintarObjetivos_en($id_proyecto) {
    $metacampo = get_post_meta($id_proyecto, 'objetivos_proyecto_disc_en', true);
    if (trim($metacampo) != '') {
        ?>
        <div><?php echo $metacampo; ?></div>
    <?php
    }
}

/**
 * Pinta la información de resultados de un proyecto
 * @param int $id_proyecto ID del post tipo disc_proyectos con el proyecto a pintar
 */
function disc_proyectos_pintarResultados($id_proyecto) {
    $metacampo = get_post_meta($id_proyecto, 'resultados_proyecto_disc', true);
    if (trim($metacampo) != '') {
        ?>
        <div><?php echo $metacampo; ?></div>
    <?php
    }
}

/**
 * Pinta la información de resultados de un proyecto EN INGLÉS
 * @param int $id_proyecto ID del post tipo disc_proyectos con el proyecto a pintar
 */
function disc_proyectos_pintarResultados_en($id_proyecto) {
    $metacampo = get_post_meta($id_proyecto, 'resultados_proyecto_disc_en', true);
    if (trim($metacampo) != '') {
        ?>
        <div><?php echo $metacampo; ?></div>
    <?php
    }
}

/**
 * Pinta informacion relevante de los profesores que se encuentran trabajando en el proyecto $id_proyecto
 * @param type $id_proyecto proeycto para el cual se quiere pintar informacion básica de profesores participantes.
 */
function disc_proyectos_pintarProfesoresAsociados($id_proyecto)
{
    //ID de profesor lider y arreglo de Ids con profesores participantes. (disc_profesores)
    $profesor_lider = get_post_meta($id_proyecto, 'profesor_lider_proyecto_disc', true);
    $profesores_participantes = get_post_meta($id_proyecto, 'profesores_participantes_proyecto_disc', true);
    DiscProfProyUtilidades::debug_to_echo('Lider de proyecto '.$profesor_lider);
    DiscProfProyUtilidades::debug_to_echo('IDs profesores participantes (debug)');
    DiscProfProyUtilidades::debug_to_echo_var_dump($profesores_participantes);
    $rol = get_role('editor');
    DiscProfProyUtilidades::debug_to_echo( json_encode($rol));

    //$rango = range(1, 10);

    ?>

    <!---
      TODO: Se debe hacer refactoring. No se debe usar el style de esta manera. Usar CSS.
    ---->

        <style>
            .div-contenedor-column{
               margin-top: 10px;
               padding-right: 0px;
            }
            .div-contenedor-profesor{
                height: 100px;
                border: #337ab7 solid thin;
                border-radius: 5px;
                padding-top: 10px;
                padding-left: 5px;
                overflow-y: auto;
            }
            .imagen-box-column {
                max-width: 90%;
                height: auto;
                margin: 0px;
                padding: 0px;
            }

            .text-box-column{
                vertical-align: top;
            }

            @media (max-width: 768px) {
                .div-contenedor-profesor{
                    height:auto;
                    padding-bottom: 5px;
                }
            }

        </style>
        <div class="div-contenedor-profesores-participantes row">
    <?php foreach ($profesores_participantes as $id_profesor): ?>
        <?php
        $post_profesor = get_post($id_profesor);
        $username = $post_profesor->post_title;
        $nombre = get_post_meta($id_profesor, 'nombre_mostrar', true);
	$correo = esc_html(get_post_meta($id_profesor, 'correo', true));
	// La URL va a consistir en la página del multisitio del profesor.
	$url = get_home_url().'/'.str_replace(array("-","."),"",$username) ;
        ?>
            <div class="div-contenedor-column col-md-4 col-sm-6">
        <div class="div-contenedor-profesor" >
            <div class="col-xs-2 col-sm-4" style="margin: 0px; padding: 0px;">

            <?php if ( has_post_thumbnail($id_profesor)) : ?>
                <a href="<?php echo get_the_permalink($post_profesor); ?>" title="<?php echo $username ?>">
                    <img src="<?php echo get_the_post_thumbnail_url($post_profesor); ?>" class="imagen-box-column img-rounded"/>
                </a>
                <?php else:?>

            <?php endif; ?>
            </div>
            <div class="col-xs-10 col-sm-8" style="margin: 5px 0px 0px; padding: 0px;">
                <div><a href="<?php echo $url; ?>" <h5><?php echo $nombre ?></h5></a></div>
                <div><p style="font-size: smaller;">e-mail: <b><?php echo enmascarar_correo($correo); ?></b></p></div>
            </div>
        </div>
        </div>

    <?php endforeach;?>
        </div>
    <?php
}

function disc_proyectos_pintarEstudiantesAsociados($id_proyecto)
{
  //ID de profesor lider y arreglo de Ids con profesores participantes. (disc_profesores)
  //$profesor_lider = get_post_meta($id_proyecto, 'profesor_lider_proyecto_disc', true);
  $estudiantes_participantes = get_post_meta($id_proyecto, 'estudiantes_participantes_proyecto_disc', true);
  DiscProfProyUtilidades::debug_to_echo('IDs estudiantes participantes (debug)');
  DiscProfProyUtilidades::debug_to_echo_var_dump($estudiantes_participantes);

  ?>

  <!---
    TODO: Se debe hacer refactoring. No se debe usar el style de esta manera. Usar CSS.
  ---->

      <style>
          .div-contenedor-column{
             margin-top: 10px;
             padding-right: 0px;
          }
          .div-contenedor-estudiante{
              height: 85px;
              border: #b88b33 solid thin;
              border-radius: 5px;
              padding-top: 0px;
              padding-left: 20px;
              overflow-y: auto;
          }
          .imagen-box-column {
              max-width: 90%;
              height: auto;
              margin: 0px;
              padding: 0px;
          }

          .text-box-column{
              vertical-align: top;
          }

          @media (max-width: 768px) {
              .div-contenedor-estudiante{
                  height:auto;
                  padding-bottom: 5px;
              }
          }

      </style>
      <div class="div-contenedor-estudiantes-participantes row">
  <?php
  $estudiantes_participantes = explode(",",$estudiantes_participantes);
  $estudiantes_participantes2 = array(array('username' => $estudiantes_participantes[0], 'display_name' => 'Oscar Kiyoshige Garcés Aparicio' ), array('username' => $estudiantes_participantes[1], 'display_name' => 'Oscar Kiyoshige Garcés Aparicio' ));
  foreach ($estudiantes_participantes2 as $estudiante):
      $correo_estudiante = $estudiante['username'].'@uniandes.edu.co';
      $nombre_estudiante = $estudiante['display_name'];

      ?>
      <div class="div-contenedor-column col-md-4 col-sm-6">
      <div class="div-contenedor-estudiante" >
          <div class="col-xs-12 col-sm-12" style="margin: 5px 0px 0px; padding: 0px;">
              <div><h5><?php echo $nombre_estudiante ?></h5></div>
              <div><p style="font-size: smaller;">e-mail: <b><?php echo enmascarar_correo($correo_estudiante) ?></b></p></div>
          </div>
      </div>
      </div>

  <?php endforeach;?>
      </div>
  <?php
}


/**
 * Color para un estado de actividad dado o negro si no se identifica como valido. Valido = (Activo/Cerrado)
 * @param type $estado_actividad etiqueta para el estado de actividad (Activo/Cerrado)
 * @return string color del estado o negro si no identifica el estado como valido.
 */
function disc_proyectos_get_color_estado($estado_actividad){
    //NEGRO
    $color_estado = "#000000";

    if($estado_actividad == 'Activo')
    {
        //VERDE
        $color_estado = "#47994E";
    }
    if($estado_actividad == 'Cerrado')
    {
        //ROJO
        $color_estado = "#AA2828";
    }
    return $color_estado;
}

/**
 * Pinta un conjunto de proyectos, dado un WP_Query
 * @param WP_Query $the_query query de worpress con los post tipo disc_proyecto a pintar
 */
function disc_proyectos_pintarMultiplesProyectos($the_query, $con_filtro) {
   DiscProfProyUtilidades::debug_to_echo("Pintor Multiples Proyectos INICIO");

    if ($the_query->have_posts()) : ?>

    <script language="javascript" type="text/javascript">

    function functionProyectos(){
        var options = {
          valueNames: [ 'titulo_proyecto','estado_proyecto', 'categoria_proyecto', 'grupo_proyecto' ]
        };
        var proyectosList = new List('proyectos', options);
    }

    function functionProyectosEN(){
        var optionsEN = {
          valueNames: [ 'titulo_proyecto_en','estado_proyecto_en', 'categoria_proyecto_en', 'grupo_proyecto_en' ]
        };
        var proyectosListEN = new List('proyectos_en', optionsEN);
    }

    addOnloadEvent(functionProyectos);
    addOnloadEvent(functionProyectosEN);

    </script>
    <style>
        .div-contenedor-proyecto{
            padding: 0px;
            height:300px;
            overflow-y: auto
        }
        @media (max-width: 768px) {
            .div-contenedor-proyecto{
                height:auto;
            }
        }
    </style>
    <!--Selector de idioma -->
    <div class="row">
            <div class="col-md-11 hidden-sm hidden-xs"></div>
            <div class="col-md-1">
                <div class="dropdown">
                    <button id="bt_idioma_proyecto_disc" class="btn btn-disc dropdown-toggle" type="button" data-toggle="dropdown">
                        <img id="img_idioma_proyecto_disc" src="<?php echo plugins_url( 'img/ES.png', __FILE__ ) ?>"/>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick="cambiarIdiomaProyecto('ES')">ES <img src="<?php echo plugins_url( 'img/ES.png', __FILE__ ) ?>"/></a></li>
                        <li><a href="#" onclick="cambiarIdiomaProyecto('EN')">EN <img src="<?php echo plugins_url( 'img/EN.png', __FILE__ ) ?>"/></a></li>
                    </ul>
               </div>
            </div>
    </div>
    <div class="info_proyecto_es" style="display:inline;">
        <?php
        //Catalogo de proyectos en españo
        DiscProfProyUtilidades::debug_to_echo('Inserte contenido en español aqui...');
        disc_proyectos_pintarMultiplesProyectosES($the_query, $con_filtro);  ?>
    </div>
    <?php
    /* Restore original Post Data
    * NB: Because we are using new WP_Query we aren't stomping on the
    * original $wp_query and it does not need to be reset with
    * wp_reset_query(). We just need to set the post data back up with
    * wp_reset_postdata().
    */
    wp_reset_postdata();
    ?>
    <div class="info_proyecto_en" style="display:none;">
        <?php
        //Catalogo de proyectos en inglés
        DiscProfProyUtilidades::debug_to_echo('Insert english content for projecst here...');
        disc_proyectos_pintarMultiplesProyectosEN($the_query, $con_filtro);  ?>
    </div>

    <?php endif;
}

/**
 * Pinta la seccion en ESPAÑOL para el metodo que pinta el catalogo de proyectos tipo cuadricula.
 * @param type $the_query WP_QUERY con los posts (disc_proyectos) seleccionados a pintar.
 */
function disc_proyectos_pintarMultiplesProyectosES($the_query, $con_filtro)
{ ?>
    <div id="proyectos">
      <?php if($con_filtro): ?>
        <div class="row-fluid">

            <div class="col-sm-12" style="margin: 20px 0px;">
                <div class="col-sm-2"><h4 style="text-align: center;">Buscar: </h4></div>
                <div class="col-sm-6"><input type="text" class="search form-control"  placeholder="Nombre, estado, grupo o categoria"></div>
                <div class="col-sm-3"><button class="sort btn btn-info" data-sort="grupo_proyecto">Ordenar por grupo</button></div>
            </div>
        </div>
      <?php endif; ?>
    <ul class="list rig columns-3" style="list-style-type:none; padding: 0px;">

    <?php
        while ($the_query->have_posts()) :
            $the_query->the_post();
            //$currentPost = get_post();

            $title = get_the_title();
            //DiscProfProyUtilidades::debug_to_echo($title);
            $id_proyecto = get_the_ID();

            //Campos de un proyecto almacenados como metadata
            $estado_actividad = esc_html(get_post_meta($id_proyecto, 'estado_actividad_proyecto_disc', true));
            $desc_corta = esc_html(get_post_meta($id_proyecto, 'desc_corta_proyecto_disc', true));

            $color_estado = disc_proyectos_get_color_estado($estado_actividad);


            //Taxonomias asociadas a un proyecto
            $categorias = disc_proyectos_darCategorias($id_proyecto);
            $grupos = disc_proyectos_darGrupos($id_proyecto);

            ?>

        <li style="border-left: <?php echo $color_estado?> solid thick;">
            <div class="div-contenedor-proyecto" >
                    <div class="col-xs-4" style="padding: 0px; display: block;">
                        <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <img src="<?php the_post_thumbnail_url(); ?>" class="img-rounded"/>
                                </a>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-8" style="padding-left: 10px; display: block;">
                        <h4><a class="titulo_proyecto" href="<?php echo get_the_permalink(); ?>"><?php echo $title; ?></a></h4>
                        <h5 class="estado_proyecto" style="color: <?php echo $color_estado?>;" ><span class="glyphicon glyphicon-dashboard"></span><span class="h5">Estado: </span><?php echo $estado_actividad ?> </h5>

                    </div>
                    <div class="col-xs-12" style="padding-left: 5px; display: block;">
                        <p><?php echo $desc_corta ?></p>
                        <div class="col-md-6">
                            <h5><span class="glyphicon glyphicon-bookmark"></span> Categoría:</h5>
                            <?php if ($categorias) : ?>
                            <dl class="categoria_proyecto" style="list-style: none;">
                                    <?php foreach ($categorias as $cat) : ?>
                                        <dt> <?php echo $cat->name ?></dt>
                                    <?php endforeach; ?>
                                        </dl>
                            <?php else : ?>
                                        <p><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sin categorias asociadas</em></p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fa fa-users"></i> Grupo:</h5>
                            <?php if ($grupos) : ?>
                            <dl class="grupo_proyecto" style="list-style: none;">
                                    <?php foreach ($grupos as $grup) : ?>
                                        <?php if ($grup->description != '' && substr($grup->description, 0, 4) == 'http') : ?>
                                            <dt><a href="<?php echo $grup->description?>" target="_blank"><?php echo $grup->name?></a></dt>
                                        <?php else : ?>
                                            <dt><?php echo $grup->name ?></dt>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                        </dl>
                            <?php else : ?>
                                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>Sin grupos asociados</em></p>
                            <?php endif; ?>
                        </div>
                    </div>
            </div>
         </li>
        <?php endwhile; ?>
    </ul>
    </div>
<?php
}

/**
 *  * Pinta la seccion en INGLÉS para el metodo que pinta el catalogo de proyectos tipo cuadricula.
 * @param type $the_query WP_QUERY con los posts (disc_proyectos) seleccionados a pintar.
 */
function disc_proyectos_pintarMultiplesProyectosEN($the_query)
{ ?>
    <div id="proyectos_en">
      <?php if($con_filtro): ?>
        <div class="row-fluid">
            <div class="col-sm-12" style="margin: 20px 0px;">
                <div class="col-sm-2"><h4 style="text-align: center;">Search: </h4></div>
                <div class="col-sm-6"><input type="text" class="search form-control"  placeholder="Name, status, group or category"></div>
                <div class="col-sm-3"><button class="sort btn btn-info" data-sort="grupo_proyecto_en">Sort by group</button></div
            </div>
        </div>
      <?php endif; ?>
    <ul class="list rig columns-3" style="list-style-type:none; padding: 0px;">

    <?php
        while ($the_query->have_posts()) :
            $the_query->the_post();
            //$currentPost = get_post();

            $title = get_the_title();
            //DiscProfProyUtilidades::debug_to_echo($title);
            $id_proyecto = get_the_ID();

            //Campos de un proyecto almacenados como metadata
            $estado_actividad = get_post_meta($id_proyecto, 'estado_actividad_proyecto_disc', true);
            $estado_actividad_en = disc_proyectos_get_estado_en_ingles($estado_actividad);

            $desc_corta_en = get_post_meta($id_proyecto, 'desc_corta_proyecto_disc_en', true);

            $color_estado = disc_proyectos_get_color_estado($estado_actividad);


            //Taxonomias asociadas a un proyecto
            $categorias = disc_proyectos_darCategorias($id_proyecto);
            $grupos = disc_proyectos_darGrupos($id_proyecto);

            ?>

        <li style="border-left: <?php echo $color_estado?> solid thick;">
            <div class="div-contenedor-proyecto" >
                    <div class="col-xs-4" style="padding: 0px; display: block;">
                        <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <img src="<?php the_post_thumbnail_url(); ?>" class="img-rounded"/>
                                </a>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-8" style="padding-left: 10px; display: block;">
                        <h4><a class="titulo_proyecto_en" href="<?php echo get_the_permalink(); ?>"><?php echo $title; ?></a></h4>
                        <h5 class="estado_proyecto_en" style="color: <?php echo $color_estado?>;" ><span class="glyphicon glyphicon-dashboard"></span><span class="h5">Status: </span><?php echo $estado_actividad_en ?> </h5>

                    </div>
                    <div class="col-xs-12" style="padding-left: 5px; display: block;">
                        <p><?php echo $desc_corta_en ?></p>
                        <div class="col-md-6">
                            <h5><span class="glyphicon glyphicon-bookmark"></span> Category:</h5>
                            <?php if ($categorias) : ?>
                            <dl class="categoria_proyecto_en" style="list-style: none;">
                                    <?php foreach ($categorias as $cat) : ?>
                                        <dt> <?php echo $cat->name ?></dt>
                                    <?php endforeach; ?>
                                        </dl>
                            <?php else : ?>
                                        <p><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No categories</em></p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fa fa-users"></i> Research Group:</h5>
                            <?php if ($grupos) : ?>
                            <dl class="grupo_proyecto_en" style="list-style: none;">
                                    <?php foreach ($grupos as $grup) : ?>
                                        <?php if ($grup->description != '' && substr($grup->description, 0, 4) == 'http') : ?>
                                            <dt><a href="<?php echo $grup->description?>" target="_blank"><?php echo $grup->name?></a></dt>
                                        <?php else : ?>
                                            <dt><?php echo $grup->name ?></dt>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                        </dl>
                            <?php else : ?>
                                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>No Research groups</em></p>
                            <?php endif; ?>
                        </div>
                    </div>
            </div>
         </li>
        <?php endwhile; ?>
    </ul>
    </div>
<?php
}
