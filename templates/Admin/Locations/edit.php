<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location $location
 */
 
use App\Model\Entity\Location;
use Cake\Core\Configure;

$this->Html->script('dist/admin_edit_locations.min', ['block' => true]);
$externalIdLabel = Configure::read('isYhnImportEnabled') ? 'YHN ID' : 'External ID / Retail ID';
$id = $locaton->id;
?>
<div class="container-fluid site-body fap-cities default">
	<div class="row">
		<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
		</div>
		<div class="container">
			<div class="row">
				<div class="clear"></div>
				<header class="col-md-12 mt10">
					<div class="panel panel-light">
						<div class="panel-heading">Locations Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
								<?= $this->Html->link(__(' View'), ['prefix' => false, 'controller' => 'locations', 'action' => 'view', $location->id], ['class' => 'btn btn-default bi bi-eye-fill', 'target' => '_blank']) ?>
								<?= $this->Html->link(__(' Clinic Edit'), ['prefix' => false, 'controller' => 'locations', 'action' => 'edit', $location->id], ['class' => 'btn btn-default bi bi-pencil-fill', 'target' => '_blank']) ?>
								<?= $this->Html->link(__(' Copy Location Data'), ['action' => 'copy', $location->id], ['class' => 'btn btn-default bi bi-clipboard2-check-fill']) ?>
								<?= $this->Html->link(__(' Calls'), ['prefix' => false, 'controller' => 'caCalls', 'action' => 'index', $location->id], ['class' => 'btn btn-default bi bi-telephone-fill', 'target' => '_blank']) ?>
								<?= $this->Html->link(__(' Call Call Groups'), ['prefix' => false, 'controller' => 'caCallGroups', 'action' => 'index', $location->id], ['class' => 'btn btn-default bi bi-telephone-fill', 'target' => '_blank']) ?>
							</div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
						        <div class="form">
						            <?= $this->Form->create($location) ?>
						            <fieldset>
						                <?php
							                echo $this->Form->control('title');
							                echo '<div class="col-md-3 col-md-offset-3 pl0 mb-3">';
						                    echo $this->Form->control('is_active');
						                    echo '</div>';
						                    echo '<div class="col-md-3 pl0 mb-3">';
						                    echo $this->Form->control('is_show');
						                    echo '</div>';
						                    echo '<div class="form-group">';
						                    echo '<div class="col col-md-9 col-md-offset-3 pl0 mb10">';
						                    echo $location->is_yhn ? '<span class="label label-yhn bi bi-globe-americas mr5"> YHN ' . $location->yhn_tier . '</span>' : '';
						                    echo $location->is_cqp ? '<span class="label label-cqp bi bi-briefcase-fill mr5">CQP ' . $location->cqp_tier . '</span>' : '';
						                    echo $location->_ ? '<span class="label label-cqp mr5">CQ Premier</span>' : '';
						                    echo $location->is_iris_plus ? '<span class="label label-earq mr5">Iris+</span>' : '';
						                    echo $location->is_call_assist ? '<span class="label label-success bi bi-telephone-fill mr5"> Call Assist</span>' : '<span class="label label-danger bi bi-telephone-fill"> Not Call Assist</span>';
						                    echo $location->is_retail ? '<span class="label label-primary mr5">Retail</span>' : '';
						                    echo '</div>';
						                    echo '</div>';
						                    echo $this->Form->control('listing_type', [
											    'type' => 'select',
											    'options' => Location::$listingTypes,
											    'class' => 'form-control',
											    'label' => ['class' => 'col col-md-3 control-label'],
											    'div' => ['class' => 'form-group mb5'],
											]);
						                    echo '<div class="col-md-9 col-md-offset-3 pl0 mb-3">';
						                    echo $this->Form->control('is_listing_type_frozen', ['label' => ' Freeze Listing Type']);
						                    echo '</div>';
						                ?>
										<table class="table table-striped table-bordered table-condensed mb5">
											<tbody>
												<tr>
													<th class="tar" width="25%">Location ID</th>
													<td><?= $location->id ?></td>
												</tr>
												<tr>
													<th class="tar">SF ID</th>
													<td><?= $location->id_sf ?></td>
												</tr>
												<tr>
													<th class="tar">Oticon ID</th>
													<td><?= $location->id_oticon ?></td>
												</tr>
												<tr>
													<th class="tar">YHN ID</th>
													<td><?= $location->id_yhn_location ?></td>
												</tr>
												<tr>
													<th class="tar">CQP Practice ID</th>
													<td><?= $location->id_cqp_practice ?></td>
												</tr>
												<tr>
													<th class="tar">CQP Office ID</th>
													<td><?= $location->id_cqp_office ?></td>
												</tr>
												<tr>
													<th class="tar">Parent Location ID</th>
													<td><?= $location->id_parent ?></td>
												</tr>
												<tr>
													<th class="tar">Location Segment</th>
													<td><?= $location->location_segment ?></td>
												</tr>
												<tr>
													<th class="tar">Profile_status</th>
													<td><?= $location->completeness . ' - ' . $location->review_status ?></td>
												</tr>
												<tr>
													<th class="tar">Location URL</th>
													<td><?= $location->url ?></td>
												</tr>
											</tbody>
										</table>
										<?= $this->Form->control('priority', ['label' => ['class' => 'col col-md-3 control-label'], 'class' => 'col col-md-9 mb10']); ?>
						                <div class="tabbable">
											<ul class="nav nav-tabs location-tabs clearfix">
												<li class="active"><a href="#Location" data-toggle="tab" aria-expanded="true">Location</a></li>
												<li><a href="#Details" data-toggle="tab">Details</a></li>
												<li><a href="#Provider" data-toggle="tab">Provider</a></li>
												<li><a href="#Hours" data-toggle="tab">Hours</a></li>
												<li><a href="#Payment" data-toggle="tab">Payment</a></li>
												<li><a href="#Notes" data-toggle="tab" aria-expanded="false">Notes</a></li>
												<li><a href="#CallAssist" data-toggle="tab">Call Assist</a></li>
												<li><a href="#User" data-toggle="tab">User</a></li>
												<li><a href="#Reviews" data-toggle="tab">Reviews</a></li>
												<li><a href="#Imports" data-toggle="tab">Imports</a></li>
												<li><a href="#Filters" data-toggle="tab">Filters</a></li>
												<li><a href="#Admin" data-toggle="tab">Admin</a></li>
											</ul>
											<div class="tab-content mt10">
												<!-- Location Tab -->
												<div class="tab-pane active" id="Location">
													<div class="form-group">
														<div class="col col-md-offset-2 col-md-8 mb10 pl0">
															<?= $this->Html->link(' Geocode', ['action' => 'geocode'], ['class' => 'btn btn-xs btn-primary bi bi-geo-alt-fill']) ?>
														</div>
													</div>
													<div class="col-md-6 p0">
														<?php
															echo $this->Form->control('address', ['label' => ['class' => 'col col-md-4-override control-label'], 'class' => 'col col-md-8-override mb10']);
															echo $this->Form->control('city', ['label' => ['class' => 'col col-md-4-override control-label'], 'class' => 'col col-md-8-override mb10']);
															echo $this->Form->control('zip', ['label' => ['class' => 'col col-md-4-override control-label'], 'class' => 'col col-md-8-override mb10']);
														?>
													</div>
													<div class="col-md-6 p0">
														<?php
															echo $this->Form->control('address_2', ['label' => ['class' => 'col col-md-4-override control-label'], 'class' => 'col col-md-8-override mb10']);
															echo $this->Form->control('state', ['label' => ['class' => 'col col-md-4-override control-label'], 'class' => 'col col-md-8-override mb10']);
															echo '<div class="col-md-8 col-md-offset-4 pl0 mb-3">';
															echo $this->Form->control('is_mobile', ['label' => ' Mobile-only clinic?']);
															echo '</div>';
														?>
													</div>
													<div class="row" id="radius"<?php if(!$location->is_mobile){echo ' style="display:none"';}?>>
														<div class="col-md-6">
															<?= $this->Form->control('radius') ?>
														</div>
														<div class="col-md-6">
															<?= $this->Form->control('mobile_text') ?>
														</div>
													</div>
													<div class="clearfix"></div>
													<div class="row pl0">
														<div class="col-md-12">
															<?php
											                    echo $this->Form->control('phone', ['label' => ['class' => 'col col-md-2-override control-label'], 'class' => 'col col-md-10-override mb10']);
											                    echo $this->Form->control('email', ['label' => ['class' => 'col col-md-2-override control-label'], 'class' => 'col col-md-10-override mb10']);
											                ?>
											            </div>
											            <div class="mb-3 form-group">
											                <div class="col-md-6 p0">
												                <?php
											                    	echo $this->Form->control('lat', ['label' => ['class' => 'col col-md-4-override control-label'], 'class' => 'col col-md-8-override mb10']);
											                    ?>
											                </div>
											                <div class="col-md-6 pl0">
											                    <?php echo $this->Form->control('lon', ['label' => ['class' => 'col col-md-4-override control-label'], 'class' => 'col col-md-8-override mb10']);
												                ?>
											                </div>
											                <?php
											                    echo $this->Form->control('timezone', ['label' => ['class' => 'col col-md-2-override control-label'], 'class' => 'col col-md-10-override mb10', 'required' => false]);
											                    echo $this->Form->control('landmarks', ['label' => ['class' => 'col col-md-2-override control-label'], 'class' => 'col col-md-10-override mb10']);
											                ?>
											                <span class="help-block col-md-10 col-md-offset-2">Use this field for landmarks, cross streets, neighborhood or other information that helps patients find your clinic.</span>
											            </div>
														<div class="row">
															<div class="col-md-offset-2 col-md-10">
																<div class="thumbnail">
																	<?= $this->element('locations/map', ['location' => $location]); ?>
																</div>
															</div>
														</div>
														<!-- Linked Locations -->
														<hr class="mt25">
														<div class="row">
															<div class="col-md-12">
																<label class="col col-md-2 control-label">Linked Locations</label><div class="clearfix"></div>
																<table class="table-striped table-bordered col-md-offset-2 col-md-10">
																	<?php foreach ($uniqueLocationLinks as $key => $linkedLocationId): ?>
																		<tr id="tr-link-<?php echo $key; ?>">
																			<td>
																				<div id="div-link-<?php echo $key; ?>">
																					<?php echo $this->Clinic->linkedLocationInfo($linkedLocationId); ?>
																					<span class="help-block text-danger" style="display:none;" id="link-error-<?php echo $key; ?>"></span>
																				</div>
																			</td>
																			<td style="width:100px;" align="center">
																				<button type="button" class="btn btn-md btn-danger js-link-delete" data-key="<?php echo $key; ?>" data-id="<?php echo $id; ?>" data-link="<?php echo $linkedLocationId; ?>">Delete</button>
																			</td>
																		</tr>
																	<?php endforeach; ?>
																	<?php $key = count($uniqueLocationLinks); ?>
																	<tr id="tr-link-<?php echo $key; ?>">
																		<td>
																			<div id="div-link-<?php echo $key; ?>">
																				<?php echo $this->Form->hidden('linked_location_id'); ?>
																				<input class="form-control linked-location" data-key="<?php echo $key; ?>" data-id="<?php echo $id; ?>" />
																				<span class="help-block text-danger" style="display:none;" id="link-error-<?php echo $key; ?>"></span>
																			</div>
																		</td>
																		<td style="width:100px;" align="center">
																			<div id="div-add-delete-<?php echo $key; ?>">
																			</div>
																		</td>
																	</tr>
																</table>
																<span class="help-block col-md-offset-2 col-md-10">
																	<?php if (Configure::read('isTieringEnabled')): ?>These are displayed on Enhanced/Premier profiles only. <?php endif; ?>
																	Search by typing in clinic name, <?php echo $zipShort; ?>, or <?php echo Configure::read('siteNameAbbr'); ?> ID. Select the correct clinic from the drop-down list.
																</span>
															</div>
														</div>
													</div>
												</div>
												<!-- Details tab -->
												<div class="tab-pane" id="Details">
													<div class="col-md-12 ida-wrapper mb20 pl0">
													    <?= $this->Form->hidden('Location.is_ida_verified', ['value' => 0]) ?>
													    <label class="col control-label switch boolean-switch" for="location-is-ida-verified">
													        <?= $this->Form->checkbox('Location.is_ida_verified', [
													            'value' => 1,
													            'class' => '',
													            'id' => 'location-is-ida-verified'
													        ]) ?>
													        <span class="slider" style="margin-left:245px"></span> Ida verified clinic
													    </label>
													</div>
													<?php
														echo $this->Form->control('slogan', ['class' => 'text', 'type' => 'text']);
														echo $this->Form->control('url');
									                    echo $this->Form->control('facebook');
									                    echo $this->Form->control('twitter');
									                    echo $this->Form->control('youtube');
									                    /*** TODO: replace with CKEditor ***/
									                    echo $this->Form->control('services', ['required' => true]);
									                    echo $this->Form->control('about_us', ['required' => true]);
													?>
													<div class="panel panel-default pb20">
														<div class="panel-heading">Enhanced features</div>
														<div class="panel-body m10<?php if ($location->listing_type != Location::LISTING_TYPE_ENHANCED && $location->listing_type != Location::LISTING_TYPE_PREMIER){echo " panel-disabled";}?>">
															<!-- Badges -->
															<div class="form-group">
																<label class="col col-md-3 control-label">Badges</label>
																<div class="col col-md-4">
																	<?= $this->element('locations/badges'); ?>
																</div>
															</div>
														</div>
													</div>
													<?php if (Configure::read('isTieringEnabled')): ?>
														<div class="panel panel-default">
															<div class="panel-heading">Premier features</div>
															<div class="panel-body m10<?php if ($location->listing_type != Location::LISTING_TYPE_ENHANCED && $location->listing_type != Location::LISTING_TYPE_PREMIER){echo " panel-disabled";}?>">
																<!-- Clinic logo -->
																<!-- *** TODO: This code will need to be updated once logo uploading added *** -->
																<div>
																	<label class="col col-md-3 control-label">Clinic logo</label>
																	<table class="table-striped table-bordered col-md-offset-3 col-md-9">
																		<tbody>
																			<tr>
																				<td>
																					<img class="ml60 mb10" id="photo-thumb-logo" src="<?php if(!empty($location->logo_url)){echo '/cloudfiles/clinics/' . $location->logo_url;} ?>">
																				<?php
																					echo $this->Form->control("logo_file", [
																						'type' => 'file',
																						'label' => 'File name',
																						'class' => 'form-control photo-url',
																						'id' => 'LocationLogo0Url'
																					]);
																				?>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																	<span class="help-block col-md-9 col-md-offset-3">Logos must be JPG format and less than 500KB. To add a logo, click on "Choose File" then select the logo from your computer. For best results, please use logo images that are a minimum of 250 x 250 pixels and a maximum of 800 x 800 pixels. Logos with icons or images are highly recommended over text based logos.</span>
																</div>
																<div class="clearfix"></div>
																<hr>
																<!-- Videos -->
																<div>
																	<label class="col col-md-3 control-label">Videos</label><div class="clearfix"></div>
																	<table class="table-striped table-bordered col-md-offset-3 col-md-9">
																		<tbody>
																			<!-- *** TODO: This code will need to be updated once locationvideo added *** -->
																			<?php //foreach ($this->request->data['LocationVideo'] as $key => $video): ?>
																				<tr>
																					<td>
																						<span class="hidden"><?php //=$LocationVideo.$key.id ?></span>
																						<div>
																							<?php /*$this->Form->control("LocationVideo.$key.video_url", [
																								'label' => false,
																								'div' => false,
																								'wrapInput' => false
																							]);*/ ?>
																						</div>
																					</td>
																					<td style="width:100px;" align="center">
																						<button type="button" class="btn btn-md btn-danger js-video-delete" data-key="<?php //echo $key; ?>">Delete</button>
																					</td>
																				</tr>
																			<?php //endforeach; ?>
																			<tr class="footer">
																				<td>
																					<input class="form-control video-url" />
																					<span class="help-block text-danger" style="display:none;" id="video-add-error">Video URL is invalid. Must start with http: or https:</span>
																				</td>
																				<td style="width:100px;" align="center">
																					<button type="button" class="btn btn-md btn-success js-video-add">add</button>
																					<input type="hidden" class="videoKey" value="<?php //echo count($locationVideo); ?>" />
																				</td>
																			</tr>
																		</tbody>
																	</table>
																	<span class="help-block col-md-9 col-md-offset-3">Please copy and paste the URL from the YouTube, Vimeo, Dailymotion or Wistia video you'd like to add. Alternatively, you can go to the video and click "share", then copy and paste the link generated. After adding the link, please click ADD.</span>
																</div>
																<div class="clearfix"></div>
																<hr>
																<!-- Photo Album -->
																<div>
																	<label class="col col-md-3 control-label">Photos</label><div class="clearfix"></div>
																	<table class="table-striped table-bordered col-md-offset-3 col-md-9">
																		<tbody>
																		<!-- *** TODO: This code will need to be updated once locationphoto added *** -->
																		<?php //foreach ($locationPhoto as $key => $photo): ?>
																			<?php //if (!empty($photo->photo_url)): ?>
																				<tr>
																					<td>
																						<span class="hidden"><?php //=$locationPhoto.$key.id; ?></span>
																						<div class='row mt5 mb10'>
																							<div class='col-md-offset-3 col-md-9'>
																								<img src="/cloudfiles/clinics/<?php //echo $photo->photo_url; ?>">
																							</div>
																						</div>
																						<?php
																						/*echo $this->Form->control("LocationPhoto.$key.photo_url", [
																							'label' => 'File name',
																							'readonly' => 'readonly',
																						]);
																						echo $this->Form->control("LocationPhoto.$key.alt", [
																							'label' => 'Description',
																							'required' => true,
																						]);*/
																						?>
																					</td>
																					<td style="width:100px;" class="tac">
																						<button type="button" class="btn btn-md btn-danger js-photo-delete" data-key="<?php //=$key; ?>">Delete</button>
																					</td>
																				</tr>
																			<?php //endif; ?>
																		<?php //endforeach; ?>
																		</tbody>
																	</table>
																	<span class="help-block col-md-9 col-md-offset-3">Photos must be JPG format and less than 2MB. To add a photo, click on "Choose File". To remove a photo, click on "Delete".</span>
																</div>
																<div class="clearfix"></div>
																<hr>
																<!-- *** TODO: header variables, e.g. showSpecialAnnouncements need to be set *** -->
																<?php //if ($showSpecialAnnouncement): ?>
																	<!-- Special announcements / Flex space / Coupons -->
																	<div id="specialAnnouncements" data-iscqpremier="<?php //echo $isCqPremier; ?>" data-adid="<?php //echo $adId; ?>" data-couponid="<?php //echo $couponId; ?>">
																		<label class="col col-md-3 control-label">Special announcement</label>
																		<div class="clearfix"></div>
																		<div id="couponLibrary" style="display:none;">
																			<div class="row mb20 pr20 pl20">
																				<div class="col-md-3">
																					<div class="panel panel-light text-center mb5" style="height:373px;">
																						<div class="text-center" style="padding-top:150px;">
																							<button type="button" class="btn btn-large btn-primary text-center js-choose-own-coupon">Choose my own</button>
																						</div>
																					</div>
																				</div>
																				<div class="col-md-3">
																					<?php echo $this->Clinic->previewCoupon(1); ?>
																				</div>
																				<div class="col-md-3">
																					<?php echo $this->Clinic->previewCoupon(2); ?>
																				</div>
																				<div class="col-md-3">
																					<?php echo $this->Clinic->previewCoupon(3); ?>
																				</div>
																			</div>
																			<div class="row mb20 pr20 pl20">
																				<div class="col-md-3">
																					<?php echo $this->Clinic->previewCoupon(4); ?>
																				</div>
																				<div class="col-md-3">
																					<?php echo $this->Clinic->previewCoupon(5); ?>
																				</div>
																				<div class="col-md-3">
																					<?php echo $this->Clinic->previewCoupon(6); ?>
																				</div>
																				<div class="col-md-3">
																					<?php echo $this->Clinic->previewCoupon(7); ?>
																				</div>
																			</div>
																			<div class="row pr20 pl20">
																				<div class="col-md-3">
																					<?php echo $this->Clinic->previewCoupon(8); ?>
																				</div>
																				<div class="col-md-3">
																					<?php echo $this->Clinic->previewCoupon(9); ?>
																				</div>
																				<div class="col-md-3">
																				</div>
																				<div class="col-md-3">
																				</div>
																			</div>
																		</div>
																		<div id="couponSelected" style="display:none;">
																			<span class="hidden"><?php echo $location->id_coupon; ?></span>
																			<div class='col-md-offset-4 col-md-3'>
																				<?php //echo $this->Clinic->previewCoupon($couponId, false, true); ?>
																			</div>
																			<div class='col-md-5'></div>
																		</div>
																		<div id="uploadCoupon" style="display:none;">
																			<?php //if ($adId): ?>
																				<?php /*echo $this->Form->control('LocationAd.id',
																					[
																						'type' => 'hidden',
																						'value' => $adId
																					]);*/
																				?>
																			<?php //endif; ?>
																			<?php //if ($isCqPremier): ?>
																				<div class="col-md-offset-3 mb20"><button type="button" class="btn btn-md btn-primary js-show-coupon-library mt5">View Coupon Options</button></div>
																			<?php //endif; ?>
																			<?php //if (!empty($locationAd->photo_url) || !empty($locationAd->title) || !empty($locationAd->description)): ?>
																				<div class='row mb20' id='location-ad-preview'>
																					<div class='col-md-offset-3 col-md-3'>
																						<div class="panel panel-light text-center mb5">
																							<?php if (!empty($locationAd->title)): ?>
																								<div class="panel-heading"><?php echo $locationAd->title; ?></div>
																							<?php endif; ?>
																							<?php if (!empty($locationAd->photo_url)): ?>
																								<div class="panel-body">
																									<img class="coupon-image" src="/cloudfiles/clinics/<?php echo $locationAd->photo_url; ?>">
																								</div>
																							<?php endif; ?>
																							<?php if (!empty($locationAd->description)): ?>
																								<div class="panel-footer"><?php echo $locationAd->description; ?></div>
																							<?php endif; ?>
																						</div>
																						<div class="text-center"><button type="button" class="btn btn-md btn-danger js-ad-delete mt5">Delete announcement /<br>Choose another</button></div>
																					</div>
																				</div>
																			<?php //endif; ?>
																			<?php
																				echo $this->Form->control("LocationAd.photo_url", [
																					'label' => 'File name',
																					'readonly' => 'readonly',
																					'wrapInput' => 'col-md-7',
																					'after' => '<label class="btn btn-sm btn-default mt5">
																						<span>Upload image</span>
																						<input type="file" name="data[LocationAd][file]" class="form-control hidden" id="LocationAdFile">
																						</label>',
																					'help_block' => 'Images must be JPG format, less than 500kb, and under 700 pixels in width.<br>
																						<span class="text-danger" id="location-ad-error" style="display:none;" id="location-ad-error">Image is invalid. Must be a .jpg or .jpeg and less than 500kb.</span>'
																				]);
																			?>
																			<?php
																				echo $this->Form->control("LocationAd.title", [
																					'label' => 'Title',
																					'maxlength' => 50,
																					'required' => false,
																					'help_block' => 'This text will appear in the header of this space. 50 characters max.'
																				]);
																				echo $this->Form->control("LocationAd.description", [
																					'type' => 'textarea',
																					'rows' => 2,
																					'label' => 'Message',
																					'maxlength' => 500,
																					'required' => false,
																					'help_block' => 'This text will appear in the low text of this space. 500 characters max.'
																				]);
																			?>
																			<div class="form-group">
																				<label for="LocationAdBorder" class="col col-md-3 control-label">Border</label>
																				<input type="hidden" name="data[LocationAd][border]" id="LocationAdBlank_" value="">
																				<div class="col col-md-9">
																					<div class="col-md-3 border-radio<?php //if($locationAd->border == 'blank'){ echo ' selected-border';} ?>"><label for="LocationAdBlank" class="col control-label"><input type="radio" name="data[LocationAd][border]" value="blank" id="LocationAdBlank"<?php //if($locationAd->border == 'blank'){ echo ' checked';} ?>> No Border</label></div>
																					<div class="col-md-3 border-radio<?php //if($locationAd->border == 'border-dashed'){ echo ' selected-border';} ?>"><label for="LocationAdDashed" class="col control-label border-dashed"><input type="radio" name="data[LocationAd][border]" value="border-dashed" id="LocationAdDashed"<?php //if($locationAd->border == 'border-dashed'){ echo ' checked';} ?>> Dashed</label></div>
																					<div class="col-md-3 border-radio<?php //if($locationAd->border == 'border-dotted'){ echo ' selected-border';} ?>"><label for="LocationAdDotted" class="col control-label border-dotted"><input type="radio" name="data[LocationAd][border]" value="border-dotted" id="LocationAdDotted"<?php //if($locationAd->border == 'border-dotted'){ echo ' checked';} ?>> Dotted</label></div>
																					<div class="col-md-3 border-radio<?php //if($locationAd->border == 'border-inset'){ echo ' selected-border';} ?>"><label for="LocationAdInset" class="col control-label border-inset"><input type="radio" name="data[LocationAd][border]" value="border-inset" id="LocationAdInset"<?php //if($locationAd->border == 'border-inset'){ echo ' checked';} ?>> Inset</label></div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="clearfix"></div>
																	<hr>
																<?php //endif; ?>
															</div>
														</div>
													<?php endif; ?>
													<?php //if ($isCqPremier): ?>
														<!-- Vidscrips -->
														<!-- *** TODO: locationVidscrips needs to be added -->
														<div id="vidscrips">
															<?php echo $this->Form->control('LocationVidscrips.id',
																[
																	'type' => 'hidden',
																	//'value' => $locationVidscrips->id
																]);
															?>
															<label class="col col-md-3 control-label mb20">Vidscrips</label>
															<div class="clearfix"></div>
															<?php
																echo $this->Form->control("LocationVidscrips.vidscrip", [
																	'label' => 'Vidscrip ID',
																	'maxlength' => 30,
																	'help_block' => 'Add your Vidscrip ID to access embedded Vidscrip videos.'
																]);	
															?>
															<?php
																echo $this->Form->control("LocationVidscrips.email", [
																	'label' => 'Vidscrip related email',
																	'help_block' => 'Enter the email address associated with your Vidscrip account.'
																]);	
															?>
														</div>
													<?php //endif; ?>
												</div>
												
												<!-- Provider Tab -->
												<div class="tab-pane" id="Provider">
													<!-- *** TODO: call this when Provider is added to page, including locations/provider *** -->		
													<?php
														//$count = count($this->request->data['Provider']);
													?>
													<?php //foreach ($this->request->data['Provider'] AS $key => $provider): ?>
														<?php //echo $this->element('locations/provider', ['key' => $key, 'provider' => $provider, 'clinic' => false, 'locationId' => $id]); ?>
													<?php //endforeach; ?>
													<?php //echo $this->element('locations/provider', ['new' => true, 'key' => $count, 'provider' => [], 'clinic' => false]); ?>
												</div>
												
												<!-- Hours Tab -->
												<div class="tab-pane" id="Hours">
													<div class="row">
														<div class="col-md-12">
															<?php echo $this->Form->control('optional_message', [
																'label' => ['class' => 'col col-md-2 control-label'],
																'wrapInput' => 'col col-md-10',
																'rows' => 3,
																'maxlength' => 400,
																'required' => false,
																'help_block' => 'Use this field to leave an update for patients about any changes this clinic is implementing regarding COVID-19.',
																'div' => 'form-group mb0']); ?>
														</div>
													</div>
													<table class="table table-striped table-bordered">
														<tr>
															<th width="16%">Day of Week</th>
															<th width="30%">Open Hrs</th>
															<th width="30%">Close Hrs</th>
															<th width="12%">Closed</th>
															<th width="12%">By Appt</th>
														</tr>
														<!-- *** TODO: update once locationHour is pulled in ***-->
														<span class="hidden"><?php //echo $locationHour->id; ?></span>
														<?php //foreach ($days as $day): ?>
															<tr>
																<td><?php //echo date("l", strtotime($day)); ?></td>
																<td class="form-inline">
																	<?php /*echo $this->Form->control("LocationHour.".$day."_open", [
																		'label' => false,
																		'type' => 'time',
																		'empty' => true,
																		//*** TODO: convert24hours needs to be built ***
																		//'selected' => $this->Clinic->convert24hours($this->request->data['LocationHour'][$day.'_open']),
																		'div' => false,
																		'class' => false
																	]); */?>
																</td>
																<td>
																	<?php /*echo $this->Form->control("LocationHour.".$day."_close", [
																		'label' => false,
																		'type' => 'time',
																		'empty' => true,
																		//'selected' => $this->Clinic->convert24hours($this->request->data['LocationHour'][$day.'_close']),
																		'div' => false,
																		'class' => false
																	]);*/ ?>
																</td>
																<td>
																	<?php /*echo $this->Form->control("LocationHour.".$day."_is_closed", [
																		'label' => false,
																		'type' => 'checkbox',
																		'div' => false,
																		'class' => 'is-closed-checkbox',
																		//'data-day' => ucfirst($day)
																	]);*/ ?>
																</td>
																<td>
																	<?php /*echo $this->Form->control("LocationHour.".$day."_is_byappt", [
																		'label' => false,
																		'type' => 'checkbox',
																		'div' => false,
																		'class' => false,
																	]);*/ ?>
																</td>
															</tr>
														<?php //endforeach; ?>
														<tr>
															<td colspan="5" class="center">
															<?php /*echo $this->Form->control('LocationHour.is_evening_weekend_hours', [
																'div' => false,
																'label' => [
																	'class' => 'col col-md-12 control-label tal mr5',
																	'text' => 'Evening and/or weekend hours available by appointment. Please call to schedule.',
																],
																'type' => 'checkbox',
																'class' => false,
																'wrapInput' => 'col col-md-12'
															]);*/ ?></td>
														</tr>
														<tr>
															<td colspan="5" class="center">
																<?php /*echo $this->Form->control('LocationHour.is_closed_lunch', [
																	'type' => 'checkbox',
																	'div' => false,
																	'class' => false,
																	'wrapInput' => 'col col-md-12 mb10',
																	'label' => [
																		'class' => 'col col-md-12 control-label tal',
																		'text' => 'Closed for lunch',
																	],
																]);*/ ?>
																<div id="closedLunch" class="col col-md-12" style="display:none;">
																	<div class="form-group required">
																		<label class="col col-md-2 tal">Lunch break</label>
																		<div class="col col-md-10">
																			<?php /*echo $this->Form->control('LocationHour.lunch_start', [
																				'type' => 'time',
																				'label' => false,
																				'class' => false,
																				'div' => false,
																				'wrapInput' => false,
																				'empty' => true,
																				'interval' => 15,
																				//'value' => $this->Clinic->convert24hours($this->request->data['LocationHour']['lunch_start']),
																			]);*/ ?>
																			<span class="mr5 ml5">-</span>
																			<?php /*echo $this->Form->control('LocationHour.lunch_end', [
																				'type' => 'time',
																				'label' => false,
																				'class' => false,
																				'div' => false,
																				'wrapInput' => false,
																				'empty' => true,
																				'interval' => 15,
																				'timeFormat' => 12,
																				//'value' => $this->Clinic->convert24hours($this->request->data['LocationHour']['lunch_end']),
																			]);*/ ?>
																		</div>
																	</div>
																</div>
															</td>
														</tr>
													</table>
												</div>
												
												<!-- Payment Tab -->
												<div class="tab-pane" id="Payment">
													<div class="control-group">
														<div class="controls">
															<p><strong>Acceptable Methods of Payment</strong></p>
															<!-- *** TODO: set up payment methods *** -->
															<?php //$payment_json = isset($this->request->data['Payment']) ? $this->request->data['Payment'] : $this->request->data['Location']['payment']; ?>
															<?php //echo $this->Clinic->paymentForm($payment_json); ?>
														</div>
													</div>
												</div>
												
												<!-- Notes Tab -->
												<div class="tab-pane" id="Notes">
													<!-- *** TODO: set up notes *** -->
													<?php //$noteCount = count($this->request->data['LocationNote']); ?>
													<div class="notes">
														<?php //echo $this->Form->input("LocationNote.$noteCount.body", array('required' => false)); ?>
														<?php 
															//*** TODO: update when CKEditor is ready ***
															/*echo $this->Ckeditor->replace("LocationNote{$noteCount}Body", [
																'toolbar' => 'Basic', 
																'height' => '200px', 
																'var_name' => "NoteBody",
															]); */
														?>
														<div class="row">
															<div class="col-lg-12">
																<input type="submit" value="Save Location" class="btn btn-primary btn-lg pull-right">
															</div>
														</div>
														<br />
														<?php
															/*foreach ($this->request->data['LocationNote'] as $note) {
																echo $this->element('locations/note', ['note' => $note]);
															}*/
														?>
													</div>
												</div>
												
												<?php if ($isAdmin): ?>
													<!-- Call Assist Tab -->
													<?php if (Configure::read('isCallAssistEnabled')): ?>
														<div class="tab-pane" id="CallAssist">
															<?php if ($location->is_call_assist): ?>
																<div class="well"><span class="bi bi-check-lg" style="color:limegreen;"></span> Call Assist is enabled. The CallSource number will route to our call center.</div>
															<?php else: ?>
																<div class="well"><span class="bi bi-x-lg" style="color:red;"></span> Call Assist is disabled. The CallSource number will route directly to clinic.</div>
															<?php endif; ?>
															<div class="col-md-12 p0">
															<?= $this->Form->control('is_bypassed', [
															    'label' => [
															        'text' => 'Send outbound survey calls directly to consumer<br><span class="text-muted">(Clinic will not answer)</span>',
															        'escape' => false,
															        'class' => 'pt0'
															    ],
															    'type' => 'select',
															    'options' => [0 => 'No', 1 => 'Yes']
															]); ?>
															</div>
															<?= $this->Form->control('direct_book_type', [
																'label' => 'Direct book type',
																'type' => 'select',
																'options' => Location::$directBookTypes,
															]);	?>
															<div id="direct-book-links">
																<?= $this->Form->control('direct_book_url', [
																	'label' => 'Direct book URL',
																	'type' => 'text',
																	'rows' => 4,
																	'required' => false
																]);	?>
																<?= $this->Form->control('direct_book_iframe', [
																	'label' => 'Direct book iFrame',
																	'type' => 'text',
																	'rows' => 4,
																	'required' => false
																]);	?>
															</div>
															<hr>
															<div class="control-group mb20">
																<div class="controls">
																	<div class="btn-group">
																		<!-- *** TODO: Html helper needs to be built out *** -->
																		<?php /*echo $this->Html->link('<span class="glyphicon glyphicon-refresh"></span> Update or Create CS Number',
																			['action' => 'call_source', $id, '#' => 'CallAssist'],
																			['escape' => false, 'class' => 'btn btn-xs btn-default']); ?>
																		<?php echo $this->Html->link('<span class="glyphicon glyphicon-refresh"></span> End and create new CS Number',
																			['action' => 'cs_end_create', $id, '#' => 'CallAssist'],
																			['escape' => false, 'class' => 'btn btn-xs btn-info'],
																			'This will end this CS number, but leaves the CS customer active. Then creates a new CS number. Are you sure?'); ?>
																		<?php echo $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> Raw Lookup',
																			['action' => 'call_source_raw', $id, '#' => 'CallAssist'],
																			['class' => 'btn btn-xs btn-default', 'escape' => false]); ?>
																		<?php echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span> End CS Number',
																			['action' => 'end', $id, '#' => 'CallAssist'],
																			['class' => 'btn btn-xs btn-danger', 'escape' => false],
																			'This will end all CallSource campaigns for this location and inactivate this CS customer. Are you sure?');*/ ?>
																	</div>
																</div>
															</div>
															<table class="table table-striped table-bordered table-condensed mb10">
																<tr>
																	<th>CallSource Number</th>
																	<th>Target Number</th>
																	<th>Clinic Number</th>
																	<th>Is Active</th>
																</tr>
																<!-- *** TODO: CallSource needs to be added to page *** -->
																<?php //foreach ($this->request->data['CallSource'] as $callSource): ?>
																	<tr>
																		<td>
																			<?php //echo formatPhoneNumber($callSource['phone_number']); ?>
																		</td>
																		<td>
																			<?php //echo formatPhoneNumber($callSource['target_number']); ?>
																		</td>
																		<td>
																			<?php //echo formatPhoneNumber($callSource['clinic_number']); ?>
																		</td>
																		<td>
																			<?php //echo $callSource['is_active']; ?>
																		</td>
																	</tr>
																<?php //endforeach; ?>
															</table>
														</div>
													<!-- User Tab -->
													<div class="tab-pane" id="User">
														<div class="form-group mb20">
															<div class="controls col-md-offset-3 col-md-9">
																<div class="btn-group">
																	<!-- *** TODO: Html helper needs to be built out *** -->
																	<?php /*echo $this->Html->link('<span class="glyphicon glyphicon-envelope"></span> Send Default Email', ['controller' => 'location_users', 'action' => 'default_email', $this->request->data['LocationUser']['id'], $this->request->data['Location']['id']], ['class' => 'btn btn-xs btn-default', 'escape' => false]); ?>
																	<?php echo $this->Html->link('<span class="glyphicon glyphicon-lock"></span> Send Password Reset Email', ['controller' => 'location_users', 'action' => 'change_password', $this->request->data['LocationUser']['id'], $this->request->data['Location']['id']], ['class' => 'btn btn-xs btn-default', 'escape' => false]); ?>
																	<?php echo $this->Html->link('<span class="glyphicon glyphicon-retweet"></span> Generate New Password', ['controller' => 'location_users', 'action' => 'generate_new_password', $this->request->data['LocationUser']['id'], $this->request->data['Location']['id']], ['class' => 'btn btn-xs btn-default', 'escape' => false]);*/ ?>
																</div>
															</div>
														</div>
														<h2>Clinic User</h2>
														<table class="table table-striped table-bordered table-condensed">
															<tr>
																<th class="col-md-3 tar">ID</th>
																<!-- *** TODO: uncomment this and much of the code below when LocationUser added *** -->
																<td class="col-md-9"><?php //echo $this->request->data['LocationUser']['id']; ?></td>
															</tr>
															<tr>
																<th class="col-md-3 tar">Created</th>
																<td class="col-md-9"><?php echo dateTimeCentralToEastern($location->created); ?></td>
															</tr>
															<tr>
																<th class="col-md-3 tar">Modified</th>
																<td class="col-md-9"><?php echo dateTimeCentralToEastern($location->modified); ?></td>
															</tr>
														</table>
														<?php /*echo $this->Form->control('LocationUser.id') ?>
														<?php echo $this->Form->control('LocationUser.username'); ?>
														<?php echo $this->Form->control('LocationUser.first_name', ['required' => false]); ?>
														<?php echo $this->Form->control('LocationUser.last_name', ['required' => false]); ?>
														<?php echo $this->Form->control('LocationUser.email', ['required' => false]);*/ ?>
														<div class="form-group">
															<label class="col col-md-3 control-label">Last Login</label>
															<div class="col col-md-9">
																<div class="form-control" disabled="true">
																	<?php
																	/*if ($this->request->data['LocationUser']['lastlogin']) {
																		echo date('F d Y, g:i a', strtotime($this->request->data['LocationUser']['lastlogin']));
																	} else {
																		echo 'Never Logged In';
																	}*/
																	?>
																</div>
															</div>
														</div>
														<hr>
														<div class="form-group">
															<div class="controls">
																<label class="col col-md-3 control-label">Email Notifications</label><div class="clearfix"></div>
																<?php
																$i=0; /*keep $i outside scope*/
																//*** TODO: add LocationEmail ***
																//$count = count($this->request->data['LocationEmail']);
																?>
																<?php //for(; $i < $count; $i++): ?>
																	<?php //if ($this->B3F->value("LocationEmail.$i.email")): /* Only show if we have something to show*/ ?>
																		<hr />
																		<?php //if($i != $count): ?>
																			<div class="form-group">
																				<div class="col col-md-offset-3 col-md-9">
																					<?php /*echo $this->Html->link(
																						'Delete This Email',
																						array('prefix' => 'Admin', 'controller' => 'location_users', 'action' => 'deluser',
																						$this->request->data['LocationEmail'][$i]['id']), array(), 'Are you sure?'
																					);*/ ?>
																				</div>
																			</div>
																		<?php //endif; ?>
																		<?php //echo $this->Form->control("LocationEmail.$i.id", array('default' => isset($this->request->data['LocationEmail'][$i]['id']) ? $this->request->data['LocationEmail'][$i]['id'] : '')); ?>
																		<?php //foreach(array('email','first_name','last_name') as $field): ?>
																			<?php //echo $this->Form->control("LocationEmail.$i.$field", array('default' => isset($this->request->data['LocationEmail'][$i][$field]) ? $this->request->data['LocationEmail'][$i][$field] : '')); ?>
																		<?php //endforeach; ?>
																		<hr>
																	<?php //endif; ?>
																<?php //endfor; ?>
									
																<div class="form-group">
																	<div class="col col-md-offset-3 col-md-9">
																		<?php //echo $this->Html->link('Add Another Email', '#', array('onclick' => '$("#additional-notification").slideDown(); return false;')); ?>
																	</div>
																</div>
									
																<?php //$notificationStyle = isset($this->validationErrors['LocationEmail'][$i]) ? '' : 'display:none;'; ?>
																<div id="additional-notification" style=<?php //echo $notificationStyle; ?>>
																	<?php //echo $this->Form->control("LocationEmail.$i.id", ['default' => isset($this->request->data['LocationEmail'][$i]['id']) ? $this->request->data['LocationEmail'][$i]['id'] : '']); ?>
																	<?php //foreach(['email','first_name','last_name'] as $field): ?>
																		<?php //echo $this->Form->control("LocationEmail.$i.$field", ['required' => false]); ?>
																	<?php //endforeach; ?>
																	<hr />
																</div>
															</div>
														</div>
														<hr>
														<div class="form-group">
															<label class="col col-md-3 control-label">Login History</label>
															<div class="col col-md-9">
																<div class="table-responsive">
																	<table class="table table-condensed table-striped table-bordered">
																		<tr>
																			<th>Login</th>
																			<th>IP Address</th>
																		</tr>
																		<?php //foreach ($locationUserLogins as $locationUserLogin): ?>
																			<tr>
																				<td><?php //echo $locationUserLogin['login_date']; ?></td>
																				<td><?php //echo $locationUserLogin['ip']; ?></td>
																			</tr>
																		<?php //endforeach; ?>
																	</table>
																</div>
															</div>
														</div>
													</div>
													
													<!-- Reviews Tab -->
													<div class="tab-pane" id="Reviews">
														<table class="table table-striped table-bordered table-condensed">
															<tr><th class="col-md-3 tar">Reviews Approved</th><td class="col-md-9"><?php echo $location->reviews_approved; ?></td></tr>
															<tr><th class="col-md-3 tar">Average Rating</th><td class="col-md-9"><?php echo $location->average_rating; ?></td></tr>
														</table>
														<div id="reviews" class="pb10">
															<div class="control-group">
																<div class="controls">
																<!-- *** TODO: Pull in Review *** -->
																<?php //foreach($this->request->data['Review'] as $review): ?>
																	<!-- *** TODO: Add locations/review_body *** -->
																	<?php //echo $this->element('locations/review_body', array('review' => $review)); ?>
																	<div class="ml20 mt10">
																		<span class='label label-default'><?php //echo $this->Clinic->reviewStatus($review['status']) ?></span>
																		<?php /*echo $this->Html->link("<span class='glyphicon glyphicon-pencil'></span> Edit This Review",
																			['controller' => 'reviews', 'action' => 'edit', $review['id']],
																			['escape' => false, 'class' => 'btn btn-xs btn-default ml10']);*/ ?>
																	</div>
																	<hr>
																<?php //endforeach; ?>
																</div>
															</div>
														</div>
														<div class="control-group">
															<div class="controls">
																<?php //if ($id): ?>
																	<?php //echo $this->Html->link('<span class="glyphicon glyphicon-retweet"></span> Load All Reviews For This Clinic', array($id, '#' => 'Reviews', 'loadall' => 1), array('class' => 'btn btn-xs btn-info', 'escape' => false)); ?>
																<?php //endif; ?>
																<?php //echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> Add A Review For This Clinic', array('controller' => 'reviews', 'action' => 'edit', 0, $this->request->data['Location']['id']), array('class' => 'btn btn-xs btn-primary', 'escape' => false)); ?>
															</div>
														</div>
													</div>
													
													<!-- US Imports Tab -->
													<!-- *** TODO: add import specific variables, e.g. $lastOticonImportDate *** -->
													<div class="tab-pane" id="Imports">
														<h4>Imports</h4>
														<div class="tabbable">
															<ul class="nav nav-tabs import-tabs">
																<?php if (Configure::read('isOticonImportEnabled')): ?>
																	<li class="active"><a href="#Oticon" data-toggle="tab">Oticon</a></li>
																<?php endif; ?>
																<?php if (Configure::read('isYhnImportEnabled')): ?>
																	<li><a href="#YHN" data-toggle="tab">YHN</a></li>
																<?php endif; ?>
																<?php if (Configure::read('isCqpImportEnabled')): ?>
																	<li><a href="#CQP" data-toggle="tab">CQP</a></li>
																<?php endif; ?>
															</ul>
															<div class="tab-content mt10">
																<!-- Oticon Tab -->
																<div class="tab-pane active" id="Oticon">
																	<span><strong>Most recent Oticon import:</strong> <?php //echo $lastOticonImportDate; ?></span><br><br>
																	<?php if (!empty($location->oticon_tier)): ?>
																		<!-- Show change status only if this in an active Oticon clinic -->
																		<div class="form-group col-md-12">
																			<div class="btn-group">
																				<?php //echo $this->Html->link('<span class="glyphicon glyphicon-refresh"></span> Update Field Statuses Without Accepting Oticon Changes', array('controller' => 'locations', 'action' => 'check_oticon', $this->request->data['Location']['id']), array('class' => 'btn btn-xs btn-default', 'escape' => false)); ?>
																			</div>
																		</div>
																		<div class="clearfix"></div>
																		<table class="table table-striped table-bordered table-condensed">
																			<tr>
																				<th>Field</th>
																				<th>Status</th>
																				<th>HH value</th>
																				<th>Oticon value</th>
																				<th></th>
																			</tr>
																			<?php //foreach (['email', 'phone', 'title', 'address'] as $field): ?>
																				<?php //$ucField = ucfirst($field); ?>
																				<tr>
																					<td><?php //echo $ucField; ?></td>
																					<td><?php //echo $this->Clinic->{"readable".$ucField."Status"}($this->request->data); ?></td>
																					<td>
																						<?php /*
																						if ($field == 'address') {
																							echo $this->Clinic->get('address').' ';
																							echo $this->Clinic->get('address_2').' ';
																							echo $this->Clinic->get('city').' ';
																							echo $this->Clinic->get('state').' ';
																							echo $this->Clinic->get('zip');
																						} else {
																							echo $this->Clinic->get($field);
																						}*/
																						?>
																					</td>
																					<td>
																						<?php /*
																						if ($field == 'address') {
																							echo $this->Clinic->getOticonField(null, 'address').' ';
																							echo $this->Clinic->getOticonField(null, 'address_2').' ';
																							echo $this->Clinic->getOticonField(null, 'city').' ';
																							echo $this->Clinic->getOticonField(null, 'state').' ';
																							echo $this->Clinic->getOticonField(null, 'zip');
																						} else {
																							echo $this->Clinic->getOticonField(null, $field);
																						} */
																						?>
																					</td>
																					<td nowrap>
																						<?php /*
																						$confirmMessage = 'Are you sure?';
																						if ($field == 'phone') {
																							$confirmMessage .= ' This will also update the CallSource number for you.';
																						}
																						if ($field == 'address') {
																							$confirmMessage .= ' This will also re-geolocate the clinic for you.';
																						}*/
																						?>
																						<? //endif; ?>
																						<?php /*echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> Accept Oticon Change',
																							['controller' => 'locations', 'action' => 'take_oticon', $this->request->data['Location']['id'], $field],
																							['class' => 'btn btn-xs btn-danger pull-left m5', 'escape' => false],
																							$confirmMessage);*/ ?>
																						<?php /*echo $this->Form->control('is_'.$field.'_ignore', [
																							'label' => [
																								'class' => 'control-label',
																								'text' => 'Ignore '.$ucField.' Changes',
																							],
																							'type' => 'checkbox',
																							'class' => false,
																							'wrapInput' => 'col col-md-12'
																						]);*/ ?>
																					</td>
																				</tr>
																			<?php //endforeach; ?>
																		</table>
																		<hr>
																	<?php endif; ?>
									
																	<h4>Raw Parsed of Last XML from Oticon:</h4>
																	<?php //$this->Clinic->lastXml($this->request->data); ?>
									
																	<hr>
																	<p><strong>Oticon Import Status</strong></p>
																	<table class="table table-striped table-bordered table-condensed">
																		<tr>
																			<th>Import Date</th>
																			<th>Status</th>
																			<th>Oticon Tier</th>
																			<th>HH Listing Type</th>
																			<th>Active</th>
																			<th>Show</th>
																			<th>Grace Period</th>
																		</tr>
																		<?php //foreach($this->request->data['ImportStatus'] as $importStatus): ?>
																			<tr>
																				<td><?php //echo dateTimeCentralToEastern($importStatus['created']); ?></td>
																				<td><?php //echo $this->Clinic->getImportStatus($importStatus); ?></td>
																				<td><?php //echo $importStatus['oticon_tier']; ?></td>
																				<td><?php //echo $importStatus['listing_type']; ?></td>
																				<td><?php //echo $this->Clinic->getActiveStatus($importStatus); ?></td>
																				<td><?php //echo $this->Clinic->getShowStatus($importStatus); ?></td>
																				<td><?php //echo $this->Clinic->getGracePeriodStatus($importStatus); ?></td>
																			</tr>
																		<?php //endforeach; ?>
																	</table>
																	<?php //if ($id): ?>
																		<?php //echo $this->Html->link('<span class="glyphicon glyphicon-refresh"></span> Load All Statuses For This Clinic', array($id, '#' => 'Oticon', 'loadall' => 1), array('class' => 'btn btn-xs btn-info', 'escape' => false)); ?>
																	<?php //endif; ?>
																</div>
									
																<!-- YHN Tab -->
																<div class="tab-pane" id="YHN">
																	<div class="row">
																		<label class="col-md-3 control-label">YHN Import Date</label>
																		<div class="col col-md-3">
																			<select class="form-control js-import-select">
																				<!-- *** TODO: Uncomment once importLocation is set *** -->
																				<?php //foreach ($this->request->data['ImportLocation'] AS $importLocation): ?>
																					<?php //if ($importLocation['Import']['type'] == 'yhn'): ?>
																						<option value="<?php echo '1' //Populating with dummy value for now $importLocation['import_id']; ?>">
																							<?php //echo date('F d, Y', strtotime($importLocation['Import']['created'])); ?>
																						</option>
																					<?php //endif; ?>
																				<?php //endforeach; ?>
																			</select>
																		</div>
																	</div>
																	<?php $hideFields = ['id', 'import_id', 'location_id', 'match_type', 'notes', 'id_cqp_practice', 'id_cqp_office']; ?>
																	<?php //foreach ($this->request->data['ImportLocation'] AS $importLocation): ?>
																		<?php //if ($importLocation['Import']['type'] == 'yhn'): ?>
																			<div class="import col-md-11 col-md-offset-1" import="<?php //echo $importLocation['import_id']; ?>">
																				<br /><br />
																				<table class="table table-striped table-bordered table-condensed">
																					<?php //foreach ($importLocation AS $label => $value): ?>
																						<?php //if (is_array($value) || in_array($label, $hideFields)) { continue; } ?>
																						<?php /*
																						switch ($label) {
																							case "zip":
																								$label = Configure::read('zipLabel');
																								break;
																							case "state":
																								$label = Configure::read('stateLabel');
																								break;
																							case "id_external":
																								$label = $externalIdLabel;
																								break;
																							default:
																								break;
																						} */?>
																						<tr>
																							<th class="text-right col-md-3"><?php //echo ucfirst(str_replace('_', ' ', $label)); ?></th>
																							<td class="col-md-9"><?php //echo $value; ?></td>
																						</tr>
																					<?php //endforeach; ?>
																				</table>
																			</div>
																		<?php //endif; ?>
																	<?php //endforeach; ?>
																	<div class="form-group col-md-12">
																	</div>
																	<div class="clearfix"></div>
																</div>
									
																<!-- CQP Tab -->
																<div class="tab-pane" id="CQP">
																	<div class="row">
																		<label class="col-md-3 control-label">CQP Import Date</label>
																		<div class="col col-md-3">
																			<select class="form-control js-cqp-import-select">
																			<!-- *** TODO: uncomment once $importLocation is called in *** -->
																			<?php //foreach ($this->request->data['ImportLocation'] AS $importLocation): ?>
																				<?php //if ($importLocation['Import']['type'] == 'cqp'): ?>
																					<option value="<?php echo '1' //Populate with dummy value for now $importLocation['import_id']; ?>">
																						<?php //echo date('F d, Y', strtotime($importLocation['Import']['created'])); ?>
																					</option>
																				<?php //endif; ?>
																			<?php //endforeach; ?>
																			</select>
																		</div>
																	</div>
																	<?php $hideFields = ['id', 'import_id', 'location_id', 'match_type', 'notes', 'id_external', 'id_oticon', 'is_retail']; ?>
																	<?php //foreach ($this->request->data['ImportLocation'] as $importLocation): ?>
																		<?php //if ($importLocation['Import']['type'] == 'cqp'): ?>
																			<div class="cqpImport col-md-11 col-md-offset-1" import="<?php //echo $importLocation['import_id']; ?>">
																				<br><br>
																				<table class="table table-striped table-bordered table-condensed">
																					<?php //foreach ($importLocation AS $label => $value): ?>
																						<?php //if (is_array($value) || in_array($label, $hideFields)) { continue; } ?>
																						<?php /*
																						switch ($label) {
																							case "zip":
																								$label = Configure::read('zipLabel');
																								break;
																							case "state":
																								$label = Configure::read('stateLabel');
																								break;
																							case "id_external":
																								$label = $externalIdLabel;
																								break;
																							default:
																								break;
																						} */?>
																						<tr>
																							<th class="text-right col-md-3"><?php //echo ucfirst(str_replace('_', ' ', $label)); ?></th>
																							<td class="col-md-9" style="word-break: break-word;"><?php //echo $value; ?></td>
																						</tr>
																					<?php //endforeach; ?>
																				</table>
																				<?php //echo $this->Clinic->cqpImportNotes($importLocation['notes']); ?>
																			</div>
																		<?php //endif; ?>
																	<?php //endforeach; ?>
																	<div class="form-group col-md-12">
																	</div>
																	<div class="clearfix"></div>
																</div>
															</div>
														</div>
													</div>
													
													<!-- CA Import Tab -->
													<?php if (!Configure::read('isYhnImportEnabled')): ?>
														<div class="tab-pane" id="Import">
															<div class="row">
																<label class="col-md-3 control-label">Import Date</label>
																<div class="col col-md-3">
																	<select class="form-control js-import-select">
																	<?php //foreach ($this->request->data['ImportLocation'] AS $importLocation): ?>
																		<option value="<?php echo $importLocation['import_id']; ?>">
																			<?php //echo date('F d, Y', strtotime($importLocation['Import']['created'])); ?>
																		</option>
																	<?php //endforeach; ?>
																	</select>
																</div>
															</div>
															<?php $hideFields = ['id', 'import_id', 'location_id', 'match_type', 'notes', 'id_cqp_practice', 'id_cqp_office']; ?>
															<?php //foreach ($this->request->data['ImportLocation'] AS $importLocation): ?>
															<div class="import col-md-11 col-md-offset-1" import="<?php echo $importLocation['import_id']; ?>">
																<br /><br />
																<table class="table table-striped table-bordered table-condensed">
																	<?php //foreach ($importLocation AS $label => $value): ?>
																		<?php //if (is_array($value) || in_array($label, $hideFields)) { continue; } ?>
																		<?php /*
																		switch ($label) {
																			case "zip":
																				$label = Configure::read('zipLabel');
																				break;
																			case "state":
																				$label = Configure::read('stateLabel');
																				break;
																			case "id_external":
																				$label = $externalIdLabel;
																				break;
																			default:
																				break;
																		} */?>
																		<tr>
																			<th class="text-right col-md-3"><?php //echo ucfirst(str_replace('_', ' ', $label)); ?></th>
																			<td class="col-md-9"><?php //echo $value; ?></td>
																		</tr>
																	<?php //endforeach; ?>
																</table>
															</div>
															<?php //endforeach; ?>
															<div class="form-group col-md-12">
															</div>
															<div class="clearfix"></div>
														</div>
													<?php endif; ?>
													
													<!-- Filters Tab -->
													<div class="tab-pane" id="Filters">
														<div class="control-group mb20">
															<div class="controls">
																<div class="btn-group">
																	<?php //echo $this->Html->link('<span class="glyphicon glyphicon-refresh"></span> Update Filters', array('action' => 'update_filters', $id, '#' => 'Filters'), array('escape' => false, 'class' => 'btn btn-xs btn-default')); ?>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="col col-md-9 col-md-offset-3">
																	<?= $this->Form->control('filter_has_photo', [
																		'label' => [
																			'class' => 'col control-label',
																			'text' => 'Has Photo',
																		],
																		'type' => 'checkbox',
																		'class' => ''
																	]); ?>
																</div>
																<div class="col col-md-9 col-md-offset-3">
																	<?= $this->Form->control('filter_insurance', [
																		'label' => [
																			'class' => 'col control-label',
																			'text' => 'Accepts Insurance',
																		],
																		'type' => 'checkbox',
																		'class' => ''
																	]); ?>
																</div>
																<div class="col col-md-9 col-md-offset-3">
																	<?= $this->Form->control('filter_evening_weekend', [
																		'label' => [
																			'class' => 'col control-label',
																			'text' => 'Evening or Weekend Hours',
																		],
																		'type' => 'checkbox',
																		'class' => ''
																	]); ?>
																</div>
															</div>
															<div class="col-md-6">
																<div class="col col-md-9 col-md-offset-3">
																	<?= $this->Form->control('filter_adult_hearing_test', [
																		'label' => [
																			'class' => 'col control-label',
																			'text' => 'Adult Hearing Test',
																		],
																		'type' => 'checkbox',
																		'class' => ''
																	]); ?>
																</div>
																<div class="col col-md-9 col-md-offset-3">
																<?= $this->Form->control('filter_hearing_aid_fitting', [
																	'label' => [
																		'class' => 'col control-label',
																		'text' => 'Hearing Test Aid Fitting',
																	],
																	'type' => 'checkbox',
																	'class' => ''
																]); ?>
																</div>
															</div>
														</div>
													</div>
													
													<!-- Admin Tab -->
													<div class="tab-pane" id="Admin">
														<table class="table table-striped table-bordered table-condensed">
															<tr>
																<th class="col-md-3 tar">Date Created</th>
																<!-- *** TODO: build dateTimeCentralToEastern *** -->
																<td class="col-md-9"><?php //echo dateTimeCentralToEastern($location->created); ?></td>
															</tr>
															<tr>
																<th class="col-md-3 tar">Last Modified</th>
																<td class="col-md-9"><?php //echo dateTimeCentralToEastern($location->modified); ?></td>
															</tr>
														</table>
														<?= $this->Form->control('redirect'); ?>
														<?= $this->Form->control('is_retail', [
																'label' => 'WDH Retail',
																'type' => 'select',
																'options' => [
																	0 => 'No',
																	1 => 'Yes',
																],
																'default' => 0,
															]);
														?>
														<?php if (Configure::read('isYhnImportEnabled')): ?>
															<?= $this->Form->control('is_cq_premier', [
																	'label' => 'CQ Premier',
																	'type' => 'select',
																	'options' => [
																		0 => 'No',
																		1 => 'Yes',
																	],
																	'default' => 0,
																]);
															?>
															<?= $this->Form->control('is_iris_plus', [
																	'label' => 'Iris+',
																	'type' => 'select',
																	'options' => [
																		0 => 'No',
																		1 => 'Yes',
																	],
																	'default' => 0,
																	'help_block' => 'If clinic is Iris+, select both "CQ Premier" and "Iris+"',
																]);
															?>
														<?php endif; ?>
														<?= $this->Form->control('is_junk', [
																'label' => 'Junk',
																'type' => 'select',
																'options' => [
																	0 => 'No',
																	1 => 'Yes',
																],
																'default' => 0,
															]);
														?>
														<div class="col col-md-9 col-md-offset-3 pl0">
															<?= $this->Form->control('is_email_allowed', [
																'label' => [
																	'class' => 'control-label',
																	'text' => 'Allow email notifications for profile updates'
																]
															]); ?>
														</div>
														<?php if (Configure::read('isTieringEnabled')): ?>
															<div class="col col-md-9 col-md-offset-3 pl0">
																<?= $this->Form->control('is_service_agreement_signed', [
																	'label' => [
																		'class' => 'control-label',
																		'text' => 'Service agreement signed'
																	]
																]); ?>
															</div>
															<strong class="col col-md-9 col-md-offset-2">Premier Features -- Individual purchase</strong>
															<div class="row col-md-12 mb25<?php if($location->is_cqp){echo ' panel-disabled';}?>">
																<div class="col col-md-9 col-md-offset-3">
																	<?= $this->Form->control('feature_content_library', [
																		'label' => [
																			'class' => 'control-label',
																			'text' => 'Social media library'
																		]
																	]); ?>
																</div>
																<div id="content-library-expiration" class="col col-md-6" style="display:none;">
																	<?php
																	echo $this->Form->control('content_library_expiration', [
																		'label' => 'Expires',
																		'type' => 'text',
																		'class' => 'form-control datepicker',
																		'div' => 'form-group mb0',
																		'autocomplete' => 'off'
																	]);
																	?>
																</div>
															</div>
														<?php endif; ?>
														<hr class="clearfix">
														<div id="versions">
															<a href="#" id="load-versions" class="btn btn-info">Load Versions</a> <img id="version-loader" src="/img/ajax-loader.gif" class="hide">
														</div>
													</div>
													<?php endif; ?>
												<?php endif; ?>
						                		</div>
											</div>
						                </div>
						            </fieldset>
						            <?php
					                    echo '<div class="form-actions tar clearfix">';
					                    echo $this->Form->button(__('Save Location'), ['class' => 'btn btn-primary btn-lg']);
					                    echo '</div>';
						            ?>
						            <?= $this->Form->end() ?>
						        </div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>