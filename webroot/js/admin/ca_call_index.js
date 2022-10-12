import '../common/common';
import './search_toggle';

$(document).ready(function() {
console.debug('ready');
	//Delete Button
	$('body').on('click', '#deleteBtn', function() {
		// The "delete" button was clicked. Display the confirmation modal.
		var callId = $(this).data("id");
		var callGroupId = $(this).data("group-id");
		$("span#deleteCallBtn").html("<a href='/admin/ca_calls/delete/"+callId+"' class='btn btn-danger'>Delete Call</a>");
		$("span#deleteCallGroupBtn").html("<a href='/admin/ca_call_groups/delete/"+callGroupId+"' class='btn btn-danger'>Delete Call Group</a>");
		$("#delete-modal").modal("show");
	});
});
