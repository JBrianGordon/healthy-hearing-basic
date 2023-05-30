<?php
    use Cake\Core\Configure;
    $countryCode = $_SESSION['geoLocData']['country'];
    extract(Configure::read('oticonCountries.' . $countryCode));
?>
<p>
    <?php
        echo $this->Html->image('/img/country_flags/' . $countryCode . '.svg', [
            'alt' => 'Flag of ' . $countryName,
            'width' => '40px',
            'height' => '40px',
            'class' => 'mr10 flag'
        ]);
    ?>
    <strong>Are you located in <?php echo $countryName; ?>?</strong>
</p>
<p>
    <?php if (! $isOticonSite): ?>
        Schedule a hearing test with <?php echo $this->Html->link($countrySiteName, $countrySiteURL,['class' => 'GEO-link-click', 'target' => '_blank', 'rel' => 'noopener']); ?>.
    <?php else: ?>
        Book a <?php echo $this->Html->link('hearing test near you', $countrySiteURL,['class' => 'GEO-link-click', 'target' => '_blank', 'rel' => 'noopener']); ?>.
    <?php endif; ?>
</p>
