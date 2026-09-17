<?php require_once "public/plantilla.html"; startblock('article'); ?>

<h1 class="h3 mb-2 text-gray-800">Lista de Operarios</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Operarios</h6>
        <a href="<?php echo APP_URL; ?>index.php?url=operario&accion=crear" class="btn btn-primary btn-sm">
            <i class="fas fa-plus fa-sm"></i> Nuevo Operario
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr><th>#</th><th>Nombre</th><th>Apellido</th><th>Correo</th><th>Teléfono</th><th>Documento</th><th class="text-center">Acciones</th></tr>
                </thead>
                <tbody>
                    <?php if(!empty($operarios)): ?>
                        <?php foreach($operarios as $o): ?>
                        <tr>
                            <td><?php echo $o->getId(); ?></td>
                            <td><?php echo htmlspecialchars($o->getNombre()); ?></td>
                            <td><?php echo htmlspecialchars($o->getApellido()); ?></td>
                            <td><?php echo htmlspecialchars($o->getCorreo()); ?></td>
                            <td><?php echo htmlspecialchars($o->getTelefono()); ?></td>
                            <td><?php echo htmlspecialchars($o->getDocumento()); ?></td>
                            <td class="text-center">
                                <a href="<?php echo APP_URL; ?>index.php?url=operario&accion=editar&id=<?php echo $o->getId(); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="<?php echo APP_URL; ?>index.php?url=operario&accion=eliminar&id=<?php echo $o->getId(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar operario?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center text-muted">No hay operarios registrados.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endblock(); ?>