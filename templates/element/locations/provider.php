<?php
use Cake\Core\Configure;
?>

<?php $hidingBasicProviders = (Configure::read('country') != 'CA' && $isBasicClinic && $key >= 1 && empty($new)); ?>
<div class="well provider" provider="<?php echo $key; ?>">
	<?php if (!empty($new)): ?>
		<div class="control-group mb0">
			<div class="controls">
				<p><strong>New Provider</strong></p>
			</div>
		</div>
	<?php endif; ?>
	<?php if(empty($new) && empty($provider->title) && empty($provider->credentials) && empty($provider->thumb_url) && empty($provider->description) && !$hidingBasicProviders) : ?>
	<p class="col-sm-9 col-md-offset-3 red">This provider isn't showing because it is lacking details. Please fill out this section completely.</p>
	<?php endif; ?>
	<?php if($hidingBasicProviders) : ?>
		<p class="col-sm-9 col-md-offset-3 red">This staff person is not currently showing on the public-facing profile because this profile is currently basic. <a href="/clinic">Upgrade your profile to enhanced or premier</a> to show more than one staff member. You can move your preferred provider to the top position with the up and down arrows.</p>
	<?php endif; ?>
	<?php
		echo $this->Form->hidden("Provider." . $key . ".id", ['value'=>$provider->id ?? '']);
		if (!empty($provider->id)) {
			echo $this->Html->link('Delete Provider', ['controller' => 'providers', 'action' => 'delete', $provider->id, isset($locationId) ? $locationId : ''], ['class' => 'btn btn-danger btn-xs'], 'Are you sure?');
		}
		echo '<span id="provider' . $key . 'First" class="clinic-anchor"></span>';
		echo '<div class="form-group">';
			echo $this->Form->control("Provider." . $key . ".first_name", ['label'=> ['class' => 'col col-sm-3 control-label'], 'class' => 'col-sm-9 mb10', 'required' => false, 'value'=>$provider->first_name ?? '']);
		echo '</div>';
		if (!$clinic):
			echo '<div class="form-group">';
				echo $this->Form->control("Provider." . $key . ".middle_name", ['label'=> ['class' => 'col col-sm-3 control-label'], 'class' => 'col-sm-9 mb10', 'value'=>$provider->middle_name ?? '']);
			echo '</div>';
		endif;
		echo '<span id="provider' . $key . 'Last" class="clinic-anchor"></span>';
		echo '<div class="form-group">';
			echo $this->Form->control("Providers." . $key . ".last_name", ['label'=> ['class' => 'col col-sm-3 control-label'], 'class' => 'col-sm-9 mb10', 'required' => false, 'value'=>$provider->last_name ?? '']);
		echo '</div>';
		echo '<div class="form-group">';
			echo $this->Form->control("Provider." . $key . ".email", ['label'=> ['class' => 'col col-sm-3 control-label'], 'class' => 'col-sm-9 mb10', 'value'=>$provider->email ?? '']);
		echo '</div>';
	?>

	<?php if (Configure::read('showProviderCredentialButtons')): ?>
		<div class="form-group mb5">
			<label class="col col-sm-3 control-label">Credentials</label>
			<div class="col col-sm-9 p0">
				<?= $this->Clinic->credSelect("provider-" . $key . "-credentials") ?>
			</div>
		</div>
		<?php
			echo '<div class="form-group"><div class="col col-sm-9 col-md-offset-3 mb10 p0">';
				echo $this->Form->control("provider-" . $key . "-credentials", ['label' => false, 'value'=>$provider->credentials ?? '']); 
			echo '</div></div>';
		?>
	<?php else: ?>
		<?= $this->Form->control("Provider." . $key . ".credentials", ['label'=> ['class' => 'col col-sm-3 control-label'], 'value'=>$provider->credentials ?? '']) ?>
	<?php endif; ?>

	<?php
		$credentials = isset($provider->credentials) ? $provider->credentials : '';
		
		$calculatedTitle = $this->Clinic->getProviderTitle($credentials);
		echo '<div class="form-group">';
			echo $this->Form->control("Provider." . $key . ".title", ['class' => 'col col-sm-9', 
			'label' => ['text' => 'Title', 'class' => 'col-sm-3 control-label'], 'placeholder' => $calculatedTitle, 'value' => $provider->title ?? ''
		]);
		echo '</div>';
	?>

	<?php
		if (!empty($this->request->data['Provider'][$key]['description'])) {
			// Ckeditor doesn't handle office namespace tags well
			$this->request->data['Provider'][$key]['description'] = str_replace('<o:', '<', $this->request->data['Provider'][$key]['description']);
			$this->request->data['Provider'][$key]['description'] = str_replace('</o:', '</', $this->request->data['Provider'][$key]['description']);
		}
		echo '<span id="provider' . $key . 'Desc" class="clinic-anchor"></span>';
		echo '<div class="col-sm-9 col-md-offset-3"><small>Tell us about you! What makes you different from other hearing professionals? Why should customers choose your clinic over others?</small></div>';
		echo $this->Form->control("Provider." . $key . ".description", ['label' => ['class' => 'col-sm-3 tar control-label'], 'class' => 'col-sm-9 mb20 editor', 'required' => false, 'value' => $provider->description ?? '', 'cols' => '30', 'rows' => '6']);
		//*** TODO: update when CKEditor is ready ***
		//echo $this->Ckeditor->replace("Provider" . $key . "Description", ['var_name' => "Provider" . $key . "Description", 'height'=>'200', 'var_name' => "Provider" . $key . "Description"]);
		echo '<span id="upsellMessage' . $key .'" class="text-danger pb20 col-xs-12 tar" style="display:none">Want to add more text? Upgrade your profile to remove the character limits. Click <a href="/clinic/pages/faq#upgrades" target="_blank">here</a> to learn more about upgrading.</span>';
		if (!$clinic):
			if (Configure::read('showProviderAudOrHis')) {
				echo $this->Form->control('Provider.' . $key . '.aud_or_his', [
					'label' => 'Audiologist or HIS',
					'disabled' => 'disabled'
				]);
			}
		endif;
	?>

	<div class="col-md-12 mb20 form-group">
		<div class="checkbox form-check form-switch">
				<?= $this->Form->control('Provider.' . $key . '.is_ida_verified', [
					'type' => 'checkbox',
					'label' => ['class' => 'pl110 pr30 fw-bold form-check-label'],
					'class' => 'form-check-input'
					])
				?>
		</div>
	</div>
	<div class="form-group clearfix">
		<div class="col-sm-4 col-sm-offset-2">
			<?= $this->Form->control("Provider." . $key . ".order", ['label' => ['text' => 'Order', 'class' => 'col-sm-3 control-label'], 'value' => $key + 1, 'required' => true, 'id'=>"order-" . $key, 'readonly'=>true, 'class' => 'provider-order col-sm-9'])	?>
			<span class="help-block ml70">1 = top</span>
		</div>
		<div class="col-sm-6">
			<p>
				<?= $this->Html->link('Move Up &#8679;', '#', ['class' => 'btn btn-default btn-xs btn-block js-provider-up mb5', 'provider' => $key, 'escape' => false]) ?>
				<?= $this->Html->link('Move Down &#8681;', '#', ['class' => 'btn btn-default btn-xs btn-block js-provider-down mb5', 'provider' => $key, 'escape' => false], []) ?>
			</p>
		</div>
	</div>
	<?php
		if (isset($provider)) {
			echo '<span id="provider' . $key . 'Photo" class="clinic-anchor"></span>';
			if (!empty($provider->thumb_url)) {
				echo $this->Form->control("Provider." . $key . ".thumb_url", ['class' => 'col col-sm-9', 'label' => ['text' => 'Current photo', 'class' => 'col-sm-3 control-label'], 'value' => $provider->thumb_url ?? '']);
				echo '<div class="btn btn-danger btn-xs provider-photo-delete pull-right m10" data-target="Provider' . $key . 'ThumbUrl">Delete Photo</div>';
			}
			echo "<div class='form-group'><div class='col col-sm-9 col-md-offset-3'>" . $this->Clinic->providerImage($provider) . "</div></div>";
		}
		if (function_exists("imagecreate")) {
			echo $this->Form->control("Provider." . $key . ".file", ['type' => 'file', 'label' => ['text' => 'Upload Image', 'class' => 'col-sm-3 control-label'], 'value' => $provider->image_url ?? '', 'class' => 'col-sm-9 p15']);
			echo '<span class="help-block text-danger tar" style="display:none" id="provider-photo-add-error-' . $key . '">Please resize this photo to under 2MB before uploading. If you need help resizing the photo, please email the photo to <a href="mailto:' . Configure::read("customer-support-email") .'">' . Configure::read("customer-support-email") .'</a> and we\'ll be happy to assist you.</span><p class="help-block tar">Photos must be JPG format and less than 2MB. To add a photo, click on "Choose File".</p>';
		} else {
			echo "<div class='col-md-offset-3 alert alert-danger'>Unable to upload new images. Need to install the GD library on this server to access the 'imagecreate' function.</div>";
		}
	?>
</div>
