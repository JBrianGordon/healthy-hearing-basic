<?php
/**
 * @var \App\View\AppView $this
 */

use App\Enums\Model\Review\ReviewRating;
use BootstrapUI\View\Helper\FormHelper;
use Cake\Core\Configure;

$zipLabel = Configure::read('zipLabel');
?>
<!-- Review submit modal -->
<div class="modal fade" id="reviewSubmitModal" tabindex="-1" aria-labelledby="reviewSubmitModalLabel" aria-hidden="true">
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
            'reviews.verify', [
              'label' => [
                'text' => 'By checking this box, I certify that I am not an owner or employee of this clinic or a competitor and that this review is my genuine opinion of this clinic based on my experience as a customer.',
              ],
              'required' => false, // Removes HTML 5 required message
              'type' => 'checkbox',
            ],
          );
        ?>
      </div>
      <div class="modal-footer">
        <div id="review-error" class="text-white pt-4 px-4 my-2"></div>
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

<!-- Review thank you modal -->
<div class="modal fade" id="reviewThankYouModal" tabindex="-1" aria-labelledby="reviewThankYouModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="reviewThankYouModalLabel">Thank you for sharing your experience at <?= $location->title ?>:</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>
          <strong>All submissions are moderated.</strong> Reviews are typically published on clinic profiles within <strong>one to three business days.</strong>
        </p>
        <h4>Subscribe to the <?= Configure::read('siteName'); ?> newsletter</h4>
        <?=
          $this->Form->create($location, [
            'id' => 'submitReviewForm',
            'url' => [
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
            'reviews.verify', [
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
        <div id="review-error" class="text-white py-4 px-4 my-4"></div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No Thanks</button>
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
    const reviewForm = document.querySelector('#submitReviewForm');
    const thankYouForm = document.querySelector('#reviewThankYouModal');

    reviewForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        const addReviewUrl = event.target.action;
        const reviewFormData = new URLSearchParams(new FormData(reviewForm)).toString();

        try {
            const response = await fetch(addReviewUrl, {
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/x-www-form-urlencoded'
                },
                method: 'POST',
                body: reviewFormData
            });

            if (!response.ok) {
                throw new Error();
            }

            jsonResponse = await response.json();

            if (!jsonResponse.success && jsonResponse.errors) {
                let reviewErrorDiv = document.getElementById('review-error');
                reviewErrorDiv.replaceChildren(); // Clear any previous content

                for (let key in jsonResponse.errors) {
                    if (jsonResponse.errors.hasOwnProperty(key)) {
                        let errorMessage = jsonResponse.errors[key];

                        // Create a <p> element for the error message
                        let errorParagraph = document.createElement('p');
                        errorParagraph.textContent = errorMessage;

                        // Append the <p> element to the reviewErrorDiv
                        reviewErrorDiv.appendChild(errorParagraph);
                    }
                }
                reviewErrorDiv.classList.add('bg-danger', 'w-100');
            } else {
                const reviewSubmitModal = document.querySelector('#reviewSubmitModal');
                const bootstrapModal = bootstrap.Modal.getInstance(reviewSubmitModal);
                bootstrapModal.hide();
                const thankYouModal = new bootstrap.Modal(document.getElementById('reviewThankYouModal'));
                thankYouModal.show();
            }
        } catch {
            alert("We're sorry, but there was an error while processing your review. If you continue to see this error, please try again later. Thank you and sorry for the inconvenience.");
        }
    });
</script>