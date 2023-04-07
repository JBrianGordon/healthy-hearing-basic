
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
						<?= $this->element('header/admin_panel_link') ?>
						<?php if ($this->Identity->get('role') === 'clinic'): ?>
							<?= $this->element('header/clinic_panel_link') ?>
						<?php endif; ?>
					</ul>
					<!-- TODO: SEARCH/MAGNIFYING GLASS -->
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