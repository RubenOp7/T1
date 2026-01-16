<?php
  // REPLACE WITH YOUR REAL EMAIL
  $receiving_email_address = 'ventas@cam-intl.com';

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    // Standalone GoDaddy/PHP Logic
    $to = $receiving_email_address;
    $from_name = $_POST['name'];
    $from_email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validate inputs
    if (empty($from_name) || empty($from_email) || empty($message)) {
        http_response_code(400);
        echo "Por favor complete todos los campos.";
        exit;
    }

    // Email Headers
    $headers = "From: " . $from_name . " <" . $from_email . ">\r\n";
    $headers .= "Reply-To: " . $from_email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Email Body
    $email_content = "<h2>Nuevo mensaje de la web</h2>";
    $email_content .= "<p><strong>Nombre:</strong> $from_name</p>";
    $email_content .= "<p><strong>Email:</strong> $from_email</p>";
    $email_content .= "<p><strong>Asunto:</strong> $subject</p>";
    $email_content .= "<p><strong>Mensaje:</strong><br>$message</p>";

    // Send
    if(mail($to, $subject, $email_content, $headers)) {
      echo 'OK'; // This specific string tells the Javascript to show the Green Success Message
    } else {
      echo 'Error al enviar el mensaje. Intente más tarde.';
    }
    die();
  }
?>