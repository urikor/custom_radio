<?php
/**
 * Main html markup template.
 */
?>
<div class="ticker param block">
    <span id="ticker"><?php echo date('d/m/Y H:i:s'); ?></span>
</div>
<div id="customRadio">
    <div class="title param">
        <span class="label">Track:</span><span id="title">...</span>
    </div>
    <div class="artist param">
        <span class="label">Artist:</span><span id="artist">...</span>
    </div>
    <div class="album param">
        <span class="label">Album: </span><span id="album">...</span>
    </div>
    <div class="genre param">
        <span class="label">Genre: </span><span id="genre">...</span></div>
    <div class="duration param"><span class="label">Duration: </span><span id="duration">...</span> s
    </div>
    <div class="next-song param">
        <span class="label">Next:</span><span id="next">...</span> s
    </div>
</div>
<div id="stat-form" class="block">
    <?php include 'include/most-form.php'; ?>
</div>

<link rel="stylesheet" type="text/css" href="cstm-radio/css/radio.css">
<script src="cstm-radio/js/radio.js"></script>
