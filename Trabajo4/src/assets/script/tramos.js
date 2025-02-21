//Añadimos eventos a los botones de añadir tramo
window.onload = function(){
    let botones = document.querySelectorAll("div.nuevo")
    botones.forEach(boton => {
        boton.addEventListener("click", changeButton)
    })

    let remove = document.querySelectorAll("div.remove-hover")
    remove.forEach(boton => {
        boton.addEventListener("click", removeActive)
    })
}

//Función que modifica los botones al clickar
function changeButton(e){
    //Obtenemos el botón
    let boton = e.target;
    console.log(boton)
    
    //Obtenenemos la lista de clases de ese div para comprobar si está activo o no
    let clases = boton.classList;
    console.log(clases)
    
    if(clases.contains("active")){
            clases.remove("active")
            boton.innerHTML = "&#10133;<br>Añadir Tramo<br>a la Reserva"
    }else{
            clases.add("active")
            boton.innerHTML = "&#10004;<br>Tramo Añadido"
    } 
}

function removeActive(e){
    let target = e.target.parentNode.childNodes[0];

    target.classList.remove("active");
    target.innerHTML = "&#10133;<br>Añadir Tramo<br>a la Reserva";
}

//Añadir validacion al formulario, si no hay al menos un checkbox seleccionado, no se puede enviar