<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Log\LogTrait;
use Cake\Mailer\Mailer;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Review mailer.
 */
class ReviewMailer extends Mailer
{
    use LocatorAwareTrait;
    use LogTrait;

    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'Review';

    /**
     * Send an email to a clinic after a positive email is approved.
     *
     * @param \Cake\ORM\Entity $review Review entity
     * @param string $toEmail Recipient email address
     * @return $this
     */
    public function emailPositiveReviewReceived($review, $toEmail)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($toEmail)
            ->setSubject(Configure::read('siteNameAbbr') . ' -- Positive Review Received')
            ->viewBuilder()
                ->setTemplate('Review/review_received')
                ->setVar('reviewData', $review);

        return $this;
    }

    /**
     * Send an email to a clinic after a negative email is approved.
     *
     * @param \Cake\ORM\Entity $review Review entity
     * @param string $toEmail Recipient email address
     * @return $this
     */
    public function emailNegativeReviewReceived($review, $toEmail)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($toEmail)
            ->setSubject(Configure::read('siteNameAbbr') . ' -- Negative Review Received')
            ->viewBuilder()
                ->setTemplate('Review/review_received_negative')
                ->setVar('reviewData', $review);

        return $this;
    }

    /**
     * Send an email to a clinic after a review response is published.
     *
     * @param \Cake\ORM\Entity $review Review entity
     * @param string $toEmail Recipient email address
     * @return $this
     */
    public function emailReviewResponsePosted($review, $toEmail)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($toEmail)
            ->setSubject(Configure::read('siteNameAbbr') . ' -- Review Response Posted')
            ->viewBuilder()
                ->setTemplate('Review/review_response_posted')
                ->setVar('reviewData', $review);

        return $this;
    }

    /**
     * Send an email to site's customer-support-email if clinic doesn't have email
     *
     * @param \Cake\ORM\Entity $review Review entity
     * @return $this
     */
    public function noEmailSentToClinic($review, $toEmail)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($toEmail)
            ->setSubject(Configure::read('siteNameAbbr') . ' -- Review email not sent')
            ->viewBuilder()
                ->setTemplate('Review/review_no_email')
                ->setVar('reviewData', $review);

        return $this;
    }
}
