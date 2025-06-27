//<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js" />

function functionprof(){
	/* Value names son los nombres de las clases HTML para hacer el filtro. En este caso, las clases son nombre-grupo (Para el
	nombre dl grupo), profesor (Para el nombre del profesor), mail (Correo electrónico) */
	var options = {
		valueNames: [ 'nombre','info' ]
	};
	var userList = new List('profesores', options);

}
addOnloadEvent(functionprof);
