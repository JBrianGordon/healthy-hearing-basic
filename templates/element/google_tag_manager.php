<?php use Cake\Core\Configure; ?>
<!-- Google Tag Manager script -->
<script>
(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?= Configure::read('gtmId'); ?>');
</script>
<noscript>
	<iframe src="https://www.googletagmanager.com/ns.html?id=<?=Configure::read('gtmId') ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- Tag Manager Consent -->
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    
    if(localStorage.getItem('consentMode') != null){
        gtag('consent', 'default', JSON.parse(localStorage.getItem('consentMode')));
    }
</script>
<!-- Google Tag Manager functions -->
<script>
//List of data pushes pushed in this request
dataLayer.dataPushes = [];
dataLayer.hhDebugging = <?= var_export(Configure::read('debug'), true) ?>;

//Abstract push of data to push, creates log for us.
dataLayer.hhPush = function(dataToPush) {
	if (this.hhDebugging) {
		myLog(dataToPush);
	}
	this.dataPushes.push(dataToPush); //keeps track of pushes
	this.push(dataToPush); //Actual push
}

//abstract datafunction to use much easier than the given function
dataLayer.hhTrackEvent = function(category, action, label, value, nonInt) {
	//Setting Defaults
	label = label || document.location.pathname;
	value = value || null;
	nonInt = nonInt || null;

	var dataToPush = {
		"event" : "fire-ga-event",
		"eventCat" : category,
		"eventAction" : action,
		"eventLabel" : label
	};
	if (value) {
		dataToPush.eventValue = value;
	}
	if (nonInt) {
		dataToPush.eventNonInt = 'true';
	}
	this.hhPush(dataToPush);
}
</script>
