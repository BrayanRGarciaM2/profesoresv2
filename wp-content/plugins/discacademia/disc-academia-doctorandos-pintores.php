<?php

/**
* Recibe el array de Estudiante. Imprime el estudiante.
*/
function pintarEstudiante($estudiante)
{?>
    <li class="academia">
        <h4><?php echo $estudiante['name'].' '.$estudiante['lastname']; ?></h4>
        <p>Tesis: <?php echo $estudiante['thesis']; ?></p>
        <p><span class="glyphicon glyphicon-envelope"></span> <?php echo enmascarar_correo($estudiante['username'].'@uniandes.edu.co');?> </p>
    </li>

<?php }
