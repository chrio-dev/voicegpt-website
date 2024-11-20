<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validate reCAPTCHA
    $recaptcha_secret = '6Le44oQqAAAAAAwsntDYFsNqoLm6_khx4VC7KH2z';
    $recaptcha_response = $_POST['g-recaptcha-response'];
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';

    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    if ($recaptcha->success) {
        // Prepare data to send to Power Automate
        $data = array(
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message
        );

        $url = 'https://prod-03.germanywestcentral.logic.azure.com:443/workflows/e834aa3480eb4960b33fff48fc161409/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=h50ppIGoeraLTMocNWmN7Jku5VOiNCvWOdwGbKp5yyg';

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ),
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            echo 'Error: Form submission failed.';
        } else {
            echo 'Success: Your message has been sent.';
        }
    } else {
        echo 'Error: reCAPTCHA verification failed.';
    }
} else {
    echo 'Error: Invalid request method.';
}
?>