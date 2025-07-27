-- Este script recrea la base de datos 'lcs' con la estructura completa para LabMind.
-- Incluye la deshabilitación/habilitación de FOREIGN_KEY_CHECKS para manejar dependencias.

-- Deshabilitar temporalmente la verificación de claves foráneas para permitir la eliminación y creación de tablas
SET FOREIGN_KEY_CHECKS = 0;

-- Eliminar tablas existentes para asegurar una recreación limpia
-- ¡ADVERTENCIA! Esto borrará todos los datos en estas tablas si ya existen.
DROP TABLE IF EXISTS `results`;
DROP TABLE IF EXISTS `study_details`;
DROP TABLE IF EXISTS `patient_studies`;
DROP TABLE IF EXISTS `studies`;
DROP TABLE IF EXISTS `work_orders`;
DROP TABLE IF EXISTS `appointments`;
DROP TABLE IF EXISTS `doctors`;
DROP TABLE IF EXISTS `patients`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `roles`; -- Si tuvieras una tabla de roles separada, aunque usaremos ENUM en users

-- --------------------------------------------------------
-- Estructura de la tabla `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL, -- Clave: Columna para el hash seguro de la contraseña
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `first_name` VARCHAR(50) DEFAULT NULL,
  `last_name` VARCHAR(50) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `address` VARCHAR(255) DEFAULT NULL,
  `role` ENUM('admin','doctor','receptionist','lab_tech','cashier','user') NOT NULL DEFAULT 'user',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `last_login` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de la tabla `patients`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `patients` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(100) NOT NULL,
  `date_of_birth` DATE NOT NULL,
  `gender` ENUM('M', 'F', 'Other') NOT NULL,
  `address` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(100) UNIQUE DEFAULT NULL,
  `created_by_user_id` INT(11) DEFAULT NULL, -- Quién registró al paciente
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`created_by_user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de la tabla `doctors`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `doctors` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL UNIQUE, -- Relaciona al doctor con un usuario del sistema (para login)
  `specialty` VARCHAR(100) NOT NULL,
  `license_number` VARCHAR(50) NOT NULL UNIQUE,
  `clinic_address` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(100) UNIQUE DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE -- Si el usuario se borra, el doctor también
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de la tabla `studies` (Tipos de estudios disponibles, ej., "Examen de Sangre")
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `studies` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `description` TEXT DEFAULT NULL,
  `price` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de la tabla `work_orders` (Órdenes de trabajo/servicios solicitados)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `work_orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `patient_id` INT(11) NOT NULL,
  `doctor_id` INT(11) DEFAULT NULL, -- Doctor que refiere, opcional
  `order_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('pending', 'in_progress', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
  `total_amount` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
  `registered_by_user_id` INT(11) DEFAULT NULL, -- Quién creó la orden (ej., recepcionista)
  `payment_status` ENUM('pending', 'paid', 'partially_paid', 'refunded') NOT NULL DEFAULT 'pending',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`patient_id`) REFERENCES `patients`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`doctor_id`) REFERENCES `doctors`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`registered_by_user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de la tabla `patient_studies` (Estudios específicos asociados a una orden de trabajo de un paciente)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `patient_studies` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `work_order_id` INT(11) NOT NULL,
  `study_id` INT(11) NOT NULL,
  `status` ENUM('ordered', 'sample_collected', 'in_analysis', 'results_available', 'cancelled') NOT NULL DEFAULT 'ordered',
  `sample_collection_date` DATETIME DEFAULT NULL,
  `expected_result_date` DATE DEFAULT NULL,
  `performed_by_user_id` INT(11) DEFAULT NULL, -- Quién realizó el estudio (ej., técnico de laboratorio)
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`work_order_id`) REFERENCES `work_orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`study_id`) REFERENCES `studies`(`id`) ON DELETE RESTRICT, -- RESTRICT: no permite borrar el tipo de estudio si está siendo usado
  FOREIGN KEY (`performed_by_user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de la tabla `results` (Resultados de los estudios)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `results` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `patient_study_id` INT(11) NOT NULL UNIQUE, -- Un resultado por estudio de paciente
  `result_data` TEXT NOT NULL, -- Datos del resultado (ej., JSON, texto plano)
  `result_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `validated_by_user_id` INT(11) DEFAULT NULL, -- Quién validó el resultado (ej., doctor o supervisor)
  `is_final` TINYINT(1) NOT NULL DEFAULT 0, -- 0=borrador, 1=final
  `file_path` VARCHAR(255) DEFAULT NULL, -- Ruta a un PDF o imagen del resultado
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`patient_study_id`) REFERENCES `patient_studies`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`validated_by_user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de la tabla `appointments` (Citas para pacientes)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `patient_id` INT(11) NOT NULL,
  `appointment_date` DATETIME NOT NULL,
  `reason` TEXT DEFAULT NULL,
  `status` ENUM('scheduled', 'completed', 'cancelled', 'rescheduled') NOT NULL DEFAULT 'scheduled',
  `scheduled_by_user_id` INT(11) DEFAULT NULL, -- Quién agendó la cita (ej., recepcionista)
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`patient_id`) REFERENCES `patients`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`scheduled_by_user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------
-- Datos de ejemplo para `users`
-- --------------------------------------------------------
-- ¡IMPORTANTE! Genera un hash de contraseña REAL para 'admin'.
-- Por ejemplo, crea un archivo temporal 'hash_generator.php' con:
-- <?php echo password_hash("TuContraseñaSegura123*", PASSWORD_DEFAULT); ?>
-- Ejecútalo en el navegador y copia el hash resultante aquí.
-- NO USES EL HASH DE EJEMPLO DIRECTAMENTE EN PRODUCCIÓN.
INSERT INTO `users` (`username`, `password_hash`, `email`, `first_name`, `last_name`, `phone`, `address`, `role`, `is_active`) VALUES
('admin', '$2y$10$wTfH.S5z.Q0J5oK7pQ9nnu.F0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0dF0d', 'admin@labmind.com', 'Admin', 'Sistema', '123-456-7890', 'Calle Principal 123', 'admin', 1),
('recepcion', '$2y$10$hash_para_recepcionista_aqui', 'recepcion@labmind.com', 'Maria', 'Gomez', '987-654-3210', 'Avenida Siempre Viva 456', 'receptionist', 1),
('doctor1', '$2y$10$hash_para_doctor1_aqui', 'doctor1@labmind.com', 'Dr. Carlos', 'Perez', '555-111-2222', 'Clinica Central', 'doctor', 1),
('labtech1', '$2y$10$hash_para_labtech1_aqui', 'labtech1@labmind.com', 'Ana', 'Lopez', '555-333-4444', 'Laboratorio Principal', 'lab_tech', 1);

-- --------------------------------------------------------
-- Datos de ejemplo para `studies`
-- --------------------------------------------------------
INSERT INTO `studies` (`name`, `description`, `price`) VALUES
('Examen de Sangre Completo', 'Hemograma completo, química sanguínea, perfil lipídico', 75.00),
('Análisis de Orina', 'Examen físico, químico y microscópico de orina', 20.00),
('Cultivo de Garganta', 'Identificación de bacterias causantes de infecciones de garganta', 45.00),
('Perfil Tiroideo', 'TSH, T3, T4', 90.00);


-- Habilitar nuevamente la verificación de claves foráneas al final del script
SET FOREIGN_KEY_CHECKS = 1;