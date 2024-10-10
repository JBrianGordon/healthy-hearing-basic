<?php
declare(strict_types=1);

namespace App\Form;

use App\Utility\MailchimpUtility;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Mailer\MailerAwareTrait;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * ContactUs Form.
 */
class ContactUsForm extends Form
{
    use MailerAwareTrait;

    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addFields([
            'first_name' => 'string',
            'last_name' => 'string',
            'phone' => 'string',
            'email' => 'string',
            'zip' => 'string',
            'subscribe' => 'boolean',
            'hearing_care_professional' => 'boolean',
            'message' => 'text',
        ]);
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        return $validator->email('email')
            ->notBlank('email')
            ->notBlank('message');
    }

    /**
     * Defines what to execute once the Form is processed
     *
     * @param array $requestData Form data.
     * @return bool
     */
    protected function _execute(array $requestData): bool
    {
        $userData = [
            'email_address' => $requestData['email'],
            'merge_fields' => [
                'FNAME' => $requestData['first_name'],
                'LNAME' => $requestData['last_name'],
            ],
        ];

        if ($requestData['subscribe'] === '1') {
            $mailchimp = new MailchimpUtility();
            $mailchimp->subscribeMember($userData);
        }
        $locations = TableRegistry::getTableLocator()->get('Locations');
        $zipUrl = Router::url($locations->findUrlByZip($requestData['zip']));

        $this->getMailer('ContactUs')->send('notifyAdmin', [$requestData]);
        $this->getMailer('ContactUs')->send('thanksVisitor', [$requestData, $zipUrl]);

        return true;
    }
}
