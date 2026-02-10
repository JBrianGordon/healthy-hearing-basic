<?php
use Cake\Core\Configure;
?>
<?php if(!$isClinic): ?>
<div class="d-md-none" data-hh-side-nav>
	<div class="row noprint">
		<div class="col-sm-12">
			<ul class="side-nav-links">
				<li><span><strong class="invisible">Menu</strong></span></li>
				<?php if ($isClinic || isset($clinicPage)): ?>
					<?php $locationId = $user->locations[0]->id ?? null; ?>
					<li><a href="/clinic/locations/edit/<?= $locationId ?>" class="bi bi-globe2"> My Profile</a></li>
					<li><a href="/clinic/ca-call-groups/report/<?= $locationId ?>" class="bi bi-list-task"> Reporting</a></li>
					<li><a href="/clinic/reviews/<?= $locationId ?>" class="bi bi-star-fill"> Reviews</a></li>
					<li><a href="/clinic/library" class="bi bi-book-fill"> Library</a></li>
					<li><a href="/clinic/pages/faq" class="bi bi-question-circle-fill"> Help</a></li>
					<li><a href="/clinic/locations/account/<?= $locationId ?>" class="bi bi-person-fill"> My Account</a></li>
					<?php if ($isClinic || $adminAccessAllowed) : ?>
						<li><a href="/logout" class="bi bi-power"> Logout</a></li>
					<?php endif; ?>
				<?php else: ?>
					<li><a href="/hearing-aids" class="text-link text-success" tabindex="-1">Find a clinic</a></li>
					<li>
						<a href="#" tabindex="-1" class="dropdown-toggle side-nav-dropdown">Hearing loss</a>
						<ul class="dropdown-menu">
							<li><a class="text-link" tabindex="-1" href="/help/hearing-loss">Hearing loss overview</a></li>
							<?php if(Configure::read('country') == 'US'): ?>
								<li><a class="text-link" tabindex="-1" href="/help/hearing-loss/symptoms">Symptoms</a></li>
								<li><a class="text-link" tabindex="-1" href="/help/hearing-loss/causes">Causes</a></li>
							<?php endif; ?>
							<li><a class="text-link" tabindex="-1" href="/help/hearing-loss/tests">Tests</a></li>
						</ul>
					</li>
					<li>
						<a href="#" tabindex="-1" class="dropdown-toggle side-nav-dropdown">Hearing aids</a>
						<ul class="dropdown-menu">
							<li><a class="text-link" tabindex="-1" href="/help/hearing-aids">Hearing aids overview</a></li>
							<?php if(Configure::read('country') == 'US'): ?>
								<li><a class="text-link" tabindex="-1" href="/help/hearing-aids/health-benefits">Health benefits</a></li>
							<?php endif; ?>
							<li><a class="text-link" tabindex="-1" href="/help/hearing-aids/types">Types & styles</a></li>
							<li><a class="text-link" tabindex="-1" href="/help/hearing-aids/prices">Prices</a></li>
							<li><a class="text-link" tabindex="-1" href="/help/hearing-aids/insurance-financial-assistance">Insurance & financial assistance</a></li>
						</ul>
					</li>
					<?php if (Configure::read('showTinnitus')): ?>
						<li>
							<a href="#" tabindex="-1" class="dropdown-toggle side-nav-dropdown">Tinnitus</a>
							<ul class="dropdown-menu">
								<li><a class="text-link" tabindex="-1" href="/help/tinnitus">Tinnitus overview</a></li>
								<li><a class="text-link" tabindex="-1" href="/help/tinnitus/symptoms">Symptoms</a></li>
								<li><a class="text-link" tabindex="-1" href="/help/tinnitus/relief">Relief</a></li>
							</ul>
						</li>
					<?php else: ?>
						<li>
							<a href="#" tabindex="-1" class="dropdown-toggle side-nav-dropdown">Tinnitus</a>
								<ul class="dropdown-menu">
									<li><a class="text-link" tabindex="-1" href="/help/hearing-loss/tinnitus-treatment">Diagnosis & treatment</a></li>
								</ul>
						</li>
					<?php endif; ?>
					<li>
						<a href="/help/online-hearing-test" class="text-link" tabindex="-1">Online hearing test</a>
					</li>
					<?php $aldUrl = (Configure::read('country') == 'CA') ? "/help/hearing-aids/assistive-listening-devices" : "/help/assistive-listening-devices"; ?>
					<li><a href="<?= $aldUrl ?>" class="text-link">Assistive listening devices</a></li>
					<?php if (Configure::read('showReports')): ?>
						<li><a href="/report" class="text-link" tabindex="-1">News</a></li>
					<?php endif; ?>
					<?php if (Configure::read('showNewsletter')): ?>
						<li><a href="/newsletter" class="text-link" tabindex="-1">Sign up for our newsletter</a></li>
					<?php endif; ?>
					<?php if (isset($clinicPage) && !$adminAccessAllowed): ?>
						<li><a href="/login" class="text-link">Login</a></li>
					<?php endif; ?>
					<?php if ($adminAccessAllowed): ?>
						<li><a href="/admin"><span class="text-link bi bi-gear-fill"></span> Admin</a></li>
					<?php endif; ?>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div>
<?php endif; ?>