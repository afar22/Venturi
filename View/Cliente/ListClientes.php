<?php require_once "public/plantilla.html"; startblock('article'); ?>
 <h1 class="h3 mb-2 text-gray-800">Lista de Clientes</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Estufas</h6>
        <a href="<?php echo APP_URL; ?>index.php?url=estufa&accion=crear" class="btn btn-primary btn-sm">
            <i class="fas fa-plus fa-sm"></i> Nueva Estufa
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Estado</th>
                        <th>Info. Adicional</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($estufas)): ?>
                        <?php foreach($estufas as $e): ?>
                        <tr>
                            <td><?php echo $e['nEstufaid']; ?></td>
                            <td><?php echo htmlspecialchars($e['cNombres'] . ' ' . $e['cApellidos']); ?></td>
                            <td><?php echo htmlspecialchars($e['cTipoEstufa']); ?></td>
                            <td><?php echo htmlspecialchars($e['cMarcaEstufa']); ?></td>
                            <td><?php echo htmlspecialchars($e['cModelo']); ?></td>
                            <td>
                                <?php
                                $estados = [1 => 'Activa', 2 => 'En mantenimiento', 3 => 'Inactiva'];
                                $estado  = $e['nEstadoEstufafk'];
                                $badge   = $estado == 1 ? 'success' : ($estado == 2 ? 'warning' : 'danger');
                                ?>
                                <span class="badge badge-<?php echo $badge; ?>">
                                    <?php echo $estados[$estado] ?? 'Desconocido'; ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($e['cInformacionAdicional']); ?></td>
                            <td class="text-center">
                                <a href="<?php echo APP_URL; ?>index.php?url=estufa&accion=detalle&id=<?php echo $e['nEstufaid']; ?>"
                                   class="btn btn-info btn-sm" title="Ver detalle">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo APP_URL; ?>index.php?url=estufa&accion=editar&id=<?php echo $e['nEstufaid']; ?>"
                                   class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo APP_URL; ?>index.php?url=estufa&accion=eliminar&id=<?php echo $e['nEstufaid']; ?>"
                                   class="btn btn-danger btn-sm" title="Eliminar"
                                   onclick="return confirm('¿Seguro que deseas eliminar esta estufa?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">No hay estufas registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php endblock(); ?>