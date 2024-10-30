<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;
use Cake\Core\Configure;

class QuizResultsMailer extends Mailer
{
    public static $name = 'QuizResults';

    public function sendQuizResult($name, $hearingResult, $toEmail, $symptoms)
    {
        $isUS = Configure::read('country') == 'US';
        $template = 'quiz_result_normal';
        if ($hearingResult == 'possible') {
            $template = 'quiz_result_possible';
        } else if ($hearingResult == 'significant') {
            $template = 'quiz_result_significant';
        }
        $this
            ->setEmailFormat('html')
            ->setTo($toEmail)
            ->setSubject('Quiz Result')
            ->setViewVars([
                'symptoms' => $symptoms,
                'name' => $name,
                'isUS' => $isUS
            ])
            ->viewBuilder()
                ->setTemplate("QuizResults/$template");

        return $this;
    }
}