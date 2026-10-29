<?php require_once "public/plantilla.html"; startblock('article'); ?> <h1 class="h3 mb-2 text-gray-800">Lista de Clientes</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Clientes</h6>
        <a href="<?php echo APP_URL; ?>index.php?url=cliente&accion=crear" class="btn btn-primary btn-sm">
            <i class="fas fa-plus fa-sm"></i> Nuevo Cliente
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
                        <th>Tipo Doc.</th>
                        <th>Documento</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($clientes)): ?>
                        <?php foreach($clientes as $cli): ?>
                        <tr>
                            <td><?php echo $cli->getId(); ?></td>
                            <td><?php echo htmlspecialchars($cli->getNombre()); ?></td>
                            <td><?php echo htmlspecialchars($cli->getApellido()); ?></td>
                            <td><?php echo htmlspecialchars($cli->getCorreo()); ?></td>
                            <td><?php echo htmlspecialchars($cli->getTipoDocumento()); ?></td>
                            <td><?php echo htmlspecialchars($cli->getDocumento()); ?></td>
                            <td class="text-center">
                                <a href="<?php echo APP_URL; ?>index.php?url=cliente&accion=editar&id=<?php echo $cli->getId(); ?>" class="btn btn-info btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo APP_URL; ?>index.php?url=cliente&accion=eliminar&id=<?php echo $cli->getId(); ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este cliente?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay clientes registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php endblock(); ?>