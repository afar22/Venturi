<?php require_once "public/plantilla.html"; startblock('article'); ?>

<h1 class="h3 mb-2 text-gray-800">Crear Factura</h1>
<?php if(!empty($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Datos de la Factura</h6></div>
    <div class="card-body">
        <form action="<?php echo APP_URL; ?>index.php?url=factura&accion=guardar" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Cliente</label>
                    <select class="form-control" name="clientefk" required>
                        <option value="" disabled selected>Seleccione un cliente...</option>
                        <?php foreach($clientes as $c): ?>
                        <option value="<?php echo $c->getId(); ?>"><?php echo htmlspecialchars($c->getNombre() . ' ' . $c->getApellido()); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Total Pago ($)</label>
                    <input type="number" class="form-control" name="totalPago" placeholder="0" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Fecha</label>
                    <input type="date" class="form-control" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="<?php echo APP_URL; ?>index.php?url=factura&accion=lista" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left fa-sm"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-sm"></i> Guardar</button>
            </div>
        </form>
    </div>
</div>
<?php endblock(); ?>