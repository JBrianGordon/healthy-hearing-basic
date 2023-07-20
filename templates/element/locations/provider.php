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
	<p class="col-md-9 col-md-offset-3 red">This provider isn't showing because it is lacking details. Please fill out this section completely.</p>
	<?php endif; ?>
	<?php if($hidingBasicProviders) : ?>
		<p class="col-md-9 col-md-offset-3 red">This staff person is not currently showing on the public-facing profile because this profile is currently basic. <a href="/clinic">Upgrade your profile to enhanced or premier</a> to show more than one staff member. You can move your preferred provider to the top position with the up and down arrows.</p>
	<?php endif; ?>
	<?php
		echo $this->Form->input("Provider." . $key . ".id", ['value'=>$provider->id ?? '']);
		if (!empty($provider->id)) {
			echo $this->Html->link('Delete Provider', ['controller' => 'providers', 'action' => 'delete', $provider->id, isset($locationId) ? $locationId : ''], ['class' => 'btn btn-danger btn-xs'], 'Are you sure?');
		}
		echo '<span id="provider' . $key . 'First" class="clinic-anchor"></span>';
		echo $this->Form->input("Provider." . $key . ".first_name", ['required' => false, 'value'=>$provider->first_name ?? '']);
		if (!$clinic):
			echo $this->Form->input("Provider." . $key . ".middle_name", ['value'=>$provider->middle_name ?? '']);
		endif;
		echo '<span id="provider' . $key . 'Last" class="clinic-anchor"></span>';
		echo $this->Form->input("Providers." . $key . ".last_name", ['required' => false, 'value'=>$provider->last_name ?? '']);
		echo $this->Form->input("Provider." . $key . ".email", ['value'=>$provider->email ?? '']);
	?>

	<?php if (Configure::read('showProviderCredentialButtons')): ?>
		<div class="form-group mb5">
			<label class="col col-md-3 control-label">Credentials</label>
			<div class="col col-md-9">
				<?php echo $this->Clinic->credSelect($provider->credentials ?? ''); ?>
			</div>
		</div>
		<?php echo $this->Form->input("Provider." . $key . ".credentials", ['label' => false, 'wrapInput' => 'col col-md-9 col-md-offset-3', 'value'=>$provider->credentials ?? '']); ?>
	<?php else: ?>
		<?php echo $this->Form->input("Provider." . $key . ".credentials", ['value'=>$provider->credentials ?? '']); ?>
	<?php endif; ?>

	<?php
		$credentials = isset($this->request->data['Provider'][$key]['credentials']) ? $this->request->data['Provider'][$key]['credentials'] : '';
		$calculatedTitle = $this->Clinic->getProviderTitle($credentials);
		echo $this->Form->input("Provider." . $key . ".title", [
			'placeholder' => $calculatedTitle, 'value' => $provider->title ?? ''
		]);
	?>

	<?php
		if (!empty($this->request->data['Provider'][$key]['description'])) {
			// Ckeditor doesn't handle office namespace tags well
			$this->request->data['Provider'][$key]['description'] = str_replace('<o:', '<', $this->request->data['Provider'][$key]['description']);
			$this->request->data['Provider'][$key]['description'] = str_replace('</o:', '</', $this->request->data['Provider'][$key]['description']);
		}
		echo '<span id="provider' . $key . 'Desc" class="clinic-anchor"></span>';
		echo '<div class="col-md-9 col-md-offset-3"><small>Tell us about you! What makes you different from other hearing professionals? Why should customers choose your clinic over others?</small></div>';
		echo $this->Form->input("Provider." . $key . ".description", ['required' => false, 'value' => $provider->description ?? '']);
		//*** TODO: update when CKEditor is ready ***
		//echo $this->Ckeditor->replace("Provider" . $key . "Description", ['var_name' => "Provider" . $key . "Description", 'height'=>'200', 'var_name' => "Provider" . $key . "Description"]);
		echo '<span id="upsellMessage' . $key .'" class="text-danger pb20 col-xs-12 tar" style="display:none">Want to add more text? Upgrade your profile to remove the character limits. Click <a href="/clinic/pages/faq#upgrades" target="_blank">here</a> to learn more about upgrading.</span>';
		if (!$clinic):
			if (Configure::read('showProviderAudOrHis')) {
				echo $this->Form->input('Provider.' . $key . '.aud_or_his', [
					'label' => 'Audiologist or HIS',
					'disabled' => 'disabled'
				]);
			}
			echo $this->Form->input('Provider.' . $key . '.is_ida_verified', [
					'div' => false,
					'label' => [
						'class' => 'col control-label switch boolean-switch ida-verified',
						'text' => 'Ida verified provider',
					],
					'type' => 'checkbox',
					'class' => '',
					'wrapInput' => 'col-md-12'
			]);
		endif;
	?>

	<div class="form-group">
		<div class="col-md-4 col-md-offset-2">
			<?php echo $this->Form->input("Provider." . $key . ".order", ['label' => 'Order', 'value' => $key + 1, 'id'=>"order-" . $key, 'readonly'=>true, 'help_block' => '1 = top', 'class' => 'provider-order']);	?>
		</div>
		<div class="col-md-6">
			<p>
				<?php echo $this->Html->link('Move Up &#8679;', '#', ['class' => 'btn btn-default btn-xs btn-block js-provider-up', 'provider' => $key, 'escape' => false]); ?>
				<?php echo $this->Html->link('Move Down &#8681;', '#', ['class' => 'btn btn-default btn-xs btn-block js-provider-down', 'provider' => $key, 'escape' => false], []); ?>
			</p>
		</div>
	</div>
	<?php
		if (isset($this->request->data['Provider'][$key])) {
			echo '<span id="provider' . $key . 'Photo" class="clinic-anchor"></span>';
			if (!empty($this->request->data['Provider'][$key]['thumb_url'])) {
				echo $this->Form->input("Provider." . $key . ".thumb_url", ['label' => 'Current photo', 'value' => $provider->thumb_url ?? '']);
				echo '<div class="btn btn-danger btn-xs provider-photo-delete pull-right" data-target="Provider' . $key . 'ThumbUrl">Delete Photo</div>';
			}
			echo "<div class='form-group'><div class='col col-md-9 col-md-offset-3'>" . $this->Clinic->providerImage($this->request->data['Provider'][$key]) . "</div></div>";
		}
		if (function_exists("imagecreate")) {
			echo $this->Form->input("Provider." . $key . ".file", ['type' => 'file', 'label' => 'Upload Image', 'value' => $provider->image_url ?? '']);
			echo '<span class="help-block text-danger tar" style="display:none" id="provider-photo-add-error-' . $key . '">Please resize this photo to under 2MB before uploading. If you need help resizing the photo, please email the photo to <a href="mailto:' . Configure::read("customer-support-email") .'">' . Configure::read("customer-support-email") .'</a> and we\'ll be happy to assist you.</span><p class="help-block text-right">Photos must be JPG format and less than 2MB. To add a photo, click on "Choose File".</p>';
		} else {
			echo "<div class='col-md-offset-3 alert alert-danger'>Unable to upload new images. Need to install the GD library on this server to access the 'imagecreate' function.</div>";
		}
	?>
</div>
