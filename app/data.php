<?php

require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['stQue']) && !empty($_POST['lgQue'])) {
    $userData[] = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $userData[] = trim(filter_var($_POST['phone'], FILTER_SANITIZE_STRING));
    $userData[] = trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $userData[] = trim(filter_var($_POST['stQue'], FILTER_SANITIZE_STRING));
    $userData[] = trim(filter_var($_POST['lgQue'], FILTER_SANITIZE_STRING));

    if (!in_array(null, $userData)) {
        $phoneRegexp = "/^0(2|3|4|5|8|9)(\d)?\d{7}$/";

        if (mb_strlen($userData[0]) >= 2 && mb_strlen($userData[0]) <= 50) {
            if (preg_match($phoneRegexp, $userData[1])) {
                if (mb_strlen($userData[3]) >= 2 && mb_strlen($userData[3]) <= 50) {
                    if (mb_strlen($userData[4]) >= 2 && mb_strlen($userData[4]) <= 50) {
                        $dbcon = 'mysql:host=localhost;dbname=idan_landing_pages;charset=utf8';
                        $db = new PDO($dbcon, 'root', '');
                        $sql = "INSERT INTO karin1_contacts VALUES('',?,?,?,?,?)";
                        $query = $db->prepare($sql);

                        $mail = new PHPMailer();
                        $mail->Charset = 'UTF-8';
                        $mail->setFrom('no-reply@idan.work', 'idan');
                        $mail->addAddress('idanco77@gmail.com', 'Idan Cohen'); // should be: (job2u.li@gmail.com, 'Liat Razabi') 
                        $mail->Subject = 'new lead - karin1 landing page';

                        $mail->Body = <<<EOT
<body dir="rtl" style="font-family: arial; color: #fff; height: 100%; float: right;">
<div style="background-color: #eaa4ba; border: 3px solid #b398a1; padding: 10px; width: 90%;">
<h3 style="text-align: center; color: #fff;">שלום עידן. יש לך ליד נוסף להגרלה:</h3>
<hr style="border: 1px solid #b398a1">
<table style="width: 100%; border-collapse: collapse;">
<tr>
<td style="border: 2px solid #b398a1; width: 20%"><b>שם הגולש: </b></td>
<td style="border: 2px solid #b398a1">{$userData[0]}</td>
</tr>
<tr>
<td style="border: 2px solid #b398a1; width: 20%"> <b>האימייל של הגולש: </b></td>
<td style="border: 2px solid #b398a1">{$userData[2]}</td>
</tr>
<tr>
<td style="border: 2px solid #b398a1; width: 20%"> <b>הטלפון של הגולש: </b></td>
<td style="border: 2px solid #b398a1">{$userData[1]}</td>
</tr>
<tr>
<td style="border: 2px solid #b398a1; width: 20%"> <b>הטעם האהוב על הגולש:</b></td>
<td style="border: 2px solid #b398a1">{$userData[3]}</td>
</tr>
<tr>
<td style="border: 2px solid #b398a1; width: 20%"> <b>למה דווקא לי מגיע?</b></td>
<td style="border: 2px solid #b398a1">{$userData[4]}</td>
</tr>
</table>
</div>
</body>
EOT;

                        $mail->IsHTML(true);
                        if ($mail->send()) {
                            echo $query->execute($userData);
                        }
                    }
                }
            }
        }
    }
}


