<?php
    require_once './includes/header.php';

    if(isset($_SESSION["plazas"]) && isset($_SESSION["fechaReserva"])){
        $plazas = $_SESSION["plazas"];
        $disponibles = maxAlumnos($plazas);
        selectedTramos();
        $idProfe = $_SESSION["profesor"]["IdProfesor"];
        echo "<form action='./acciones/reservar.php' method='post' id='formReserva'>
        <input type='hidden' name='profe' value='$idProfe' id='idProfesor'>
        
        <h2>Formulario de Reserva</h2><hr>
        <label for='clase'>Seleccione Clase</label><br>
        <select name='clase' id='clase'>
        <option>Seleccione un opción</option>";




        echo printClases($idProfe, $db);
        echo "</select>
        
        <br><br>


        <label for='asignatura'>Seleccione Asignatura</label><br>
        <select name='asignatura' id='asignatura'>
            <option>Seleccione curso para mostrar asignaturas</option>
        </select>
        
        <br><br>
        
        <label for='alumnos'>Seleccione el número de alumnos</label><br>
        <input type='number' id='alumnos' name='alumnos' max='$disponibles'><br>
        <div style='width: 80%'>
            <input type='checkbox' id='excederAlumnos' style='display:inline-block;'> 
            <label for='excederAlumnos' style='display:inline'> Quiero reservar para una cantidad mayor de alumnos</label>
        </div><br><br>
        ";

        echo "<button type='submit'>Reservar</button>
        
        </form>";
    }else{
        header("location: reserva.php");
        exit();
    }

    require_once './includes/footer.php';

    //Función que imprime options de las clases a las que imparte un profesor
    function printClases($idPro, $db){
        $query = "select Cursos.IdCurso, Cursos.Nombre from Cursos
                    inner join Profesor_Curso_Asignatura on Cursos.IdCurso = Profesor_Curso_Asignatura.IdCurso
                    where Profesor_Curso_Asignatura.IdProfesor = $idPro
                    group by Cursos.IdCurso";

        $result = mysqli_query($db, $query);

        $cadena = "";

        while($registro = mysqli_fetch_assoc($result)){
            $cadena .= "<option value='$registro[IdCurso]'>$registro[Nombre]</option>";
        }
        return $cadena;
    }

    //Función que calcula el máximo de almunos en función de los tramos seleccionados
    function maxAlumnos($plazas){
        $disponibles = 100;
        
        foreach ($plazas as $tramo => $value) {
            if($value < $disponibles){
                $disponibles = $value;
            }
        }
        return $disponibles;
    }

    //Función que añade a la session un array con los ids de los tramos seleccionado en el select
    function selectedTramos(){
        $tramos = [];

        for ($i=1; $i < 7; $i++) { 
            if(isset($_GET["tramo$i"])){
                $tramos[] = $i;
            }
        }

        $_SESSION["selectedTramos"] = $tramos;
    }

?>

<script>

    const clase = document.getElementById("clase");

    //Obtenemos el input number de alumnos
    let input = document.getElementById("alumnos");

    //Obtenemos el número máximo de alumnos que permite el tramo
    let maxAlumnos = parseInt(input.getAttribute('max'));
    let alumnosClase = 0;

    clase.addEventListener("change", cargarAsignaturas);

    //Evento de checkbox para saltar el límite de alumnos
    let check = document.getElementById('excederAlumnos');
    check.addEventListener("change", saltarLimiteAlumnos)

    function cargarAsignaturas(){
        console.log("asdasdasd");
        let idClase = document.getElementById("clase").value;

        let idProfe = document.getElementById("idProfesor").value;

        console.log(idClase)
        console.log(idProfe)
        if(idClase == "Seleccione un opción"){
            return
        }
        let listaAsignaturas = document.getElementById("asignatura");

        listaAsignaturas.innerHTML = "<option>Seleccione asignatura</option>";

        let data = new FormData();

        data.append('curso', idClase);
        data.append('profe', idProfe);

        fetch("./acciones/opt-asignaturas.php",{
            method: "POST",
            body: data
        })
        .then(respuesta => respuesta.text())
        .then(data => listaAsignaturas.innerHTML += data)
        .catch(error => {
            console.log("Ha habido un error, vuelva a intentarlo");
        })


        //Fetch para los números de alumnos, solo lo hacemos si el número es menor y si el check está desactivado
        if(!check.checked){
            let claseData = new FormData();

            claseData.append('clase', idClase);

            fetch("./acciones/getAlumnosClase.php", {
                method: "POST",
                body: claseData
            })
            .then(respuesta => respuesta.text())
            .then(numAlumnos => {
                alumnosClase = parseInt(numAlumnos);


                if(numAlumnos < maxAlumnos){
                    input.setAttribute('max', alumnosClase)
                    input.setAttribute('value', alumnosClase)
                }
                
            })
        }
        
    }

    function saltarLimiteAlumnos(e){
        if(e.target.checked){
            input.setAttribute('max', maxAlumnos)
        }else{
            input.setAttribute('max', alumnosClase)
            input.setAttribute('value', alumnosClase)
        }
    }
</script>
