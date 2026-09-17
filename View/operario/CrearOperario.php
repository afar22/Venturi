<?php require_once "public/plantilla.html"; startblock('article'); ?>

<h1 class="h3 mb-2 text-gray-800">Crear Operario</h1>
<?php if(!empty($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Datos del Operario</h6></div>
    <div class="card-body">
        <form action="<?php echo APP_URL; ?>index.php?url=operario&accion=guardar" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Apellido</label>
                    <input type="text" class="form-control" name="apellido" placeholder="Ingrese el apellido" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Correo</label>
                    <input type="email" class="form-control" name="correo" placeholder="ejemplo@correo.com" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Teléfono</label>
                    <input type="text" class="form-control" name="telefono" placeholder="Ingrese el teléfono" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Documento</label>
                    <input type="text" class="form-control" name="documento" placeholder="Número de documento" required>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="<?php echo APP_URL; ?>index.php?url=operario&accion=lista" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left fa-sm"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-sm"></i> Guardar</button>
            </div>
        </form>
    </div>
</div>
<?php endblock(); ?>
