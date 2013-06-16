<?php
    require_once "Mail.php";
//require_once 'System.php';

    $from     = "<from.gmail.com>";
    $to       = "<terkel.brix@gmail.com>";
    $subject  = "Hi!";
    $body     = "Hi,\n\nHow are you?";

    $host     = "ssl://smtp.gmail.com";
    $port     = "465";
    $username = "terkel.brix@gmail.com";  //<> give errors
    $password = "zlazqvghnzyeokvf";

    $headers = array(
        'From'    => $from,
        'To'      => $to,
        'Subject' => $subject
    );
    $smtp = Mail::factory('smtp', array(
        'host'     => $host,
        'port'     => $port,
        'auth'     => true,
        'username' => $username,
        'password' => $password
    ));

    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
        echo("<p>" . $mail->getMessage() . "</p>");
    } else {
        echo("<p>Message successfully sent!</p>");
    }

?>  <!-- end of php tag-->