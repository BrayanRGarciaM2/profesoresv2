<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//----------------------------------------------------------------
// METODOS QUE SE ENCARGAN PRINCIPALMENTE DE LA PRESENTACION DE LOS DATOS DE PROFESORES
// SHORTCODES, SINGLE Y ARCHIVE.
//----------------------------------------------------------------

/**
 * Pinta toda la información del profesor
 * @param int $id_prof id el profesor a pintar
 * @param String $imagen clase de la imagen
 * @param String $presentacion la presentación que se desea usar
 */
function pintarAll($id_prof, $imagen, $presentacion, $catedra)
{?>
        <div class="row">
            <div class="col-md-9 hidden-sm hidden-xs"></div>
            <div class="col-md-3">
                <div class="dropdown">
                    <button id="bt_idioma_prof_disc" class="btn btn-disc dropdown-toggle" type="button" data-toggle="dropdown">
                        <img id="img_idioma_prof_disc" src="<?php echo plugins_url( 'img/ES.png', __FILE__ ) ?>"/>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick="cambiarIdioma('ES')">ES <img src="<?php echo plugins_url( 'img/ES.png', __FILE__ ) ?>"/></a></li>
                        <li><a href="#" onclick="cambiarIdioma('EN')">EN <img src="<?php echo plugins_url( 'img/EN.png', __FILE__ ) ?>"/></a></li>
                    </ul>
               </div>
            </div>
        </div>
    <?php
    if($presentacion && $presentacion == 'tabs')
    {?>
       <div class="info_prof_es" style="display:inline;">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#general">Información general</a></li>
                <li><a data-toggle="tab" href="#formacion">Formación</a></li>

                <?php //Si es profesor de catedra no debería imprimir el campo de investigación
								 if(!$catedra) : ?>
                	<li><a data-toggle="tab" href="#investigacion">Investigación</a></li>
								<?php endif; ?>

                <li><a data-toggle="tab" href="#docencia">Docencia</a></li>
            </ul>
            <div class="tab-content">
                <div id="general" class="tab-pane fade in active">
                    <?php pintarGeneral($id_prof, $imagen); ?>
                </div>
                <div id="formacion" class="tab-pane fade">
                    <h2>Formación académica</h2>
                    <?php pintarFormacion($id_prof); ?>
                </div>

                <?php //Si es profesor de catedra no debería imprimir el campo de investigación
								 if(!$catedra) : ?>
									 <div id="investigacion" class="tab-pane fade">
											 <h2>Líneas de investigación y áreas de interés</h2>
											 <?php pintarIntereses($id_prof, false); ?>
									 </div>

								<?php endif; ?>

                <div id="docencia" class="tab-pane fade">
                    <h2>Cursos</h2>
                    <?php pintarCursos($id_prof); ?>
                </div>
            </div>
        </div>
        <div class="info_prof_en" style="display:none;">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#generalinformation">General information</a></li>
                <li><a data-toggle="tab" href="#degrees">Degrees</a></li>
                <li><a data-toggle="tab" href="#research">Research</a></li>
                <li><a data-toggle="tab" href="#teaching">Teaching</a></li>
            </ul>
            <div class="tab-content">
                <div id="generalinformation" class="tab-pane fade in active">
                    <?php pintarGeneral_en($id_prof, $imagen); ?>
                </div>
                <div id="degrees" class="tab-pane fade">
                    <h2>Academic degrees</h2>
                    <?php pintarFormacion_en($id_prof); ?>
                </div>

                <?php //Si es profesor de catedra no debería imprimir el campo de investigación
								 if(!$catedra) : ?>
									 <div id="investigacion" class="tab-pane fade">
											 <h2>Research lines and areas of interest</h2>
											 <?php pintarIntereses_en($id_prof, false); ?>
									 </div>

								<?php endif; ?>

                <div id="teaching" class="tab-pane fade">
                    <h2>Courses</h2>
                    <?php pintarCursos_en($id_prof); ?>
                </div>
            </div>
        </div>
    <?php
    }
    else { ?>
        <div class="info_prof_es" style="display:inline;">
            <?php pintarGeneral($id_prof, $imagen); ?>

            <h2>Formación académica</h2>
            <?php pintarFormacion($id_prof); ?>

            <?php //Si es profesor de catedra no debería imprimir el campo de investigación
								 if(!$catedra) : ?>

								 		<h2>Líneas de investigación y áreas de interés</h2>
								 		<?php pintarIntereses($id_prof, false); ?>

						<?php endif; ?>

            <h2>Cursos</h2>
            <?php pintarCursos($id_prof); ?>
        </div>
        <div class="info_prof_en" style="display:inline;">
            <?php pintarGeneral_en($id_prof, $imagen); ?>

            <h2>Formación académica</h2>
            <?php pintarFormacion_en($id_prof); ?>

            <?php //Si es profesor de catedra no debería imprimir el campo de investigación
								 if(!$catedra) : ?>
									<h2>Líneas de investigación y áreas de interés</h2>
									<?php pintarIntereses_en($id_prof, false); ?>
						<?php endif; ?>

            <h2>Cursos</h2>
            <?php pintarCursos_en($id_prof); ?>
        </div>
    <?php
    }
}

/**
 * Pinta solo la info general del profesor (contacto + redes)
 * @param int $id_prof id el profesor a pintar
 * @param String $imagen clase de la imagen
 */
function pintarGeneral($id_prof, $imagen)
{
    $img = wp_get_attachment_url(get_post_thumbnail_id($id_prof));
    $nombre = get_post_meta($id_prof, 'nombre_mostrar', true);
    echo '<h2>'.$nombre.'</h2>';
    if($imagen != '' && $img)
    {?>
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $img; ?>" alt="profesor" class="<?php echo $imagen; ?> img-profesor" />
            </div>
            <div class="col-md-8">
                <?php pintarGeneralNoImg($id_prof);?>
            </div>
        </div>
    <?php }
    else
    {
        pintarGeneralNoImg($id_prof);
    }
}

/**
 * Pinta solo la info general del profesor (contacto + redes) en inglés
 * @param int $id_prof id el profesor a pintar
 * @param String $imagen clase de la imagen
 */
function pintarGeneral_en($id_prof, $imagen)
{
    $img = wp_get_attachment_url(get_post_thumbnail_id($id_prof));
    $nombre = get_post_meta($id_prof, 'nombre_mostrar', true);
    echo '<h2>'.$nombre.'</h2>';
    if($imagen != '' && $img)
    {?>
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $img; ?>" alt="profesor" class="<?php echo $imagen; ?>" />
            </div>
            <div class="col-md-8">
                <?php pintarGeneralNoImg_en($id_prof);?>
            </div>
        </div>
    <?php }
    else
    {
        pintarGeneralNoImg_en($id_prof);
    }
}

/**
 * Pinta la información general sin incluir imagen
 * @param int $id_prof id el profesor a pintar
 */
function  pintarGeneralNoImg($id_prof)
{
     $categorias  = darCategorias($id_prof);
     $grupos  = darGrupos($id_prof);
     $oficina = get_post_meta($id_prof, 'oficina', true);
     $correo = get_post_meta($id_prof, 'correo', true);
     $extension = get_post_meta($id_prof, 'extension', true);
     $face = get_post_meta($id_prof, 'facebook', true);
     $twitter = get_post_meta($id_prof, 'twitter', true);
     $google = get_post_meta($id_prof, 'google', true);
     $linked = get_post_meta($id_prof, 'linkedin', true);
     $researchgate = get_post_meta($id_prof, 'researchgate', true);
     $googlescholar = get_post_meta($id_prof, 'googlescholar', true);
     $dblp = get_post_meta($id_prof, 'dblp', true);
     $post_type = get_post_type($id_prof);

     echo '<h4><span class="glyphicon glyphicon-bookmark"></span> Categoría:</h4>';
     if($categorias)
     {
        echo '<ul style="list-style: none;">';
        foreach ($categorias as $cat) {
            echo '<li>'.$cat->name.'</li>';
        }
        echo '</ul>';
     }
     if($post_type === 'disc_profesores'){
       echo '<h4><i class="fa fa-users"></i> Grupo:</h4>';
       if($grupos)
       {
         echo '<ul style="list-style: none;">';
         foreach ($grupos as $grup) {
           if($grup->description != '' && substr($grup->description, 0 ,4) =='http' )
           {
             echo '<li><a href="'.$grup->description.'" target="_blank">'.$grup->name.'</a></li>';
           }
           else
           {
             echo '<li>'.$grup->name.'</li>';
           }


         }
         echo '</ul>';
       }
     }

     echo '<h4><span class="glyphicon glyphicon-user"></span> Contacto:</h4>';
     if($oficina && trim($oficina) != '')
     {
        echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="glyphicon glyphicon-home"></span> Oficina: </b>'.$oficina.'</p>';
     }
    if($correo && trim($correo) != '')
    {
        echo '<div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="glyphicon glyphicon-envelope"></span> Correo: </b>'. enmascarar_correo($correo). '</div>';
     }
    if($extension && trim($extension) != '')
    {
        echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="glyphicon glyphicon-earphone"></span> Extensión: </b>'.$extension.'</p>';
    }


    echo '<p class="redes">';
     if($face && trim($face) != '')
    {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://www.facebook.com/'.$face.'" target="_blank"><i class="fa fa-facebook-square fa-2x"></i></a>';
    }
    if($twitter && trim($twitter) != '')
    {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://www.twitter.com/'.$twitter.'" target="_blank"><i class="fa fa-twitter fa-2x"></i></a>';
    }
    if($google && trim($google) != '')
    {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$google.'" target="_blank"><i class="fa fa-google-plus fa-2x"></i></a>';
    }
    if($linked && trim($linked) != '')
    {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$linked.'" target="_blank"><i class="fa fa-linkedin fa-2x"></i></a>';
    }
    if($researchgate && trim($researchgate) != '')
    {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$researchgate.'" target="_blank"><span class="label label-info"><span class="glyphicon glyphicon-link">ResearchGate</span></span></a>';
    }
    if($googlescholar && trim($googlescholar) != '')
    {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$googlescholar.'" target="_blank"><span class="label label-info"><span class="glyphicon glyphicon-link">GoogleScholar </span></span></a>';
    }
    if($dblp && trim($dblp) != '')
    {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$dblp.'" target="_blank"><span class="label label-info"><span class="glyphicon glyphicon-link">DPLB </span></span></a>';
    }
    echo '</p>';

}

/**
 * Pinta la información general sin incluir imagen en inglés
 * @param int $id_prof id el profesor a pintar
 */
function  pintarGeneralNoImg_en($id_prof)
{
     $categorias  = darCategorias($id_prof);
     $grupos  = darGrupos($id_prof);
     $oficina = get_post_meta($id_prof, 'oficina', true);
     $correo = get_post_meta($id_prof, 'correo', true);
     $extension = get_post_meta($id_prof, 'extension', true);
     $face = get_post_meta($id_prof, 'facebook', true);
     $twitter = get_post_meta($id_prof, 'twitter', true);
     $google = get_post_meta($id_prof, 'google', true);
     $linked = get_post_meta($id_prof, 'linkedin', true);
     $researchgate = get_post_meta($id_prof, 'researchgate', true);
     $googlescholar = get_post_meta($id_prof, 'googlescholar', true);
     $dblp = get_post_meta($id_prof, 'dblp', true);

     $post_type = get_post_type($id_prof);

     echo '<h4><span class="glyphicon glyphicon-bookmark"></span> Category:</h4>';
     if($categorias)
     {
        echo '<ul style="list-style: none;">';
        foreach ($categorias as $cat) {
            $catAdicional = darGruposInfoAdicional($cat->idCat);
            echo '<li>'.$catAdicional['nombre_cat_en'].'</li>';
        }
        echo '</ul>';
     }

     if($post_type === 'disc_profesores'){
       echo '<h4><i class="fa fa-users"></i> Research group:</h4>';
       if($grupos)
       {
         echo '<ul style="list-style: none;">';
         foreach ($grupos as $grup) {
           $grupoAdicional = darGruposInfoAdicional($grup->idGrupo);
           if($grup->description != '' && substr($grup->description, 0 ,4) =='http' )
           {
             echo '<li><a href="'.$grup->description.'" target="_blank">'.$grupoAdicional['nombre_grupo_en'].'</a></li>';
           }
           else
           {
             echo '<li>'.$grupoAdicional['nombre_grupo_en'].'</li>';
           }


         }
         echo '</ul>';
       }
     }

     echo '<h4><span class="glyphicon glyphicon-user"></span> Contact info:</h4>';
     if($oficina && trim($oficina) != '')
     {
        echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="glyphicon glyphicon-home"></span> Office: </b>'.$oficina.'</p>';
     }
    if($correo && trim($correo) != '')
    {
        echo '<div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="glyphicon glyphicon-envelope"></span> Email: </b>'. enmascarar_correo($correo). '</div>';
     }
    if($extension && trim($extension) != '')
    {
        echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="glyphicon glyphicon-earphone"></span> Extension: </b>'.$extension.'</p>';
    }


    echo '<p class="redes">';
     if($face && trim($face) != '')
    {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://www.facebook.com/'.$face.'" target="_blank"><i class="fa fa-facebook-square fa-2x"></i></a>';
    }
    if($twitter && trim($twitter) != '')
    {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://www.twitter.com/'.$twitter.'" target="_blank"><i class="fa fa-twitter fa-2x"></i></a>';
    }
    if($google && trim($google) != '')
    {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$google.'" target="_blank"><i class="fa fa-google-plus fa-2x"></i></a>';
    }
    if($linked && trim($linked) != '')
    {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$linked.'" target="_blank"><i class="fa fa-linkedin fa-2x"></i></a>';
    }
    if($researchgate && trim($researchgate) != '')
    {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$researchgate.'" target="_blank"><span class="label label-info"><span class="glyphicon glyphicon-link">ResearchGate</span></span></a>';
    }
    if($googlescholar && trim($googlescholar) != '')
    {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$googlescholar.'" target="_blank"><span class="label label-info"><span class="glyphicon glyphicon-link">GoogleScholar </span></span></a>';
    }
    if($dblp && trim($dblp) != '')
    {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$dblp.'" target="_blank"><span class="label label-info"><span class="glyphicon glyphicon-link">DPLB </span></span></a>';
    }
    echo '</p>';

}

/**
 * Pinta el grupo(s) del profesor
 * @param int $id_prof id el profesor a pintar
 * @param str $titulo si se quiere o no mostrar el título.
 */
function pintarGrupo($id_prof, $titulo)
{
    $grupos  = darGrupos($id_prof);
    if($grupos)
    {
        echo ($titulo == 'true') ? '<h4><i class="fa fa-users"></i> <span class="info_prof_es" style="display:inline;">Grupo:: </span><span class="info_prof_en" style="display:none;">Research Group: </span></h4>': '';
        echo '<ul style="list-style: none;">';
        foreach ($grupos as $grup) {
            if($grup->description != '' && substr($grup->description, 0 ,4) =='http' )
            {
                echo '<li><a href="'.$grup->description.'" target="_blank">'.$grup->name.'</a></li>';
            }
            else
            {
                 echo '<li>'.$grup->name.'</li>';
            }


        }
        echo '</ul>';
    }

}

/**
 *  TODO: Los métodos en inglés deberían ser uno solo ya que en algunos sólo cambian los títulos.
 *  TODO: En este momento si se hace un cambio se deben hacer en todos los métodos es y en. Qué pasa si se aumentan el número de idiomas?
 * Pinta el grupo(s) del profesor en Inglés.
 *
 * @param int $id_prof id el profesor a pintar
 * @param str $titulo si se quiere o no mostrar el título.
 */
function pintarGrupo_en($id_prof, $titulo)
{
    $grupos  = darGrupos($id_prof);
    if($grupos)
    {
        echo ($titulo == 'true') ? '<h4><span class="info_prof_en" style="display:inline;">Research Group: </span></h4>': '';
        echo '<ul style="list-style: none;">';
        foreach ($grupos as $grup) {
            if($grup->description != '' && substr($grup->description, 0 ,4) =='http' )
            {
                echo '<li><a href="'.$grup->description.'" target="_blank">'.$grup->name.'</a></li>';
            }
            else
            {
                 echo '<li>'.$grup->name.'</li>';
            }


        }
        echo '</ul>';
    }

}

/**
 * pinta la categoría(s) del profesor
 * @param int $id_prof id el profesor a pintar
 */
function pintarCategoria($id_prof)
{
    $categorias  = darCategorias($id_prof);
    if($categorias)
    {
        echo '<ul style="list-style: none;">';
        foreach ($categorias as $cat) {
            echo '<li>'.$cat->name.'</li>';
        }
        echo '</ul>';
    }

}

/**
 * Pinta la información de cursos del profesor
 * @param int $id_prof id el profesor a pintar
 */
function pintarCursos($id_prof)

{
    $cursos  = get_post_meta($id_prof, 'cursos_profesor_disc', true);
     if(trim($cursos) != '')
     {
       ?>
          <div><?php echo $cursos; ?></div>
     <?php }
}

/**
 * Pinta la información de cursos del profesor en inglés
 * @param int $id_prof id el profesor a pintar
 */
function pintarCursos_en($id_prof)
{
    $cursos  = get_post_meta($id_prof, 'cursos_profesor_disc_en', true);
     if(trim($cursos) != '')
     {?>
          <div><?php echo $cursos; ?></div>
     <?php }
}

/**
 * Pinta la información de los intereses del profesor
 * @param int $id_prof id el profesor a pintar
 */
function pintarIntereses($id_prof, $titulo)
{
    $intereses  = get_post_meta($id_prof, 'intereses_profesor_disc', true);
     if(trim($intereses) != '')
     {
        echo ($titulo == 'true') ? '<h4><i class="fa fa-check-circle"></i> Intereses y líneas de Investigación:</h4>': '';
       ?>

          <div><?php echo $intereses; ?></div>
     <?php }
}

/**
 * Pinta la información de los intereses del profesor ebn inglés
 * @param int $id_prof id el profesor a pintar
 */
function pintarIntereses_en($id_prof, $titulo)
{
    $intereses  = get_post_meta($id_prof, 'intereses_profesor_disc_en', true);
     if(trim($intereses) != '')
     {
        echo ($titulo == 'true') ? '<h4><i class="fa fa-check-circle"></i> Interests and Research lines:</h4>': '';
       ?>

          <div><?php echo $intereses; ?></div>
     <?php }


}

/**
 * Pinta la información de formación del profesor
 * @param int $id_prof id el profesor a pintar
 */
function pintarFormacion($id_prof)
{
    $formacion  = get_post_meta($id_prof, 'formacion_profesor_disc', true);
     if(trim($formacion) != '')
     {?>
          <div><?php echo $formacion; ?></div>
     <?php }
}

/**
 * Pinta la información de formación del profesor en inglés
 * @param int $id_prof id el profesor a pintar
 */
function pintarFormacion_en($id_prof)
{
    $formacion  = get_post_meta($id_prof, 'formacion_profesor_disc_en', true);
     if(trim($formacion) != '')
     {?>
          <div><?php echo $formacion; ?></div>
     <?php }
}

/**
 * Pinta el nombre para mostrar del profesor
 * @param int $id_prof id el profesor a pintar
 * @param String $imagen clase de la imagen
 */
function pintarNombreMostrar($id_prof, $imagen)
{
    $nombre = get_post_meta($id_prof, 'nombre_mostrar', true);
    $img = wp_get_attachment_url(get_post_thumbnail_id($id_prof));

    if($imagen != '' && $img)
    {?>
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $img; ?>" alt="profesor" class="<?php echo $imagen; ?> img-profesor"/>
            </div>
            <div class="col-md-8">
                <h2><?php echo $nombre; ?></h2>
            </div>
        </div>
    <?php }
    else
    {?>
        <h2><?php echo $nombre; ?></h2>
    <?php }
}

/**
 * Pinta el nombre del profesor
 * @param int $id_prof id el profesor a pintar
 * @param String $imagen clase de la imagen
 */
function pintarNombre($id_prof, $imagen)
{
    $nombre = get_post_meta($id_prof, 'nombre_prof_disc', true);
    $img = wp_get_attachment_url(get_post_thumbnail_id($id_prof));

    if($imagen != '' && $img)
    {?>
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $img; ?>" alt="profesor" class="<?php echo $imagen; ?> img-profesor"/>
            </div>
            <div class="col-md-8">
                <h2><?php echo $nombre; ?></h2>
            </div>
        </div>
    <?php }
    else
    {?>
        <h2><?php echo $nombre; ?></h2>
    <?php }
}

/**
 * Pinta la información de contacto del profesor
 * @param int $id_prof id el profesor a pintar
 * @param String $imagen clase de la imagen
 */
function pintarContacto($id_prof, $imagen, $titulo)
{
    $img = wp_get_attachment_url(get_post_thumbnail_id($id_prof));

    echo ($titulo == 'true') ? '<h4><span class="glyphicon glyphicon-user"></span>  Contacto:</h4>': '';
    if($imagen != '' && $img)
    {?>
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $img; ?>" alt="profesor" class="<?php echo $imagen; ?> img-profesor"/>
            </div>
            <div class="col-md-8">
                <?php pintarContactoNoImg($id_prof);?>
            </div>
        </div>
    <?php }
    else
    {
        pintarContactoNoImg($id_prof);
    }

}

/**
 * Pinta la información de contacto del profesor en Inglés
 * @param int $id_prof id el profesor a pintar
 * @param String $imagen clase de la imagen
 */
function pintarContacto_en($id_prof, $imagen, $titulo)
{
    $img = wp_get_attachment_url(get_post_thumbnail_id($id_prof));

    echo ($titulo == 'true') ? '<h4><span class="glyphicon glyphicon-user"></span>  Contact:</h4>': '';
    if($imagen != '' && $img)
    {?>
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $img; ?>" alt="profesor" class="<?php echo $imagen; ?> img-profesor"/>
            </div>
            <div class="col-md-8">
                <?php pintarContactoNoImg_en($id_prof);?>
            </div>
        </div>
    <?php }
    else
    {
        pintarContactoNoImg_en($id_prof);
    }

}

/**
 * Pinta la información de contacto del profesor sin imagen en Inglés
 * @param int $id_prof id el profesor a pintar
 */
function pintarContactoNoImg_en($id_prof)
{
    $oficina = get_post_meta($id_prof, 'oficina', true);
    $correo = get_post_meta($id_prof, 'correo', true);
    $extension = get_post_meta($id_prof, 'extension', true);

    ?>


    <?php
    if($oficina && trim($oficina) != '')
    {?>

        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="glyphicon glyphicon-home"></span> <span class="info_prof_en" style="display:inline;">Office: </span> </b> <?php echo $oficina; ?></p>

    <?php }
    if($correo && trim($correo) != '')
    { ?>
      <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="glyphicon glyphicon-envelope"></span><span class="info_prof_en" style="display:inline;"> Email: </span> </b> <?php echo enmascarar_correo($correo); ?> </div>
     <?php }
    if($extension && trim($extension) != '')
    {?>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="glyphicon glyphicon-earphone"></span><span class="info_prof_en" style="display:inline;"> Extension: </span> </b> <?php echo $extension; ?></p>
    <?php
    }
  }


/**
 * Pinta la información de contacto del profesor sin imagen
 * @param int $id_prof id el profesor a pintar
 */
function pintarContactoNoImg($id_prof)
{
    $oficina = get_post_meta($id_prof, 'oficina', true);
    $correo = get_post_meta($id_prof, 'correo', true);
    $extension = get_post_meta($id_prof, 'extension', true);

    ?>


    <?php
    if($oficina && trim($oficina) != '')
    {?>

        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="glyphicon glyphicon-home"></span> <span class="info_prof_es" style="display:inline;">Oficina: </span><span class="info_prof_en" style="display:none;">Office: </span> </b> <?php echo $oficina; ?></p>

    <?php }
    if($correo && trim($correo) != '')
    { ?>
      <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="glyphicon glyphicon-envelope"></span> <span class="info_prof_es" style="display:inline;">Correo: </span><span class="info_prof_en" style="display:none;">Email: </span> </b> <?php echo enmascarar_correo($correo); ?> </div>
     <?php }
    if($extension && trim($extension) != '')
    {?>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="glyphicon glyphicon-earphone"></span> <span class="info_prof_es" style="display:inline;">Extensión: </span><span class="info_prof_en" style="display:none;">Extension: </span> </b> <?php echo $extension; ?></p>
    <?php
    }
  }

/**
 * Pinta la información de redes sociales del profesor
 * @param int $id_prof id el profesor a pintar
 * @param String $imagen clase de la imagen
 */
function pintarSocial($id_prof, $imagen)
{
    $img = wp_get_attachment_url(get_post_thumbnail_id($id_prof));

    if($imagen != '' && $img)
    {?>
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $img; ?>" alt="profesor" class="<?php echo $imagen; ?> img-profesor"/>
            </div>
            <div class="col-md-8">
                <?php pintarSocialNoImg($id_prof);?>
            </div>
        </div>
    <?php }
    else
    {
        pintarSocialNoImg($id_prof);
    }
}

/**
 * Pinta la información de redes sociales del profesor sin imagen
 * @param int $id_prof id el profesor a pintar
 */
function pintarSocialNoImg($id_prof)
{
    $face = get_post_meta($id_prof, 'facebook', true);
    $twitter = get_post_meta($id_prof, 'twitter', true);
    $google = get_post_meta($id_prof, 'google', true);
    $linked = get_post_meta($id_prof, 'linkedin', true);
    $researchgate = get_post_meta($id_prof, 'researchgate', true);
    $googlescholar = get_post_meta($id_prof, 'googlescholar', true);
    $dblp = get_post_meta($id_prof, 'dblp', true);

    echo '<p class="redes">';
     if($face && trim($face) != '')
    {?>
        <a href="https://www.facebook.com/<?php echo $face; ?>" target="_blank"><i class="fa fa-facebook-square fa-2x"></i></a>
    <?php }
    if($twitter && trim($twitter) != '')
    {?>
        <a href="https://www.twitter.com/<?php echo $twitter; ?>" target="_blank"><i class="fa fa-twitter fa-2x"></i></a>
    <?php }
    if($google && trim($google) != '')
    {?>
        <a href="<?php echo $google; ?>" target="_blank"><i class="fa fa-google-plus fa-2x"></i></a>
    <?php }
    if($linked && trim($linked) != '')
    {?>
        <a href="<?php echo $linked; ?>" target="_blank"><i class="fa fa-linkedin fa-2x"></i></a>
    <?php }
    if($researchgate && trim($researchgate) != '')
    {?>
        <a href="<?php echo $googlescholar; ?>" target="_blank"><span class="label label-info"><span class="glyphicon glyphicon-link">ResearchGate </span></span></a>
    <?php }
    if($googlescholar && trim($googlescholar) != '')
    {?>
        <a href="<?php echo $googlescholar; ?>" target="_blank"><span class="label label-info"><span class="glyphicon glyphicon-link">GoogleScholar </span></span></a>
    <?php }
    if($dblp && trim($dblp) != '')
    {?>
        <a href="<?php echo $researchgate; ?>" target="_blank"><span class="label label-info"><span class="glyphicon glyphicon-link"> DPLB </span></span></a>
    <?php }
    echo '</p>';

}

/**
 * Pinta toda la información del profesor para el temaplte single
 * @param int $id_prof id el profesor a pintar
 * @param String $imagen clase de la imagen
 * @param String $presentacion la presentación que se desea usar
 */
function pintarAllSingle($id_prof, $imagen)
{?>
         <div class="row">
            <div class="col-md-9 hidden-sm hidden-xs"></div>
            <div class="col-md-3">
                <div class="dropdown">
                    <button id="bt_idioma_prof_disc" class="btn btn-disc dropdown-toggle" type="button" data-toggle="dropdown">
                        <img id="img_idioma_prof_disc" src="<?php echo plugins_url( 'img/ES.png', __FILE__ ) ?>"/>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick="cambiarIdioma('ES')">ES <img src="<?php echo plugins_url( 'img/ES.png', __FILE__ ) ?>"/></a></li>
                        <li><a href="#" onclick="cambiarIdioma('EN')">EN <img src="<?php echo plugins_url( 'img/EN.png', __FILE__ ) ?>"/></a></li>
                    </ul>
               </div>
            </div>
        </div>
        <?php

        $nombre = get_post_meta($id_prof, 'nombre_mostrar', true);
        echo '<h2>'.$nombre.'</h2>';
        ?>
        <div class="info_prof_es" style="display:inline;">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#general">Información general</a></li>
                <li><a data-toggle="tab" href="#formacion">Formación</a></li>
                <li><a data-toggle="tab" href="#investigacion">Investigación</a></li>
                <li><a data-toggle="tab" href="#docencia">Docencia</a></li>
            </ul>
            <div class="tab-content">
                <div id="general" class="tab-pane fade in active">
                    <?php pintarGeneralSingle($id_prof, $imagen); ?>
                </div>
                <div id="formacion" class="tab-pane fade">
                    <h2>Formación académica</h2>
                    <?php pintarFormacion($id_prof); ?>
                </div>
                <div id="investigacion" class="tab-pane fade">
                    <h2>Líneas de investigación y áreas de interés</h2>
                    <?php pintarIntereses($id_prof, false); ?>
                </div>
                <div id="docencia" class="tab-pane fade">
                    <h2>Cursos</h2>
                    <?php pintarCursos($id_prof); ?>
                </div>
            </div>
        </div>
        <div class="info_prof_en" style="display:none;">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#generalinformation">General information</a></li>
                <li><a data-toggle="tab" href="#degrees">Degrees</a></li>
                <li><a data-toggle="tab" href="#research">Research</a></li>
                <li><a data-toggle="tab" href="#teaching">Teaching</a></li>
            </ul>
            <div class="tab-content">
                <div id="generalinformation" class="tab-pane fade in active">
                    <?php pintarGeneralSingle_en($id_prof, $imagen); ?>
                </div>
                <div id="degrees" class="tab-pane fade">
                    <h2>Academic degrees</h2>
                    <?php pintarFormacion_en($id_prof); ?>
                </div>
                <div id="research" class="tab-pane fade">
                    <h2>Research lines and areas of interest</h2>
                    <?php pintarIntereses_en($id_prof); ?>
                </div>
                <div id="teaching" class="tab-pane fade">
                    <h2>Courses</h2>
                    <?php pintarCursos_en($id_prof); ?>
                </div>
            </div>
        </div>

    <?php
}

/**
 * Pinta solo la info general del profesor (contacto + redes) para el tempalte single
 * @param int $id_prof id el profesor a pintar
 * @param String $imagen clase de la imagen
 */
function pintarGeneralSingle($id_prof, $imagen)
{
    $img = wp_get_attachment_url(get_post_thumbnail_id($id_prof));

    if($imagen != '' && $img)
    {?>
        <div class="row">
            <div class="col-md-4">
                <br />
                <img src="<?php echo $img; ?>" alt="profesor" class="<?php echo $imagen; ?> img-profesor"/>
            </div>
            <div class="col-md-8">
                <?php pintarGeneralNoImg($id_prof);?>
            </div>
        </div>
    <?php }
    else
    {
        pintarGeneralNoImg($id_prof);
    }
}

/**
 * Pinta solo la info general del profesor (contacto + redes) para el tempalte single en inglés
 * @param int $id_prof id el profesor a pintar
 * @param String $imagen clase de la imagen
 */
function pintarGeneralSingle_en($id_prof, $imagen)
{
    $img = wp_get_attachment_url(get_post_thumbnail_id($id_prof));

    if($imagen != '' && $img)
    {?>
        <div class="row">
            <div class="col-md-4">
                <br />
                <img src="<?php echo $img; ?>" alt="profesor" class="<?php echo $imagen; ?> img-profesor"/>
            </div>
            <div class="col-md-8">
                <?php pintarGeneralNoImg_en($id_prof);?>
            </div>
        </div>
    <?php }
    else
    {
        pintarGeneralNoImg_en($id_prof);
    }
}

/**
* Pinta todos los profesores para listarlos en el Home.
* A tener en cuenta: Por los post_type pasados por parámetros se hace una búsqueda con el query_posts.
* Esto desborda a otro método. Esta solución debería tener un refactoring. Para no permitir efectos de borde.
* @param Array $params para buscar los posts de los profesores a pintar.
* @param Array $post_types los post_types a ser buscados.
* @param int $columna Indica el número de columnas a pintar.
*/
function pintarListadoProfesores($params, $post_types, $columna, $visualizacion){
  //Solicita el script filtro_profesores. Esto se hace bajo demanda.
   wp_enqueue_script('filtro_profesores',plugins_url('js/filtro_profesores.js', __FILE__), true); ?>

     <div id="profesores">
         <div class="row">
             <div class="col-md-9 hidden-sm hidden-xs">
               <div class="col-md-2"><h4 style="text-align: center;">Buscar: </h4></div>
               <div class="col-md-7"><input type="text" class="search form-control"  placeholder="Nombre o correo" onclick="functionprof()"></div>
             </div>
             <div class="col-md-3">
                 <div class="dropdown">
                     <button id="bt_idioma_prof_disc" class="btn btn-disc dropdown-toggle" type="button" data-toggle="dropdown">
                         <img id="img_idioma_prof_disc" src="<?php echo plugins_url( 'img/ES.png', __FILE__ ) ?>"/>
                         <span class="caret"></span>
                     </button>
                     <ul class="dropdown-menu">
                         <li><a href="#" onclick="cambiarIdioma('ES')">ES <img src="<?php echo plugins_url( 'img/ES.png', __FILE__ ) ?>"/></a></li>
                         <li><a href="#" onclick="cambiarIdioma('EN')">EN <img src="<?php echo plugins_url( 'img/EN.png', __FILE__ ) ?>"/></a></li>
                     </ul>
                </div>
             </div>
         </div>
      <div class="row">
      <ul class="list" style="list-style-type:none;">
        <?php if( isset($post_types['post_type']) && in_array('disc_profesores', $post_types['post_type'])): ?>
          <?php $params['post_type'] = 'disc_profesores'; query_posts($params);   ?>
            <li><h2> <span class="info_prof_es" style="display:inline;">Profesores </span><span class="info_prof_en" style="display:none;">Professor </span>  </h2></li>
            <?php ($visualizacion === 'tarjeta') ? pintarListadoProfesores_delegado_tarjeta($columna) : pintarListadoProfesores_delegado_lista($columna); ?>
        <?php endif; ?>

        <?php if(isset($post_types['post_type']) && in_array('disc_prof_catedra', $post_types['post_type'])): ?>
            <?php $params['post_type'] = 'disc_prof_catedra'; query_posts($params);   ?>
          <li> <br> <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12"><h2>  <span class="info_prof_es" style="display:inline;">Profesores de Cátedra</span><span class="info_prof_en" style="display:none;">Adjunct Professor </span>  </h2> </div></li>
          <?php ($visualizacion === 'tarjeta') ? pintarListadoProfesores_delegado_tarjeta($columna) : pintarListadoProfesores_delegado_lista($columna); ?>
        <?php endif;?>
      </ul>
      </div>
    </div>

<?php
    wp_reset_query();
}


/**
* Este método delegado sirve para imprimir el listado de los profesores.
* Se debe tener cuidado al usarlo debido a qué el método usa el resultado de query_posts de métodos anteriores.
* Puede ocasinar efectos de borde.
* @param int $Columna Número de columnas para imprimir los profesores.
*/
function pintarListadoProfesores_delegado_tarjeta($columna){
        //Sirve para decidir si usar h2 o h3. Esto depende si se imprimen 1 o 2 columnas.
          $tipo_titulo_inicio = '<h3 class="nombre">';
          $tipo_titulo_fin = '</h3>';
        ?>
           <?php while ( have_posts() ) : the_post(); ?>
            <?php
              $id_prof = get_the_ID();
              $nombre = get_post_meta($id_prof, 'nombre_mostrar', true);
              $categorias  = darCategorias($id_prof);
              $grupos  = darGrupos($id_prof);
              reset($grupos);
              $grupo = strtolower(($grupos) ? explode("-",current($grupos)->name)[0] : "disc");
            ?>
            <li>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="flip-container">
                  <div class="flipper">
                    <div class="front">
                      <div class="box-profesor box-color-<?php echo($grupo); ?>">
                          <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail('thumbnail', array('class'=>'img-profesor, round-image')); ?>
                          <?php endif; ?>
                          <p>
                            <?php $real_title_path = str_replace(array("-","."),"",get_the_title()); ?>
                            <?php echo $tipo_titulo_inicio; ?><?php echo $nombre; ?> <?php echo $tipo_titulo_fin; ?>
                            <ul style="list-style: none;">
                              <?php
                                foreach ($categorias as $cat) {
                                  echo '<li><h4>'.$cat->name.'</h4></li>';
                                }
                              ?>
                            </ul>
                          </p>
                        </div>
                    </div>
                    <div class="back">
                      <div class="box-profesor box-color-<?php echo($grupo); ?>">
                        <?php echo $tipo_titulo_inicio; ?> <a href="<?php echo get_home_url().'/'.$real_title_path; ?>"><?php echo $nombre; ?></a>  <?php echo $tipo_titulo_fin; ?>
                        <?php pintarContactoNoImg($id_prof); ?>
                        <?php pintarGrupo($id_prof, 'true'); ?>
                        <?php pintarSocialNoImg($id_prof); ?>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </li>
              <?php endwhile;
}

/**
* Este método delegado sirve para imprimir el listado de los profesores.
* Se debe tener cuidado al usarlo debido a qué el método usa el resultado de query_posts de métodos anteriores.
* Puede ocasinar efectos de borde.
* @param int $Columna Número de columnas para imprimir los profesores.
*/
function pintarListadoProfesores_delegado_lista($columna){
        //Sirve para decidir si usar h2 o h3. Esto depende si se imprimen 1 o 2 columnas.
          $tipo_titulo_inicio = ($columna=="2") ? '<h3 class="nombre">' : '<h3 class="nombre">';
          $tipo_titulo_fin = ($columna=="2") ? '</h3>' : '</h2>';
        ?>
           <?php while ( have_posts() ) : the_post(); ?>

                            <li>
                             <?php echo (($columna  == 1) ? '<div class="col-md-12">' : '<div class="col-md-6">') ?>
                               <div class="row">
                                   <?php echo (($columna  == 1) ? '<div class="col-md-3">' : '<div class="col-md-4">') ?>
                                     <?php if ( has_post_thumbnail() ) : ?>
                                         <?php the_post_thumbnail('thumbnail', array('class'=>'img-profesor')); ?>
                                     <?php endif; ?>
                                 </div>
                                 <?php echo (($columna  == 1) ? '<div class="col-md-9 info-profesor">' : '<div class="col-md-8 info-profesor">') ?>
                                     <?php
                                         $id_prof = get_the_ID();
                                         $nombre = get_post_meta($id_prof, 'nombre_mostrar', true);
                                         $categorias  = darCategorias($id_prof);
                                         $grupos  = darGrupos($id_prof);
                                    ?>
                                    <!--- No se debería dejar puntos, guiones en el path de la url. --->
                                    <?php $real_title_path = str_replace(array("-","."),"",get_the_title()); ?>
                                     <?php echo $tipo_titulo_inicio; ?> <a href="<?php echo get_home_url().'/'.$real_title_path; ?>"><?php echo $nombre; ?></a>  <?php echo $tipo_titulo_fin; ?>
                                     <?php
                                         echo '<div class="info_prof_es info" style="display:inline;">';
                                         echo '<h4><span class="glyphicon glyphicon-bookmark"></span> Categoría:</h4>';
                                         if($categorias)
                                         {
                                            echo '<ul style="list-style: none;">';
                                            foreach ($categorias as $cat) {
                                                echo '<li>'.$cat->name.'</li>';
                                            }
                                            echo '</ul>';
                                         }
                                         echo '</div>';
                                         echo '<div class="info_prof_en" style="display:none;">';
                                         echo '<h4><span class="glyphicon glyphicon-bookmark"></span> Category:</h4>';
                                         if($categorias)
                                         {
                                            echo '<ul style="list-style: none;">';
                                            foreach ($categorias as $cat) {
                                                $catAdicional = darGruposInfoAdicional($cat->idCat);
                                                echo '<li>'.$catAdicional['nombre_cat_en'].'</li>';
                                            }
                                            echo '</ul>';
                                         }
                                         echo '</div>';

                                         if(get_post_type() === 'disc_profesores'){
                                           echo '<div class="info_prof_es" style="display:inline;">';


                                           echo '<h4><i class="fa fa-users"></i> Grupo:</h4>';
                                           if($grupos)
                                           {
                                             echo '<ul style="list-style: none;">';
                                             foreach ($grupos as $grup) {
                                               if($grup->description != '' && substr($grup->description, 0 ,4) =='http' )
                                               {
                                                 echo '<li><a href="'.$grup->description.'" target="_blank">'.$grup->name.'</a></li>';
                                               }
                                               else
                                               {
                                                 echo '<li>'.$grup->name.'</li>';
                                               }


                                             }
                                             echo '</ul>';
                                           }
                                           echo '</div>';
                                         }
                                          echo '<div class="info_prof_en" style="display:none;">';
                                          echo '<h4><i class="fa fa-users"></i> Research Group:</h4>';
                                          if($grupos)
                                         {
                                            echo '<ul style="list-style: none;">';
                                            foreach ($grupos as $grup) {
                                                $grupoAdicional = darGruposInfoAdicional($grup->idGrupo);
                                                if($grup->description != '' && substr($grup->description, 0 ,4) =='http' )
                                                {
                                                    echo '<li><a href="'.$grup->description.'" target="_blank">'.$grupoAdicional['nombre_grupo_en'].'</a></li>';
                                                }
                                                else
                                                {
                                                     echo '<li>'.$grupoAdicional['nombre_grupo_en'].'</li>';
                                                }


                                            }
                                            echo '</ul>';
                                         }
                                         echo '</div>';
                                     ?>
                                 </div>
                                <?php //echo ((($contador_profesores % 2) === 0) ? '</div>' : '') ?>
                              <!--- Este div es del ROW -->
                            </div>
                            <!--- Este div es de la columna -->
                          </div>
                           </li>
              <?php endwhile;
}
