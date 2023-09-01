<div id="footerContainer">
  <footer id="cookieFooter" class="row noprint">
  	<div class="container">
  		<div class="row">
  			<p class="text-small text-center">This website stores cookies on your computer to customize your website experience and to count your visit. We don’t track you across other websites. You can opt out of our count by choosing "use only necessary cookies". By using our site, you signal that you agree with our <a href="/privacy-policy">Privacy Policy</a>.</p>
  			<div class="tac">
  				<button id="acceptAll" class="btn btn-light mb10 btn-cookie">Accept policy</button>
  				<button id="rejectAll" class="btn btn-light mb10 btn-cookie">Use only necessary cookies</button>
  			</div>
  		</div>
  	</div>
  </footer>
</div>
<script>
  function hideBanner() {
    document.getElementById('cookieFooter').style.display = 'none';
  }

  if(localStorage.getItem('consentMode') === null) {
    
    document.getElementById('acceptAll').addEventListener('click', function() {
      setConsent({
	    functionality: true,
	    security: true,
        analytics: true,
        marketing: true,
        personalization: true
      });
      hideBanner();
    });
    document.getElementById('rejectAll').addEventListener('click', function() {
      setConsent({
	    functionality: false,
	    security: false,
        analytics: false,
        marketing: false,
        personalization: false
      });
      hideBanner();
    });
  } else {
	  hideBanner();
  }
  
  function setConsent(consent) {
    const consentMode = {
		'functionality_storage': consent.functionality ? 'granted' : 'denied',
		'security_storage': consent.security ? 'granted' : 'denied',
		'ad_storage': consent.marketing ? 'granted' : 'denied',
		'analytics_storage': consent.analytics ? 'granted' : 'denied',
		'personalization_storage': consent.personalization ? 'granted' : 'denied',
    };
    gtag('consent', 'update', consent);  
    localStorage.setItem('consentMode', JSON.stringify(consentMode));
  }
</script>