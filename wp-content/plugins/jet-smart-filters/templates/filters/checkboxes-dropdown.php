<?php

if ( empty( $args ) || ! $args['options'] ) {
	return;
}

include jet_smart_filters()->get_template( 'common/filter-label.php' );

?>
<div class="jet-checkboxes-dropdown">
	<div class="jet-checkboxes-dropdown__label"><?php echo isset( $args['dropdown_placeholder'] ) ? $args['dropdown_placeholder'] : '' ?></div>
	<div class="jet-checkboxes-dropdown__body">
		<?php include jet_smart_filters()->get_template( 'filters/checkboxes.php' ); ?>
	</div>
</div>