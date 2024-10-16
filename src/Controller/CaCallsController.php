<?php
declare(strict_types=1);

namespace App\Controller;
use App\Model\Entity\CaCallGroup;
use App\Model\Entity\CaCall;
use App\Model\Entity\User;
use Cake\Core\Configure;
use Cake\View\JsonView;

/**
 * CaCalls Controller
 *
 * @property \App\Model\Table\CaCallsTable $CaCalls
 * @method \App\Model\Entity\CaCall[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CaCallsController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent(
            'Recaptcha.Recaptcha',
            [
                'enable' => true,
                'sitekey' => Configure::read('recaptchaPublicKey'),
                'secret' => Configure::read('recaptchaPrivateKey'),
                'type' => 'image',
                'theme' => 'light',
                'lang' => 'en',
                'size' => 'normal',
            ]
        );
    }

	/**
	* Online appointment request form - accessed by clicking 'submit'
	*/
	public function ajaxApptRequest() {
		$this->viewBuilder()->setLayout('ajax');
		$this->meta['robots'] = "NOINDEX, FOLLOW";
		$data = [];
		$requestData = $this->request->getData();
		if (!empty($requestData)) {
			// Verify reCAPTCHA response
			/* TODO
			if (!$this->Recaptcha->verify()) {
				$data['success'] = false;
				$data['errorMessage'] = 'reCAPTCHA test failed ("I\'m not a robot"). Please try again!';
	            $this->set(compact('data'));
	            $this->viewBuilder()->setOption('serialize', 'data');
	            return;
			}*/
			// New inbound call
			$caCall = $this->fetchTable('CaCalls')->newEntity([
				'start_time' => getCurrentEasternTime(),
				'call_type' => CaCall::CALL_TYPE_APPT_REQUEST_FORM,
				'user_id' => User::USER_ID_AUTOMATED_USER
			]);
			$caCallGroup = $this->fetchTable('CaCallGroups')->newEntity($requestData['CaCallGroup']);
			$topics = [
				// topic key / prospect?
				CaCallGroup::TOPIC_WANTS_APPT => true,
				CaCallGroup::TOPIC_AID_LOST_OLD => true,
				CaCallGroup::TOPIC_APPT_FOLLOWUP => false, //non-prospect
				CaCallGroup::TOPIC_TINNITUS => true
			];
			$topicChecked = false;
			$isProspect = false;
			$wantsHearingTestOnly = false;
			foreach ($topics as $topic => $prospectTopic) {
				if (!empty($caCallGroup->$topic)) {
					$topicChecked = true;
					if ($prospectTopic) {
						$isProspect = true;
					}
					if ($topic == CaCallGroup::TOPIC_WANTS_APPT) {
						$wantsHearingTestOnly = true;
					} else {
						$wantsHearingTestOnly = false;
					}
				}
			}
			if (!$topicChecked) {
				// No topics were selected. Default to 'wants appt'.
				$topicWantsAppt = CaCallGroup::TOPIC_WANTS_APPT;
				$caCallGroup->$topicWantsAppt = true;
				$isProspect = true;
				$wantsHearingTestOnly = true;
			}
			$caCallGroup->prospect = $isProspect ? CaCallGroup::PROSPECT_YES : CaCallGroup::PROSPECT_NO;
			$caCallGroup->status = CaCallGroup::STATUS_FOLLOWUP_APPT_REQUEST_FORM;
			$caCallGroup->wants_hearing_test = $wantsHearingTestOnly;
			$caCallGroup->scheduled_call_date = getCurrentEasternTime();
			$caCall->ca_call_group = $caCallGroup;
			if ($return = $this->CaCalls->save($caCall, ['validate' => true, 'deep' => true])) {
				$data['success'] = true;
			} else {
				$data['success'] = false;
				// TODO: parseValidationErrors() needed
				//$data['errorMessage'] = "Your appointment request was not submitted. Please try again.<br><br>".$this->CaCall->parseValidationErrors();
			}
		}
		$this->set('data', $data);
		$this->viewBuilder()->setOption('serialize', 'data');
	}
}
