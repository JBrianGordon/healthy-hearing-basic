<?php
/**
 * @var \App\View\AppView $this
 */

use App\Enums\Model\Review\ReviewRating;
use BootstrapUI\View\Helper\FormHelper;
use Cake\Core\Configure;

$zipLabel = Configure::read('zipLabel');
?>
<div class="modal fade" id="reviewSubmitModal" tabindex="-1" aria-labelledby="reviewSubmitModalLabel" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="reviewSubmitModalLabel">Tell others about your experience at <?= $location->title ?>:</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?=
          $this->Form->create($location, [
            'id' => 'submitReviewForm',
            'url' => [
              // 'controller' => 'Reviews',
              'action' => 'addReview'
            ],
            'context' => [
              'validator' => [
                  'Reviews' => 'default'
              ]
            ],
            'align' => [
                FormHelper::GRID_COLUMN_ONE => 3, // first column (span over 4 columns)
                FormHelper::GRID_COLUMN_TWO => 9, // second column (span over 8 columns)
            ],
          ])
        ?>
        <?php
          echo $this->Form->hidden(
            'reviews.location_id', [
              'value' => $location->id,
            ]
          );
          echo $this->Form->control(
            'reviews.first_name', [
              'placeholder' => 'First name',
              'label' => [
                'class' => 'text-end',
                'text' => 'My first name:',
              ]
            ],
          );
          echo $this->Form->control(
            'reviews.last_name', [
              'placeholder' => 'Last name',
              'label' => [
                'class' => 'text-end',
                'text' => 'My last name:',
              ]
            ],
          );
        ?>
        <p class="col-md-9 offset-md-3 small text-muted">Please provide your real name. We will only show your first name and last initial. We do not publish anonymous reviews.</p>
        <?php
          echo $this->Form->control(
            'reviews.zip', [
              'placeholder' => $zipLabel,
              'label' => [
                'class' => 'text-end',
                'text' => 'My ' . $zipLabel . ':',
              ]
            ],
          );
        ?>
        <?php if ($zipLabel === 'postal code'): ?>
            <p class="col-md-9 offset-md-3 small text-muted">Please enter your postal code in the correct format, i.e. A1B 2C3.</p>
        <?php endif; ?>
        <?php
          echo $this->Form->control(
            'reviews.rating', [
              'label' => [
                'class' => 'text-end',
                'text' => 'My rating:',
              ],
              'type' => 'select',
              'options' => array_combine(
                ReviewRating::getRatingValueArray(),
                ReviewRating::getRatingLabelArray(),
              ),
              'empty' => 'Select rating',
            ],
          );
          echo $this->Form->control(
            'reviews.body', [
              'label' => [
                'class' => 'text-end',
                'text' => 'My review:',
              ],
              'type' => 'textarea',
              'rows' => 3,
            ],
          );
        ?>
        <p class="col-md-9 offset-md-3 small text-muted">Describe your experience for other readers on <?= Configure::read('siteUrl') ?></p>
        <?php
          echo $this->Form->control(
            'Review.verify', [
              'label' => [
                // 'class' => 'col-md-10 offset-md-2',
                'text' => 'By checking this box, I certify that I am not an owner or employee of this clinic or a competitor and that this review is my genuine opinion of this clinic based on my experience as a customer.',
              ],
              'type' => 'checkbox',
            ],
          );
        ?>
      </div>
      <div class="modal-footer">
        <?php
          echo $this->Form->button(
            'Submit review', [
              'type' => 'submit',
              'id' => 'submitReview',
              'class' => [
                'btn',
                'btn-primary',
              ],
            ]
          );
        ?>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

<script type="text/javascript">
  const form = document.querySelector('#submitReviewForm');

  form.addEventListener('submit', async (event) => {
    event.preventDefault();
    const targeturl = event.target.action;
    const formData = new URLSearchParams(new FormData(form)).toString();

    try {
      const response = await fetch(targeturl, {
        headers: {
          'Accept': 'application/json',
          'Content-type': 'application/x-www-form-urlencoded'
        },
        method: 'POST',
        body: formData
      });

      if (response.ok) {
        const reviewSubmitModal = document.querySelector('#reviewSubmitModal');
        const bootstrapModal = bootstrap.Modal.getInstance(reviewSubmitModal);
        bootstrapModal.hide();
      } else {
        throw new Error(`An error occurred: ${response.statusText}`);
      }
    } catch (error) {
      alert(error.message);
    }
  });
</script>