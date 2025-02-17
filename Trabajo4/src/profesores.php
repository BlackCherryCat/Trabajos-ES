<?php require_once 'includes/header.php'; ?>

<h2>Profesores</h2>
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
    <!-- Cards -->
    <?php
    $profesores = obtenerProfesores($db);

    //pintar un card por cada profesor
    foreach ($profesores as $profesor) { ?>
        <div class="col-md-4">
            <a href="#" class="text-decoration-none">
                <div class="card p-3">
                    <img src="./assets/img/usuario.avif" class="card-img-top" alt="Imagen de <?= htmlspecialchars($profesor['Nombre']) ?>" 
                        data-bs-toggle="modal" data-bs-target="#modalImagen" data-bs-src="imagen.avif" />
                    
                    <h5 class="card-title m-0"><?= htmlspecialchars($profesor['Nombre']) . ' ' . htmlspecialchars($profesor['Apellidos']) ?></h5>
                    
                    <span class="status-badge">Alta</span>
                    
                    <p class="text-muted mt-2">
                        <a href="editar.php?id=<?= $profesor['IdProfesor'] ?>"><button>Editar</button></a>
                        <a href="borrar.php?id=<?= $profesor['IdProfesor'] ?>"><button>Borrar</button></a>
                        <a href="baja.php?id=<?= $profesor['IdProfesor'] ?>"><button>Dar de baja</button></a>
                    </p>
                </div>
            </a>
        </div>
    <?php } ?>
</div>


<?php require_once 'includes/footer.php'; ?>