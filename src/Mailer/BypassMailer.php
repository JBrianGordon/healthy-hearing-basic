<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;

/**
 * Bypass mailer.
 */
class BypassMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'Bypass';

    public function apptRequestFormsBypass($requestData)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($requestData['email'])
            ->setSubject('Appointment Request Forms Bypass')
            ->setViewVars([
                'name' => $requestData['first_name'],
                'email' => $requestData['email']
            ])
            ->viewBuilder()
                ->setTemplate('Bypass/appt_requiest_forms_bypass');
    }

    public function callTrackingBypass($requestData)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($requestData['email'])
            ->setSubject('Call Tracking Bypass')
            ->setViewVars([
                'name' => $requestData['first_name'],
                'email' => $requestData['email']
            ])
            ->viewBuilder()
                ->setTemplate('Bypass/call_tracking_bypass');
    }

    public function callTrackingBasicBypass($requestData)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($requestData['email'])
            ->setSubject('Call Tracking Basic Bypass')
            ->setViewVars([
                'name' => $requestData['first_name'],
                'email' => $requestData['email']
            ])
            ->viewBuilder()
                ->setTemplate('Bypass/call_tracking_basic_bypass');
    }

    public function outOfOffice($requestData)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($requestData['email'])
            ->setSubject('Out of Office')
            ->setViewVars([
                'name' => $requestData['first_name'],
                'email' => $requestData['email']
            ])
            ->viewBuilder()
                ->setTemplate('Bypass/out_of_office');
    }
}
