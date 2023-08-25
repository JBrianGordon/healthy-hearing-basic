<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Core\Configure;
use Cake\Log\Log;
use GuzzleHttp\Exception\ClientException;
use MailchimpMarketing\ApiClient;

class MailchimpUtility
{
    /**
     * @var \MailchimpMarketing\ApiClient
     */
    private $client;

    /**
     * @var string
     */
    private $listId;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = new ApiClient();

        $this->client->setConfig([
            'apiKey' => Configure::read('mailchimpApiKey'),
            'server' => Configure::read('mailchimpServerPrefix'),
        ]);

        $this->listId = Configure::read('mailchimpListIdNewsletter');
    }

    /**
     * Subscribe someone to the consumer Mailchimp newsletter
     *
     * @param array $userData User data submitted through a form
     */
    public function subscribeMember($userData)
    {
        try {
            return $this->client->lists->addListMember($this->listId, [
                'email_address' => $userData['email_address'],
                'status' => 'pending',
                'merge_fields' => $userData['merge_fields'],
            ]);
        } catch (ClientException $e) {
            Log::write(
                'error',
                'Mailchimp exception: ' . $e->getResponse()->getBody()->getContents()
            );
        }
    }
}
