<!-- Special announcements / Flex space / Coupons -->
<div id="specialAnnouncements" data-iscqpremier="<?= $isCqPremier; ?>" data-adid="<?= $adId; ?>" data-couponid="<?= $couponId; ?>">
    <label class="form-label col-md-3">Special announcement</label>
    <div class="clearfix"></div>
    <div id="couponLibrary" style="display:none;">
        <div class="row mb20 pr20 pl20">
            <div class="col-md-3">
                <div class="panel panel-light text-center mb5" style="height:373px;">
                    <div class="text-center" style="padding-top:150px;">
                        <button type="button" class="btn btn-large btn-primary text-center js-choose-own-coupon">Choose my own</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <?= $this->Clinic->previewCoupon(1) ?>
            </div>
            <div class="col-md-3">
                <?= $this->Clinic->previewCoupon(2) ?>
            </div>
            <div class="col-md-3">
                <?= $this->Clinic->previewCoupon(3) ?>
            </div>
        </div>
        <div class="row mb20 pr20 pl20">
            <div class="col-md-3">
                <?= $this->Clinic->previewCoupon(4) ?>
            </div>
            <div class="col-md-3">
                <?= $this->Clinic->previewCoupon(5) ?>
            </div>
            <div class="col-md-3">
                <?= $this->Clinic->previewCoupon(6) ?>
            </div>
            <div class="col-md-3">
                <?= $this->Clinic->previewCoupon(7) ?>
            </div>
        </div>
        <div class="row pr20 pl20">
            <div class="col-md-3">
                <?= $this->Clinic->previewCoupon(8) ?>
            </div>
            <div class="col-md-3">
                <?= $this->Clinic->previewCoupon(9) ?>
            </div>
            <div class="col-md-3">
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
    <div id="couponSelected" style="display:none;">
        <?= $this->Form->hidden('id_coupon', ['id' => 'couponId']); ?>
        <div class='col-md-3 offset-md-4'>
            <?= $this->Clinic->previewCoupon($couponId, false, true) ?>
        </div>
        <div class='col-md-5'></div>
    </div>
    <div id="uploadCoupon" style="display:none;">
        <?php if ($adId): ?>
            <?php echo $this->Form->control('location_ad.id',
                [
                    'type' => 'hidden',
                    'value' => $adId
                ]);
            ?>
        <?php endif; ?>
        
        <?php if ($isCqPremier): ?>
            <div class="offset-md-3 mb20"><button type="button" class="btn btn-md btn-primary js-show-coupon-library mt5">View Coupon Options</button></div>
        <?php endif; ?>
        <div class='row mb20' id='location-ad-preview'>
            <?php if (!empty($locationAd->image_url) || !empty($locationAd->title) || !empty($locationAd->description)): ?>
                <div class='col-md-3 offset-md-3'>
                    <div class="panel panel-light text-center mb5">
                        <?php if (!empty($locationAd->title)): ?>
                            <div class="panel-heading"><?= $locationAd->title ?></div>
                        <?php endif; ?>
                        <?php if (!empty($locationAd->image_url)): ?>
                            <div class="panel-body">
                                <img class="coupon-image" src="<?= $locationAd->image_url ?>">
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($locationAd->description)): ?>
                            <div class="panel-footer"><?= $locationAd->description ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="text-center"><button type="button" class="btn btn-md btn-danger js-ad-delete mt5">Delete announcement /<br>Choose another</button></div>
                </div>
            <?php endif; ?>
        </div>
        <?=
            $this->Form->control("location_ad.image_url", [
                'label' => 'File name',
                'class' => 'col-md-7-override d-inline',
                'value' => $locationAd->image_url ?? '',
                'readonly' => 'readonly',
                'templates' => [
                    'inputContainer' => '{{content}}<label class="btn btn-sm btn-default mt5 float-end col-md-2-override p5 tac"><span>Upload image</span><input type="file" name="location_ad[file]" class="form-control hidden" id="LocationAdFile"></label>{{help}}',
                    'help' => '<br><p class="form-text text-muted col-md-offset-3 mb-3">{{content}}</p>'
                ],
                'help' => 'Images must be JPG format, less than 500kb, and under 700 pixels in width.<br>
                <span class="text-danger" id="location-ad-error" style="display:none;">Image is invalid. Must be a .jpg or .jpeg and less than 500kb.</span>'
            ]);
        ?>
        <?php
            echo $this->Form->control("location_ad.title", [
                'label' => 'Title',
                'class' => 'mt-3',
                'maxlength' => 50,
                'required' => false,
                'templates' => [
                    'inputContainer' => '{{content}}{{help}}',
                    'help' => '<small class="form-text text-muted col-md-offset-3 mb-3">{{content}}</small><br>'
                ],
                'help' => 'This text will appear in the header of this space. 50 characters max.'
            ]);

            echo $this->Form->control("location_ad.description", [
                'type' => 'textarea',
                'rows' => 2,
                'label' => 'Message',
                'class' => 'mt-3',
                'maxlength' => 500,
                'required' => false,
                'templates' => [
                    'inputContainer' => '{{content}}{{help}}',
                    'help' => '<small class="form-text text-muted col-md-offset-3 mb-3">{{content}}</small><br>'
                ],
                'help' => 'This text will appear in the low text of this space. 500 characters max.'
            ]);
        ?>
        <div class="form-group">
            <label for="LocationAdBorder" class="form-label col-md-3">Border</label>
            <input type="hidden" name="location_ad[border]" id="LocationAdBlank_" value="">
            <?php
            $border = $location->location_ad->border ?? '';
            $borderIsBlank = in_array($border, ['blank', '']);
            ?>
            <div class="col col-md-9">
                <div class="col-md-3 border-radio<?= $borderIsBlank ? ' selected-border' : '' ?>">
                    <label for="LocationAdBlank" class="col control-label w-100 tac">
                        <input type="radio" name="location_ad[border]" value="blank" id="LocationAdBlank"<?= $borderIsBlank ? ' checked' : '' ?>> No Border
                    </label>
                </div>
                <div class="col-md-3 border-radio<?= $border == 'border-dashed' ? ' selected-border' : '' ?>">
                    <label for="LocationAdDashed" class="col control-label border-dashed w-100 tac">
                        <input type="radio" name="location_ad[border]" value="border-dashed" id="LocationAdDashed"<?= $border == 'border-dashed' ? ' checked' : '' ?>> Dashed
                    </label>
                </div>
                <div class="col-md-3 border-radio<?= $border == 'border-dotted' ? ' selected-border' : '' ?>">
                    <label for="LocationAdDotted" class="col control-label border-dotted w-100 tac">
                        <input type="radio" name="location_ad[border]" value="border-dotted" id="LocationAdDotted"<?= $border == 'border-dotted' ? ' checked' : '' ?>> Dotted
                    </label>
                </div>
                <div class="col-md-3 border-radio<?= $border == 'border-inset' ? ' selected-border' : '' ?>">
                    <label for="LocationAdInset" class="col control-label border-inset w-100 tac">
                        <input type="radio" name="location_ad[border]" value="border-inset" id="LocationAdInset"<?= $border == 'border-inset' ? ' checked' : '' ?>> Inset
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<hr>