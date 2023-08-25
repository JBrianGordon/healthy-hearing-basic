<?php use Cake\Core\Configure; ?>
<footer class="row site-footer noprint">
	<div class="container">
		<div class="row footer-row">
			<div class="col-md-2">
				<ul class="no-bullets">
					<li><a href="/" class="text-link">Home</a></li>
					<li><a href="/about" class="text-link">About us</a></li>
					<li><a href="/contact-us" class="text-link">Contact <?php echo $siteName; ?></a></li>
					<?php if (Configure::read('showFeeds')): ?>
						<li><a href="/feeds" class="text-link">RSS feeds</a></li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="col-md-2">
				<ul class="no-bullets">
					<?php if (Configure::read('showReports')): ?>
						<li><a href="/report" class="text-link">The <?= Configure::read('siteNameAbbr') ?> report</a></li>
					<?php endif; ?>
					<?php if (Configure::read('showHearingTest')): ?>
						<li><a href="/help/online-hearing-test" class="text-link">Online hearing test</a></li>
					<?php endif; ?>
					<li><a href="/terms-of-use" class="text-link">Terms of use</a></li>
					<li><a href="/privacy-policy" class="text-link">Privacy policy</a></li>
					<li><a href="/sitemap" class="text-link">Sitemap</a></li>
				</ul>
			</div>
			<div class="col-md-2">
				<ul class="no-bullets">
					<li><a href="<?= $this->Clinic->nearMeLink() ?>" class="text-link action-link">Find a clinic near me</a></li>
					<li><a href="/help/hearing-loss" class="text-link">Hearing loss help</a></li>
					<li><a href="/help/hearing-aids" class="text-link">Hearing aids help</a></li>
					<?php if (Configure::read('showManufacturers')): ?>
						<li><a href="/hearing-aid-manufacturers" class="text-link">Hearing aid manufacturers</a></li>
					<?php endif; ?>
					<li><a href="/clinic" class="text-link">For clinics</a></li>
				</ul>
			</div>
			<div class="col-md-6">
				<?php if (Configure::read('showNewsletter')): ?>
					<p class="text-primary text-small">
					<strong>Get the best of <?php echo $siteName; ?> delivered to your inbox!</strong>
					</p>
					<p>
					<?php
					echo $this->Html->link('Sign up for our newsletter', '/newsletter', ['class' => 'btn btn-primary btn-sm']);
					?>
					</p>
				<?php endif; ?>
				<div class="soc-icons">
					<?php if(Configure::read('sameAsSocialLinks.facebook')): ?>
						<a href="<?= Configure::read('sameAsSocialLinks.facebook') ?>" class="text-light" target="_blank" rel="noopener"><span class="hh-icon-circle-facebook"></span><?= Configure::read('siteNameAbbr') ?> Facebook page</a>
					<?php endif; ?>
					<?php if(Configure::read('sameAsSocialLinks.twitter')): ?>
						<a href="<?= Configure::read('sameAsSocialLinks.twitter') ?>" class="text-light" target="_blank" rel="noopener"><?= Configure::read('siteNameAbbr') ?> Twitter page<span class="hh-icon-circle-twitter"></span></a>
					<?php endif; ?>
					<?php if(Configure::read('sameAsSocialLinks.youtube')): ?>
						<a href="<?= Configure::read('sameAsSocialLinks.youtube') ?>" class="text-light" target="_blank" rel="noopener"><span class="hh-icon-circle-youtube"></span><?= Configure::read('siteNameAbbr') ?> YouTube page</a>
					<?php endif; ?>
				</div>

				<?php if(Configure::read('isCallAssistEnabled')): ?>
					<!-- TrustBox widget - Micro Review Count -->
					<div class="trustpilot-widget mt10" data-locale="en-US" data-template-id="5419b6a8b0d04a076446a9ad" data-businessunit-id="5ea6da5ea36b600001b4ee2c" data-style-height="24px" data-style-width="100%" data-theme="light" data-stars="1,2,3,4,5" data-no-reviews="hide" data-scroll-to-list="true" data-allow-robots="true" data-min-review-count="10">
					<a href="https://www.trustpilot.com/review/healthyhearing.com" target="_blank" rel="noopener">Trustpilot</a>
					</div>
					<!-- End TrustBox widget -->
				<?php endif; ?>
				
			</div>
		</div>
		
		<div class="row">
			<!-- In Partnership With -->
			<div class="<?php if (Configure::read('country') == 'CA') {echo 'ca-';} ?>partner-block col-md-6">
				<p class="text-primary text-small">
					<em>In partnership <br class="hidden-xs hidden-sm">with</em>            
					<?php if (Configure::read('country') == 'US'): ?>
						<a href="https://www.oticon.com/?utm_medium=banner&utm_source=HealthyHearingFooter&utm_campaign=Oticonlogo&utm_content=146750_oticonlogo" target="_blank" rel="noopener">
							<img id="oticon-logo-footer" loading="lazy" class="oticon-logo" src="/img/Oticon_Logo_LCT_250.png" alt="In partnership with Oticon" width="125" />
						</a>
					<?php elseif (Configure::read('country') == 'CA'): ?>
						<a style="margin-left: 10px;" href="https://www.oticon.ca/hearing-aid-users" target="_blank" rel="noopener">
							<img loading="lazy" class="oticon-logo" src="/img/Oticon_Logo_LCT_250.png" alt="Oticon Canada" width="125px" />
						</a>
					<?php endif; ?>
				</p>
			</div>

			<?php if (Configure::read('country') == 'US'): ?>
				<!-- Digital Health Awards -->
				<div class="dha-block col-md-6">
					<div class="mobile-row">
						<img loading="lazy" style="margin: 5px 0 0 10px;" src="/img/dha_winner_logo_f2017.jpg" alt="Digital Health Award winner for Fall 2017" border="0" width="80" height="80" style="width:auto;height:auto" />
						<img loading="lazy" style="margin: 5px 0 0 10px;" src="/img/dha_winner_logo_f2018.jpg" alt="Digital Health Award winner for Fall 2018" border="0" width="80" height="80" style="width:auto;height:auto" />
					</div>
					<div class="mobile-row">
						<img loading="lazy" style="margin: 5px 0 0 10px;" src="/img/dha_winner_logo_f2019.jpg" alt="Digital Health Award winner for Fall 2019" border="0" width="80" height="80" />
						<img loading="lazy" style="margin: 5px 0 0 10px;" src="/img/dha_winner_logo_f2020.jpg" alt="Digital Health Award winner for Fall 2020" border="0" width="80" height="80" />
					</div>
					<div class="mobile-row">
						<a href="/about">
							<img loading="lazy" style="margin: 5px 0 0 10px;" src="/img/dha_winner_logo_f2021.jpg" alt="Digital Health Award winner for Fall 2021" border="0" width="80" height="80" />
						</a>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</footer>
<footer class="row site-colophon noprint">
	<div class="col-md-12 text-center text-small">
		<strong>&copy; Copyright <?php echo date('Y'); ?>. All Rights Reserved.</strong> 
		<?= Configure::read('siteUrl') ?>HealthyHearing.com does not provide medical advice, diagnosis or treatment.
	</div>
</footer>

<?php if(Configure::read('isCallAssistEnabled')): ?>
	<!-- TrustBox script -->
		<script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
	<!-- End TrustBox script -->
<?php endif; ?>

<script type="application/ld+json">
{
	"@context" : "https://schema.org",
	"@type" : "Organization",
	"name" : "<?= Configure::read('siteName') ?>",
	"url" : "https://www.<?= Configure::read('siteUrl') ?>",
	"logo": "https://www.<?= Configure::read('siteUrl') . Configure::read('logo') ?>"
	<?php if (Configure::read('country') == 'US'): ?>
	,
	"sameAs" : [
		"https://www.facebook.com/healthyhearing",
		"https://twitter.com/HearingAids",
		"https://www.youtube.com/user/HealthyHearing",
		"https://www.linkedin.com/company/9426778"
	]
	<?php endif; ?>
}
</script>