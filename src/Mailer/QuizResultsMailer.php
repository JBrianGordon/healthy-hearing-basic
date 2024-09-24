<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;
use function debug;

class QuizResultsMailer extends Mailer
{
    public function sendQuizResult($data)
    {
        debug("aaaaa");
        $results = json_decode($data, true);
        $name = $results['firstName'] . ' ' . $results['lastName'];
        $hearingResult = $results['hearingResult'];
        $toEmail = $results['email'];

        $template = 'quiz_result_normal';
        if ($hearingResult == 'possible') {
            debug("bbbbb");
            $template = 'quiz_result_possible';
        } else if ($hearingResult == 'significant') {
            debug("ccccc");
            $template = 'quiz_result_significant';
        }

        $this
            ->setEmailFormat('html')
            ->setTo($toEmail)
            ->setSubject('Quiz Result')
            ->setTemplate($template)
            ->setViewVars([
                'results' => $results,
                'name' => $name
            ]);

        debug("ddddd");
        return $this;
    }
}