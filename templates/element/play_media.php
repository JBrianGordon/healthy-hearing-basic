<?php
$media = isset($media) ? $media : array('url' => false, 'id' => null);
?>
<?php if ($media['url']): ?>
    <div id="jquery_jplayer_<?php echo $media['id'] ?>" class="jp-jplayer"></div>
    <div id="jp_container_<?php echo $media['id'] ?>" class="jp-audio">
        <div class="jp-type-single">
            <div class="jp-gui jp-interface">
                <nav>
                    <ul class="jp-controls pagination m0">
                        <li><a href="javascript:;" class="jp-play" tabindex="1"><span class="glyphicon glyphicon-play"></span></a></li>
                        <li><a href="javascript:;" class="jp-pause" tabindex="1"><span class="glyphicon glyphicon-pause"></span></a></li>
                        <li><a href="javascript:;" class="jp-stop" tabindex="1"><span class="glyphicon glyphicon-stop"></span></a></li>
                        <!-- <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                        <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                        <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>-->
                    </ul>
                </nav>
                <!--<div class="jp-progress">
                    <div class="jp-seek-bar">
                        <div class="jp-play-bar"></div>
                    </div>
                </div>-->
                <!--<div class="jp-volume-bar">
                    <div class="jp-volume-bar-value"></div>
                </div>-->
                <div class="clearfix"></div>
                <span class="jp-time-holder label label-primary">
                    <span class="jp-current-time"></span> / <span class="jp-duration-removeme"><?php echo $this->App->secondsToMinutes($media['duration']); ?></span>
                    <!--<ul class="jp-toggles">
                        <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
                        <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
                    </ul>-->
                </span>
            </div>
            <!-- <div class="jp-title">
                <ul>
                    <li><a href="<?php echo $media['url'] ?>" target="_blank">Download</a></li>
                </ul>
            </div> -->
            <div class="jp-no-solution">
                <p><small><strong>Update Required</strong><br>To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank" rel="noopener">Flash plugin</a>.</small></p>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        if (typeof media == 'undefined') {
            var media = [];
        }
        media.push(<?php echo json_encode($media); ?>);
    </script>
<?php endif; ?>
