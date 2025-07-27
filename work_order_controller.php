<?php
// LabMind/modules/reception/work_order_controller.php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../includes/db_connection.php';
require_once __DIR__ . '/../../includes/auth_middleware.php';

requireRole(['administrator', 'receptionist', 'lab_technician']); // Permisos para este controlador

$conn = getDbConnection();

$action = $_REQUEST['action'] ?? ''; // Obtener la acción del formulario o URL

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger datos del formulario
            $patient_id = $_POST['patient_id'] ?? null;
            $doctor_id = $_POST['doctor_id'] ?? null;
            $study_ids = $_POST['study_ids'] ?? [];
            $total_amount = $_POST['total_amount'] ?? 0;
            $notes = $_POST['notes'] ?? '';
            $is_paid = isset($_POST['is_paid']) ? 1 : 0;
            $created_by = $_SESSION['user_id'] ?? null;

            if (!$patient_id || empty($study_ids)) {
                $_SESSION['message'] = "Paciente y estudios son obligatorios.";
                $_SESSION['message_type'] = "error";
                header('Location: ' . BASE_URL . 'reception/work_order/insert');
                exit();
            }

            // Generar número de folio (ejemplo simple, mejora para uno único globalmente)
            $folio_number = 'LM-' . date('YmdHis') . rand(100, 999);

            // Iniciar transacción
            $conn->begin_transaction();

            try {
                // Insertar en work_orders
                $stmt_order = $conn->prepare("INSERT INTO work_orders (patient_id, doctor_id, folio_number, total_amount, notes, is_paid, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt_order->bind_param("iisdsii", $patient_id, $doctor_id, $folio_number, $total_amount, $notes, $is_paid, $created_by);
                $stmt_order->execute();
                $work_order_id = $stmt_order->insert_id;
                $stmt_order->close();

                // Insertar estudios en work_order_studies
                foreach ($study_ids as $study_id) {
                    // Obtener precio actual del estudio
                    $stmt_study_price = $conn->prepare("SELECT price FROM studies WHERE id = ?");
                    $stmt_study_price->bind_param("i", $study_id);
                    $stmt_study_price->execute();
                    $result_price = $stmt_study_price->get_result();
                    $study_price = $result_price->fetch_assoc()['price'] ?? 0;
                    $stmt_study_price->close();

                    $stmt_wo_study = $conn->prepare("INSERT INTO work_order_studies (work_order_id, study_id, study_price) VALUES (?, ?, ?)");
                    $stmt_wo_study->bind_param("iid", $work_order_id, $study_id, $study_price);
                    $stmt_wo_study->execute();
                    $stmt_wo_study->close();
                }

                // Generar QR Code Link (esto es una URL de ejemplo, el QR se generaría en el front-end o en un servicio)
                $qr_code_link = BASE_URL . 'results/view?folio=' . urlencode($folio_number);
                $stmt_update_qr = $conn->prepare("UPDATE work_orders SET qr_code_link = ? WHERE id = ?");
                $stmt_update_qr->bind_param("si", $qr_code_link, $work_order_id);
                $stmt_update_qr->execute();
                $stmt_update_qr->close();

                $conn->commit();
                $_SESSION['message'] = "Orden de trabajo creada con éxito. Folio: " . $folio_number;
                $_SESSION['message_type'] = "success";
            } catch (mysqli_sql_exception $e) {
                $conn->rollback();
                $_SESSION['message'] = "Error al crear la orden de trabajo: " . $e->getMessage();
                $_SESSION['message_type'] = "error";
            }
            header('Location: ' . BASE_URL . 'reception/work_order/insert');
            exit();
        }
        break;

    case 'list':
        // Lógica para listar órdenes de trabajo
        $orders = [];
        $query = "SELECT wo.*, p.first_name AS patient_fname, p.last_name AS patient_lname,
                         d.first_name AS doctor_fname, d.last_name AS doctor_lname
                  FROM work_orders wo
                  JOIN patients p ON wo.patient_id = p.id
                  LEFT JOIN doctors d ON wo.doctor_id = d.id
                  ORDER BY wo.order_date DESC";
        $result = $conn->query($query);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        // Puedes pasar $orders a una vista o devolver como JSON
        // header('Content-Type: application/json');
        // echo json_encode(['success' => true, 'data' => $orders]);
        break;

    case 'get_details':
        // Lógica para obtener detalles de una orden específica (por ID o folio)
        $order_id = $_GET['id'] ?? null; // o folio
        if ($order_id) {
            $stmt = $conn->prepare("SELECT wo.*, p.first_name AS patient_fname, p.last_name AS patient_lname,
                                       d.first_name AS doctor_fname, d.last_name AS doctor_lname
                                FROM work_orders wo
                                JOIN patients p ON wo.patient_id = p.id
                                LEFT JOIN doctors d ON wo.doctor_id = d.id
                                WHERE wo.id = ?");
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $order_details = $result->fetch_assoc();
            $stmt->close();

            if ($order_details) {
                // Obtener estudios asociados
                $stmt_studies = $conn->prepare("SELECT wos.*, s.study_name FROM work_order_studies wos JOIN studies s ON wos.study_id = s.id WHERE wos.work_order_id = ?");
                $stmt_studies->bind_param("i", $order_id);
                $stmt_studies->execute();
                $result_studies = $stmt_studies->get_result();
                $order_details['studies'] = [];
                while ($study = $result_studies->fetch_assoc()) {
                    $order_details['studies'][] = $study;
                }
                $stmt_studies->close();

                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $order_details]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Orden no encontrada']);
            }
        }
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para actualizar una orden de trabajo existente
            // Similar a 'create' pero con UPDATE y manejo de work_order_studies (INSERT/DELETE)
            // Asegúrate de que solo los campos permitidos sean actualizables.
            $_SESSION['message'] = "Funcionalidad de actualización pendiente.";
            $_SESSION['message_type'] = "info";
            header('Location: ' . BASE_URL . 'reception/work_order/list'); // Redirige a la lista
            exit();
        }
        break;

    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para eliminar una orden de trabajo
            $order_id = $_POST['id'] ?? null;
            if ($order_id) {
                $conn->begin_transaction();
                try {
                    $stmt = $conn->prepare("DELETE FROM work_order_studies WHERE work_order_id = ?");
                    $stmt->bind_param("i", $order_id);
                    $stmt->execute();
                    $stmt->close();

                    $stmt = $conn->prepare("DELETE FROM work_orders WHERE id = ?");
                    $stmt->bind_param("i", $order_id);
                    $stmt->execute();
                    $stmt->close();

                    $conn->commit();
                    $_SESSION['message'] = "Orden de trabajo eliminada con éxito.";
                    $_SESSION['message_type'] = "success";
                } catch (mysqli_sql_exception $e) {
                    $conn->rollback();
                    $_SESSION['message'] = "Error al eliminar la orden: " . $e->getMessage();
                    $_SESSION['message_type'] = "error";
                }
            } else {
                $_SESSION['message'] = "ID de orden no proporcionado.";
                $_SESSION['message_type'] = "error";
            }
            header('Location: ' . BASE_URL . 'reception/work_order/list');
            exit();
        }
        break;

    default:
        // Si se accede sin una acción específica (ej. para APIs RESTful)
        header("HTTP/1.0 400 Bad Request");
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}

// No cerrar conexión aquí si se usa getDbConnection() y se requiere para el enrutador principal