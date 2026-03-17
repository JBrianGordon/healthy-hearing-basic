<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Ddeboer\Imap\Server;
use App\Utility\CKBoxUtility;
use App\Model\Entity\CaCallGroup;
use App\Model\Entity\CaCall;
use App\Model\Entity\User;

/**
 * ParseVoicemail command.
 */
class ParseVoicemailCommand extends Command
{
    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/4/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);
        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|void|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->out('Parsing voicemail emails');

        $this->CaCalls = $this->fetchTable('CaCalls');

        $ckCategoryId = Configure::read('CK.voicemail-uploads');
        $ckBoxUtility = new CKBoxUtility($ckCategoryId);

        $hostname = Configure::read('voicemailEmail.hostname');
        $username = Configure::read('voicemailEmail.username');
        $password = Configure::read('voicemailEmail.password');
        $server = new Server($hostname);
        $connection = $server->authenticate($username, $password);

        $mailbox = $connection->getMailbox('INBOX');

        // Read voicemails from inbox
        $messages = $mailbox->getMessages();
        foreach ($messages as $count => $message) {
            echo $count.' ';
            $archiveMessage = true;
            $attachments = $message->getAttachments();
            foreach ($attachments as $count => $attachment) {
                $subtype = $attachment->getSubtype();
                if ($subtype == 'WAV') {
                    $timestamp = $message->getDate()->getTimestamp();
                    $subject = $message->getSubject();
                    preg_match('/[0-9]+/', $subject, $matches);
                    $fromPhone = isset($matches[0]) ? $matches[0] : 'unknown';
                    $filename = $timestamp."_".$fromPhone.".wav";
                    $filepath = "ftp/callAssist/voicemails/".$filename;
                    file_put_contents(
                        $filepath,
                        $attachment->getDecodedContent()
                    );
                    $duration = (int)round($this->getWavDuration($filepath));
                    // Do not save voicemails under 5 seconds
                    if ($duration >= 5) {
                        // Save the wav file to CDN
                        $result = $ckBoxUtility->uploadWavFile($filepath);
                        if ($result['status'] == 'error') {
                            $io->out($result['message']);
                            // Do not archive. We can try again next time.
                            $archiveMessage = false;
                        } else {
                            $io->out($result['message']);
                            // Delete the local file
                            unlink($filepath);
                            // Save a new call with this data
                            $caCall = $this->CaCalls->newEntity([
                                'user_id' => User::USER_ID_AUTOMATED_USER,
                                'start_time' => date('Y-m-d H:i:s', $timestamp),
                                'duration' => $duration,
                                'call_type' => CaCall::CALL_TYPE_INBOUND_VM,
                                'recording_url' => $result['url'],
                                'recording_duration' => $duration,
                                'ca_call_group' => [
                                    'caller_phone' => is_numeric($fromPhone) ? $fromPhone : null,
                                    'status' => CaCallGroup::STATUS_VM_NEEDS_CALLBACK,
                                    'scheduled_call_date' => date('Y-m-d H:i:s'), // call back immediately
                                ],
                            ]);
                            if ($caCall->hasErrors()) {
                                // Validation failed, handle errors
                                $errors = $caCall->getErrors(); // Get all errors
                                $errorMsg .= " Error: failed to save email ({$subject})<br>";
                                $io->out($errorMsg);
                                $io->out($errors);
                                // Do not archive. We can try again next time.
                                $archiveMessage = false;
                            } else {
                                // No errors, proceed to save
                                if ($this->CaCalls->save($caCall, ['associated' => ['CaCallGroups']])) {
                                    $io->out("Email ({$subject}) saved");
                                } else {
                                    // Save failed, handle errors
                                    $errors = $caCall->getErrors(); // Get all errors
                                    $errorMsg .= " Error: failed to save email ({$subject})<br>";
                                    $io->out($errorMsg);
                                    $io->out($errors);
                                    // Do not archive. We can try again next time.
                                    $archiveMessage = false;
                                }
                            }
                        }
                    } else {
                        $io->out(" Ignoring email from ".$fromPhone.". Duration = ".$duration." seconds.");
                    }
                }
            }
            // Archive message
            if ($archiveMessage && (Configure::read('env') == 'prod')) {
                $archiveMailbox = $connection->getMailbox('[Gmail]/All Mail');
                $message->move($archiveMailbox);
            }
        }

        $io->out('Done!');
    }

    private function getWavDuration(string $filePath) {
        if (!file_exists($filePath)) {
            trigger_error('File does not exist: ' . $filePath);
            return null;
        }

        $fileContents = file_get_contents($filePath);
        if ($fileContents === false) {
            trigger_error('Could not read file: ' . $filePath);
            return null;
        }

        // Extract necessary header information
        $riffHeader = unpack('VchunkID/VchunkSize/Vformat', substr($fileContents, 0, 12));
        $fmtSubchunk = unpack('VsubchunkID/VsubchunkSize/vaudioFormat/vnumChannels/VsampleRate/VbyteRate/vblockAlign/vbitsPerSample', substr($fileContents, 12, 24));

        // Find the 'data' subchunk
        $dataOffset = 36; // Initial assumption for 'data' subchunk offset
        while (substr($fileContents, $dataOffset, 4) !== 'data' && $dataOffset < strlen($fileContents)) {
            $dataOffset++;
        }

        if (substr($fileContents, $dataOffset, 4) !== 'data') {
            trigger_error('Could not find data subchunk in WAV file.');
            return null;
        }

        $dataSubchunk = unpack('VsubchunkID/VsubchunkSize', substr($fileContents, $dataOffset, 8));
        $dataSize = $dataSubchunk['subchunkSize'];

        $sampleRate = $fmtSubchunk['sampleRate'];
        $numChannels = $fmtSubchunk['numChannels'];
        $bitsPerSample = $fmtSubchunk['bitsPerSample'];

        // Calculate duration
        if ($sampleRate > 0 && $numChannels > 0 && $bitsPerSample > 0) {
            $bytesPerSample = ($bitsPerSample / 8);
            $totalSamples = $dataSize / ($numChannels * $bytesPerSample);
            return $totalSamples / $sampleRate; // Duration in seconds
        }

        return null;
    }
}
