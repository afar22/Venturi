<?php 
require_once "public/plantilla.html";
startblock('article');
?>

   <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>


<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Clientes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalClientes; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Facturas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalFacturas; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Citas Agendadas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalCitas; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Calendario -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-calendar mr-2"></i>Calendario de Citas</h6>
                <a href="<?php echo APP_URL; ?>index.php?url=cita&accion=crear" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus fa-sm"></i> Nueva Cita
                </a>
            </div>
            <div class="card-body">
                <div id="calendario"></div>
            </div>
        </div>
    </div>

    <!-- Citas recientes -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Próximas Citas</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <?php if(!empty($citasRecientes)): ?>
                        <?php foreach($citasRecientes as $cita): ?>
                        <a href="<?php echo APP_URL; ?>index.php?url=cita&accion=lista" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><?php echo htmlspecialchars($cita['cTipoEstufa']); ?></h6>
                                <small class="text-muted"><?php echo $cita['dFecha']; ?></small>
                            </div>
                            <small class="text-muted"><?php echo htmlspecialchars($cita['cDescripcion'] ?? ''); ?></small>
                        </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="list-group-item text-center text-muted">No hay citas próximas</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendario');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: '<?php echo APP_URL; ?>index.php?url=index&accion=eventosCitas',
        eventClick: function(info) {
            alert('Cita: ' + info.event.title + '\nFecha: ' + info.event.startStr);
        }
    });
    calendar.render();
});
</script>


<?php  endblock();?>
