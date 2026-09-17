<?php require_once "public/plantilla.html"; startblock('article'); ?>

<h1 class="h3 mb-2 text-gray-800">Lista de Citas</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Citas Agendadas</h6>
        <a href="<?php echo APP_URL; ?>index.php?url=cita&accion=crear" class="btn btn-primary btn-sm">
            <i class="fas fa-plus fa-sm"></i> Nueva Cita
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr><th>#</th><th>Tipo Estufa</th><th>Operario</th><th>Fecha</th><th>Descripción</th><th class="text-center">Acciones</th></tr>
                </thead>
                <tbody>
                    <?php if(!empty($citas)): ?>
                        <?php foreach($citas as $c): ?>
                        <tr>
                            <td><?php echo $c['nCitaid']; ?></td>
                            <td><?php echo htmlspecialchars($c['cTipoEstufa']); ?></td>
                            <td><?php echo htmlspecialchars($c['nombreOperario'] ?? '-'); ?></td>
                            <td>
                                <?php
                                $hoy = date('Y-m-d');
                                $badge = $c['dFecha'] >= $hoy ? 'success' : 'secondary';
                                ?>
                                <span class="badge badge-<?php echo $badge; ?>"><?php echo $c['dFecha']; ?></span>
                            </td>
                            <td><?php echo htmlspecialchars($c['cDescripcion'] ?? ''); ?></td>
                            <td class="text-center">
                                <a href="<?php echo APP_URL; ?>index.php?url=cita&accion=eliminar&id=<?php echo $c['nCitaid']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar cita?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted">No hay citas agendadas.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endblock(); ?>