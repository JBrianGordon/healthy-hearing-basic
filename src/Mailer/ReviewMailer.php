<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Log\LogTrait;

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
     */
    public function emailPositiveReviewReceived($review)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($this->getLocationEmail($review->location_id))
            ->setSubject(Configure::read('siteNameAbbr') . ' -- Positive Review Received')
            ->viewBuilder()
                ->setTemplate('Review/positiveReviewReceived')
                ->setVar('reviewData', $review);
    }

    /**
     * Send an email to a clinic after a negative email is approved.
     *
     * @param \Cake\ORM\Entity $review Review entity
     */
    public function emailNegativeReviewReceived($review)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($this->getLocationEmail($review->location_id))
            ->setSubject(Configure::read('siteNameAbbr') . ' -- Negative Review Received')
            ->viewBuilder()
                ->setTemplate('Review/negativeReviewReceived')
                ->setVar('reviewData', $review);
    }

    /**
     * Send an email to a clinic after a review response is published.
     *
     * @param \Cake\ORM\Entity $review Review entity
     */
    public function emailReviewResponsePosted($review)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($this->getLocationEmail($review->location_id))
            ->setSubject(Configure::read('siteNameAbbr') . ' -- Review Response Posted')
            ->viewBuilder()
                ->setTemplate('Review/reviewResponsePosted')
                ->setVar('reviewData', $review);
    }

    protected function getLocationEmail($locationId)
    {
        return $this
            ->getTableLocator()
            ->get('Locations')
            ->findById($locationId)
            ->first()
            ->email;
    }
}
