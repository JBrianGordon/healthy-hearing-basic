import './common';
import '../../../node_modules/jquery-ui/ui/widgets/datepicker';
import '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap/dropdown';
import '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap/tooltip';
import '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap/popover';
import '../admin/nav_tabs';

$('[data-toggle=\"popover\"]').popover();
$('.datepicker').datepicker();
// Click the default tab
if ($('a[href=\"#callConcierge\"]').data('default') === true) {
	$('a[href=\"#callConcierge\"]').tab('show');
} else {
	$('a[href=\"#callTracking\"]').tab('show');
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    sessionStorage.setItem('clinicReportActiveTab', $(e.target).attr('href'));
});

var clinicReportActiveTab = sessionStorage.getItem('clinicReportActiveTab');
if (clinicReportActiveTab) {
    $('.nav-tabs a[href="' + clinicReportActiveTab + '"]').tab('show');
}