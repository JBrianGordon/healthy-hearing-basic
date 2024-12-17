<?php
use Cake\Core\Configure;
?>

<?php $hidingBasicProviders = (Configure::read('country') != 'CA' && $isBasicClinic && $key >= 1 && empty($new)); ?>
<div class="well provider" provider="<?= $key ?>">
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
		echo $this->Form->hidden("providers." . $key . ".id", ['value'=>$provider->id ?? '']);
		if (!empty($provider->id)) {
			echo $this->Html->link('Delete Provider', ['controller' => 'providers', 'action' => 'delete', $provider->id, isset($locationId) ? $locationId : ''], ['class' => 'btn btn-danger btn-xs'], 'Are you sure?');
		}
		echo '<span id="provider' . $key . 'First" class="clinic-anchor"></span>';
		echo '<div class="form-group">';
			echo $this->Form->control("providers." . $key . ".first_name", ['label'=> ['class' => 'col col-sm-3 control-label'], 'class' => 'col-sm-9 mb10', 'required' => false, 'value'=>$provider->first_name ?? '']);
		echo '</div>';
		if (!$clinic):
			echo '<div class="form-group">';
				echo $this->Form->control("providers." . $key . ".middle_name", ['label'=> ['class' => 'col col-sm-3 control-label'], 'class' => 'col-sm-9 mb10', 'value'=>$provider->middle_name ?? '']);
			echo '</div>';
		endif;
		echo '<span id="provider' . $key . 'Last" class="clinic-anchor"></span>';
		echo '<div class="form-group">';
			echo $this->Form->control("providers." . $key . ".last_name", ['label'=> ['class' => 'col col-sm-3 control-label'], 'class' => 'col-sm-9 mb10', 'required' => false, 'value'=>$provider->last_name ?? '']);
		echo '</div>';
		echo '<div class="form-group">';
			echo $this->Form->control("providers." . $key . ".email", ['label'=> ['class' => 'col col-sm-3 control-label'], 'class' => 'col-sm-9 mb10', 'value'=>$provider->email ?? '']);
		echo '</div>';
	?>

	<?php if (Configure::read('showProviderCredentialButtons')): ?>
		<div class="form-group mb5">
			<label class="col col-sm-3 control-label">Credentials</label>
			<div class="col col-sm-9 p0">
				<?= $this->Clinic->credSelect("providers-" . $key . "-credentials") ?>
			</div>
		</div>
		<?php
			echo '<div class="form-group"><div class="col col-sm-9 col-md-offset-3 mb10 p0">';
				echo $this->Form->control("providers." . $key . ".credentials", ['label' => false, 'value'=>$provider->credentials ?? '']); 
			echo '</div></div>';
		?>
	<?php else: ?>
		<?= $this->Form->control("providers." . $key . ".credentials", ['label'=> ['class' => 'col col-sm-3 control-label'], 'value'=>$provider->credentials ?? '']) ?>
	<?php endif; ?>

	<?php
	$credentials = isset($provider->credentials) ? $provider->credentials : '';
	$calculatedTitle = $this->Clinic->getProviderTitle($credentials);
	?>
	<div class="form-group">
		<?= $this->Form->control("providers." . $key . ".title", [
			'class' => 'col col-sm-9',
			'label' => ['text' => 'Title', 'class' => 'col-sm-3 control-label'],
			'required' => false,
			'placeholder' => $calculatedTitle,
			'value' => $provider->title ?? ''
		]); ?>
	</div>
	<?php
	if (!empty($provider->description)) {
		// Ckeditor doesn't handle office namespace tags well
		$provider->description = str_replace('<o:', '<', $provider->description);
		$provider->description = str_replace('</o:', '</', $provider->description);
	}
	?>
	<span id="provider{$key}Desc" class="clinic-anchor"></span>
	<div class="col-sm-9 col-md-offset-3">
		<small>Tell us about you! What makes you different from other hearing professionals? Why should customers choose your clinic over others?</small>
	</div>
	<?php
	echo $this->Form->control("providers." . $key . ".description", [
		'class' => 'editor',
		'required' => false
	]);
	echo '<span id="upsellMessage' . $key .'" class="text-danger pb20 col-xs-12 tar" style="display:none">Want to add more text? Upgrade your profile to remove the character limits. Click <a href="/clinic/pages/faq#upgrades" target="_blank">here</a> to learn more about upgrading.</span>';
	if (!$clinic) {
		if (Configure::read('showProviderAudOrHis')) {
			echo $this->Form->control('providers.' . $key . '.aud_or_his', [
				'label' => 'Audiologist or HIS',
				'disabled' => 'disabled'
			]);
		}
	}
	?>

	<div class="form-group clearfix">
		<div class="col-sm-4 col-sm-offset-2">
			<?= $this->Form->control("providers." . $key . ".priority", [
				'label' => [
					'text' => 'Order',
					'class' => 'col-sm-3 control-label'
				],
				'required' => true,
				'readonly'=>true,
				'class' => 'provider-priority col-sm-9'
			])?>
			<span class="help-block ml70">1 = top</span>
		</div>
		<div class="col-sm-3">
			<p>
				<?= $this->Html->link('Move Up &#8679;', '#', ['class' => 'btn btn-default btn-xs btn-block js-provider-up mb5', 'provider' => $key, 'escape' => false]) ?>
				<?= $this->Html->link('Move Down &#8681;', '#', ['class' => 'btn btn-default btn-xs btn-block js-provider-down mb5', 'provider' => $key, 'escape' => false], []) ?>
			</p>
		</div>
	</div>
	<?php
		if (isset($provider)) {
				if (!empty($provider->photo_name) && !empty($provider->photo_url)) {
		            preg_match("/assets\/(.*?)\/file/", $provider->photo_url, $matches);
		            $providerImageCkId = $matches[1];

					echo $this->Form->control("providers." . $key . ".photo_name", ['class' => 'col col-sm-9', 'label' => ['text' => 'Current photo', 'class' => 'col-sm-3 control-label'], 'value' => $provider->photo_name ?? '']);
					echo '<div class="btn btn-danger btn-xs provider-photo-delete-ck pull-right m10" data-target="providers-' . $key . '-thumb-url" data-provider-id="' . $key . '" data-provider-ck="'. $providerImageCkId .'">Delete Photo</div>';
					echo "<div class='form-group'><div class='profile-pic-container'><img id=provider-pic-" . $key . " src=". $provider->photo_url . " loading='lazy'</div></div>";
				}
				echo $this->Form->control("providers." . $key . ".photo_name", ['type' => 'file', 'label' => ['text' => 'Upload Image', 'class' => 'col-sm-3 control-label'], 'class' => 'provider-imageUpload col-sm-9 p15', 'data-provider-index' => $key]);
				echo '<img id="provider-imagePreview-' . $key . '" class="form-group col-md-offset-3" src="#" alt="Image Preview" style="display: none; max-width: 100px; max-height: 100px;" />';
		}
	?>
</div>