import $ from 'jquery';
import '../common-vite/common';
import 'jquery-ui/ui/widgets/datepicker';

$('.datepicker').datepicker({
	dateFormat: 'yy-mm-dd'
});
