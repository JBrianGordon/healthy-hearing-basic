<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;

class QuizResultMailer extends Mailer
{
    public function sendQuizResult($quizResult)
    {
        $results = json_decode($data['results'], true);
        $name = $results['firstName'] . ' ' . $results['lastName'];
        $hearingResult = $results['hearingResult'];
        $toEmail = $results['email'];

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
            ->setTemplate($template)
            ->setViewVars([
                'quizResult' => $results,
                'name' => $name
            ]);

        return $this;
    }
}