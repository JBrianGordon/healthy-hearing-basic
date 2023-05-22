<?php
use Cake\Core\Configure;
$nearMeLink = $this->Clinic->nearMeLink();
?>
<p>
    <strong>Hearing <?php echo Configure::read('regionalSpelling.center'); ?>s close to me:
        <?php if ($zip = $_SESSION['geoLocData']['zip']): ?>
            <a href="<?php echo $nearMeLink; ?>"><?php echo $zip; ?></a>
        <?php endif; ?>
    </strong>
</p>
<div>
    <table class="table table-striped table-bordered">
        <?php foreach ($clinicsNearMe as $distance => $location): ?>
            <tr><td><?php echo $this->Text->truncate($this->Html->link($location->title, $location->hh_url, ['class' => 'text-link']), 40, ['html' => true]); ?></td></tr>
        <?php endforeach; ?>
    </table>
    <a href="<?php echo $nearMeLink; ?>" class="text-link"><strong>See more clinics near me</strong></a>
</div>
