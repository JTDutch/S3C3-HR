<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = 'band.unhinged.music@gmail.com';
    public string $fromName   = 'Unhinged Band';
    public string $recipients = 'justvanthiel@gmail.com';

    public string $userAgent  = 'CodeIgniter';

    public string $protocol   = 'smtp';
    public string $mailPath   = '/usr/sbin/sendmail';
    public string $SMTPHost   = 'smtp.gmail.com';
    public string $SMTPUser   = 'band.unhinged.music@gmail.com';

    // Instead of setting SMTPPass here, we initialize it in the constructor.
    public string $SMTPPass   = ''; 

    public int $SMTPPort      = 465;
    public int $SMTPTimeout   = 5;
    public bool $SMTPKeepAlive= false;
    public string $SMTPCrypto  = 'ssl';
    public bool $wordWrap     = true;
    public int $wrapChars     = 76;
    public string $mailType   = 'text';
    public string $charset    = 'UTF-8';
    public bool $validate     = false;
    public int $priority      = 3;
    public string $CRLF       = "\r\n";
    public string $newline    = "\r\n";
    public bool $BCCBatchMode = false;
    public int $BCCBatchSize  = 200;
    public bool $DSN         = false;

    public function __construct()
    {
        // Set the SMTPPass from the environment variable.
        $this->SMTPPass = getenv('EMAIL_PASS');
    }
}
