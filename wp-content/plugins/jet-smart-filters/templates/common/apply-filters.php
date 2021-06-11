<?php
/**
 * Apply filters button
 */
?>
<div class="apply-filters"<?php if ( ! empty( $data_atts ) ) {
	echo ' ' . $data_atts;
} ?>>
	<button
		type="button"
		class="apply-filters__button"
	><?php echo $settings['apply_button_text']; ?></button>
</div>