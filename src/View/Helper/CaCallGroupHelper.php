<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use App\Model\Entity\CaCall;
use App\Model\Entity\CaCallGroup;

class CaCallGroupHelper extends Helper {
    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    protected $helpers = ['Identity', 'Html', 'Form'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function initialize(array $config): void
    {
        $this->CaCallGroups = TableRegistry::getTableLocator()->get('CaCallGroups');
        $this->CaCalls = TableRegistry::getTableLocator()->get('CaCalls');
    }

    public function getCallerInfo($call){
        //TODO
        $retval = $call['CaCallGroup']['caller_first_name'].' '.$call['CaCallGroup']['caller_last_name'].'<br />';
        if (!$call['CaCallGroup']['is_patient']) {
            $retval .= 'calling for '.$call['CaCallGroup']['patient_first_name'].' '.$call['CaCallGroup']['patient_last_name'].'<br />';
        }
        $retval .= formatPhoneNumber($call['CaCallGroup']['caller_phone']);
        return $retval;
    }

    /**
    * Format datetime into readable format: 'Today 1:30 PM', 'Yesterday 12:45 AM', 'Monday Nov 3rd 11:10 PM'
    */
    public function formatDate($timestamp){
        $date = '';
        if (date('m/d/Y', $timestamp) == date('m/d/Y', strtotime('today'))) {
            $date = 'Today';
        } elseif (date('m/d/Y', $timestamp) == date('m/d/Y', strtotime('yesterday'))) {
            $date = 'Yesterday';
        } else {
            $date = date('l M jS', $timestamp);
        }
        $date .= ' '.date('g:i A', $timestamp);
        return $date;
    }
    /**
    * Get the result of a specific call group
    * @param id - Call Group id
    * @return string result to display
    */
    public function getCallResult($id) {
        return $this->CaCallGroups->getCallResult($id);
    }
    /**
    * Get the outbound call type based on current call group status.
    * @param string - status enum
    * @param string - score enum
    * @param string - direct book type
    * @param bool - wantsHearingTest
    * @return string - call type enum
    */
    public function getCallTypeByStatus($status, $score, $directBookType, $wantsHearingTest) {
        return $this->CaCalls->getCallTypeByStatus($status, $score, $directBookType, $wantsHearingTest);
    }
    /**
    * Get readable call type based on call type enum.
    * @param string - call type enum
    * @param string - status enum
    * @return string - readable call type
    */
    public function getReadableCallType($callType, $status=null) {
        $readableCallType = '';
        if (array_key_exists($callType, CaCall::$callTypes)) {
            $readableCallType = CaCall::$callTypes[$callType];
        } else if (in_array($status, [CaCallGroup::STATUS_VM_NEEDS_CALLBACK, CaCallGroup::STATUS_VM_CALLBACK_ATTEMPTED])) {
            $readableCallType = 'Voicemail needs callback';
        }
        return $readableCallType;
    }
}
?>
