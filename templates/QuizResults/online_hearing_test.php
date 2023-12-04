<?php
/**
 * @var \App\View\AppView $this
 */

	use Cake\Core\Configure;

	$this->Breadcrumbs->add([['title' => 'Home', 'url' => '/'], ['title' => ('Online hearing test')]]);

	$this->Html->script('dist/online_hearing_test.min', ['block' => true]);
?>
<div class="container-fluid site-body blog">
  <div class="row">
    <div class="backdrop backdrop-gradient backdrop-height"></div>
    <div class="container">
      <div class="row noprint">
        <div class="col-sm-9 inverse">
            <?= $this->Breadcrumbs->render(); ?>
            <?= $this->element('breadcrumb_schema') ?>
            <div id="ellipses">...</div>
        </div>
	  </div>
      <div class="row page-content">
		<div class="col-sm-9">
			<article class="panel hearing-test">
			<div class="panel-body">
				<div class="panel-section expanded">
					<h1 class="text-primary" id="start-h1">How's your hearing?</h1>
					<h2 id="result-h2" class="text-primary" style="display:none;">Your hearing test results</h2>
					<div id="start-test" class="test-start clear">
						<img src="/img/quiz/hh19-free-online-hearing-test.jpg" width="450" height="300" class="img-rounded img-responsive center-block mb30" alt="A woman struggles to hear a friend talking">
						<p class="lead text-primary">Hearing loss is a touchy subject that can bring out the procrastinator in even the best of us. If you think you have hearing loss, take our free online hearing test and then schedule an appointment for a complete hearing assessment at a hearing clinic near you.</p>
						<p>The questions on this online hearing test can help you prepare for your first appointment with an audiologist or hearing aid specialist.</p>
						<div class="mt5 mb20 text-center">
							<a href="#HearingTest" role="button" onclick="HT.reset();" class="btn btn-light btn-large" data-bs-toggle="modal">Launch Online Hearing Test <span class="glyphicon glyphicon-play glyphicon-white"></span></a>
						</div>
						<p>After you take the test, <a href="<?=$this->Clinic->nearMeLink() ?>" target="_blank">visit our directory</a> to find a hearing clinic near you. Take the first step to improve your quality of life through better hearing today!</p>
					</div>

					<!-- Hearing test results -->
					<div id="Results" style="display:none;">
						<div id="test-result" style="display:none;">
							<div id="test-result-normal" style="display:none;">
								<div class="well">
									<img src="/img/quiz/hearing-test-icon-stoplight-green.png" alt="Green stoplight" width="195" height="195" loading="lazy" class="pull-left img-rounded p10">
									<p class="lead">
										Congratulations! The results of your online hearing test indicate you likely have normal hearing. You don’t report having difficulty hearing and understanding in many of the common situations people with hearing loss find challenging.
									</p>
								</div>
								<h2>What do I do next?</h2>
								<p>Now is the time to keep your good hearing in top shape with a combination of hearing protection, a healthy lifestyle and regular hearing screenings to monitor for any changes.</p>
								<?= $this->element('hearingtest/header_line', ['text' => 'Schedule a baseline hearing test with a clinic near you']) ?>
							</div>

							<div id="test-result-possible" style="display:none;">
								<div class="well">
									<div class="row">
										<div class="span3 col-sm-4">
											<img src="/img/quiz/hearing-test-icon-stoplight-yellow.png" alt="Yellow stoplight" width="195" height="195" loading="lazy" class="pull-left img-rounded p10">
										</div>
										<div class="span7 col-sm-8">
											<p class="lead">
												The results of your online hearing test indicate you may have hearing loss. You reported having at least occasional difficulty in some listening situations that are challenging for people who are losing their hearing.
											</p>
										</div>
									</div>
								</div>
								<h2>What do I do next?</h2>
								<p>Even a mild hearing loss can have significant effects on your relationships, work life and overall quality of life. Take the next step and schedule an appointment with a local audiologist or hearing aid specialist to assess your hearing and get help to improve and protect the hearing you have left.</p>
								<?= $this->element('hearingtest/header_line', ['text' => 'Schedule a hearing test with a clinic near you']) ?>
								<p>The sooner you find out more about your hearing loss and possible treatments, the more successful you’ll be at improving your hearing.</p>
							</div>

							<div id="test-result-significant" style="display:none;">
								<div class="well">
									<div class="row">
										<div class="span3">
											<img src="/img/quiz/hearing-test-icon-stoplight-red.png" alt="Red stoplight" width="195" height="195" loading="lazy" class="pull-left img-rounded p10">
										</div>
										<div class="span7">
											<p class="lead">
												The results of your online hearing test indicate you likely have a significant hearing loss. You reported frequently having difficulty in most of the same listening situations as others with hearing loss.
											</p>
										</div>
									</div>
								</div>
								<h2>What do I do next?</h2>
								<p>Maybe you’ve already been told you have hearing loss.</p>
								<p>Many people wait years to seek help for their hearing loss once they become aware of it. Meanwhile, your relationships, work life and even other aspects of your health can suffer greatly. Don’t let this happen to you!</p>
								<?= $this->element('hearingtest/header_line', ['text' => 'Schedule a hearing test with a clinic near you']) ?>
								<p>Seek help now so you can get back to enjoying life right away.</p>
							</div>
						</div>

						<div id="near-me-results">
							<?= $this->element($this->Clinic->nearMe($clinicsNearMe)) ?>
						</div>
						<?php if (Configure::read('showNewsletter')): ?>
							<?= $this->element('hearingtest/header_line', ['text' => 'Learn more about hearing loss and keep in touch'])?>
							<p>Sign up for our newsletter!</p>
							<?php
								echo $this->Form->create(null, [
									'id' => 'HearingTestNewsletterForm',
									'class' => 'form-horizontal mb10'
								]);
								echo $this->Form->control('first_name', [
									'label' => ['class' => 'col-sm-3 control-label'],
									'id' => 'newsletterFirstName',
									'placeholder' => 'First name',
									'class' => 'mb20 col-sm-9'
								]);
								echo $this->Form->control('last_name', [
									'label' => ['class' => 'col-sm-3 control-label'],
									'id' => 'newsletterLastName',
									'placeholder' => 'Last name',
									'class' => 'mb20 col-sm-9'
								]);
								echo $this->Form->control('email', [
									'label' => ['class' => 'col-sm-3 control-label'],
									'id' => 'newsletterEmail',
									'placeholder' => 'Email',
									'class' => 'mb20 col-sm-9',
									'required' => true
								]);
							?>
								<div id="subscribe_error" class="tal text-error alert alert-danger" style="display:none;"></div>
								<div class="g-recaptcha"
									 data-sitekey="<?= Configure::read('recaptchaPublicKey') ?>"
									 data-callback='submitNewsletterSignup'
									 data-size="invisible">
								</div>
								<div class="tar">
									<?= $this->Form->button('Sign up', [
											'id' => 'submitBtnNewsletterHearingTest',
											'type' => 'submit',
											'class' => 'btn btn-lg btn-primary',
										])
									?>
								</div>
								<small class="help-block tar p20">This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" rel="noopener" target="_blank">Privacy Policy</a> and <a href="https://policies.google.com/terms" rel="noopener" target="_blank">Terms of Service</a> apply.</small>
							<?= $this->Form->end() ?>
							<div id="subscribe_success" class="tal text-error alert alert-success" style="display:none;">
								<p>Thank you for subscribing to our newseltter!</p>
								<br>
								<p>Please check your inbox for a confirmation message from Healthy Hearing with the subject line: <strong>Healthy Hearing Newsletter: Please Confirm Subscription</strong>.</p>
								<br>
								<p>You will need to click a link listed in this message to activate your subscription. If you don't see a confirmation e-mail within the next few minutes, please check your spam/junk folder.</p>
							</div>
						<?php endif; ?>
						<?= $this->element('hearingtest/header_line', ['text' => 'Want to try again?']) ?>
						<p>Surprised by your result? Feel free to retake the test!</p>
						<div class="mt30 tac">
							<a href="#HearingTest" role="button" onclick="HT.reset();" class="btn btn-light btn-lg mb10" data-bs-toggle="modal">Launch Online Hearing Test <span class="glyphicon glyphicon-play glyphicon-white"></span></a>
						</div>
						<img src="/img/quiz/hh19-free-online-hearing-test.jpg" width="300" height="200" class="img-rounded img-responsive center-block mt30" alt="A woman struggles to hear a friend talking">
					</div>
					<!-- End Results -->
				</div>
			</div>
			<?= $this->element('content/share', ['show_badge' => false, 'hidePinterest' =>'true']) ?>
			</article>
		</div>
		<?= $this->element('side_panel') ?>


		<?php $this->append('bs-modals'); ?>
		<!-- Modal hearing test -->
		<div id="HearingTest" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content test-overlay">
					<div class="modal-header flex-row-reverse">
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<div id="test-counter" class="modal-title"></div>
					</div>
					<div class="modal-body m0">
						<!-- Pages -->
						<!-- RARELY/SOMETIMES/OFTEN -and- YES/NO Questions -->
						<?php
							$questions = [
								['How often do you have difficulty understanding voices on the phone?','rarelySometimesOften','hearing-test-icon-phone.png', 'phone'],
								['Have you had disagreements with others because you didn’t hear what was said correctly, or have your loved ones suggested you have your hearing checked?', 'yesNo'],
								['How often do you have to turn up your TV to hear what you’re watching?','rarelySometimesOften','hearing-test-icon-TV.png', 'television'],
								['How often do you have difficulty understanding women’s voices or young children?','rarelySometimesOften'],
								['Do you have a history of excessive noise exposure from working in a factory, as a firefighter, as a musician, at an airport, in the military, firearm use or other?','yesNo', 'hearing-test-icon-jackhammer.png', 'jackhammer'],
								['When people speak to you, do you feel you can hear but not understand all the words? Does it seem like people are mumbling when they speak to you?','yesNo'],
								['How often do you have trouble hearing in noisy situations like restaurants, large gatherings or public places?','rarelySometimesOften','hearing-test-icon-party.png', 'party horn'],
								['How often do you “fake it,” pretending to hear or nodding in agreement even though you aren’t sure what was really said?','rarelySometimesOften'],
								['Do you experience tinnitus (a ringing, buzzing or hissing sound) in one or both ears?','yesNo','hearing-test-icon-ringing-ears.png', 'ringing ears'],
								['How often do you avoid social situations, engaging in hobbies you used to enjoy, or conversations with others because of difficulty hearing?','rarelySometimesOften']
							];
							foreach ($questions as $index => $question) {
								$page = $index;
								echo $this->element('hearingtest/yes_no_sometimes', [
									'question' => $question[0],
									'questionType' => $question[1],
									'iconFilename' => array_key_exists(2, $question) ? $question[2] : '',
									'iconAltText' => array_key_exists(3, $question) ? $question[3] : '',
									'page' => $page
								]);
							}
						?>
						<!-- CONTACT INFORMATION Page -->
						<div id="test-page-10" class="test-page form-horizontal">
							<div class="questions-container">
								<div class="questions">
									Please provide us with your contact information so we can send you personalized results.
								</div>
							</div>
								<div class="form-group required" style="height:50px">
									<label for="inputFirstName" class="col col-md-3 control-label">First name</label>
									<div class="col col-md-6 required">
										<input id="inputFirstName" name="firstName" class="form-control" maxlength="255" type="text" placeholder="First name" required="required" autocomplete="given-name">
									</div>
								</div>
								<div class="form-group required" style="height:50px">
									<label for="inputLastName" class="col col-md-3 control-label">Last name</label>
									<div class="col col-md-6 required">
										<input id="inputLastName" name="lastName" class="form-control" maxlength="255" type="text" placeholder="Last name" required="required" autocomplete="family-name">
									</div>
								</div>
								<div class="form-group required" style="height:50px">
									<label for="testerEmail" class="col col-md-3 control-label">Email address</label>
									<div class="col col-md-6 required">
										<input id="testerEmail" name="Email" class="form-control" maxlength="255" type="email" placeholder="Email address" required="required" autocomplete="email">
									</div>
								</div>
								<div id="error-10" class="mt10 ml10 mr10 answer-required alert alert-danger" role="alert" style="display:none;">Please Fill Out All Fields</div>
								<input id="url-result" type="hidden" name="results" value="">
								<div class="text-center">
									<button onclick="HT.nextButton(10);" class="email-btn btn btn-light btn-lg">Show my results</button>
								</div>
							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	  </div>
	</div>
  </div>
</div>
<!-- End modal hearing test -->
<?php $this->end(); ?>

<?php $answers = $this->Wiki->getAnswers(); // Better place than WikiHelper for this function? ?>
<script type="text/javascript">
	let online_answers = <?= isset($answers) ? json_encode($answers) : 'null' ?>;
</script>