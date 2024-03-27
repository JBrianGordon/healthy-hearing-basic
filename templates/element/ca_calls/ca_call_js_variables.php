<?php
use App\Model\Entity\CaCall;
use App\Model\Entity\CaCallGroup;
use App\Model\Entity\Location;
?>

<script type="text/javascript">
	// Global javascript variables for ca_call_edit.js
	window.PROSPECT_YES = <?php echo json_encode(CaCallGroup::PROSPECT_YES); ?>;
	window.PROSPECT_NO = <?php echo json_encode(CaCallGroup::PROSPECT_NO); ?>;
	window.PROSPECT_UNKNOWN = <?php echo json_encode(CaCallGroup::PROSPECT_UNKNOWN); ?>;
	window.PROSPECT_DISCONNECTED = <?php echo json_encode(CaCallGroup::PROSPECT_DISCONNECTED); ?>;
	window.prospectTopics = <?php echo json_encode(CaCallGroup::$prospectTopics); ?>;
	window.SCORE_APPT_SET = <?php echo json_encode(CaCallGroup::SCORE_APPT_SET); ?>;
	window.SCORE_TENTATIVE_APPT = <?php echo json_encode(CaCallGroup::SCORE_TENTATIVE_APPT); ?>;
	window.SCORE_APPT_SET_DIRECT = <?php echo json_encode(CaCallGroup::SCORE_APPT_SET_DIRECT); ?>;
	window.SCORE_NOT_REACHED = <?php echo json_encode(CaCallGroup::SCORE_NOT_REACHED); ?>;
	window.SCORE_MISSED_OPPORTUNITY = <?php echo json_encode(CaCallGroup::SCORE_MISSED_OPPORTUNITY); ?>;
	window.SCORE_DISCONNECTED = <?php echo json_encode(CaCallGroup::SCORE_DISCONNECTED); ?>;
	window.callTypes = <?php echo json_encode(CaCall::$callTypes); ?>;
	window.CALL_TYPE_INBOUND = <?php echo json_encode(CaCall::CALL_TYPE_INBOUND); ?>;
	window.CALL_TYPE_INBOUND_QUICK_PICK = <?php echo json_encode(CaCall::CALL_TYPE_INBOUND_QUICK_PICK); ?>;
	window.CALL_TYPE_VM_CALLBACK_CLINIC = <?php echo json_encode(CaCall::CALL_TYPE_VM_CALLBACK_CLINIC); ?>;
	window.CALL_TYPE_VM_CALLBACK_CONSUMER = <?php echo json_encode(CaCall::CALL_TYPE_VM_CALLBACK_CONSUMER); ?>;
	window.CALL_TYPE_VM_CALLBACK_INVALID = <?php echo json_encode(CaCall::CALL_TYPE_VM_CALLBACK_INVALID); ?>;
	window.CALL_TYPE_FOLLOWUP_APPT_REQUEST = <?php echo json_encode(CaCall::CALL_TYPE_FOLLOWUP_APPT_REQUEST); ?>;
	window.CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT = <?php echo json_encode(CaCall::CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT); ?>;
	window.CALL_TYPE_FOLLOWUP_APPT = <?php echo json_encode(CaCall::CALL_TYPE_FOLLOWUP_APPT); ?>;
	window.CALL_TYPE_FOLLOWUP_NO_ANSWER = <?php echo json_encode(CaCall::CALL_TYPE_FOLLOWUP_NO_ANSWER); ?>;
	window.CALL_TYPE_FOLLOWUP_TENTATIVE_APPT = <?php echo json_encode(CaCall::CALL_TYPE_FOLLOWUP_TENTATIVE_APPT); ?>;
	window.statuses = <?php echo json_encode(CaCallGroup::$statuses); ?>;
	window.STATUS_VM_NEEDS_CALLBACK = <?php echo json_encode(CaCallGroup::STATUS_VM_NEEDS_CALLBACK); ?>;
	window.STATUS_VM_CALLBACK_ATTEMPTED = <?php echo json_encode(CaCallGroup::STATUS_VM_CALLBACK_ATTEMPTED); ?>;
	window.STATUS_VM_CALLBACK_TOO_MANY_ATTEMPTS = <?php echo json_encode(CaCallGroup::STATUS_VM_CALLBACK_TOO_MANY_ATTEMPTS); ?>;
	window.STATUS_WRONG_NUMBER = <?php echo json_encode(CaCallGroup::STATUS_WRONG_NUMBER); ?>;
	window.STATUS_INCOMPLETE = <?php echo json_encode(CaCallGroup::STATUS_INCOMPLETE); ?>;
	window.STATUS_NON_PROSPECT = <?php echo json_encode(CaCallGroup::STATUS_NON_PROSPECT); ?>;
	window.STATUS_FOLLOWUP_SET_APPT = <?php echo json_encode(CaCallGroup::STATUS_FOLLOWUP_SET_APPT); ?>;
	window.STATUS_FOLLOWUP_APPT_REQUEST_FORM = <?php echo json_encode(CaCallGroup::STATUS_FOLLOWUP_APPT_REQUEST_FORM); ?>;
	window.STATUS_FOLLOWUP_NO_ANSWER = <?php echo json_encode(CaCallGroup::STATUS_FOLLOWUP_NO_ANSWER); ?>;
	window.STATUS_APPT_SET = <?php echo json_encode(CaCallGroup::STATUS_APPT_SET); ?>;
	window.STATUS_TENTATIVE_APPT = <?php echo json_encode(CaCallGroup::STATUS_TENTATIVE_APPT); ?>;
	window.STATUS_MISSED_OPPORTUNITY = <?php echo json_encode(CaCallGroup::STATUS_MISSED_OPPORTUNITY); ?>;
	window.STATUS_MO_NO_ANSWER = <?php echo json_encode(CaCallGroup::STATUS_MO_NO_ANSWER); ?>;
	window.STATUS_NEW = <?php echo json_encode(CaCallGroup::STATUS_NEW); ?>;
	window.STATUS_QUICK_PICK_REFUSED_NAME_ADDRESS = <?php echo json_encode(CaCallGroup::STATUS_QUICK_PICK_REFUSED_NAME_ADDRESS); ?>;
	window.STATUS_QUICK_PICK_CALLER_REFUSED_HELP = <?php echo json_encode(CaCallGroup::STATUS_QUICK_PICK_CALLER_REFUSED_HELP); ?>;
	window.MAX_CLINIC_FOLLOWUP_ATTEMPTS = <?php echo json_encode(CaCallGroup::MAX_CLINIC_FOLLOWUP_ATTEMPTS); ?>;
	window.MAX_PATIENT_FOLLOWUP_ATTEMPTS = <?php echo json_encode(CaCallGroup::MAX_PATIENT_FOLLOWUP_ATTEMPTS); ?>;
	window.MAX_VM_OUTBOUND_ATTEMPTS = <?php echo json_encode(CaCallGroup::MAX_VM_OUTBOUND_ATTEMPTS); ?>;
	window.easternTimezone = <?php echo json_encode(getEasternTimezone()); ?>;
	window.DIRECT_BOOK_NONE = <?php echo json_encode(Location::DIRECT_BOOK_NONE); ?>;
	window.DIRECT_BOOK_DM = <?php echo json_encode(Location::DIRECT_BOOK_DM); ?>;
	window.DIRECT_BOOK_BLUEPRINT = <?php echo json_encode(Location::DIRECT_BOOK_BLUEPRINT); ?>;
	window.DIRECT_BOOK_EARQ = <?php echo json_encode(Location::DIRECT_BOOK_EARQ); ?>;
</script>
