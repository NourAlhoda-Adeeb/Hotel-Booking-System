<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    // معلومات المرسل
    public $fromEmail = 'nour02alhuda@gmail.com';
    public $fromName  = 'AN Hotel';

    // إعدادات SMTP (Gmail)
    public $protocol   = 'smtp';
    public $SMTPHost   = 'smtp.gmail.com';
    public $SMTPUser   = 'nour02alhuda@gmail.com';
    public $SMTPPass   = 'vkgkshhxjoltlsky'; // 🔥 App Password بدون مسافات
    public $SMTPPort   = 587;
    public $SMTPCrypto = 'tls';

    // إعدادات عامة
    public $mailType = 'html';
    public $charset  = 'UTF-8';
    public $newline  = "\r\n";
    public $CRLF     = "\r\n";

    public $wordWrap = true;
}
