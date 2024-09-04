<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;

/**
 * Admin mailer.
 */
class AdminMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'Admin';

    /**
     * Send a basic email to admin user. Use default template.
     *
     * @param array $email
     */
    public function default($email)
    {
        $to = isset($email['to']) ? $email['to'] : Configure::read('customer-support-email');
        $subject = isset($email['subject']) ? $email['subject'] : "";
        $body = isset($email['body']) ? $email['body'] : "";
        $this
            ->setEmailFormat('html')
            ->setTo($to)
            ->setSubject($subject)
            ->viewBuilder()
                ->setTemplate('default')
                ->setVar('content', $body);
    }
}
