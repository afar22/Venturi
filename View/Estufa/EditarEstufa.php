<?php require_once "public/plantilla.html"; startblock('article'); ?>

<h1 class="h3 mb-2 text-gray-800">Editar Estufa</h1>
<?php if(!empty($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Datos de la Estufa</h6></div>
    <div class="card-body">
        <form action="<?php echo APP_URL; ?>index.php?url=estufa&accion=actualizar" method="POST">
            <input type="hidden" name="estufa_id" value="<?php echo htmlspecialchars($estufa->getId()); ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Tipo de estufa</label>
                    <input type="text" class="form-control" name="tipoEstufa" value="<?php echo htmlspecialchars($estufa->getTipoEstufa()); ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Marca</label>
                    <input type="text" class="form-control" name="marca" value="<?php echo htmlspecialchars($estufa->getMarca()); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Modelo</label>
                    <input type="text" class="form-control" name="modelo" value="<?php echo htmlspecialchars($estufa->getModelo()); ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Estado</label>
                    <select class="form-control" name="estadoEstufafk" required>
                        <option value="1" <?php echo ($estufa->getEstadoEstufa_fK() == 1) ? 'selected' : ''; ?>>Activa</option>
                        <option value="0" <?php echo ($estufa->getEstadoEstufa_fK() == 0) ? 'selected' : ''; ?>>Inactiva</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Cliente</label>
                    <select class="form-control" name="clientefk" required>
                        <option value="">Seleccione un cliente</option>
                        <?php if(!empty($clientes)): ?>
                            <?php foreach($clientes as $cliente): ?>
                                <option value="<?php echo $cliente->getId(); ?>" <?php echo ($cliente->getId() == $estufa->getClientefk()) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cliente->getNombre() . ' ' . $cliente->getApellido()); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Información adicional</label>
                    <textarea class="form-control" name="informacionAdicional" rows="4"><?php echo htmlspecialchars($estufa->getInformacionAdicional()); ?></textarea>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="<?php echo APP_URL; ?>index.php?url=estufa&accion=lista" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left fa-sm"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-sm"></i> Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
<?php endblock(); ?>
