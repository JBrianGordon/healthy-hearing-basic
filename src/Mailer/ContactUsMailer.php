<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;
use Cake\Log\LogTrait;

/**
 * ContactUs mailer.
 */
class ContactUsMailer extends Mailer
{
    use LogTrait;
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'ContactUs';

    public function notifyAdmin($requestData)
    {
        if ($requestData['hearing_care_professional'] === '1') {
            $this
                ->setEmailFormat('html')
                ->setTo('btalkington@healthyhearing.com')
                ->setSubject(Configure::read('siteNameAbbr') . 'Clinic Inquiry - ' . $requestData['email'])
                ->viewBuilder()
                    ->setTemplate('ContactUs/from_website')
                    ->setVar('contactInfo', $requestData);
        } else {
            $this
                ->setEmailFormat('html')
                ->setTo('btalkington@healthyhearing.com')
                ->setSubject('Message From Website: ' . $requestData['email'])
                ->viewBuilder()
                    ->setTemplate('ContactUs/from_website')
                    ->setVar('contactInfo', $requestData);
        }
    }

    public function thanksVisitor($requestData)
    {
        if ($requestData['hearing_care_professional'] === '1') {
            $this
                ->setEmailFormat('html')
                ->setTo('btalkington@healthyhearing.com')
                ->setSubject('Thanks for contacting ' . Configure::read('siteName'))
                ->viewBuilder()
                    ->setTemplate('ContactUs/thanks_clinic');
        } else {
            $this
                ->setEmailFormat('html')
                ->setTo('btalkington@healthyhearing.com')
                ->setSubject('Thanks for contacting ' . Configure::read('siteName'))
                ->viewBuilder()
                    ->setTemplate('ContactUs/thanks_consumer');
        }
    }

}
