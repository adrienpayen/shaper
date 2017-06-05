<?php
namespace Core\Mail;

use Symfony\Component\Yaml\Yaml;

class Mailer extends \PHPMailer
{
    /** @var \PHPMailer */
    protected $mail;


    private $config;

    public function __construct($exceptions = null)
    {
        parent::__construct($exceptions);

        $this->mail = new \PHPMailer();
        $this->config = Yaml::parse(file_get_contents('../App/Config/parameters.yml'));
        $this->config = $this->config['mail'];
    }

    public function sendMail($recipient, $subject, $msg, $sender = null)
    {
        $mail = $this->mail;
        $mail->IsSMTP();
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
        $mail->IsHTML(true);
        $mail->Host='ssl0.ovh.net';  //aussi essayé smtp.mondomaine.com ssl0.ovh.net
        $mail->Port = 465;    //  587 ou 465 ou 25
        $mail->Username = 'root@ajarcms.com';      // SMTP login
        $mail->Password = 'yaFBfi3x';        // SMTP password
        $mail->SMTPAuth = true;      // Active l'authentification par smtp
        $mail->SMTPSecure = 'ssl';  // tls ou ssl
        $mail->Priority = 3;   // Priorité : 1 Urgent, 3 Normal, 6 Lent
        $mail->CharSet = "ISO-8859-1";




//        exit;
//        $mail = $this->mail;
//
//        $mail->Host = $this->config['smtp'];
//        $mail->Port = $this->config['port'];
//        $mail->SMTPSecure = "ssl";
//        $mail->SMTPAuth   = true;
//        $mail->Username = $this->config['username'];
//        $mail->Password = $this->config['password'];
//        $mail->SMTPDebug = 3;
//        echo '<pre>';
//        $mail->IsSMTP();

        if (!$sender) {
            $mail->SetFrom($this->config['expeditor_adress'], 'Nom Prénom');
        }

        $mail->AddAddress($recipient);
        $mail->Subject = $subject;

        $mail->MsgHTML($msg);

        if (!$mail->Send()) {
            echo 'Erreur : ' . $mail->ErrorInfo;
            return false;
        } else {
            echo 'Message envoyé !';
            return true;
        }
    }
}