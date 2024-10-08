<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;

/**
 * Profile mailer.
 */
class ProfileMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'Profile';

    public function clinicDefaultEmail($requestData)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($requestData['email'])
            ->setSubject('Clinic Default Email')
            ->setViewVars([
                'name' => $requestData['first_name'],
                'email' => $requestData['email']
            ])
            ->viewBuilder()
                ->setTemplate('Profile/clinic_default_email');
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
                ->setTemplate('Profile/out_of_office');
    }

    public function profileUpdate($requestData)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($requestData['email'])
            ->setSubject('Profile Update')
            ->setViewVars([
                'name' => $requestData['first_name'],
                'email' => $requestData['email']
            ])
            ->viewBuilder()
                ->setTemplate('Profile/profile_update');
    }

    public function resetPasswordEmail($requestData)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($requestData['email'])
            ->setSubject('Reset Password')
            ->setViewVars([
                'name' => $requestData['first_name'],
                'email' => $requestData['email']
            ])
            ->viewBuilder()
                ->setTemplate('Profile/reset_password_email');
    }

    public function upgradeProfile($requestData)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($requestData['email'])
            ->setSubject('Upgrade Profile')
            ->setViewVars([
                'name' => $requestData['first_name'],
                'email' => $requestData['email']
            ])
            ->viewBuilder()
                ->setTemplate('Profile/upgrade_profile');
    }
}