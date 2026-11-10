<?php require_once "public/plantilla.html"; startblock('article'); ?>

<h1 class="h3 mb-2 text-gray-800">Crear Estufa</h1>
<?php if(!empty($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Datos de la Estufa</h6></div>
    <div class="card-body">
        <form action="<?php echo APP_URL; ?>index.php?url=estufa&accion=guardar" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Tipo de estufa</label>
                    <input type="text" class="form-control" name="tipoEstufa" placeholder="Ej. Industrial, Doméstica" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Marca</label>
                    <input type="text" class="form-control" name="marca" placeholder="Ingrese la marca" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Modelo</label>
                    <input type="text" class="form-control" name="modelo" placeholder="Ingrese el modelo" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Estado</label>
                    <select class="form-control" name="estadoEstufafk" required>
                        <option value="">Seleccione estado</option>
                        <option value="1">Activa</option>
                        <option value="0">Inactiva</option>
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
                                <option value="<?php echo $cliente->getId(); ?>">
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
                    <textarea class="form-control" name="informacionAdicional" rows="4" placeholder="Información relevante de la estufa"></textarea>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="<?php echo APP_URL; ?>index.php?url=estufa&accion=lista" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left fa-sm"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-sm"></i> Guardar</button>
            </div>
        </form>
    </div>
</div>
<?php endblock(); ?>
