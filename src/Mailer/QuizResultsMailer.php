<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;

class QuizResultMailer extends Mailer
{
    public function sendQuizResult($quizResult, $toEmail)
    {
        $template = 'quiz_result_normal';
        if ($quizResult == 'possible') {
            $template = 'quiz_result_possible';
        } else if ($quizResult == 'significant') {
            $template = 'quiz_result_significant';
        }

        $this
            ->setEmailFormat('html')
            ->setTo($toEmail)
            ->setSubject('Quiz Result')
            ->viewBuilder()
                ->setTemplate($template)
                ->setVar('quizResult', $quizResult);

        return $this;
    }
}