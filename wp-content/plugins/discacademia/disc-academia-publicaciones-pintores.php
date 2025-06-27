<?php
/**
 * Imprimi un array de resultados desde academia
 * @param array $results las publicaciones que se desean pintar
 */
function imprimirAcademiaPublicaciones($results,$offset){
    global $tipos;
    // Count de la cantidad de publicaciones
    foreach ($results as $result){
        imprimirEnFormatoPublicacion($result['type'],$result['year'], $result['title'], $result['reference'], $offset);
    }
  }

function imprimirEnFormatoPublicacion($tipo_publicacion, $anio, $titulo_publicacion, $referencia, $offset = 20){
  global $tipos;?>

  <li id="<?php echo($offset/20) ?>" class="<?php echo 't'.$tipo_publicacion ?> <?php echo 'y'.$anio ?> publicacion">
    <div class="item-publicacion">
      <div class="row">
        <div class="col-md-11">
          <span class="titulo-publicacion"><?php echo $titulo_publicacion; ?></span>
          <span class="label label-success"><?php echo $tipos[$tipo_publicacion] ? $tipos[$tipo_publicacion] : $tipo_publicacion  ?></span>
        </div>
        <div class="col-md-1">
            <i><p><?php echo $anio ?> </b></p></i>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12"
          <p><?php echo $referencia ?> - <b> <?php echo $anio ?> </b></p>
        </div>
      </div>

        <!--<p><b>Tipo:</b> <?php //echo $tipos[$result['type']]; ?></p>
        <p><b>Año:</b> <?php echo $result['year']; ?></p>
        <p><b>Referencia:</b> <?php echo $result['reference']; ?></p>-->
    </div>
  </li>

<?php }

/**
* Imprime un array de los cursos de un determinado profesor
* @param array $results con los cursos a imprimir
*/
function imprimirCursosProfesores($results){
  $entro_anio = 0;
  $entro_periodo = 0;
  $nuevo_anio = true;
  $periodo = 0;
  $anio = 0;?>

  <div class="cursos">

    <?php // Se recorre cada curso. Si un curso pertenece a un nuevo periodo y año se crean nuevos divs, para el año y para el período.
    foreach ($results as $key => $curso): ?>
      <?php if($anio !== $curso['year']):
          $anio = $curso['year'];
          $entro_anio = $entro_anio + 1;
          if($entro_periodo > 0):
            ?>
        </div>
          <?php endif;
          if($entro_anio > 1): ?>
        </div>
            <?php  $entro_anio=1;
              $periodo = 0;
              $entro_periodo = 0;
          endif;?>

        <button class="accordion"> <strong><?php echo $anio; ?> </strong> </button>
        <div class="panel" id="div_accordion_panel">

      <?php endif; ?>

      <?php if($periodo !== $curso['period']['id']):
        $periodo =  $curso['period']['id'];
        $entro_periodo = $entro_periodo + 1;
        if($entro_periodo > 1): ?>
        </div>

        <?php
        $entro_periodo=1;
        endif;
        ?>
            <div class="col-md-6">
              <h4><?php echo $anio.'-'.$periodo; ?> </h4>
      <?php endif; ?>

        <p> <?php echo $curso['name']; ?> </p>

    <?php
   endforeach; ?>
</div>
</div>
</div>
<?php }
