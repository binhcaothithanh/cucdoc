<?php

// Gmail by default doesnt allow send server email so it force you change to "less secure app" => then send email easy
// https://myaccount.google.com/lesssecureapps?pli=1&rapt=AEjHL4N2WxJxurbeL3UCD6tvGUKcFK2FOcjfY9WbHJym1_cY3t8aTtgW3V-WwGvKqyAZcmxiamIFVWJSP2ACk0cRpzyxf48Wiw

    // 'useragent' => 'CodeIgniter',
    // 'protocol' => 'smtp',
    // 'smtp_host' => 'smtp.googlemail.com',
    // 'smtp_port' => 465,
    // 'smtp_user' => 'shopdaophuot@gmail.com',
    // 'smtp_pass' => 'Trvuhh123',
    // 'smtp_crypto' => 'ssl',
    // '_smtp_auth' => TRUE,
    // 'mailtype' => 'html',
    // 'smtp_timeout' => '4',
    // 'charset' => 'iso-8859-1',
    // 'validation' => FALSE,
    // 'newline' => "\r\n",
    // 'wordwrap' => TRUE

$config['protocol']    = 'smtp';
$config['smtp_host']   = 'ssl://smtp.googlemail.com';
$config['smtp_port']   = 465;
$config['smtp_user']   = 'binh.caothithanh@gmail.com'; // Your Gmail
$config['smtp_pass']   = 'kygi swdu hduy cuom';   // Use App Password (not Gmail password)
$config['mailtype']    = 'html';
$config['charset']     = 'utf-8';
$config['wordwrap']    = TRUE;
$config['newline']     = "\r\n";
?>
