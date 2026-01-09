<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corp[]|\Cake\Collection\CollectionInterface $corps
 */
 
$this->Vite->script('common','common-vite');
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'Hearing aid and cochlear implant companies', 'url' => ''],
]);
?>
<div class="container-fluid site-body blog">
	<div class="row">
	    <div class="backdrop backdrop-gradient backdrop-height"></div>
	    <div class="container">
	    	<div class="row noprint">
				<header class="col-md-12 inverse">
					<?= $this->Breadcrumbs->render() ?>
					<?= $this->element('breadcrumb_schema') ?>
					<div id="ellipses">...</div>
				</header>
			</div>
			<div class="row page-content">
				<div class="col-lg-9 float-start">
				  <section class="panel">
				    <div class="panel-body">
				      <div class="panel-section expanded">
				        <h1 class="text-primary">Hearing aid manufacturers</h1>
						<p><?php echo $pageContent; ?></p>
				        <?php foreach ($corps as $corp): ?>
					        <div class="well manufacturer" id="manufacturer-<?= $corp->id ?>">
					          <div class="row">
					            <div class="col-xl-3 gutter-below">
						            <div class="logo-container">
													<img src="<?= $corp->logo_url ?>" loading="lazy" alt="<?= $corp->title ?>" class="img-responsive align-center" width="150px">
						            </div>
					            </div>
					            <div class="col-xl-9">
					              <p>
					                <?= $corp->short ?>
					              </p>
					              <p>
					              	<a href="<?= $corp->hh_url['slug'] ?>" class="text-link">Read more about <?= $corp->title ?></a>
					              </p>
					            </div>
					          </div>
					        </div>
				      	<?php endforeach; ?>
				      </div>
				    </div>
				  </section>
				</div>
				<?= $this->element('side_panel') ?>
			</div>
	    </div>
	</div>
</div>
<script>
  // May want to consider making this an export module if image height/width needed on other pages.
  window.onload = function() {
    const images = document.querySelectorAll('.img-responsive.align-center');

    images.forEach(image => {
      image.setAttribute('height', `${image.height}px`);
    });
  };
</script>