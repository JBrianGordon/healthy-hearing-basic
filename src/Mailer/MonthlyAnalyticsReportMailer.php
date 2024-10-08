<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;

/**
 * MonthlyAnalyticsReport mailer.
 */
class MonthlyAnalyticsReportMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'MonthlyAnalyticsReport';

    public function monthlyAnalyticsReport($requestData)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($requestData['email'])
            ->setSubject('Monthly Analytics Report')
            ->setViewVars([
                'name' => $requestData['first_name'],
                'email' => $requestData['email']
            ])
            ->viewBuilder()
                ->setTemplate('monthly_analytics_report');
    }
}