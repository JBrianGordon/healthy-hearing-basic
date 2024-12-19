<?php if (!empty($location->location_photos)): ?>
	<?php $locationPhotos = $location->location_photos; ?>
	<!-- Photo Gallery Modal -->
	<div class="modal fade" id="photoModal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
	          <span>&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			<?php foreach($locationPhotos as $photo): ?>
				<div class="modal-slide-container photo gallery">
					<img loading="lazy" src="<?= $photo->photo_url ?>" alt="<?= $photo->alt; ?>" width="200" height="150" />
				</div>
			<?php endforeach ?>
	      </div>
	    </div>
	  </div>
	</div>
	<section id="clinicPhotos" class="panel panel-primary">
		<header class="panel-heading text-center">
			<h3>Photos</h3>
		</header>
		<div class="panel-body">
			<div class="panel-section expanded" style="padding:0">
				<div class="photo-gallery">
					<?php if (count($locationPhotos) > 3): ?>
						<!-- These images are loaded with a carousel plugin. Do not use lazy loading. -->
						<?php foreach($locationPhotos as $photo): ?>
							<button data-toggle="modal" class="photo-button" data-target="#photoModal" aria-label="Display photo carousel">
								<img class="photo gallery" loading="lazy" src="<?= $photo->photo_url; ?>" alt="<?= $photo->alt; ?>" width="200" height="150" />
							</button>
						<?php endforeach ?>
					<?php elseif (count($locationPhotos) == 3): ?>
						<?php foreach($locationPhotos as $photo): ?>
							<button data-toggle="modal" class="photo-button col-sm-4" data-target="#photoModal" aria-label="Display photo carousel">
								<img class="photo gallery" loading="lazy" style="margin-bottom: 20px" src="<?= $photo->photo_url; ?>" alt="<?= $photo->alt; ?>" width="200" height="150" />
							</button>
						<?php endforeach ?>
					<?php elseif (count($locationPhotos) == 2): ?>
						<?php foreach($locationPhotos as $photo): ?>
							<button data-toggle="modal" class="photo-button col-sm-6" data-target="#photoModal" aria-label="Display photo carousel">
								<img class="photo gallery" loading="lazy" style="margin-bottom: 20px" src="<?= $photo->photo_url; ?>" alt="<?= $photo->alt; ?>" width="200" height="150" />
							</button>
						<?php endforeach ?>
					<?php else: ?>
						<button data-toggle="modal" class="photo-button col-sm-6 offset-sm-3" data-target="#photoModal" aria-label="Display photo carousel">
							<img class="photo gallery" loading="lazy" style="margin-bottom: 20px" src="<?= $locationPhotos->first()->photo_url; ?>" alt="<?= $photo->alt; ?>" width="200" height="150" />
						</button>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
