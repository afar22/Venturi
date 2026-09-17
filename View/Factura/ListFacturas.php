<?php require_once "public/plantilla.html"; startblock('article'); ?>

<h1 class="h3 mb-2 text-gray-800">Lista de Facturas</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Facturas</h6>
        <a href="<?php echo APP_URL; ?>index.php?url=factura&accion=crear" class="btn btn-primary btn-sm">
            <i class="fas fa-plus fa-sm"></i> Nueva Factura
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>#</th><th>Cliente</th><th>Total</th><th>Fecha</th><th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($facturas)): ?>
                        <?php foreach($facturas as $f): ?>
                        <tr>
                            <td><?php echo $f['nFacturaid']; ?></td>
                            <td><?php echo htmlspecialchars($f['cNombres'] . ' ' . $f['cApellidos']); ?></td>
                            <td>$<?php echo number_format($f['nTotalPago'], 0, ',', '.'); ?></td>
                            <td><?php echo $f['dFecha']; ?></td>
                            <td class="text-center">
                                <a href="<?php echo APP_URL; ?>index.php?url=factura&accion=editar&id=<?php echo $f['nFacturaid']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="<?php echo APP_URL; ?>index.php?url=factura&accion=eliminar&id=<?php echo $f['nFacturaid']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar factura?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted">No hay facturas registradas.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endblock(); ?>