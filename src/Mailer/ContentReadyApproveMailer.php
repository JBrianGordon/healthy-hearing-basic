<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;
use Cake\Core\Configure;

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

    public function contentReadyApprove($content)
    {
        $this
            ->setEmailFormat('html')
            ->setTo(Configure::read('editorEmails'))
            ->setSubject('Content #' . $content->id . ' Ready for Approval')
            ->setViewVars([
                'content' => $content,
                'url' => ['admin' => true, 'controller' => 'content', 'action' => 'edit', $content->id]
            ])
            ->viewBuilder()
                ->setTemplate('content_ready_approve');
    }
}