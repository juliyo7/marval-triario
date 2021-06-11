<?php

namespace Elementor;

use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Smart_Filters_Checkboxes_Widget extends Jet_Smart_Filters_Base_Widget {

	public function get_name() {
		return 'jet-smart-filters-checkboxes';
	}

	public function get_title() {
		return __( 'Checkboxes Filter', 'jet-smart-filters' );
	}

	public function get_icon() {
		return 'jet-smart-filters-icon-checkboxes-filter';
	}

	public function get_help_url() {
		return jet_smart_filters()->widgets->prepare_help_url(
			'https://crocoblock.com/knowledge-base/articles/jetsmartfilters-how-to-create-a-checkboxes-filter-a-difference-between-checkboxes-select-and-radio-filters/',
			$this->get_name()
		);
	}

	public function register_filter_settings_controls() {

		$this->start_controls_section(
			'additional_settings',
			array(
				'label' => __( 'Additional Settings', 'jet-smart-filters' ),
			)
		);

		$this->add_control(
			'search_enabled',
			array(
				'label'        => esc_html__( 'Search Enabled', 'jet-smart-filters' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => '',
				'label_on'     => esc_html__( 'Yes', 'jet-smart-filters' ),
				'label_off'    => esc_html__( 'No', 'jet-smart-filters' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'search_placeholder',
			array(
				'label'     => esc_html__( 'Search Placeholder', 'jet-smart-filters' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Search...', 'jet-smart-filters' ),
				'condition' => array(
					'search_enabled' => 'yes'
				)
			)
		);

		$this->add_control(
			'moreless_enabled',
			array(
				'label'        => esc_html__( 'More/Less Enabled', 'jet-smart-filters' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => '',
				'label_on'     => esc_html__( 'Yes', 'jet-smart-filters' ),
				'label_off'    => esc_html__( 'No', 'jet-smart-filters' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'less_items_count',
			array(
				'label'     => esc_html__( 'Less Items Count', 'jet-smart-filters' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5,
				'min'       => 1,
				'max'       => 50,
				'step'      => 1,
				'condition' => array(
					'moreless_enabled' => 'yes'
				)
			)
		);

		$this->add_control(
			'more_text',
			array(
				'label'     => esc_html__( 'More Text', 'jet-smart-filters' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'More', 'jet-smart-filters' ),
				'condition' => array(
					'moreless_enabled' => 'yes'
				)
			)
		);

		$this->add_control(
			'less_text',
			array(
				'label'     => esc_html__( 'Less Text', 'jet-smart-filters' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Less', 'jet-smart-filters' ),
				'condition' => array(
					'moreless_enabled' => 'yes'
				)
			)
		);

		$this->add_control(
			'dropdown_enabled',
			array(
				'label'        => esc_html__( 'Dropdown Enabled', 'jet-smart-filters' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => '',
				'label_on'     => esc_html__( 'Yes', 'jet-smart-filters' ),
				'label_off'    => esc_html__( 'No', 'jet-smart-filters' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'dropdown_placeholder',
			array(
				'label'     => esc_html__( 'Placeholder', 'jet-smart-filters' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Select some options', 'jet-smart-filters' ),
				'condition' => array(
					'dropdown_enabled' => 'yes'
				)
			)
		);

		$this->add_control(
			'scroll_enabled',
			array(
				'label'        => esc_html__( 'Scroll Enabled', 'jet-smart-filters' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => '',
				'label_on'     => esc_html__( 'Yes', 'jet-smart-filters' ),
				'label_off'    => esc_html__( 'No', 'jet-smart-filters' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'scroll_height',
			array(
				'label'     => esc_html__( 'Scroll Height(px)', 'jet-smart-filters' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 290,
				'min'       => 100,
				'max'       => 1000,
				'step'      => 1,
				'condition' => array(
					'scroll_enabled' => 'yes'
				)
			)
		);

		$this->end_controls_section();

	}

	public function register_filter_style_controls() {

		$css_scheme = apply_filters(
			'jet-smart-filters/widgets/checkboxes/css-scheme',
			array(
				'item'                  => '.jet-checkboxes-list__row',
				'child-items'           => '.jet-list-tree__children',
				'button'                => '.jet-checkboxes-list__button',
				'label'                 => '.jet-checkboxes-list__label',
				'checkbox'              => '.jet-checkboxes-list__decorator',
				'checkbox-checked-icon' => '.jet-checkboxes-list__checked-icon',
				'list-item'             => '.jet-checkboxes-list__row',
				'list-wrapper'          => '.jet-checkboxes-list-wrapper',
				'list-children'         => '.jet-list-tree__children',
				'search'                => '.jet-checkboxes-search',
				'search-input'          => '.jet-checkboxes-search__input',
				'search-clear'          => '.jet-checkboxes-search__clear',
				'more-less'             => '.jet-checkboxes-moreless',
				'more-less-toggle'      => '.jet-checkboxes-moreless__toggle',
				'dropdown'              => '.jet-checkboxes-dropdown',
				'dropdown-label'        => '.jet-checkboxes-dropdown__label',
				'dropdown-body'         => '.jet-checkboxes-dropdown__body',
				'dropdown-active-items' => '.jet-checkboxes-dropdown__active',
				'dropdown-active-item'  => '.jet-checkboxes-dropdown__active__item',
			)
		);

		$this->start_controls_section(
			'section_items_style',
			array(
				'label'      => esc_html__( 'Items', 'jet-smart-filters' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->register_horizontal_layout_controls( $css_scheme );

		$this->add_responsive_control(
			'items_space_between',
			array(
				'label'      => esc_html__( 'Space Between', 'jet-smart-filters' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item']         => 'padding-top: calc({{SIZE}}{{UNIT}}/2); margin-bottom: calc({{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}} ' . $css_scheme['list-wrapper'] => 'margin-top: calc(-{{SIZE}}{{UNIT}}/2); margin-bottom: calc(-{{SIZE}}{{UNIT}}/2);',
				),
			)
		);

		$this->add_responsive_control(
			'sub_items_offset_left',
			array(
				'label'      => esc_html__( 'Children Offset Left', 'jet-smart-filters' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['child-items'] => 'padding-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_item_style',
			array(
				'label'      => esc_html__( 'Item', 'jet-smart-filters' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'show_decorator',
			array(
				'label'        => esc_html__( 'Show Checkbox', 'jet-smart-filters' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => '',
				'label_on'     => esc_html__( 'Yes', 'jet-smart-filters' ),
				'label_off'    => esc_html__( 'No', 'jet-smart-filters' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'item_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['label'],
			)
		);

		$this->start_controls_tabs( 'item_style_tabs' );

		$this->start_controls_tab(
			'item_normal_styles',
			array(
				'label' => esc_html__( 'Normal', 'jet-smart-filters' ),
			)
		);

		$this->add_control(
			'item_normal_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-smart-filters' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'item_normal_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-smart-filters' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'item_checked_styles',
			array(
				'label' => esc_html__( 'Checked', 'jet-smart-filters' ),
			)
		);

		$this->add_control(
			'item_checked_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-smart-filters' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jet-checkboxes-list__input:checked ~ ' . $css_scheme['button'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'item_checked_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-smart-filters' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jet-checkboxes-list__input:checked ~ ' . $css_scheme['button'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'item_checked_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'jet-smart-filters' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jet-checkboxes-list__input:checked ~ ' . $css_scheme['button'] => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'item_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-smart-filters' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'   => 'before'
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border', 'jet-smart-filters' ),
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->add_control(
			'item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-smart-filters' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_checkbox_style',
			array(
				'label'      => esc_html__( 'Checkbox', 'jet-smart-filters' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => array(
					'show_decorator' => 'yes'
				)
			)
		);

		$this->add_responsive_control(
			'checkbox_size',
			array(
				'label'      => esc_html__( 'Size', 'jet-smart-filters' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px'
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 40,
					),
				),
				'default'    => array(
					'size' => 15,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['checkbox'] => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'checkbox_top_offset',
			array(
				'label'      => esc_html__( 'Offset Top', 'jet-smart-filters' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px'
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['checkbox'] => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'checkbox_label_offset',
			array(
				'label'      => esc_html__( 'Offset Right', 'jet-smart-filters' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px'
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'default'    => array(
					'size' => 5,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['label'] => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'checkbox_style_tabs' );

		$this->start_controls_tab(
			'checkbox_normal_styles',
			array(
				'label' => esc_html__( 'Normal', 'jet-smart-filters' ),
			)
		);

		$this->add_control(
			'checkbox_normal_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-smart-filters' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['checkbox'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'checkbox_checked_styles',
			array(
				'label' => esc_html__( 'Checked', 'jet-smart-filters' ),
			)
		);

		$this->add_control(
			'checkbox_checked_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-smart-filters' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jet-checkboxes-list__input:checked ~ ' . $css_scheme['button'] . ' ' . $css_scheme['checkbox'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'checkbox_checked_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'jet-smart-filters' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jet-checkboxes-list__input:checked ~ ' . $css_scheme['button'] . ' ' . $css_scheme['checkbox'] => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'checkbox_border',
				'label'       => esc_html__( 'Border', 'jet-smart-filters' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['checkbox'],
			)
		);

		$this->add_control(
			'checkbox_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-smart-filters' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['checkbox'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_checked_icon_style',
			array(
				'label'      => esc_html__( 'Checkbox Icon', 'jet-smart-filters' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => array(
					'show_decorator' => 'yes'
				)
			)
		);

		$this->add_responsive_control(
			'checked_icon_size',
			array(
				'label'      => esc_html__( 'Size', 'jet-smart-filters' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px'
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'default'    => array(
					'size' => 12,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['checkbox-checked-icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'checked_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-smart-filters' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['checkbox-checked-icon'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		// Include Search Items Style
		include jet_smart_filters()->plugin_path( 'includes/widgets/common-controls/search-items-style.php' );

		// Include More Less Style
		include jet_smart_filters()->plugin_path( 'includes/widgets/common-controls/more-less-style.php' );

		// Include Dropdown Style
		include jet_smart_filters()->plugin_path( 'includes/widgets/common-controls/dropdown-style.php' );

	}

}
