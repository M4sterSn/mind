<?php
// C:\xampp\htdocs\labmind\modules\reception\work_order_controller.php

// Asegúrate de incluir tus archivos de configuración y base de datos si es necesario
// Las rutas deben ser correctas desde este controlador (modules/reception)
require_once dirname(__DIR__, 2) . '/config.php'; // Desde modules/reception/ sube a labmind/ y encuentra config.php
require_once dirname(__DIR__, 2) . '/includes/db_connection.php'; // Lo mismo para db_connection.php
require_once dirname(__DIR__, 2) . '/includes/functions.php'; // Incluir funciones generales
require_once dirname(__DIR__, 2) . '/includes/auth_middleware.php'; // Para control de sesión, si aplica

// Opcional: Verificar sesión si este controlador requiere autenticación
// auth_middleware::check_session();

// Las variables $module, $section, $action, $id ya vienen de index.php
// por lo que no necesitas redefinirlas aquí si tu index.php las incluye globalmente
// o las pasa de alguna forma. Asumiremos que están disponibles.
// Si no están disponibles globalmente, deberías pasarlas como argumentos a tu controlador
// o hacer que el controlador las obtenga del request (similar a como lo hacía index.php).
// Para simplificar, asumiremos que están en el ámbito global o las puedes descomentar y ajustar si es necesario.

// Globalmente, $module, $section, $action, $id ya vienen definidos por index.php
global $module, $section, $action, $id;

// =========================================================================
// Función para obtener los datos de órdenes de trabajo para DataTables
// =========================================================================
function getDataTablesWorkOrders() {
    $data = [];
    $db = new DatabaseConnection();

    $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $search_value = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';

    // Ordenamiento
    $order_column_index = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
    // IMPORTANTE: Asegúrate de que los nombres de las columnas aquí coincidan con el SELECT y la DB
    // Las columnas que DataTables envía para ordenar son 0-indexed, y aquí mapeamos a nombres de DB.
    // 'id' (col 0), 'patient_name' (col 1), 'reception_date' (col 2), 'status' (col 3), acciones (col 4)
    $columns = ['wo.id', 'p.name', 'wo.reception_date', 'wo.status']; // p.name para el nombre del paciente
    $order_direction = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';
    $order_by = $columns[$order_column_index];

    // Consulta SQL base con JOIN para obtener el nombre del paciente
    $sql_base = "SELECT wo.id, p.name AS patient_name, wo.reception_date, wo.status 
                 FROM work_orders wo 
                 JOIN patients p ON wo.patient_id = p.id";
    
    // Consultas para el conteo total
    $sql_count_base = "SELECT COUNT(wo.id) AS total 
                      FROM work_orders wo 
                      JOIN patients p ON wo.patient_id = p.id";

    $where_clause = "";
    if (!empty($search_value)) {
        // Filtrar por nombre de paciente O status de orden de trabajo
        $search_escaped = $db->escape_string($search_value);
        $where_clause = " WHERE p.name LIKE '%{$search_escaped}%' OR wo.status LIKE '%{$search_escaped}%'";
    }

    // Obtener total de registros sin filtrar
    $total_records_query = $db->query(str_replace("SELECT wo.id, p.name AS patient_name, wo.reception_date, wo.status", "SELECT COUNT(wo.id)", $sql_base));
    $total_records_count = $db->fetch_assoc($total_records_query)['total'];

    // Obtener total de registros filtrados
    $total_filtered_records_query = $db->query(str_replace("SELECT wo.id, p.name AS patient_name, wo.reception_date, wo.status", "SELECT COUNT(wo.id)", $sql_base) . " {$where_clause}");
    $total_filtered_records_count = $db->fetch_assoc($total_filtered_records_query)['total'];

    // Consulta SQL con filtrado, ordenamiento y paginación
    $sql = "{$sql_base} {$where_clause} ORDER BY {$order_by} {$order_direction} LIMIT {$start}, {$length}";

    $result = $db->query($sql);

    if ($result) {
        while ($row = $db->fetch_assoc($result)) {
            $data[] = [
                $row['id'],
                $row['patient_name'], // Ahora sí existe en el resultado de la consulta
                $row['reception_date'],
                $row['status'],
                // Columna de acciones (ej. botones de editar/ver)
                '<a href="' . BASE_URL . 'reception/work_order/view/' . $row['id'] . '">Ver</a> | ' .
                '<a href="' . BASE_URL . 'reception/work_order/edit/' . $row['id'] . '">Editar</a>'
            ];
        }
    }

    $db->close_connection();

    return [
        "draw"            => $draw,
        "recordsTotal"    => $total_records_count,
        "recordsFiltered" => $total_filtered_records_count,
        "data"            => $data
    ];
}


// =========================================================================
// Lógica de Enrutamiento dentro del Controlador
// =========================================================================

// Verificar si es una solicitud AJAX (generalmente de DataTables)
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Es una solicitud AJAX, devolver solo JSON
    header('Content-Type: application/json');

    // Asumimos que si es AJAX y estamos en el work_order_controller,
    // es para obtener los datos del listado.
    if ($action === 'listing' || $action === null) { // Si es /reception/work_order/listing o solo /reception/work_order
        echo json_encode(getDataTablesWorkOrders());
    } else {
        // Manejar otras acciones AJAX si las hubiera (ej. guardar, eliminar, etc.)
        echo json_encode(['error' => 'Action not supported via AJAX for this controller.']);
    }

    exit; // Terminar la ejecución para evitar que se cargue la vista HTML
}

// Si no es una solicitud AJAX, es una carga de página normal
// Aquí se determina qué vista cargar basado en la acción

if ($action === 'listing') {
    // Si la acción es 'listing', cargar la vista del listado de órdenes
    // No necesitamos pasar datos específicos aquí para la tabla, ya que DataTables hará su propia llamada AJAX
    require_once dirname(__DIR__, 2) . '/views/reception_work_order_listing.php';
} elseif ($action === 'insert') {
    // Si la acción es 'insert', cargar la vista para insertar una nueva orden
    require_once dirname(__DIR__, 2) . '/views/work_order_insert.php';
} elseif ($action === 'view' && $id !== null) {
    // Si la acción es 'view' y hay un ID, cargar la vista de detalles
    // Aquí podrías cargar datos específicos de la orden por $id
    // $order_details = get_order_by_id($id);
    require_once dirname(__DIR__, 2) . '/views/work_order_view.php'; // Asegúrate de tener esta vista
} elseif ($action === 'edit' && $id !== null) {
    // Si la acción es 'edit' y hay un ID, cargar la vista de edición
    // Aquí podrías cargar datos específicos de la orden por $id
    // $order_details = get_order_by_id($id);
    require_once dirname(__DIR__, 2) . '/views/work_order_edit.php'; // Asegúrate de tener esta vista
} else {
    // Acción por defecto o no reconocida, redirigir al listado
    header("Location: " . BASE_URL . "reception/work_order/listing");
    exit;
}
?>
