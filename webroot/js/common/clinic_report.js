import './common';
import 'jquery-ui/ui/widgets/datepicker';
import '../admin/nav_tabs';

$('.datepicker').datepicker();

// Click the default tab
const callConciergeTab = document.querySelector('a[href="#callConcierge"]');
const callTrackingTab = document.querySelector('a[href="#callTracking"]');

if (callConciergeTab && callConciergeTab.dataset.default === "true") {
  callConciergeTab.click();
} else if (callTrackingTab) {
  callTrackingTab.click();
}

// Handle tab selection
const tabElements = document.querySelectorAll('a[data-toggle="tab"]');
tabElements.forEach(element => {
  element.addEventListener('shown.bs.tab', e => {
    sessionStorage.setItem('clinicReportActiveTab', e.target.getAttribute('href'));
  });
});

// Show the previously active tab
const clinicReportActiveTab = sessionStorage.getItem('clinicReportActiveTab');
if (clinicReportActiveTab) {
  const activeTab = document.querySelector(`.nav-tabs a[href="${clinicReportActiveTab}"]`);
  if (activeTab) {
    activeTab.click();
  }
}
