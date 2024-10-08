<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;

/**
 * ContentReadyApprove mailer.
 */
class ContentReadyApproveMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'ContentReadyApprove';

    public function contentReadyApprove($requestData)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($requestData['email'])
            ->setSubject('Content Ready for Approval')
            ->setViewVars([
                'name' => $requestData['first_name'],
                'email' => $requestData['email']
            ])
            ->viewBuilder()
                ->setTemplate('content_ready_approve');
    }
}