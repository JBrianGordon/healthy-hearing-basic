<?php
use Cake\Core\Configure;
$logoBorder = Configure::read('logo_border');
$logo = Configure::read('logo');
$clinicPageUser = (isset($clinicPage) && !empty($user));

$isCqPremier = $listing_type = $featureContentLibrary = $showLibraryLink = false;
if (!empty($user['location_id'])) {
	$this->Clinic->setLocation($user['location_id']);
	$isCqPremier = $this->Clinic->get('is_cq_premier');
	$listing_type = $this->Clinic->get('listing_type');
	$featureContentLibrary = $this->Clinic->get('feature_content_library');
}

$showLibraryLink = ($isCqPremier && $listing_type === 'Premier') || $featureContentLibrary || $isAdmin;
if (!Configure::read('showSocialMediaContentLibrary')) {
	$showLibraryLink = false;
}
?>
<nav class="navbar navbar-default navbar-fixed-top has-shadow sticky-top navbar-expand-lg navbar-light">
	<div class="container">
		<div class="row">
			<div class="col-12" id="navParent">
				<div class="navbar-header">
					<a href="/" class="navbar-logo <?= Configure::read('country'); ?>" <?= $logoBorder ?>>
						<img src="<?= $logo ?>" alt="<?= $siteName ?>" width="198" height="40" />
					</a>
				</div>
				<div class="nav navbar-right" id="navContainer">
					<div class="navbar-side-nav-trigger" data-hh-side-nav-trigger>
						<div class="navbar-side-nav-trigger" data-hh-side-nav-trigger>
							<a href="" id="desktopSideNavTrigger"><span class="hh-icon-menu"></span>Side Menu</a>
						</div>
					</div>
					<?php if (Configure::read('showReports') && ($isAdmin || $isItAdmin || $isAgent || $isCallSupervisor || $isWriter || $isCsa)): ?>
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
					<?php endif; ?>
					<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
						<li data-hh-mega-nav-trigger="find-a-professional"<?= $clinicPageUser ? 'class="hidden"' : '' ?>>
							<a id="fap-tab" class="nav-link text-uppercase" href="/hearing-aids">
								<span class="hidden-md hidden-lg">Clinics</span>
								<span class="hidden-sm">Find a clinic</span>
							</a>
						</li>
						<li data-hh-mega-nav-trigger="hearing-loss-help"<?= $clinicPageUser ? 'class="hidden"' : '' ?>>
							<?= $this->AuthLink->link('<span class="hidden-md hidden-lg">Hearing Loss</span><span class="hidden-sm">Hearing Loss Help</span>', '/help', ['escape' => false, 'class'=>'nav-link text-uppercase']); ?>
						</li>
						<li data-hh-mega-nav-trigger="hearing-aid-help"<?= $clinicPageUser ? 'class="hidden"' : '' ?>>
							<?= $this->AuthLink->link('<span class="hidden-md hidden-lg">Hearing Aids</span><span class="hidden-sm">Hearing Aids Help</span>', '/help', ['escape' => false, 'class'=>'nav-link text-uppercase']); ?>
						</li>
						<?php if (Configure::read('showReports') && !$clinicPageUser): ?>
							<li>
								<?= $this->AuthLink->link('News', '/report', ['escape' => false, 'class'=>'nav-link text-uppercase']); ?>
							</li>
						<?php endif; ?>
						<?php if(isset($clinicPage) && empty($user)) : ?>
							<li class="login btn btn-secondary bi bi-box-arrow-in-right mt15">
								<a href="/login"> Login</a>
							</li>
						<?php elseif($clinicPageUser): ?>
							<li class="dropdown clinic-link">
								<a href="#" id="myAccountDropdown" class="dropdown-toggle bi bi-person-fill" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> My Account <span class="caret"></span></a>
								<ul class="dropdown-menu" aria-labelledby="myAccountDropdown">
									<li><?= $this->Html->link(' My Profile', '/clinic/locations/edit', ['escape' => false, 'class' => 'bi bi-globe2']); ?></li>
									<li><?= $this->Html->link(' Reporting', '/clinic/ca-call-groups/report', ['escape' => false, 'class' => 'bi bi-list-task']); ?></li>
									<li><?= $this->Html->link(' Reviews', '/clinic/reviews', ['escape' => false, 'class' => 'bi bi-star-fill']); ?></li>
									<?php if ($showLibraryLink): ?>
										<li><?= $this->Html->link(' Library', '/clinic/library', ['escape' => false, 'class' => 'bi bi-book-fill']); ?></li>
									<?php endif; ?>
									<li><?= $this->Html->link(' Help', '/clinic/pages/faq', ['escape' => false, 'class' => 'bi bi-question-circle-fill']); ?></li>
									<hr class="mt10 mb10">
									<li><?= $this->Html->link(' My Account', '/clinic/users/account', ['escape' => false, 'class' => 'bi bi-person-fill']); ?></li>
									<li><?= $this->Html->link(' Logout', '/logout', ['escape' => false, 'class' => 'bi bi-power']); ?></li>
								</ul>
							</li>
						<?php endif; ?>
						<?= $this->element('header/admin_panel_link') ?>
						<?php if ($isClinic): ?>
							<?= $this->element('header/clinic_panel_link') ?>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<?php if (!$isMobileDevice): ?>
		<div data-hh-mega-nav="find-a-professional">
			<div class="row mega-nav-inner">
				<div class="col-md-6 col-sm-6">
					<?php if (!empty($clinicsNearMe)): ?>
						<?= $this->element($this->Clinic->nearMe($clinicsNearMe, 'nav_bar')); ?>
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
					<div data-hh-map></div>
					<div class="tac mt20 col-md-10 col-md-offset-1">
						<?= $this->element('locations/search', [
							'label' => 'Enter city, '.$stateLabel.' or '.$zipShort,
							'form_id' => 'fapdropdownform',
							'auto_id' => 'fapdropdownsearchid',
							'search_id' => 'fapdropdownSearch',
							'btnId' => 'fapdropdownSearchBtn',
							'inline' => true
						]); ?>
					</div>
				</div>
			</div>
		</div>

		<div data-hh-mega-nav="hearing-loss-help">
			<div class="row mega-nav-inner">
				<div class="<?= (Configure::read('isMetric')) ? 'col-md-12 col-sm-12' : 'col-md-4 col-sm-4'; ?>">
					<?php $hearing_loss = $this->Wiki->findNavBySlug('hearing-loss'); ?>
					<h4><?= $this->Html->link('Hearing loss', $hearing_loss['parent']->hh_url, ['class' => 'text-link']); ?></h4>
					<ul class="no-bullets">
						<?php foreach ($hearing_loss['children'] as $wiki): ?>
							<li<?php if(Configure::read('isMetric')) { echo ' class="col-md-4 col-sm-4"'; }?>><?= $this->Html->link($wiki->name, $wiki->hh_url, ['class' => 'text-link']); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php if (Configure::read('showTinnitus')): ?>
					<div class="col-md-4 col-sm-4">
						<?php $wikis = $this->Wiki->findNavBySlug('tinnitus'); ?>
						<h4><?= $this->Html->link('Tinnitus', $wikis['parent']->hh_url, ['class' => 'text-link']); ?></h4>
						<ul class="no-bullets">
							<?php foreach ($wikis['children'] as $wiki): ?>
								<li><?= $this->Html->link($wiki->name, $wiki->hh_url, ['class' => 'text-link']); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				<?php if (Configure::read('showAssistiveListening')): ?>
					<div class="col-md-4 col-sm-4">
						<?php $wikis = $this->Wiki->findNavBySlug('assistive-listening-devices'); ?>
						<h4><?= $this->Html->link('Assistive listening devices', $wikis['parent']->hh_url, ['class' => 'text-link']); ?></h4>
						<ul class="no-bullets">
							<?php foreach($wikis['children'] as $wiki): ?>
								<li><?= $this->Html->link($wiki->name, $wiki->hh_url, ['class' => 'text-link']); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
		</div>
		
		<div data-hh-mega-nav="hearing-aid-help">
			<?php
			$hearing_aids = $this->Wiki->findNavBySlug('hearing-aids');
			$wikis = $this->App->splitBy($hearing_aids['children'], 3);
			?>
			<div class="row mega-nav-inner">
				<div class="col-md-12 col-sm-12">
					<h4><?= $this->Html->link('Hearing aids', $hearing_aids['parent']->hh_url, ['class' => 'text-link']); ?></h4>
					<?php if (!empty($wikis[0])): ?>
						<ul class="no-bullets col-md-4 col-sm-4">
							<?php foreach($wikis[0] as $wiki): ?>
								<li><?= $this->Html->link($wiki['name'], $wiki['hh_url'], ['class' => 'text-link']); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<?php if (!empty($wikis[1])): ?>
						<ul class="no-bullets col-md-4 col-sm-4">
							<?php foreach($wikis[1] as $wiki): ?>
								<li><?= $this->Html->link($wiki['name'], $wiki['hh_url'], ['class' => 'text-link']); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<?php if (!empty($wikis[2])): ?>
						<ul class="no-bullets col-md-4 col-sm-4">
							<?php foreach($wikis[2] as $key => $wiki): ?>
								<li><?= $this->Html->link($wiki['name'], $wiki['hh_url'], ['class' => 'text-link']); ?></li>
							<?php endforeach; ?>
							<?php if (Configure::read('country') == 'US'): ?>
								<li><?= $this->Html->link('Hearing aid manufacturers', ['prefix' => false, 'plugin' => false, 'controller' => 'corps', 'action' => 'index'], ['class' => 'text-link']); ?></li>
							<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</nav>