/**
* Función Limpiar. Se encarga de reiniciar los valores a 0, del filtro.
* Muestra el menú de paginación y reinicia el contador de páginas.
*/
function limpiar(){
	var tip = document.getElementById('disctipopublicacion');
	var yea = document.getElementById('discyearpublicacion');
	var pagination = document.getElementById('pagination');

	tip.selectedIndex = 0;
	yea.selectedIndex = 0;
	pagination.style.display = 'block';
	acumulador = 1;
	refreshPagination();

}
/**
* Función Filtrar. Filtra las publicaciones, por Tipo y Fecha.
*/
function filtrar(usuario){
		var ps = document.getElementById('publicaciones-'+usuario).getElementsByTagName('LI');
		var tip = document.getElementById('disctipopublicacion');
		var yea = document.getElementById('discyearpublicacion');
		var year = yea[yea.selectedIndex].value;
		var cls = tip[tip.selectedIndex].value;
		var pagination = document.getElementById('pagination');
		pagination.style.display = 'none'

		if(cls == 0)
		{
				for (var i=0; i<ps.length; i++)
				{
						var clselem = ' '+ps[i].className + ' ';
						var cls2 = clselem.substring(clselem.indexOf('y')+1, clselem.length).trim();
						if(cls2 >= year)
						{
								ps[i].style.display = 'block';
						}
						else
						{
								ps[i].style.display = 'none';
						}
				}
		}
		else
		{
				for (var i=0; i<ps.length; i++)
				{
						var clselem = ' '+ps[i].className + ' ';
						if((' '+ps[i].className + ' ').indexOf(' t' + cls + ' ') > -1)
						{
								var cls2 = clselem.replace(' t' + cls, '').replace('y', '').trim();
								if(cls2 >= year)
								{
										ps[i].style.display = 'block';
								}
								else
								{
										ps[i].style.display = 'none';
								}
						}
						else
						{
								ps[i].style.display = 'none';
						}
				}
		}
}

/* ------------------- Funciones para la paginación  -------------------------- */
var acumulador = 1;
var divisor = 20;

/*
* Retorna el total de itemas que sean Publicación.
*/
function getTotalItems(){

	console.log("TotalItems"+document.getElementsByClassName("publicacion").length);
	return document.getElementsByClassName("publicacion").length;

}

/**
* Retorna el total de páginas
*/
function getTotalPages(){
	totalPages = Math.round(getTotalItems()/divisor);
	return totalPages > 0 ? totalPages : 1
}

/* Avanza en la paginación */
function nextPagination(){
	// 20 could be a selected option.
	var totalPages = getTotalPages();
	if(acumulador < totalPages){
			acumulador++;
		refreshPagination();
	}
	console.log("Acum Next: "+acumulador);
	console.log("totalPages: "+totalPages);

}

/* Retrocede en la paginación */
function prevPagination(){
	if(acumulador>1){
		acumulador--;
		refreshPagination();
	}
	console.log("Acum Prev: "+acumulador);
}

/* Muestra los items actuales de la página */
function refreshPagination(){

		var pubs = document.getElementsByClassName("publicacion");
		var count = document.getElementById("contador-paginas");

		if(count)
		{
		for(var i=0; i < pubs.length; i++){

				if(pubs[i]['id'] == String(acumulador-1))
					{
							pubs[i].style.display = 'block';
					}
					else
					{
							pubs[i].style.display = 'none';
					}
		}
			count.textContent = (acumulador) + " / " + (getTotalPages());
	}
}

/*Funcionalidad para hacer el accordion, se puede utilizar el de Bootstrap*/
function accordionUpdate(){
	var acc = document.getElementsByClassName("accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
	  acc[i].onclick = function() {
	    this.classList.toggle("active");
	    var panel = this.nextElementSibling;
	    if (panel.style.maxHeight){
	      panel.style.maxHeight = null;
	    } else {
	      panel.style.maxHeight = panel.scrollHeight + "px";
	    }
	  }
	}
}

function start(){
	refreshPagination();
	accordionUpdate();
}

window.onload = start;
