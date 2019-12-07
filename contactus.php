
<?php
header("Access-Control-Allow-Origin: *");
require 'PHPMailer/PHPMailerAutoload.php';

// Checking For Blank Fields..

$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'mail.codedigm.co.za'; // Specify main and backup SMTP servers
$mail->SMTPAuth = true; // Enable SMTP authentication
$mail->Username = 'info@codedigm.co.za'; // SMTP username
$mail->Password = 'TestP@ssw0rd1234'; // SMTP password
$mail->SMTPAutoTLS = false;
//$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;
$mail->isHTML(true);

try {
    $secretKey = '6Leic8UUAAAAALV9Hs4_6wpN6k6a5-Ojcb4opII2';
    $captcha = $_POST['g-recaptcha-response'];

    $name = $_POST["name"];
    $email = $_POST["email"];
    $companyName = $_POST["companyName"];
    $contactNumber = $_POST["contactNumber"];
    $companySizeId = $_POST["companySizeId"];
    $serviceId = $_POST["serviceId"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    if ($name == "" || $email == "" || $companyName == "" || $companySizeId == "" || $serviceId == "" || $subject == "" || $message == "" || $contactNumber == "") {
        echo "Fill All Fields..";
    } else {
        //captcha stuff
        $ip = $_SERVER['REMOTE_ADDR'];
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        $responseKeys = json_decode($response,true);
        if(intval($responseKeys["success"]) !== 1) {
            echo 'Please tick "I am not a Robot" on the form.';
            http_response_code(422);
         } else {
            // Check if the "Sender's Email" input field is filled out
            // Sanitize E-mail Address
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            // Validate E-mail Address
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$email) {
                echo "Invalid Sender's Email";
            } else {
                $mail->setFrom($email, 'Mailer');
                $mail->addAddress('info@codedigm.co.za', 'Info Codedigm');
                $mail->Subject = "Company Website Lead - " . $subject;
                $formattedBody = "Name: <b>" . $name . "</b><br>" . "Email: <b>" . $email . "</b><br>" . "Company Name: <b>" . $companyName . "</b><br>" . "Contact Number: <b>" . $contactNumber . "</b><br>" . "Company Size: <b>" . getCompanySize($companySizeId) . "</b><br>" . "Service: <b>" . getService($serviceId) . "</b><br>" . "Message: <b>" . $message . "</b>";

                $mail->Body = $formattedBody;
                if (!$mail->send()) {
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                    http_response_code(500);
                } else {
                    echo 'Message has been sent';
                }
            }
        }    
    }
} catch (Exception $e) {
    echo $e;
    http_response_code(500);
}

function getCompanySize($companySizeId)
{
    $companySize = "";

    switch ($companySizeId) {
        case 1:
            $companySize = "Small Enterprise";
            break;
        case 2:
            $companySize = "Medium Enterprise";
            break;
        case 3:
            $companySize = "Large Enterprise";
            break;
        case 4:
            $companySize = "Startup Or Individual";
            break;
    }

    return $companySize;
}

function getService($serviceId)
{
    $service = "";

    switch ($serviceId) {
        case 1:
            $service = "Cloud Integration Existing Or New Solution";
            break;
        case 2:
            $service = "Mobile Solution";
            break;
        case 3:
            $service = "Web Based Solution";
            break;
    }

    return $service;
}
?>
