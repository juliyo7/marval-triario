<?php
/**
 * Search items style controls
 */

namespace Elementor;

$this->start_controls_section(
	'search_items_style_section',
	[
		'label'      => esc_html__( 'Search Items', 'jet-smart-filters' ),
		'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
		'condition' => array(
			'search_enabled' => 'yes'
		)
	]
);

$this->add_responsive_control(
	'search_items_width',
	array(
		'label'      => esc_html__( 'Input Width', 'jet-smart-filters' ),
		'type'       => Controls_Manager::SLIDER,
		'size_units' => array(
			'px',
			'%',
		),
		'range'      => array(
			'px' => array(
				'min' => 0,
				'max' => 500,
			),
			'%'  => array(
				'min' => 0,
				'max' => 100,
			),
		),
		'default'    => array(
			'size' => 100,
			'unit' => '%',
		),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['search'] => 'max-width: {{SIZE}}{{UNIT}};',
		),
		'separator'  => 'after'
	)
);

$this->add_group_control(
	Group_Control_Typography::get_type(),
	array(
		'name'     => 'search_items_typography',
		'selector' => '{{WRAPPER}} ' . $css_scheme['search-input']
	)
);

$this->add_control(
	'search_items_color',
	array(
		'label'     => esc_html__( 'Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['search-input']                             => 'color: {{VALUE}}',
			'{{WRAPPER}} ' . $css_scheme['search-input'] . '::placeholder'           => 'color: {{VALUE}}',
			'{{WRAPPER}} ' . $css_scheme['search-input'] . ':-ms-input-placeholder'  => 'color: {{VALUE}}',
			'{{WRAPPER}} ' . $css_scheme['search-input'] . '::-ms-input-placeholder' => 'color: {{VALUE}}',

		),
	)
);

$this->add_control(
	'search_items_background_color',
	array(
		'label'     => esc_html__( 'Background Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['search-input'] => 'background-color: {{VALUE}}',
		),
	)
);

$this->add_group_control(
	Group_Control_Border::get_type(),
	array(
		'name'        => 'search_input_border',
		'label'       => esc_html__( 'Border', 'jet-smart-filters' ),
		'placeholder' => '1px',
		'default'     => '1px',
		'selector'    => '{{WRAPPER}} ' . $css_scheme['search-input'],
		'separator'   => 'before'
	)
);

$this->add_control(
	'search_input_border_radius',
	array(
		'label'      => esc_html__( 'Border Radius', 'jet-smart-filters' ),
		'type'       => Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['search-input'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_group_control(
	Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'search_input_box_shadow',
		'selector' => '{{WRAPPER}} ' . $css_scheme['search-input'],
	)
);

$this->add_responsive_control(
	'search_input_padding',
	array(
		'label'      => esc_html__( 'Padding', 'jet-smart-filters' ),
		'type'       => Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['search-input'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
		'separator'  => 'before'
	)
);

$this->add_responsive_control(
	'search_input_margin',
	array(
		'label'      => esc_html__( 'Margin', 'jet-smart-filters' ),
		'type'       => Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['search'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
		'separator'  => 'after'
	)
);

$this->add_control(
	'search_remove',
	array(
		'label' => __( 'Remove', 'jet-smart-filters' ),
		'type' => \Elementor\Controls_Manager::HEADING,
	)
);

$this->add_responsive_control(
	'search_remove_size',
	array(
		'label'      => esc_html__( 'Size', 'jet-smart-filters' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'range'      => array(
			'px' => array(
				'min' => 0,
				'max' => 50,
			),
		),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['search-clear'] => 'font-size: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'search_remove_right_offset',
	array(
		'label'     => esc_html__( 'Right Offset', 'jet-smart-filters' ),
		'type'      => \Elementor\Controls_Manager::SLIDER,
		'range'     => array(
			'px' => array(
				'min' => 0,
				'max' => 30,
			),
		),
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['search-clear'] => 'right: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->start_controls_tabs( 'search_remove_style_tabs' );

$this->start_controls_tab(
	'search_remove_normal_styles',
	array(
		'label' => esc_html__( 'Normal', 'jet-smart-filters' ),
	)
);

$this->add_control(
	'search_remove_normal_color',
	array(
		'label'     => esc_html__( 'Color', 'jet-smart-filters' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['search-clear'] => 'color: {{VALUE}}',
		),
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'search_remove_hover_styles',
	array(
		'label' => esc_html__( 'Hover', 'jet-smart-filters' ),
	)
);

$this->add_control(
	'search_remove_hover_color',
	array(
		'label'     => esc_html__( 'Color', 'jet-smart-filters' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['search-clear'] . ':hover' => 'color: {{VALUE}}',
		),
	)
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->end_controls_section();