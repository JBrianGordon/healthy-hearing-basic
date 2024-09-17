<?php
declare(strict_types=1);

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Mailer\MailerAwareTrait;
use Cake\Validation\Validator;

class ReviewForm extends Form
{
    use MailerAwareTrait;

    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addFields([
            'first_name' => 'string',
            'last_name' => 'string',
            'zip' => 'string',
            'rating' => 'integer',
            'body' => 'text',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        return $validator->email('email')
            ->notBlank('email')
            ->notBlank('first_name')
            ->notBlank('last_name')
            ->notBlank('zip')
            ->range('rating', [1, 5])
            ->notBlank('body');
    }

    protected function _execute(array $requestData): bool
    {
        $mailer = $this->getMailer('Review');
        $score = $requestData['score'];

        if ($score >= 4) {
            $mailer->send('emailPositiveReviewReceived', [$requestData]);
        } else if ($score <= 3) {
            $mailer->send('emailNegativeReviewReceived', [$requestData]);
        }

        return true;
    }
}