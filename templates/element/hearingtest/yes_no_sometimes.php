<?php
	$question = isset($question) ? $question : '';
	$page = isset($page) ? $page : 0;
?>
<div id="test-page-<?= $page ?>" class="test-page mb150">
	<div class="questions-container">
		<div class="questions">
			<?= $question ?>
		</div>
	</div>
	<div class="sprite-test sprite-test-ellipse-line"></div>
	<div class="answers">
		<?php if ($questionType == 'yesNo'): ?> <!-- YES/NO question anwers -->
			<input type="radio" class="test-yes-no-radio" page="<?= $page ?>" name="quizAnswers<?= $page ?>" id="quizAnswerSometimes<?= $page ?>" value="yes">
				<label class="radio inline sprite-test sprite-test-answer-box d-block" for="quizAnswerSometimes<?= $page ?>"></label>
				<span class="sprite-label">Yes</span>
			<input type="radio" class="test-yes-no-radio" page="<?= $page ?>" name="quizAnswers<?= $page ?>" id="quizAnswerNo<?= $page ?>" value="no">
				<label class="radio inline sprite-test sprite-test-answer-box d-block" for="quizAnswerNo<?= $page ?>"></label>
				<span class="sprite-label">No</span>
		<?php else: ?> <!-- RARELY/SOMETIMES/OFTEN question anwers -->
			<input type="radio" class="test-yes-no-radio" page="<?= $page ?>" name="quizAnswers<?= $page ?>" id="quizAnswerNo<?= $page ?>" value="no">
				<label class="radio inline sprite-test sprite-test-answer-box d-block" for="quizAnswerNo<?= $page ?>"></label>
				<span class="sprite-label">Rarely</span>
			<input type="radio" class="test-yes-no-radio" page="<?= $page ?>" name="quizAnswers<?= $page ?>" id="quizAnswerSometimes<?= $page ?>" value="sometimes">
				<label class="radio inline sprite-test sprite-test-answer-box d-block" for="quizAnswerSometimes<?= $page ?>"></label>
				<span class="sprite-label">Sometimes</span>
			<input type="radio" class="test-yes-no-radio" page="<?= $page ?>" name="quizAnswers<?= $page ?>" id="quizAnswerYes<?= $page ?>" value="yes">
				<label class="radio inline sprite-test sprite-test-answer-box d-block" for="quizAnswerYes<?= $page ?>"></label>
				<span class="sprite-label">Often</span>
		<?php endif; ?>
	</div>
	<div id="error-<?= $page ?>" class="ml10 mr10 answer-required alert alert-warning" style="display:none;">Please Select an Answer</div>
	<div class="clear"></div>
		<button type="button" onclick="HT.nextButton(<?= $page ?>);" class="next-btn btn btn-light btn-lg">Next</button>
	<?php if ($page == 0): ?>
		<button type="button" data-bs-dismiss="modal" class="prev-btn btn btn-default btn-lg">Cancel</button>
	<?php else: ?>
		<button type="button" onclick="HT.prevButton(<?= $page ?>);" class="prev-btn btn btn-default btn-lg">Previous</button>
	<?php endif; ?>
		<?php if ($iconFilename != ''): ?>
			<img loading="lazy" class="hearing-test-icon" alt="<?php echo $iconAltText; ?>" src="/img/quiz/<?= $iconFilename ?>">
		<?php endif; ?>
	<div class="clear"></div>
</div>