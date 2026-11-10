<?php require_once "public/plantilla.html"; startblock('article'); ?>

<h1 class="h3 mb-2 text-gray-800">Editar Cliente</h1>
<?php if(!empty($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Datos del Cliente</h6></div>
    <div class="card-body">
        <form action="<?php echo APP_URL; ?>index.php?url=cliente&accion=actualizar" method="POST">
            <input type="hidden" name="cliente_id" value="<?php echo htmlspecialchars($cliente->getId()); ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($cliente->getNombre()); ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Apellido</label>
                    <input type="text" class="form-control" name="apellido" value="<?php echo htmlspecialchars($cliente->getApellido()); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Correo</label>
                    <input type="email" class="form-control" name="correo" value="<?php echo htmlspecialchars($cliente->getCorreo()); ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Telefono</label>
                    <input type="text" class="form-control" name="telefono" value="<?php echo htmlspecialchars($cliente->getTelefono()); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Documento</label>
                    <input type="text" class="form-control" name="documento" value="<?php echo htmlspecialchars($cliente->getDocumento()); ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Tipo de documento</label>
                    <select class="form-control" name="tipoDocumento" required>
                        <option value="">Seleccione tipo</option>
                        <option value="Cedula de Ciudadania" <?php echo ($cliente->getTipoDocumento() == 'Cedula de Ciudadania') ? 'selected' : ''; ?>>Cedula de Ciudadania</option>
                        <option value="Cedula de Extranjeria" <?php echo ($cliente->getTipoDocumento() == 'Cedula de Extranjeria') ? 'selected' : ''; ?>>Cedula de Extranjeria</option>
                        <option value="Otro" <?php echo ($cliente->getTipoDocumento() == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="<?php echo APP_URL; ?>index.php?url=cliente&accion=lista" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left fa-sm"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-sm"></i> Actualizar</button>
            </div>
        </form>
    </div>
</div>
<?php endblock(); ?>
