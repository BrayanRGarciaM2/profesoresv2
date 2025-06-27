/* Poner codigo javascript personalizado en esta seccion*/
/*Sera agregado a cada pagina.*/

/**
 * Funcion para agregar on load events evitando conflictos
 * @param {type} func
 * @returns {undefined}
 */
function addOnloadEvent(func) {
    var oldonload = window.onload;
    if (typeof window.onload != 'function') {
        window.onload = func;
    }
    else {
        window.onload = function () {
            if (oldonload) {
                oldonload();
            }
            func();
        }
    }
}


