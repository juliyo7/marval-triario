<?php
/**
 * Filters label template
 */

if ( empty( $args ) || ! filter_var( $args['show_label'], FILTER_VALIDATE_BOOLEAN ) || empty( $args['filter_label'] ) ) {
	return;
}

?>
<div class="jet-filter-label"><?php echo $args['filter_label']; ?></div>
