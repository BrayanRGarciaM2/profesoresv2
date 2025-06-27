/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function cambiarIdioma(idioma)
{
    var imagen = document.getElementById('img_idioma_prof_disc');
    var ruta = imagen.src;
    var mostrar;
    var ocultar;
    
    if(idioma == 'EN')
    {
        ruta = ruta.replace('ES', idioma);
        mostrar = document.getElementsByClassName("info_prof_en");
        ocultar = document.getElementsByClassName("info_prof_es");
    }
    else
    {
        ruta = ruta.replace('EN', idioma);
        mostrar = document.getElementsByClassName("info_prof_es");
        ocultar = document.getElementsByClassName("info_prof_en");
    }
    imagen.src = ruta;
    for (var i=0; i<mostrar.length; i++) {
       mostrar[i].style.display = 'inline';
    }
    for (var i=0; i<ocultar.length; i++) {
       ocultar[i].style.display = 'none';
    }
    
}

function cambiarIdiomaProyecto(idioma)
{
    var imagen = document.getElementById('img_idioma_proyecto_disc');
    var ruta = imagen.src;
    var mostrar;
    var ocultar;
    
    if(idioma == 'EN')
    {
        ruta = ruta.replace('ES', idioma);
        mostrar = document.getElementsByClassName("info_proyecto_en");
        ocultar = document.getElementsByClassName("info_proyecto_es");
    }
    else
    {
        ruta = ruta.replace('EN', idioma);
        mostrar = document.getElementsByClassName("info_proyecto_es");
        ocultar = document.getElementsByClassName("info_proyecto_en");
    }
    imagen.src = ruta;
    for (var i=0; i<mostrar.length; i++) {
       mostrar[i].style.display = 'inline';
    }
    for (var i=0; i<ocultar.length; i++) {
       ocultar[i].style.display = 'none';
    }
    
}

