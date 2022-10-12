import '../common/common';
import '../../../node_modules/jquery-ui/ui/widgets/autocomplete';
import './nav_tabs';

$('#ReviewLocationSearch').autocomplete({
	source: "/reviewautocomplete",
	minLength: "2",
	select: function(event, ui){
		if(ui.item.id){
			$('#ReviewLocationId').val(ui.item.id);
		}
	}
});
$('#ClearClinic').on('click', function(){
	$('#ReviewLocationId').val('');
	return false;
});