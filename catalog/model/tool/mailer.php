<?php
    class ModelToolMailer extends Model {
        
        public $default_email = $this->config->get('config_email');

        public function sendMail($to, $subject, $message, $from = $this->default_email){
            $mail = new Mail();

            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');            
            $mail->setTo($to);
            $mail->setFrom($from);
            $mail->setSender($from);
            $mail->setSubject($from);
            $mail->setText($message);

            $mail->send();
        }
    }
?>