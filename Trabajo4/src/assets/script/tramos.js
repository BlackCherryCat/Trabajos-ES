//Añadimos eventos a los botones de añadir tramo
window.onload = function(){
    let botones = document.querySelectorAll("div.nuevo")
    botones.forEach(boton => {
        boton.addEventListener("click", changeButton)
    })
}

//Función que modifica los botones al clickar
function changeButton(e){
    let boton = e.target;
    console.log(boton)
}