<?php

////////////////////////////////////////////// Consulta de publicaciones  ////////////////////////////////////////////////////////////////////////////////

/**
 * Agrega el shortcode para poder consutlar publicaciones desde académia
 */
add_shortcode('disc-academia-publicaciones', 'disc_academia_publicaciones');
/**
* Agrega el shortcode para poder pintar publicaciones independientes de academia
*/
add_shortcode('disc-publicacion', 'disc_publicacion');
/**
* Agrega el shortcode para poder pintar publicaciones independientes de academia
*/
add_shortcode('disc-academia-cursos', 'disc_cursos');
/**
 * Pinta el formulario de fitro, recupera el atributo de usuario  y solicita la carga de información
 * @param array $atts los atributos del shortcode
 */
function disc_academia_publicaciones($atts)
{
    global $tipos, $estados_publicaciones;
    // Función me permite obtener los valores desde el array de estados_publicaciones
    $func = function($valor){
      global $estados_publicaciones;
      return $estados_publicaciones[trim($valor)];
    };

    $year = date('Y');
    $args = shortcode_atts(
              array('usuario'=>'',
                    'estado'=>'aceptado'), $atts);
    $usuario = $args['usuario'];
    $estado = array_map($func, explode(',',$args['estado']));
    ?>

    <div class="panel-group" id="accordion">
        <div class="panel panel-disc" id="panelbuscar">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-target="#collapseBuscar" href="#" aria-expanded="true" >Filtrar</a>
                </h4>
            </div>
            <div id="collapseBuscar" class="panel-collapse collapse in">
                <div class="panel-body">
                        <div class="form-group">
                          <label for="tipo">Tipo de publicación:</label>
                          <select class="form-control" id="disctipopublicacion" name="tipo">
                              <option value="0">Todos los tipos</option>
                              <?php foreach ($tipos as $key => $value): ?>
                                <option value="<?php echo $key; ?>"><?php echo $value ?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="inicio">A partir de:</label>
                          <select class="form-control" id="discyearpublicacion" name="inicio">
                              <?php for ($x = 1970; $x <= $year; $x++): ?>
                                    <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                              <?php endfor; ?>
                          </select>
                        </div>
                         <button type="submit" class="btn btn-disc" onclick="filtrar(<?php echo "'".$usuario."'"; ?>)">Filtrar <span class="glyphicon glyphicon-filter"></span></button>
                          <button type="submit" class="btn btn-disc" onclick="limpiar()">Limpiar <span class="glyphicon glyphicon-trash"></span></button>
                </div>
            </div>
        </div>
    </div>
    <div id="pagination" class="col-md-12" align="center">
      <div class="col-md-5"> <button type="button" class="btn btn-default" name="prev" onclick="prevPagination();" style="width:50%;"> <span class="glyphicon glyphicon-menu-left"></span> </button> </div>
      <div id="contador-paginas" class="col-md-2"></div>
      <div class="col-md-5"> <button type="button" class="btn btn-default" name="next" onclick="nextPagination();" style="width:50%;"> <span class="glyphicon glyphicon-menu-right"></span> </button> </div>
    </div>
    <div class="col-md-12">
       <ul id="publicaciones-<?php echo $usuario; ?>" style="list-style-type: none;">
          <?php cargar_academia_publicaciones($usuario, $estado); ?>
      </ul>
    </div>

<?php }

function disc_publicacion($atts)
{
    $args = shortcode_atts(array('tipo'=>'',
                    'anio'=>'',
                    'titulo'=>'',
                    'referencia' => ''),
                    $atts);
    $anio = $args['anio'];
    $tipo_publicacion = $args['tipo'];
    $titulo_publicacion = $args['titulo'];
    $referencia = $args['referencia'];?>

    <div class="col-md-12">
       <ul id="publicaciones">
          <?php imprimirEnFormatoPublicacion($tipo_publicacion, $anio, $titulo_publicacion, $referencia); ?>
      </ul>
    </div>
<?php }

function disc_cursos($atts){
  $args = shortcode_atts(array('usuario'=>''), $atts);
  $usuario = $args['usuario'];
  ?>

  <div class="col-md-12">
        <?php consulta_academia_cursos($usuario); ?>
  </div>
<?php
}
/**
 * Consulta publicaciones desde academia y solicita pintarlas, aquí está usando la nueva API para traer las consultas.
 * @param int $limit la cantidad de publicaciones a consultar
 * @param int $offset publicación desde la que se inicia a buscar
 * @param String $usuario el usuario del que se desean conocer las publicaciones
 * @return array con la respuesta de académia
 */
function consulta_academia_publicaciones($limit, $offset, $usuario, $estado)
{
    global $url_consulta_academia_api, $productos;
    //$url = 'https://academia.uniandes.edu.co/WebServicesAcademy/searchProductsServlet?limit='.$limit.'&offset='.$offset.'&dependencyExternalId=ISIS&productTypeSearch=select&userName='.$usuario;
    $consulta_id_profesor = consulta_id_academia_profesor($usuario);
    $url = sprintf($url_consulta_academia_api, $consulta_id_profesor, $productos);
    $json = file_get_contents($url);
    $results = json_decode($json, true);
    $resultados_a_imprimir = filtrar_publicaciones_por_estado($results['products'], $estado);
    imprimirAcademiaPublicaciones(array_slice($resultados_a_imprimir, $offset, $limit), $offset);
    while( count($resultados_a_imprimir)  >  ($limit+$offset) ){
        $offset += $limit;
        imprimirAcademiaPublicaciones(array_slice($resultados_a_imprimir, $offset, $limit), $offset);
    }
    return $results;
}

function sortByYear($a, $b) {

    $dA = $a['year'];
    $dB = $b['year'];
    $dAPeriod = $a['period']['id'];
    $dBPeriod = $b['period']['id'];

    $resultado = 0;

    if($dA > $dB){
      $resultado = 1;
    }else{
      if($dB > $dA){
        $resultado = -1;
      } else{
        if($dAPeriod > $dBPeriod){
          $resultado = 1;
        }else{
          $resultado = -1;
        }
      }
    }

    return $resultado;
}
/**
* Consulta los cursos de un profesor en Academia
* @param $usuario login del profesor. Se consulta, el id del profesor y luego se consultan los cursos.
*/
function consulta_academia_cursos($usuario){
  global $url_consulta_academia_api, $cursos;
  $consulta_id_profesor = consulta_id_academia_profesor($usuario);
  $url = sprintf($url_consulta_academia_api, $consulta_id_profesor, $cursos);
  $json = file_get_contents($url);
  $results = json_decode($json, true);
  $results = $results['courses'];
  usort($results, 'sortByYear');

  // Función interna, para filtrar Array. Filtra los cursos que empiecen por lab,
  // "EXAMEN","TESIS", "PASANTÍA","INTERCAMBIO","TESIS","EXAMEN","TUTORIAL","LAB"
  $results = array_filter($results, function($obj)
{
   //static $noSubjects = array("EXAMEN PROPUESTA DOCTORADO","TESIS (12CR)", "TESIS (8CR)","PASANTÍA SEMESTRAL","INTERCAMBIO INTERNACIONAL", "TESIS (4CR)","EXAMEN SUSTENTACION DOCTORADO","TUTORIAL 2","TUTORIAL 1","PASANTÍA INTERMESTRAL","TUTORIAL 4","TUTORIAL 5","TUTORIAL 3");
   static $no_subjects = array("EXAMEN","TESIS", "PASANTÍA","INTERCAMBIO","TESIS","EXAMEN","TUTORIAL","LAB","INDUST.SECRETO");
    //static $noSubjects= array();
    static $id_list = array();

    $primer_nombre =  (explode(' ', $obj['name']));
    // Solución para que no se agregue el curso INDUST.SECRETO. DISEÑO INDUST.SECRETO EMPRESAR
    if($primer_nombre[1] === 'INDUST.SECRETO'){
	return false;	
    }
    $primer_nombre = $primer_nombre[0];

    if(in_array($obj['name'].'-'.$obj['year'].$obj['period']['id'],$id_list) || in_array($primer_nombre, $no_subjects) ) {
        return false;
    }
    $id_list []= $obj['name'].'-'.$obj['year'].$obj['period']['id'];
    return true;
});

  imprimirCursosProfesores($results);

}
/**
 * Consulta el ID desde academia y solicita pintarlas
 * @param String $usuario el usuario del que se desean conocer las publicaciones
 * @return id del usuario. Si el usuario no existe retorna -1
 */
function consulta_id_academia_profesor($usuario)
{
    global $url_consulta_academia, $profesor;
    $url = $url_consulta_academia.$profesor.$usuario;
    $json = file_get_contents($url);
    $results = json_decode($json, true);
    return $results['faculties'][0]['id'] ? $results['faculties'][0]['id'] : -1;
}

/**
* Filtra las publicaciones por el estado (Aceptado, Rechazado, En proceso)
* @param Array JSON con las publicaciones.
* @param String. Estado con el cual quiere filtrarse las publicaciones
* @return Array filtrado
*/
function filtrar_publicaciones_por_estado($publicaciones, $estados){

  global $estados_publicaciones;

  $array_filtrado = array();

  if(in_array($estados_publicaciones['todos'], $estados)){
    $array_filtrado = $publicaciones;
  }else{
  foreach ($publicaciones as $pubKey => $publicacion) {

      if(in_array($publicacion['status'],$estados)){
        $array_filtrado[] = $publicacion;
      }
  }
}
  return $array_filtrado;
}

/**
 * Solicita la consulta publicaciones de academia en grupos de 20
 * @param type $usuario el usuario del que se desea consultar las publicaciones
 */
function cargar_academia_publicaciones($usuario, $estado)
{
    $limit = 20;
    $offset = 0;
    $respuesta = consulta_academia_publicaciones($limit, $offset, $usuario, $estado);

}
