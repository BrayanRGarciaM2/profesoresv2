<?php

////////////////////////////////////////////// Consulta de estudiantes de Doctorado  ////////////////////////////////////////////////////////////////////////////////

/**
 * Agrega el shortcode para poder consutlar estudiantes doctorales desde academia
 */
add_shortcode('disc-academia-doctorandos', 'disc_academia_doctorandos');
function disc_academia_doctorandos($atts)
{
    extract(shortcode_atts(array('usuario'=>''), $atts));?>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#uniandes">En Uniandes</a></li>
        <li><a data-toggle="tab" href="#pasantia">En pasantía</a></li>
        <li><a data-toggle="tab" href="#candidatos">Candidato a grado</a></li>
        <li><a data-toggle="tab" href="#graduado">Graduado</a></li>
    </ul>
    <?php $asesor = cargar_nombre_asesor($usuario); ?>

    <div class="tab-content">
        <?php cargar_academia_doctorandos($asesor); ?>
    </div>
<?php }

/**
 * Consulta los estudiantes doctorales del profesor cuyo nombre completo llega por parámetro
 * @param String $asesor nombre completo del profesor
 */
function cargar_academia_doctorandos($asesor)
{
    $url = 'https://academia.uniandes.edu.co/WebServicesAcademy/phDStudentsServlet?dependencyExternalId=ISIS&hasState=select&phDStudentStatus=1&limit=100';
    $json = file_get_contents($url);
    $results = json_decode($json, true);
    $data = $results['phDStudents'];?>
    <div id="uniandes" class="tab-pane fade in active">
        <h3>En Uniandes</h3>
        <ul style="list-style-type: none;">
            <?php foreach ($data as $estudiante):?>
                <?php if($estudiante['advisor'] == $asesor): ?>
                    <?php pintarEstudiante($estudiante); ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
    $url = 'https://academia.uniandes.edu.co/WebServicesAcademy/phDStudentsServlet?dependencyExternalId=ISIS&hasState=select&phDStudentStatus=2&limit=100';
    $json = file_get_contents($url);
    $results = json_decode($json, true);
    $data = $results['phDStudents'];?>
    <div id="pasantia" class="tab-pane fade">
          <h3>En pasantía</h3>
        <ul style="list-style-type: none;">
            <?php foreach ($data as $estudiante):?>
                <?php if($estudiante['advisor'] == $asesor): ?>
                    <?php pintarEstudiante($estudiante); ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
     <?php
    $url = 'https://academia.uniandes.edu.co/WebServicesAcademy/phDStudentsServlet?dependencyExternalId=ISIS&hasState=select&phDStudentStatus=4&limit=100';
    $json = file_get_contents($url);
    $results = json_decode($json, true);
    $data = $results['phDStudents'];?>
    <div id="candidatos" class="tab-pane fade">
          <h3>Candidato a grado</h3>
        <ul style="list-style-type: none;">
            <?php foreach ($data as $estudiante):?>
                <?php if($estudiante['advisor'] == $asesor): ?>
                    <?php pintarEstudiante($estudiante); ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
     <?php
    $url = 'https://academia.uniandes.edu.co/WebServicesAcademy/phDStudentsServlet?dependencyExternalId=ISIS&hasState=select&phDStudentStatus=3&limit=100';
    $json = file_get_contents($url);
    $results = json_decode($json, true);
    $data = $results['phDStudents'];?>
    <div id="graduado" class="tab-pane fade">
        <h3>Graduado</h3>
        <ul style="list-style-type: none;">
            <?php foreach ($data as $estudiante):?>
                <?php if($estudiante['advisor'] == $asesor): ?>
                    <?php pintarEstudiante($estudiante); ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>

<?php }

/**
 * Consulta el nombre completo del profesor para poder fitlrar sus estudiantes doctorales
 * @param String $usuario el usuario uniandes del profesor de quien se desea conocer el nombre
 * @return String nombre completo del profesor
 */
function cargar_nombre_asesor($usuario)
{
    $url = 'https://academia.uniandes.edu.co/WebServicesAcademy/searchFacultiesServlet?idExternalDepart=ISIS&currentDependencyExternalId=ISIS&dependencyMemberExternalId=ISIS&facultyState=true&hasCategory=all&useLikeUsername=true&showPhoto=true&limit=1&userName='.$usuario;
    $json = file_get_contents($url);
    $results = json_decode($json, true);
    $data = $results['faculties'][0];
    return $data['completeName'];
}
