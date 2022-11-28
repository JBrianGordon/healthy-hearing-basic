<?php
use Cake\Core\Configure;
	
$isCqPremier = $listing_type = $featureContentLibrary = $showLibraryLink = false;
if (!empty($user['location_id'])) {
	$this->Clinic->setLocation($user['location_id']);
	$isCqPremier = $this->Clinic->get('is_cq_premier');
	$listing_type = $this->Clinic->get('listing_type');
	$featureContentLibrary = $this->Clinic->get('feature_content_library');
}
//***TODO: uncomment when roles added*** $showLibraryLink = ($isCqPremier && $listing_type === 'Premier') || $featureContentLibrary || $isadmin;
if (!Configure::read('showSocialMediaContentLibrary')) {
	$showLibraryLink = false;
}
?>
<div data-hh-side-nav>
	<div class="row noprint">
		<div class="col-sm-12">
			<ul class="side-nav-links">
				<li><span><strong>Menu</strong></span></li>
			<?php //***TODO: uncomment when roles added*** if (($isadmin || $isitadmin || $isagent || $iscallsupervisor || $iswriter || $iscsa) && ($this->layout == 'admin' || $this->layout == 'clinic' || $this->layout == 'upgrade')): ?>
				<li><a href="/clinic/locations/edit"><span class="glyphicon glyphicon-globe"></span> My Profile</a></li>
				<li><a href="/clinic/ca_call_groups/report"><span class="glyphicon glyphicon-list"></span> Reporting</a></li>
				<li><a href="/clinic/reviews"><span class="glyphicon glyphicon-star"></span> Reviews</a></li>
				<li><a href="/clinic/library"><span class="glyphicon glyphicon-book"></span> Library</a></li>
				<li><a href="/clinic/pages/faq"><span class="glyphicon glyphicon-question-sign"></span> Help</a></li>
				<li><a href="/clinic/pages/about-ida"><span class="glyphicon glyphicon-certificate"></span> Inspired by Ida</a></li>
				<li><a href="/clinic/users/account"><span class="glyphicon glyphicon-user"></span> My Account</a></li>
				<li><a href="/logout"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
			<?php //else: ?>
				<li class="mt70"><a href="/hearing-aids" tabindex="-1">Find a clinic</a></li>
				<li>
					<a href="#" tabindex="-1" class="dropdown-toggle side-nav-dropdown">Hearing loss</a>
					<ul class="dropdown-menu">
						<li><a tabindex="-1" href="/help/hearing-loss">Hearing loss overview</a></li>
						<?php if(Configure::read('country') == 'US'): ?>
							<li><a tabindex="-1" href="/help/hearing-loss/symptoms">Symptoms</a></li>
							<li><a tabindex="-1" href="/help/hearing-loss/causes">Causes</a></li>
						<?php endif; ?>
						<li><a tabindex="-1" href="/help/hearing-loss/tests">Tests</a></li>
					</ul>
				</li>
				<li>
					<a href="#" tabindex="-1" class="dropdown-toggle side-nav-dropdown">Hearing aids</a>
					<ul class="dropdown-menu">
						<li><a tabindex="-1" href="/help/hearing-aids">Hearing aids overview</a></li>
						<?php if(Configure::read('country') == 'US'): ?>
							<li><a tabindex="-1" href="/help/hearing-aids/health-benefits">Health benefits</a></li>
						<?php endif; ?>
						<li><a tabindex="-1" href="/help/hearing-aids/types">Types & styles</a></li>
						<li><a tabindex="-1" href="/help/hearing-aids/prices">Prices</a></li>
						<li><a tabindex="-1" href="/help/hearing-aids/insurance-financial-assistance">Insurance & financial assistance</a></li>
					</ul>
				</li>
				<?php if (Configure::read('showTinnitus')): ?>
					<li>
						<a href="#" tabindex="-1" class="dropdown-toggle side-nav-dropdown">Tinnitus</a>
						<ul class="dropdown-menu">
							<li><a tabindex="-1" href="/help/tinnitus">Tinnitus overview</a></li>
							<li><a tabindex="-1" href="/help/tinnitus/symptoms">Symptoms</a></li>
							<li><a tabindex="-1" href="/help/tinnitus/treatment">Diagnosis & treatment</a></li>
							<li><a tabindex="-1" href="/help/tinnitus/relief">Relief</a></li>
						</ul>
					</li>
				<?php else: ?>
					<li>
						<a href="#" tabindex="-1" class="dropdown-toggle side-nav-dropdown">Tinnitus</a>
							<ul class="dropdown-menu">
								<li><a tabindex="-1" href="/help/hearing-loss/tinnitus-treatment">Diagnosis & treatment</a></li>
							</ul>
					</li>
				<?php endif; ?>
				<li><a href="/help/<?= Configure::read('country') == 'CA' ? "hearing-aids/" : ""; ?>assistive-listening-devices">Assistive listening devices</a></li>
				<?php if (Configure::read('showReports')): ?>
					<li><a href="/report" tabindex="-1">News</a></li>
				<?php endif; ?>
				<?php if(Configure::read('country') == 'US'): ?>
					<li><a href="/newsletter" tabindex="-1">Sign up for our newsletter</a></li>
				<?php endif; ?>
				<?php //***TODO: uncomment when roles added*** if(!($isadmin && $isitadmin && $isagent && $iscallsupervisor && $iswriter && $iscsa) && $this->layout == 'upgrade') : ?>
					<li><a href="/clinic/users/login">Login</a></li>
				<?php //endif; ?>
				<?php //***TODO: uncomment when roles added*** if ($isadmin || $isitadmin || $isagent || $iscallsupervisor || $iswriter || $iscsa): ?>
					<li><a href="/admin-panel"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Admin</a></li>
				<?php //endif; ?>
			<?php //endif; ?>
			</ul>
		</div>
	</div>
</div>
