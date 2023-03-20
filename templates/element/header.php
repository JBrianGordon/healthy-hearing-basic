
<?php
use Cake\Core\Configure;
	
$isadmin = isset($isadmin) ? $isadmin : false;
$isagent = isset($isagent) ? $isagent : false;
$iscallsupervisor = isset($iscallsupervisor) ? $iscallsupervisor : false;
$iscsa = isset($iscsa) ? $iscsa : false;
$iswriter = isset($iswriter) ? $iswriter : false;
$logoBorder = Configure::read('logo_border');
$logo = Configure::read('logo');
//$wikiModel = ClassRegistry::init('Wiki');
?>
<nav class="navbar navbar-default navbar-fixed-top has-shadow sticky-top navbar-expand-lg navbar-light bg-light">
	<div class="container">
		<div class="row">
			<div class="col-xs-12" id="navParent">
				<div class="navbar-header">
					<a href="/" class="navbar-logo <?= Configure::read('country'); ?>" <?= $logoBorder ?>>
						<img src="<?= $logo ?>" alt="<?= $siteName ?>" width="198" height="40" />
					</a>
				</div>
				<div class="nav navbar-right" id="navContainer">
					<?php if (!empty($user)): ?>
						<div class="navbar-side-nav-trigger" data-hh-side-nav-trigger="">
							<div class="navbar-side-nav-trigger" data-hh-side-nav-trigger="">
								<a href="" id="desktopSideNavTrigger"><span class="hh-icon-menu"></span>Side Menu</a>
							</div>
						</div>
					<?php else: ?>
						<!-- *** TODO: uncomment when $isadmin and $isitadmin are set -->
						<?php //if (Configure::read('showReports') && ($isadmin || $isitadmin || $isagent || $iscallsupervisor || $iswriter || $iscsa)): ?>
							<!--<div class="navbar-search" data-hh-search>
								<a href="" class="search-link" id="openSearch" tabindex="-1"><span class="hh-icon-search"></span>Open Side Menu</a>
								<div class="search-wrapper" id="searchWrapper">
								  <a href="#" class="close-link" id="closeSearch" tabindex="-1"><span class="hh-icon-cross"></span>Close Side Menu</a>
								  <form id="MegaSearch" action="/search" method="POST">
									<label for="ContentSearch">Search the site</label>
								  	<input type="text" id="ContentSearch" class="search-input" name="data[Content][search]" placeholder="Search the site" tabindex="-1">
								  	<input type="hidden" name="data[Content][search_id]" value="" id="ContentSearchId">
								  </form>
								</div>
							</div>-->
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
									<?php echo $this->AuthLink->link('<i class="bi bi-gear-fill"></i>', '/admin', ['escape' => false, 'class'=>'nav-link']); ?>
								</li>
							<?php //endif; ?>
						</ul>
					<?php endif; ?>
					<!-- *** TODO: $user is not currently set, check this logic when it is ***-->
					<?php if (!empty($user)): ?>
					<ul class="nav navbar-nav navbar-right ms-auto mb-2 mb-lg-0">
						
							<li class="dropdown clinic-link">
								<a href="#" class="dropdown-toggle bi bi-person-fill" role="button" id="dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false"> My Account <span class="caret"></span></a>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu">
									<li class=""><?= $this->Html->link(' My Profile', ['controller' => 'clinic', 'action' => '/locations/edit'], ['class' => 'bi bi-globe2', 'escape' => false]) ?></li>
									<li><?= $this->Html->link(' Reporting', ['controller' => 'clinic', 'action'=>'/ca_call_groups/report'], ['class' => 'bi bi-list-task']) ?></li>
									<li><?= $this->Html->link(' Reviews', ['controller' => 'clinic', 'action'=>'reviews'], ['class' => 'bi bi-star-fill']) ?></li>
									<!-- *** TODO: check if $showLibaryLink when variable is set *** -->
									<?php //if ($showLibraryLink): ?>
										<li><?= $this->Html->link(' Library', ['controller' => 'clinic', 'action'=>'library'], ['class' => 'bi bi-book-fill']) ?></li>
									<?php //endif; ?>
									<li><?= $this->Html->link(' Help', ['controller' => 'clinic', 'action'=>'/pages/faq'], ['class' => 'bi bi-question-circle-fill']) ?></li>
									<li><?= $this->Html->link(' Inspired by Ida', ['controller' => 'clinic', 'action'=>'/pages/about-ida'], ['class' => 'bi bi-award-fill']) ?></li>
									<hr class="mt10 mb10">
									<li><?= $this->Html->link(' My Account', ['controller' => 'clinic', 'action'=>'/users/account'], ['class' => 'bi bi-person-fill', 'escape' => false]) ?></li>
									<li><?= $this->Html->link(' Logout', ['prefix' => false, 'action'=>'logout'], ['class' => 'bi bi-power', 'escape' => false]) ?></li>
								</ul>
							</li>
						<?php else: ?>
							<div class="nav navbar-right" id="navContainer">
								<div class="navbar-side-nav-trigger" data-hh-side-nav-trigger>
									<div class="navbar-side-nav-trigger" data-hh-side-nav-trigger>
										<a href="" id="desktopSideNavTrigger"><span class="hh-icon-menu"></span>Side Menu</a>
									</div>
								</div>
								<!-- *** TODO: uncomment when search feature built out *** -->
								<?php //if (Configure::read('showReports') && ($isadmin || $isitadmin || $isagent || $iscallsupervisor || $iswriter || $iscsa)): ?>
									<!--<div class="navbar-search" data-hh-search>
										<a href="" class="search-link" id="openSearch" tabindex="-1"><span class="hh-icon-search"></span>Open Side Menu</a>
										<div class="search-wrapper" id="searchWrapper">
										  <a href="#" class="close-link" id="closeSearch" tabindex="-1"><span class="hh-icon-cross"></span>Close Side Menu</a>
										  <form id="MegaSearch" action="/search" method="POST">
											<label for="ContentSearch">Search the site</label>
										  	<input type="text" id="ContentSearch" class="search-input" name="data[Content][search]" placeholder="Search the site" tabindex="-1">
										  	<input type="hidden" name="data[Content][search_id]" value="" id="ContentSearchId">
										  </form>
										</div>
									</div>-->
								<?php //endif; ?>
								<ul class="nav navbar-nav">
									<?php //if ($isadmin || $isitadmin || $isagent || $iscallsupervisor || $iswriter || $iscsa): ?>
										<!--<li class="bi bi-gear-fill">
											<a href="/admin-panel"></a>
										</li>-->
									<?php //endif; ?>
								</ul>
							</div>
						
						<?php if ($isadmin || $isagent || $iswriter): ?>
							<li><?= $this->Html->link(false, ['prefix' => false, 'action'=>'admin-panel'], ['class' => 'clinic-link bi bi-gear-fill']) ?></a></li>
						<?php endif; ?>
					</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<?php if (empty($is_mobile)): ?>
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
					<?php if (Configure::read('country') == 'US'): ?>
						<div data-hh-map></div>
					<?php else: ?>
						<object data="<?= Configure::read('map'); ?>" type="image/svg+xml" id="headerMap"></object>
					<?php endif; ?>
					<div class="tac mt20">
						<!-- *** TODO: add search bar when it's built out *** -->
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
		<!-- *** TODO: uncomment portions of the below block when the wiki model and content model are further built out *** -->
		<div data-hh-mega-nav="hearing-loss-help">
			<div class="row mega-nav-inner">
				<div class="<?= (Configure::read('isMetric')) ? 'col-md-12 col-sm-12' : 'col-md-4 col-sm-4'; ?>">
					<?php //$hearing_loss = $wikiModel->findNavBySlug('hearing-loss'); ?>
					<h4><?= $this->Html->link('Hearing loss', $hearing_loss['parent']['Wiki']['hh_url'], array('class' => 'text-link')); ?></h4>
					<ul class="no-bullets">
						<?php foreach($hearing_loss['children'] as $wiki): ?>
							<li<?php if(Configure::read('isMetric')) { echo ' class="col-md-4 col-sm-4"'; }?>><?= $this->Html->link($wiki['Wiki']['name'], $wiki['Wiki']['hh_url'], array('class' => 'text-link')); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php if (Configure::read('showTinnitus')): ?>
					<div class="col-md-4 col-sm-4">
						<?php //$wikis = $wikiModel->findNavBySlug('tinnitus'); ?>
						<h4><?= $this->Html->link('Tinnitus', $wikis['parent']['Wiki']['hh_url'], array('class' => 'text-link')); ?></h4>
						<ul class="no-bullets">
							<?php foreach($wikis['children'] as $wiki): ?>
								<li><?= $this->Html->link($wiki['Wiki']['name'], $wiki['Wiki']['hh_url'], array('class' => 'text-link')); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				<?php if (Configure::read('showAssistiveListening')): ?>
					<div class="col-md-4 col-sm-4">
						<?php //$wikis = $wikiModel->findNavBySlug('assistive-listening-devices'); ?>
						<h4><?= $this->Html->link('Assistive listening devices', $wikis['parent']['Wiki']['hh_url'], array('class' => 'text-link')); ?></h4>
						<ul class="no-bullets">
							<?php foreach($wikis['children'] as $wiki): ?>
								<li><?= $this->Html->link($wiki['Wiki']['name'], $wiki['Wiki']['hh_url'], array('class' => 'text-link')); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
		</div>
		
		<div data-hh-mega-nav="hearing-aid-help">
			<?php
			//$hearing_aids = $wikiModel->findNavBySlug('hearing-aids');
			//$wikis = $this->Content->splitBy($hearing_aids['children'], 3);
			?>
			<div class="row mega-nav-inner">
				<div class="col-md-12 col-sm-12">
					<h4><?= $this->Html->link('Hearing aids', $hearing_aids['parent']['Wiki']['hh_url'], array('class' => 'text-link')); ?></h4>
					<?php if (!empty($wikis[0])): ?>
						<ul class="no-bullets col-md-4 col-sm-4">
							<?php foreach($wikis[0] as $wiki): ?>
								<li><?= $this->Html->link($wiki['Wiki']['name'], $wiki['Wiki']['hh_url'], array('class' => 'text-link')); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<?php if (!empty($wikis[1])): ?>
						<ul class="no-bullets col-md-4 col-sm-4">
							<?php foreach($wikis[1] as $wiki): ?>
								<li><?= $this->Html->link($wiki['Wiki']['name'], $wiki['Wiki']['hh_url'], array('class' => 'text-link')); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<?php if (!empty($wikis[2])): ?>
						<ul class="no-bullets col-md-4 col-sm-4">
							<?php foreach($wikis[2] as $key => $wiki): ?>
								<li><?= $this->Html->link($wiki['Wiki']['name'], $wiki['Wiki']['hh_url'], array('class' => 'text-link')); ?></li>
							<?php endforeach; ?>
							<?php if ($settings['country'] == 'US'): ?>
							<li><?= $this->Html->link('Hearing aid manufacturers', array('admin' => false, 'plugin' => false, 'controller' => 'corps', 'action' => 'index'), array('class' => 'text-link')); ?></li>
							<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php //echo $this->element('nav_wiki_menu', [], ['cache' => ['config' => 'view_short']]); ?>
	<?php endif; ?>
</nav>