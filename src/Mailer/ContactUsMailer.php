<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;

/**
 * ContactUs mailer.
 */
class ContactUsMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'ContactUs';

    /**
     * Notify admins that a ContactUs form was submitted
     * from either a hearing care professional or consumer
     *
     * @param array $requestData ContactUs form data.
     */
    public function notifyAdmin($requestData)
    {
        if ($requestData['hearing_care_professional'] === '1') {
            $this
                ->setEmailFormat('html')
                ->setTo(Configure::read('customer-support-email'))
                ->setSubject(Configure::read('siteNameAbbr') . ' Clinic Inquiry - ' . $requestData['email'])
                ->viewBuilder()
                    ->setTemplate('ContactUs/from_website')
                    ->setVar('requestData', $requestData);
        } else {
            $this
                ->setEmailFormat('html')
                ->setTo(Configure::read('customer-support-email'))
                ->setSubject('Message From Website: ' . $requestData['email'])
                ->viewBuilder()
                    ->setTemplate('ContactUs/from_website')
                    ->setVar('requestData', $requestData);
        }
    }

    /**
     * Send a thank-you email to ContactUs form submitters
     * that are specific to hearing care professionals or consumers
     *
     * @param array $requestData ContactUs form data.
     */
    public function thanksVisitor($requestData)
    {
        if ($requestData['hearing_care_professional'] === '1') {
            $this
                ->setEmailFormat('html')
                ->setTo($requestData['email'])
                ->setSubject('Thanks for contacting ' . Configure::read('siteName'))
                ->viewBuilder()
                    ->setTemplate('ContactUs/thanks_clinic');
        } else {
            $this
                ->setEmailFormat('html')
                ->setTo($requestData['email'])
                ->setSubject('Thanks for contacting ' . Configure::read('siteName'))
                ->viewBuilder()
                    ->setTemplate('ContactUs/thanks_consumer');
        }
    }
}
