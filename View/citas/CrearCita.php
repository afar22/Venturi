<?php require_once "public/plantilla.html"; startblock('article'); ?>

<h1 class="h3 mb-2 text-gray-800">Agendar Cita</h1>
<?php if(!empty($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Datos de la Cita</h6></div>
    <div class="card-body">
        <form action="<?php echo APP_URL; ?>index.php?url=cita&accion=guardar" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Estufa</label>
                    <select class="form-control" name="tipoEstufa">
                        <option value="" selected>Sin estufa asignada</option>
                        <?php if(!empty($estufas)): foreach($estufas as $e): ?>
                        <option value="<?php echo $e['nEstufaid']; ?>">
                            #<?php echo $e['nEstufaid']; ?> - <?php echo htmlspecialchars($e['cMarcaEstufa'] . ' ' . $e['cModelo']); ?>
                        </option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Fecha de la Cita</label>
                    <input type="date" class="form-control" name="fecha" min="<?php echo date('Y-m-d'); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Operario</label>
                    <select class="form-control" name="operarioFK" required>
                        <option value="" disabled selected>Seleccione un operario...</option>
                        <?php foreach($operarios as $o): ?>
                        <option value="<?php echo $o->getId(); ?>"><?php echo htmlspecialchars($o->getNombre() . ' ' . $o->getApellido()); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <textarea class="form-control" name="descripcion" rows="2" placeholder="Observaciones de la cita..."></textarea>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="<?php echo APP_URL; ?>index.php?url=cita&accion=lista" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left fa-sm"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-calendar-check fa-sm"></i> Agendar</button>
            </div>
        </form>
    </div>
</div>
<?php endblock(); ?>