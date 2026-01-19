<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

$this->Breadcrumbs->add([['title' => 'Home', 'url' => '/'], ['title' => ('Learn about '.Configure::read('siteName')), 'url' => '/contact-us']]);

$this->Vite->script('clinic_library','common-vite');
?>
<div class="container-fluid site-body">
    <div class="row">
        <div class="backdrop-container noprint">
            <div class="backdrop backdrop-gradient backdrop-height"></div>
        </div>
        <div class="container">
            <div class="row pt20">
                <div class="col-md-12">
                    <section class="panel">
                        <div class="panel-body clinicLayout">
                            <div class="panel-section expanded">
								<h1>Social media sharing library</h1>
								<div class="row mb30">
									<div class="col-sm-8">
										<?= $pageContent ?>
									</div>
									<div class="col-sm-4">
										<a href="#libraryExampleModal" data-bs-toggle="modal">
											<img style="width: 314px; height: 329px;" src="/img/library-facebook-example.png" alt="Library item example usage">
											<em>Click image to enlarge</em>
										</a>
									</div>
								</div>
								<div id="items-container">
									<?php foreach($libraryItems as $index => $libraryItem): ?>
										<?php
											$modalId = "libraryItemModal{$index}";
											$modalIdTarget = "#{$modalId}";
											$modalIdTitle = "{$modalId}Title";
										?>
										<div class="library-item">
											<div class="item-tile mb20">
												<p class="item-title hidden">
													<?= $libraryItem['title']?>
												</p>
												<p class="item-alt-title hidden">
													<?= $libraryItem['alt_title']?>
												</p>
												<p class="item-title-head hidden">
													<?= $libraryItem['title_head']?>
												</p>
												<p class="item-sub-titles hidden">
													<?php
														preg_match_all('|<h[^>]+>(.*)</h[^>]+>|iU', $libraryItem['body'], $headings );
														foreach($headings[1] as $heading){
															echo $heading . ", ";
														}
													?>
												</p>
												<img class="item-tile-image" loading="lazy" src="<?= $libraryItem['facebook_image'] ?>" alt="">
												<div class="item-tile-title">
													<p class="mb5 mr5">
														<strong><?= $libraryItem['title'] ?></strong>
													</p>
													<a href="https://www.facebook.com/sharer/sharer.php?u=<?= Router::url($libraryItem['hh_url'], true) ?>" class="btn btn-share btn-facebook" style="font-size:16px" target="_blank" rel="noopener" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;"><span class="hh-icon-facebook"></span> SHARE NOW</a>
													<a href="#" data-bs-toggle="modal" data-bs-target="<?= $modalIdTarget ?>">More options</a>
												</div>
											</div>
											<!-- Modal -->
											<div class="modal fade" id="<?= $modalId ?>" tabindex="-1" role="dialog" aria-labelledby="<?= $modalIdTitle ?>">
												<div class="modal-dialog modal-lg" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
																<span>&times;</span>
															</button>
															<h4 class="modal-title" id="<?= $modalIdTitle ?>">
																Preview: <?= $libraryItem['title'] ?>
															</h4>
														</div>
														<div class="modal-body row">
															<div class="col-md-8 item-modal-body">
																<?php
																	$htmlContent = $libraryItem['body'];
																	$modifiedHtml = str_replace(' src', ' data-src', $htmlContent);
																	echo $modifiedHtml;
																?>
															</div>
															<div class="col-md-4">
																<strong>Suggested social media message</strong>
																<p class="item-share-text mb10"><em><?= $libraryItem['library_share_text'] ?></em></p>
																<button class="copy btn btn-neutral btn-sm">Copy text</button>
																<br>
																<hr class="m10">
																<strong>Share with your followers:</strong>
																<br>
																<a href="https://www.facebook.com/sharer/sharer.php?u=<?= Router::url($libraryItem['hh_url'], true) ?>" class="btn btn-share btn-facebook mb10" style="font-size:16px" target="_blank" rel="noopener" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;"><span class="hh-icon-facebook"></span> SHARE NOW</a>
																<br>
																<a href="https://twitter.com/intent/tweet?url=<?= Router::url($libraryItem['hh_url'], true) ?>&text=" class="btn btn-share btn-twitter" target="_blank" rel="noopener" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;"><span class="hh-icon-x"></span> Tweet</a>
																<hr class="m10">
																<a href="<?= Router::url($libraryItem['hh_url'], true) ?>" class="btn btn-neutral btn-sm" target="_blank">See full article</a>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="libraryExampleModal" tabindex="-1" role="dialog" aria-labelledby="libraryExampleModalTitle">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span>&times;</span>
				</button>
				<h4 class="modal-title" id="libraryExampleModalTitle">
					Example of shared <?= Configure::read('siteName') ?> content
				</h4>
			</div>
			<div class="modal-body row">
				<img loading="lazy" style="width: 100%;" src="/img/library-facebook-example.png">
			</div>
		</div>
	</div>
</div>