<?php require_once "public/plantilla.html"; startblock('article'); ?>

<h1 class="h3 mb-2 text-gray-800">Detalle de Estufa</h1>
<p class="mb-4">Información completa de la estufa seleccionada.</p>

<?php if(!empty($estufa)): ?>
<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-fire mr-2"></i>Datos de la Estufa
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th width="40%">ID</th><td><?php echo $estufa['nEstufaid']; ?></td></tr>
                    <tr><th>Tipo</th><td><?php echo htmlspecialchars($estufa['cTipoEstufa']); ?></td></tr>
                    <tr><th>Marca</th><td><?php echo htmlspecialchars($estufa['cMarcaEstufa']); ?></td></tr>
                    <tr><th>Modelo</th><td><?php echo htmlspecialchars($estufa['cModelo']); ?></td></tr>
                    <tr>
                        <th>Estado</th>
                        <td>
                            <?php
                            $estados = [1 => 'Activa', 2 => 'En mantenimiento', 3 => 'Inactiva'];
                            $estado  = $estufa['nEstadoEstufafk'];
                            $badge   = $estado == 1 ? 'success' : ($estado == 2 ? 'warning' : 'danger');
                            ?>
                            <span class="badge badge-<?php echo $badge; ?>">
                                <?php echo $estados[$estado] ?? 'Desconocido'; ?>
                            </span>
                        </td>
                    </tr>
                    <tr><th>Info. Adicional</th><td><?php echo htmlspecialchars($estufa['cInformacionAdicional']); ?></td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-user mr-2"></i>Cliente Asignado
                </h6>
            </div>
            <div class="card-body">
                <?php if(!empty($estufa['cNombres'])): ?>
                <table class="table table-borderless">
                    <tr><th width="40%">Nombre</th><td><?php echo htmlspecialchars($estufa['cNombres'] . ' ' . $estufa['cApellidos']); ?></td></tr>
                    <tr><th>Correo</th><td><?php echo htmlspecialchars($estufa['cCorreo']); ?></td></tr>
                    <tr><th>Teléfono</th><td><?php echo htmlspecialchars($estufa['cTelefono']); ?></td></tr>
                </table>
                <?php else: ?>
                    <p class="text-muted">Sin cliente asignado.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="d-flex">
    <a href="<?php echo APP_URL; ?>index.php?url=estufa&accion=lista" class="btn btn-secondary mr-2">
        <i class="fas fa-arrow-left fa-sm"></i> Volver
    </a>
    <a href="<?php echo APP_URL; ?>index.php?url=estufa&accion=editar&id=<?php echo $estufa['nEstufaid']; ?>"
       class="btn btn-warning">
        <i class="fas fa-edit fa-sm"></i> Editar
    </a>
</div>

<?php else: ?>
    <div class="alert alert-warning">No se encontró la estufa.</div>
    <a href="<?php echo APP_URL; ?>index.php?url=estufa&accion=lista" class="btn btn-secondary">
        <i class="fas fa-arrow-left fa-sm"></i> Volver
    </a>
<?php endif; ?>

<?php endblock(); ?>