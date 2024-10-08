<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;
use function debug;

class QuizResultsMailer extends Mailer
{
    public function sendQuizResult($data)
    {
        $results = json_decode($data, true);
        $name = $results['firstName'] . ' ' . $results['lastName'];
        $hearingResult = $results['hearingResult'];
        $toEmail = $results['email'];

        $template = 'quizResultNormal';
        if ($hearingResult == 'possible') {
            $template = 'quizResultPossible';
        } else if ($hearingResult == 'significant') {
            $template = 'quizResultSignificant';
        }

        $this
            ->setEmailFormat('html')
            ->setTo($toEmail)
            ->setSubject('Quiz Result')
            ->setTemplate("QuizResults/$template")
            ->setViewVars([
                'results' => $results,
                'name' => $name
            ]);

        return $this;
    }
}