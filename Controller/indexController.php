<?php
class indexController {

    public function inicio(){
        require_once "Model/ClienteModel.php";
        require_once "Model/CitaModel.php";

        $modeloCliente = new ClienteModel();
        $modeloCita    = new CitaModel();

        $totalClientes = $modeloCliente->contarClientes();
        $totalCitas    = $modeloCita->contarCitas();
        $citasRecientes = $modeloCita->obtenerCitasRecientes();

        require_once "View/index.php";
    }

    public function eventosCitas(){
        require_once "Model/CitaModel.php";
        $modelo = new CitaModel();
        $citas = $modelo->obtenerTodasLasCitas();

        $eventos = [];
        foreach($citas as $cita){
            $eventos[] = [
                'id'    => $cita['nCitaid'],
                'title' => 'Cita - ' . $cita['cTipoEstufa'],
                'start' => $cita['dFecha'],
                'description' => $cita['cDescripcion'] ?? '',
                'color' => '#4e73df'
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($eventos);
        exit;
    }
}