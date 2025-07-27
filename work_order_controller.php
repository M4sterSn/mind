<?php
// C:\xampp\htdocs\labmind\modules\reception\work_order_controller.php

// Sube dos directorios para llegar a la raíz de labmind (labmind/config.php)
// dirname(__DIR__, 2) te lleva de 'modules/reception/' a 'labmind/'
require_once dirname(__DIR__, 2) . '/config.php';
require_once ROOT_PATH . 'includes/db_connection.php';
require_once ROOT_PATH . 'includes/auth_middleware.php';
require_once ROOT_PATH . 'includes/functions.php';

error_log("--- Inicia work_order_controller.php ---"); // Log de inicio

// Captura el método de la solicitud
$requestMethod = $_SERVER['REQUEST_METHOD'];
error_log("Request Method: " . $requestMethod); // Log del método de la solicitud

// Captura y loggea parámetros GET
error_log("GET parameters: " . print_r($_GET, true));
// Captura y loggea parámetros POST
error_log("POST parameters: " . print_r($_POST, true));


// Asegúrate de que $_GET['action'] se esté configurando correctamente con el parámetro 'action' de la URL.
// La solicitud AJAX de DataTables debe incluir ?action=ajx_work_orders_list
if (isset($_GET['action']) && $_GET['action'] === 'ajx_work_orders_list') {
    error_log("Entró al bloque AJAX ajx_work_orders_list.");

    // Variables para paginación y ordenamiento de DataTables
    $draw = $_POST['sEcho'];
    $start = $_POST['iDisplayStart'];
    $length = $_POST['iDisplayLength'];
    $search_value = $_POST['sSearch'];

    // Columnas para mapear de DataTables a la base de datos
    // Asegúrate de que 'doctor_full_name' esté en este array si lo usas en el frontend
    $columns = ['id', 'created_at', 'patient_full_name', 'doctor_full_name', 'status']; // Ajusta según las columnas que devuelvas
    $order_column_index = $_POST['iSortCol_0'];
    $order_dir = $_POST['sSortDir_0'];
    $order_column_name = $columns[$order_column_index];

    $query = "
        SELECT
            wo.id,
            wo.order_date AS created_at,
            CONCAT(p.first_name, ' ', p.last_name) AS patient_full_name,
            CASE
                WHEN wo.doctor_id IS NOT NULL THEN CONCAT(u_doc.first_name, ' ', u_doc.last_name)
                ELSE 'N/A'
            END AS doctor_full_name,
            wo.status
        FROM
            work_orders wo
        JOIN
            patients p ON wo.patient_id = p.id
        LEFT JOIN
            doctors d ON wo.doctor_id = d.id
        LEFT JOIN
            users u_doc ON d.user_id = u_doc.id
        WHERE 1=1
    ";

    $bindings = [];

    // Búsqueda global
    if (!empty($search_value)) {
        $query .= " AND (
            wo.id LIKE :search_id OR
            p.first_name LIKE :search_patient_fname OR
            p.last_name LIKE :search_patient_lname OR
            u_doc.first_name LIKE :search_doctor_fname OR
            u_doc.last_name LIKE :search_doctor_lname OR
            wo.status LIKE :search_status
        )";
        $bindings[':search_id'] = '%' . $search_value . '%';
        $bindings[':search_patient_fname'] = '%' . $search_value . '%';
        $bindings[':search_patient_lname'] = '%' . $search_value . '%';
        $bindings[':search_doctor_fname'] = '%' . $search_value . '%';
        $bindings[':search_doctor_lname'] = '%' . $search_value . '%';
        $bindings[':search_status'] = '%' . $search_value . '%';
    }

    // Total de registros sin filtrar
    $total_records_query = "SELECT COUNT(*) FROM work_orders";
    $stmt_total = $pdo->prepare($total_records_query);
    $stmt_total->execute();
    $total_records = $stmt_total->fetchColumn();

    // Total de registros filtrados (con búsqueda)
    $stmt_filtered_total = $pdo->prepare($query);
    foreach ($bindings as $key => &$val) {
        $stmt_filtered_total->bindParam($key, $val);
    }
    $stmt_filtered_total->execute();
    $filtered_records = $stmt_filtered_total->rowCount();


    // Ordenamiento
    $query .= " ORDER BY {$order_column_name} {$order_dir}";

    // Paginación
    $query .= " LIMIT :start, :length";
    $bindings[':start'] = $start;
    $bindings[':length'] = $length;

    $stmt = $pdo->prepare($query);
    foreach ($bindings as $key => &$val) {
        // Usar PDO::PARAM_INT para los límites para asegurar que se traten como enteros
        if ($key === ':start' || $key === ':length') {
            $stmt->bindParam($key, $val, PDO::PARAM_INT);
        } else {
            $stmt->bindParam($key, $val);
        }
    }
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Añadir columna de acciones (si aplica)
    foreach ($data as $key => $row) {
        $data[$key]['acciones'] = '<a href="#" class="btn btn-info btn-sm">Ver</a> ' .
                                  '<a href="#" class="btn btn-warning btn-sm">Editar</a>';
    }

    $response = array(
        "sEcho" => intval($draw),
        "iTotalRecords" => intval($total_records),
        "iTotalDisplayRecords" => intval($filtered_records),
        "aaData" => $data
    );

    header('Content-Type: application/json');
    echo json_encode($response);
    error_log("--- Fin del bloque AJAX. ---");

} else {
    // Si no es una solicitud AJAX para la lista de órdenes, carga la vista por defecto
    error_log("NO entró al bloque AJAX ajx_work_orders_list. Procesando como solicitud NO-AJAX.");
    
    // Aquí puedes incluir cualquier lógica que necesites para la vista normal.
    // Por ejemplo, cargar datos iniciales para el formulario de inserción.

    // Si no se especificó ninguna acción, o la acción no es para AJAX, se carga la vista por defecto
    // Esto es lo que se ejecuta cuando accedes a la URL directamente (ej. /labmind/reception/work_order/listing)
    error_log("No se especificó ninguna acción. Cargando vista por defecto: reception_work_order_listing.php");
    // require_once ROOT_PATH . 'views/reception_work_order_listing.php'; // ¡No hacer esto si ya estás en el controlador!
    // El controlador NO debe renderizar la vista, solo manejar la lógica y redirigir o devolver datos.
    // Si llegas aquí, significa que el navegador solicitó el controlador directamente sin la acción AJAX.
    // En una aplicación MVC, esto implicaría que el router debería haber cargado la vista.
    // Para depuración, puedes simplemente asegurar que no haya salida inesperada aquí.
    http_response_code(200); // O un 404 si no se espera que se acceda directamente
    echo "<h1>Error: Acceso no autorizado o acción no especificada.</h1>"; // Mensaje para depuración
}

error_log("--- Fin work_order_controller.php ---"); // Log de fin
?>
