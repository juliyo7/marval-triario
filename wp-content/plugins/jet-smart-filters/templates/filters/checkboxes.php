<?php

if ( empty( $args ) ) {
	return;
}

$options             = $args['options'];
$query_var           = $args['query_var'];
$by_parents          = $args['by_parents'];
$search_enabled      = $args['search_enabled'];
$search_placeholder  = $args['search_placeholder'];
$less_items_count    = $args['less_items_count'];
$more_text           = $args['more_text'];
$less_text           = $args['less_text'];
$scroll_height_style = $args['scroll_height'] ? 'style="max-height:' . $args['scroll_height'] . 'px"' : false;
$show_decorator      = isset( $args['display_options']['show_decorator'] ) ? filter_var( $args['display_options']['show_decorator'], FILTER_VALIDATE_BOOLEAN ) : false;
$dropdown_enabled    = isset( $args['dropdown_enabled'] ) ? filter_var( $args['dropdown_enabled'], FILTER_VALIDATE_BOOLEAN ) : false;
$extra_classes       = '';

if ( ! $options ) {
	return;
}

$current = $this->get_current_filter_value( $args );

if ( ! $dropdown_enabled ) {
	include jet_smart_filters()->get_template( 'common/filter-label.php' );
}

?>
<?php if ( $search_enabled ) : ?>
	<div class="jet-checkboxes-search">
		<input
			class="jet-checkboxes-search__input"
			type="search"
			autocomplete="off"
			<?php echo $search_placeholder ? 'placeholder="' . $search_placeholder .'"' : '' ?>
		>
		<div class="jet-checkboxes-search__clear"></div>
	</div>
<?php endif; ?>
<div class="jet-checkboxes-list" <?php $this->filter_data_atts( $args ); ?>><?php

	if ( $scroll_height_style ) { echo '<div class="jet-checkboxes-list-scroll" ' . $scroll_height_style . '>'; }

	echo '<div class="jet-checkboxes-list-wrapper">';
	if ( $by_parents ) {

		if ( ! class_exists( 'Jet_Smart_Filters_Terms_Walker' ) ) {
			require_once jet_smart_filters()->plugin_path( 'includes/walkers/terms-walker.php' );
		}

		$walker = new Jet_Smart_Filters_Terms_Walker();

		$walker->tree_type = $query_var;

		$args['item_template'] = jet_smart_filters()->get_template( 'filters/checkboxes-item.php' );
		$args['current']       = $current;
		$args['decorator']     = $show_decorator;

		echo '<div class="jet-list-tree">';
		echo $walker->walk( $options, 0, $args );
		echo '</div>';

	} else {

		foreach ( $options as $value => $label ) {

			$checked = '';

			if ( $current ) {

				if ( is_array( $current ) && in_array( $value, $current ) ) {
					$checked = 'checked';
				}

				if ( ! is_array( $current ) && $value == $current ) {
					$checked = 'checked';
				}

			}

			include jet_smart_filters()->get_template( 'filters/checkboxes-item.php' );

		}

	}
	echo '</div>';

	if ( $scroll_height_style ) { echo '</div>'; }

	if ( $less_items_count && count($options) > $less_items_count ) {
		echo '<div class="jet-checkboxes-moreless" data-more-text="' . $more_text . '" data-less-text="' . $less_text . '"><div class="jet-checkboxes-moreless__toggle">' . $more_text . '</div></div>';
	}

?></div>
