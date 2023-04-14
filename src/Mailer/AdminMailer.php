<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;

/**
 * ContactUs mailer.
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
     * Notify admins that a ContactUs form was submitted
     * from either a hearing care professional or consumer
     *
     * @param array $requestData ContactUs form data.
     */
    public function importComplete($email)
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
