<?php
  /**
   * Código de Cotización/Cita compatible con GoDaddy
   * Sin dependencias externas.
   */

  // 1. TU CORREO
  $receiving_email_address = 'ventas@cam-intl.com';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Recolección de datos del formulario (appointment form)
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $date = strip_tags(trim($_POST["date"]));
    $department = strip_tags(trim($_POST["department"])); // Esto es la "Línea" (Alimentos, Higiene, etc.)
    $doctor = strip_tags(trim($_POST["doctor"]));         // Esto es el "Tipo de Consulta"
    $message = trim($_POST["message"]);

    // 3. Validaciones
    if (empty($name) || empty($phone) || empty($department) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Por favor complete los campos obligatorios (Nombre, Email, Teléfono, Línea).";
        exit;
    }

    // 4. Asunto del Correo (Para que lo identifiques rápido en tu bandeja)
    $email_subject = "Nueva Solicitud de Cotización: $department";

    // 5. Construcción del Mensaje
    $email_content = "Has recibido una nueva solicitud desde la web:\n\n";
    $email_content .= "Detalles del Cliente:\n";
    $email_content .= "---------------------\n";
    $email_content .= "Nombre: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Teléfono: $phone\n\n";
    
    $email_content .= "Detalles de la Solicitud:\n";
    $email_content .= "---------------------\n";
    $email_content .= "Línea de Interés: $department\n";
    $email_content .= "Tipo de Consulta: $doctor\n";
    $email_content .= "Fecha Preferida: $date\n";
    $email_content .= "Mensaje Adicional:\n$message\n";

    // 6. Cabeceras
    $email_headers = "From: $name <$email>";

    // 7. Enviar
    if (mail($receiving_email_address, $email_subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "OK"; // Importante: El Javascript espera recibir "OK" para mostrar el éxito.
    } else {
        http_response_code(500);
        echo "Error al enviar la solicitud. Intente más tarde.";
    }

  } else {
    http_response_code(403);
    echo "Acceso denegado.";
  }
?>