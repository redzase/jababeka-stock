<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'sent_email' => array(
        'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_port' => 587,
        'smtp_user' => 'jababeka.help@gmail.com',
        'smtp_pass' => 'jababeka1234',
        'smtp_crypto' => 'security', //can be 'ssl' or 'tls' for example
        'mailtype' => 'html', //plaintext 'text' mails or 'html'
        'smtp_timeout' => '4', //in seconds
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE,
        'validation' => TRUE
    )
);
