
<?php
use Cake\Core\Configure;
	
$isadmin = isset($isadmin) ? $isadmin : false;
$isagent = isset($isagent) ? $isagent : false;
$iscallsupervisor = isset($iscallsupervisor) ? $iscallsupervisor : false;
$iscsa = isset($iscsa) ? $iscsa : false;
$iswriter = isset($iswriter) ? $iswriter : false;
$logoBorder = Configure::read('logo_border');
$logo = Configure::read('logo');
?>
<nav class="navbar navbar-default navbar-fixed-top has-shadow sticky-top navbar-expand-lg navbar-light bg-light">
	<div class="container p0">
		<div class="row">
			<div class="col-xs-12" id="navParent">
				<div class="navbar-header">
					<a href="/" class="navbar-logo <?php echo Configure::read('country'); ?>" <?php echo $logoBorder; ?>>
						<img src="<?= $logo; ?>" alt="<?php echo $siteName; ?>" width="198" height="40" />
					</a>
				</div>
				<div class="nav navbar-right" id="navContainer">
					<div class="navbar-side-nav-trigger" data-hh-side-nav-trigger>
						<div class="navbar-side-nav-trigger" data-hh-side-nav-trigger>
							<a href="" id="desktopSideNavTrigger"><span class="hh-icon-menu"></span>Side Menu</a>
						</div>
					</div>
					<!-- *** TODO: uncomment when $isadmin and $isitadmin are set -->
					<?php //if (Configure::read('showReports') && ($isadmin || $isitadmin || $isagent || $iscallsupervisor || $iswriter || $iscsa)): ?>
						<div class="navbar-search" data-hh-search>
							<a href="" class="search-link" id="openSearch" tabindex="-1"><span class="hh-icon-search"></span>Open Side Menu</a>
							<div class="search-wrapper" id="searchWrapper">
							  <a href="#" class="close-link" id="closeSearch" tabindex="-1"><span class="hh-icon-cross"></span>Close Side Menu</a>
							  <form id="MegaSearch" action="/search" method="POST">
								<label for="ContentSearch">Search the site</label>
							  	<input type="text" id="ContentSearch" class="search-input" name="data[Content][search]" placeholder="Search the site" tabindex="-1">
							  	<input type="hidden" name="data[Content][search_id]" value="" id="ContentSearchId">
							  </form>
							</div>
						</div>
					<?php //endif; ?>
					<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
						<li data-hh-mega-nav-trigger="find-a-professional">
							<a id="fap-tab" class="nav-link text-uppercase" href="/hearing-aids">
								<span class="hidden-md hidden-lg">Clinics</span>
								<span class="hidden-sm">Find a clinic</span>
							</a>
						</li>
						<li data-hh-mega-nav-trigger="hearing-loss-help">
							<?= $this->AuthLink->link('<span class="hidden-md hidden-lg">Hearing Loss</span><span class="hidden-sm">Hearing Loss Help</span>', '/help', ['escape' => false, 'class'=>'nav-link text-uppercase']); ?>
						</li>
						<li data-hh-mega-nav-trigger="hearing-aid-help">
							<?= $this->AuthLink->link('<span class="hidden-md hidden-lg">Hearing Aids</span><span class="hidden-sm">Hearing Aids Help</span>', '/help', ['escape' => false, 'class'=>'nav-link text-uppercase']); ?>
						</li>
						<?php if (Configure::read('showReports')): ?>
							<li>
								<?= $this->AuthLink->link('News', '/report', ['escape' => false, 'class'=>'nav-link text-uppercase']); ?>
							</li>
						<?php endif; ?>
						<!-- *** TODO: uncomment when $isadmin and $isitadmin are set -->
						<?php //if ($isadmin || $isitadmin || $isagent || $iscallsupervisor || $iswriter || $iscsa): ?>
							<li>
								<?= $this->AuthLink->link('<i class="bi bi-gear-fill"></i>', '/admin', ['escape' => false, 'class'=>'nav-link']); ?>
							</li>
						<?php //endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<?php if (empty($is_mobile)): ?>
		<div data-hh-mega-nav="find-a-professional">
			<div class="row mega-nav-inner">
				<div class="col-md-6 col-sm-6">
					<?php if (!empty($clinicsNearMe)): ?>
						<?php echo $this->element($this->Clinic->nearMe($clinicsNearMe, 'nav_bar')); ?>
					<?php endif; ?>
					<hr style="border-top: 4px ridge #78afc9;">
					<p class="mb5"><strong>Find hearing clinics in my country:</strong></p>
					<?php if(Configure::read('isCallAssistEnabled') == true) : ?>
						<a href="/hearing-aids" class="btn btn-xs nav-flag-GEO-link-click flag-link"><img src="/img/country_flags/US.svg" alt="Flag of the United States"></a>
						<a href="https://www.hearingdirectory.ca/hearing-aids" target="_blank" rel="noopener" class="btn btn-xs nav-flag-GEO-link-click flag-link flag-ca"><img src="/img/country_flags/CA.svg" alt="Flag of Canada"></a>
					<?php else: ?>
						<a href="/hearing-aids" class="btn btn-xs nav-flag-GEO-link-click flag-link flag-ca"><img src="/img/country_flags/CA.svg" alt="Flag of Canada"></a>
						<a href="https://www.healthyhearing.com/hearing-aids" target="_blank" rel="noopener" class="btn btn-xs nav-flag-GEO-link-click flag-link"><img src="/img/country_flags/US.svg" alt="Flag of the United States"></a>
					<?php endif; ?>
				</div>
				<div class="col-md-6 col-sm-6">
					<?php if (Configure::read('country') == 'US'): ?>
						<div data-hh-map></div>
					<?php else: ?>
						<object data="<?php echo Configure::read('map'); ?>" type="image/svg+xml" id="headerMap"></object>
					<?php endif; ?>
					<div class="tac mt20">
						<!-- *** TODO: add search bar when it's built out *** -->
						<?php /*echo $this->element('locations/search', array(
							'label' => 'Enter city, '.$stateLabel.' or '.$zipShort,
							'form_id' => 'fapdropdownform',
							'auto_id' => 'fapdropdownsearchid',
							'search_id' => 'fapdropdownSearch',
							'btnId' => 'fapdropdownSearchBtn',
							'inline' => true
						));*/ ?>
					</div>
				</div>
			</div>
		</div>
		<!-- *** TODO build out this element in it's own file or right here *** -->
		<?php //echo $this->element('nav_wiki_menu', [], ['cache' => ['config' => 'view_short']]); ?>
	<?php endif; ?>
</nav>