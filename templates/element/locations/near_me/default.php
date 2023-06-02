<ul class="no-bullets text-small">
    <?php foreach($clinicsNearMe as $distance => $location): ?>
        <li>
            <?php echo $this->Html->link($location->title, $location->hh_url, ['class' => 'text-link']); ?>
        </li>
    <?php endforeach; ?>
</ul>
