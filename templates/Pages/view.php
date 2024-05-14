<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Page $page
 */

	use Cake\Core\Configure;
	
	$this->Html->script('dist/common.min', ['block' => true]);
?>
<div class="container-fluid site-body fap-cities">
  <div class="row">
    <div class="backdrop-container">
      <div class="backdrop backdrop-gradient backdrop-height"></div>
    </div>
    <div class="container">
      <div class="row pt20">
        <div class="col-md-12">
    	  <section class="panel">
    		<div class="panel-body">
  			  <div class="panel-section expanded">
    			<div class="p20">
    			  <?= $page->content ?>
    			</div>
    		  </div>
        	</div>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>