<?php
declare(strict_types=1);

namespace App\Form;

use App\Utility\MailchimpUtility;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * Newsletter Form.
 */
class NewsletterForm extends Form
{
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
            'email' => 'string',
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
            ->notBlank('email');
    }

    /**
     * Defines what to execute once the Form is processed
     *
     * @param array $data Form data.
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

        $mailchimp = new MailchimpUtility();
        $mailchimp->subscribeMember($userData);

        return true;
    }
}
