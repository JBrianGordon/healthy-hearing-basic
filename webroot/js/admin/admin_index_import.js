import '../common/common';
import './search_toggle';

$('body').on('click', '.js-unlink', function() {
	if (!confirm('Are you sure you want to unlink this Location?')) {
		return false;
	}
});