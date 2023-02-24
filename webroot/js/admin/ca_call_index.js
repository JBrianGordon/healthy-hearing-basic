import '../common/common';
import './search_toggle';

let exportBtnClick = () => {
    let count = document.querySelector('#hiddenCount'),
		exportUrl = document.querySelector('#hiddenExport');
    if (count.value < 100000) {
        // Small file. Download immediately.
        if (confirm(`Downloading export file with ${count.value} entries. This may take up to 30 seconds. Stay on this page until download is complete.`)) {
            window.location.replace(exportUrl.value);
        }
    } else {
        // Large file
        // TODO - Large files take over 30 seconds and page times out. Send to queue when queue is working.
        alert("Export is too large. Please narrow your results to 100,000 or less.");
    }
}
document.getElementById("exportBtn").addEventListener("click", exportBtnClick);

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
