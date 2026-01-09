<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoUrl $seoUrl
 */

$this->Vite->script('admin_common','admin-vite');
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">SEO URLs Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
            </div>
        </div>
    </div>
</header>

<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <div class="wikis form content">
                    <?= $this->Form->create($seoUrl) ?>
                    <fieldset>
                        <?php
                            echo $this->Form->control('url',
                                [
                                    'placeholder' => '/report/12345-page-to-redirect-from',
                                ]
                            );
                            echo '<div class="col-md-9 col-md-offset-3 pl0">';
                            echo $this->Form->control('is_410', [
                                'label' => 'Active 410',
                            ]);

                            echo '<div id="is-410-warning" class="alert alert-warning mt-2 mb-2 d-none" role="alert">
                            Marking this as <code>410 Gone</code> tells clients and search engines
                            the URL is permanently gone.
                            <br/>
                            The <strong><em>redirect</em></strong> and <strong><em>meta property</em></strong> fields below will be ignored.
                            </div>';
                            echo '</div>';
                            echo '<div class="col-md-9 col-md-offset-3 pl0">';
                            echo $this->Form->control('redirect_is_active', [
                                'label' => 'Active Redirect',
                            ]);

                            echo '<div id="is-redirect-warning" class="alert alert-warning mt-2 mb-2 d-none" role="alert">
                            Marking this as <code>301 Redirect</code> sends clients and search engines to a new, permanent URL.
                            <br/>
                            The <strong><em>meta property</em></strong> fields below will be ignored.
                            </div>';
                            echo '</div>';
                            echo $this->Form->control('redirect_url',
                                [
                                    'placeholder' => '/report/23456-page-to-redirect-to',
                                ]
                            );
                            echo $this->Form->control('seo_title');
                            echo $this->Form->control('seo_meta_description');
                        ?>
                    </fieldset>
                    <div class="form-actions tar">
                        <?= $this->Form->button(__('Save SEO URL'), ['class' => 'btn btn-primary btn-lg']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Elements
  const is410             = document.getElementById('is-410');
  const warning410        = document.getElementById('is-410-warning');
  const redirectUrl       = document.getElementById('redirect-url');
  const redirectActive    = document.getElementById('redirect-is-active');
  const warningRedirect   = document.getElementById('is-redirect-warning');
  const seoTitle          = document.getElementById('seo-title');
  const seoMetaDescription= document.getElementById('seo-meta-description');

  // --- Show/hide the warning box under "Active 410" or "Active Redirect"
  function updateWarning410() {
    if (!is410 || !warning410) return;
    warning410.classList.toggle('d-none', !is410.checked);
  }

  function updateWarningRedirect() {
    if (!redirectActive || !warningRedirect) return;
    warningRedirect.classList.toggle('d-none', !redirectActive.checked);
  }

  // --- Apply read-only to certain text fields when 410 or redirect is active
  function apply410Effects() {
    const readonly = !!(is410 && is410.checked);
    if (redirectUrl)        redirectUrl.readOnly = readonly;
    if (seoTitle)           seoTitle.readOnly = readonly;
    if (seoMetaDescription) seoMetaDescription.readOnly = readonly;
  }

  function applyRedirectEffects() {
    const readonly = !!(redirectActive && redirectActive.checked);
    if (seoTitle)           seoTitle.readOnly = readonly;
    if (seoMetaDescription) seoMetaDescription.readOnly = readonly;
  }

  // --- Keep the checkboxes mutually exclusive
  function enforceMutualExclusionFrom410() {
    if (is410 && is410.checked && redirectActive) {
      // If 410 is turned on, force redirect off
      redirectActive.checked = false;
    }
  }

  function enforceMutualExclusionFromRedirect() {
    if (redirectActive && redirectActive.checked && is410) {
      // If redirect is turned on, force 410 off (and thus unlock fields)
      is410.checked = false;
    }
  }

  // 410
  if (is410) {
    is410.addEventListener('change', function () {
      enforceMutualExclusionFrom410();
      updateWarning410();
      updateWarningRedirect();
      apply410Effects();
    });
  }

  // redirect
  if (redirectActive) {
    redirectActive.addEventListener('change', function () {
      enforceMutualExclusionFromRedirect();
      updateWarning410();
      updateWarningRedirect();
      apply410Effects();
      applyRedirectEffects();
    });
  }

  // Initialize on load (for edit forms)
  enforceMutualExclusionFrom410();
  enforceMutualExclusionFromRedirect();
  updateWarning410();
  updateWarningRedirect();
  apply410Effects();
  applyRedirectEffects();
});
</script>