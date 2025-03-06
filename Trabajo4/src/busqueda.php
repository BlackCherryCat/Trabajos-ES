<?php
if (!isset($_POST['buscador'])) {
    header("Location: reserva.php");
}

require_once 'includes/header.php'; 
?>

<h2>Profesores</h2>
<div class="d-flex align-items-center justify-content-between">
    <a href="crear-profesor.php"><img src="./assets/img/add.png" alt="Crear profesor" width="50"></a>
    <div id="buscador">
        <form class="buscador d-flex" action=./busqueda.php method="POST">
            <input class="buscador" type="text" name="buscador" placeholder="Busqueda" required>
            <button type="submit" class="btn btn-primary buscador" class="d-flex"><img class="icon-search" src="./assets/img/search.png" alt="Buscador" width="20px"></button>
        </form>
    </div>
</div>
<div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-4">
    <?php
    $busqueda = htmlspecialchars(trim($_POST["buscador"]));
    $profesores = obtenerBusquedaProfesores($db, $busqueda);
    
    $estado = ["baja","alta"];
    //pintar un card por cada profesor
    foreach ($profesores as $profesor) { ?>
        <div class="col-md-4">
            <a href="#" class="text-decoration-none">
                <div class="card p-3">
                    <img src="<?= $profesor['ImgPerfilURL'] ?>" class="card-img-top" alt="Imagen de <?= htmlspecialchars($profesor['Nombre']) ?>"
                        data-bs-toggle="modal" data-bs-target="#modalImagen" data-bs-src="imagen.avif" />
                    
                    <h5 class="card-title m-0"><?= htmlspecialchars($profesor['Nombre']) . ' ' . htmlspecialchars($profesor['Apellidos']) ?></h5>
                    
                    <span class="<?= $estado[$profesor['EsAlta']] ?>"><?= ucfirst($estado[$profesor['EsAlta']]) ?></span>
                    
                    <p class="text-muted mt-2">
                        <a href="editar-profesor.php?id=<?= $profesor['IdProfesor'] ?>"><img src="./assets/img/editar.png" alt="Editar profesor" width="50"></a>
                        <?php 
                        if ($profesor['EsAdmin'] != 1) {
                            echo "<a href='acciones/borrar-profesor.php?id=" . $profesor['IdProfesor'] . "' class='deleteProf'><img src='./assets/img/borrar.png' alt='Eliminar profesor' width='50'></a>";
                        }
                        ?>
                    </p>
                </div>
            </a>
        </div>
    <?php } ?>
</div>

<script>
    let botonesDelete = document.querySelectorAll("a.deleteProf");

    botonesDelete.forEach(boton => boton.addEventListener('click', askConfirm));

    function askConfirm(e){
        if(!window.confirm("¿Estás seguro de que deseas eliminar a este profesor?")){
            e.preventDefault();
            return false;
        } 
    }
</script>


<?php require_once 'includes/footer.php'; ?>