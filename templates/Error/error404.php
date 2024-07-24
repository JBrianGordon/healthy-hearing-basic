<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Database\StatementInterface $error
 * @var string $message
 * @var string $url
 */

$this->layout = 'default';
$errorPage = true;

$this->assign('title', '404 Not Found');
?>
<div class="container-fluid site-body blog">
  <div class="row">
    <div class="backdrop backdrop-gradient backdrop-height"></div>
    <div class="container">
        <div class="row noprint mt20 mb40">
            <div class="col-lg-9 panel-parent float-start">
                <section class="panel">
					<div class="panel-body">
                        <div class="panel-section expanded">
                            <h1>Page not found</h1>
                            <p>We're sorry this error has occurred. There was a problem with the web page address, or this page no longer exists on Healthy Hearing.</p>
                            <p>Good news: We can help you find your way to the right place. Read through the options below to get back on track:</p>
                            <h2>Find trusted hearing clinics near me</h2>
                            <div class="col-md-6">
                                <form action="/search" id="FapMegaSearch" class="form-group" method="post" accept-charset="utf-8">
                                    <div style="display:none;">
                                        <input type="hidden" name="_method" value="POST">
                                    </div>	
                                    <div class="input-group">
                                        <input type="hidden" name="data[Location][search_id]" value="" id="LocationSearchId" class="auto-id">
                                        <label for="LocationSearch">Enter city or zip/postal code</label>
                                        <input name="data[Location][search]" class="form-control autocomplete float-start" placeholder="Enter city or ZIP" id="LocationSearch" type="text">
                                        <span class="input-group-btn float-end">
                                            <button class="btn btn-secondary rounded-0" id="LocationSearchBtn" type="submit">Search</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6 mb20 hidden-xs" style="height:62px"></div>
                            <h2>Browse our hearing health content</h2>
                            <p>Get informed with our <a href="/help/hearing-loss">hearing loss</a>, <a href="/help/hearing-aids">hearing aids</a>, <a href="/help/tinnitus">tinnitus</a> and <a href="/help">other help pages</a>.</p>
                            <h2>Need more help?</h2>
                            <p>Reach out and <a href="/contact-us">contact Healthy Hearing</a> if you have any additional questions.</p>
                        </div>
                    </div>
                </section>
            </div>
            <?= $this->element('side_panel', ['errorPage' => $errorPage]) ?>
        </div>
    </div>
  </div>
</div>