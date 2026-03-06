<?php
$bottom_text_note = get_field('bottom_text_note', 'data_interactive');
if(!empty($bottom_text_note)):
?>
<div class="data-interactive__text-bottom theme theme--neutral" data-animate='fade-in-up' data-animate-delay='0'>
    <div class="text-bottom__txt-wrapper">
        <div class="text-bottom__txt font-body-xs theme__text--primary">
            <?= $bottom_text_note; ?>
        </div>
    </div>
</div>
<?php endif; ?>