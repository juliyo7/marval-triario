<?php
/**
 * Dropdown style controls
 */

namespace Elementor;

$this->start_controls_section(
	'dropdown_style_section',
	[
		'label'     => esc_html__( 'Dropdown', 'jet-smart-filters' ),
		'tab'       => Controls_Manager::TAB_STYLE,
		'condition' => array(
			'dropdown_enabled' => 'yes'
		)
	]
);

$this->add_responsive_control(
	'dropdown_width',
	array(
		'label'      => esc_html__( 'Width', 'jet-smart-filters' ),
		'type'       => Controls_Manager::SLIDER,
		'size_units' => array(
			'%',
			'px',
		),
		'range'      => array(
			'%'  => array(
				'min' => 10,
				'max' => 100,
			),
			'px' => array(
				'min' => 50,
				'max' => 500,
			),
		),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown'] => 'max-width: {{SIZE}}{{UNIT}}',
		),
	)
);

$this->add_control(
	'dropdown_label_heading',
	array(
		'label'     => esc_html__( 'Label', 'jet-smart-filters' ),
		'type'      => Controls_Manager::HEADING,
		'separator' => 'before',
	)
);

$this->add_group_control(
	Group_Control_Typography::get_type(),
	array(
		'name'     => 'dropdown_label_typography',
		'selector' => '{{WRAPPER}} ' . $css_scheme['dropdown-label'],
	)
);

$this->add_control(
	'dropdown_label_color',
	array(
		'label'     => esc_html__( 'Text Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'default'   => '',
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-label'] => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'dropdown_label_background_color',
	array(
		'label'     => esc_html__( 'Background Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-label'] => 'background-color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	Group_Control_Border::get_type(),
	array(
		'name'      => 'dropdown_label_border',
		'default'   => '1px',
		'selector'  => '{{WRAPPER}} ' . $css_scheme['dropdown-label'],
	)
);

$this->add_control(
	'dropdown_label_border_radius',
	array(
		'label'      => esc_html__( 'Border Radius', 'jet-smart-filters' ),
		'type'       => Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-label'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_group_control(
	Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'dropdown_label_box_shadow',
		'selector' => '{{WRAPPER}} ' . $css_scheme['dropdown-label'],
	)
);

$this->add_responsive_control(
	'dropdown_label_padding',
	array(
		'label'      => esc_html__( 'Padding', 'jet-smart-filters' ),
		'type'       => Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', 'em', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-label'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		)
	)
);

$this->add_control(
	'dropdown_active_items_heading',
	array(
		'label'     => esc_html__( 'Active Items', 'jet-smart-filters' ),
		'type'      => Controls_Manager::HEADING,
		'separator' => 'before',
	)
);

$this->add_responsive_control(
	'dropdown_active_items_offset',
	array(
		'label'     => esc_html__( 'Offset', 'jet-smart-filters' ),
		'type'      => Controls_Manager::SLIDER,
		'range'     => array(
			'px' => array(
				'min' => 0,
				'max' => 40,
			),
		),
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-active-items'] => 'margin: -{{SIZE}}{{UNIT}};',
			'{{WRAPPER}} ' . $css_scheme['dropdown-active-item'] => 'margin: {{SIZE}}{{UNIT}};',
		)
	)
);

$this->add_group_control(
	Group_Control_Typography::get_type(),
	array(
		'name'     => 'dropdown_active_item_typography',
		'selector' => '{{WRAPPER}} ' . $css_scheme['dropdown-active-item'],
	)
);

$this->start_controls_tabs( 'dropdown_active_item_style_tabs' );

$this->start_controls_tab(
	'dropdown_active_item_normal_styles',
	array(
		'label' => esc_html__( 'Normal', 'jet-smart-filters' ),
	)
);

$this->add_control(
	'dropdown_active_item_normal_color',
	array(
		'label'     => esc_html__( 'Text Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-active-item'] => 'color: {{VALUE}}',
		),
	)
);

$this->add_control(
	'dropdown_active_item_normal_background_color',
	array(
		'label'     => esc_html__( 'Background Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-active-item'] => 'background-color: {{VALUE}}',
		),
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'dropdown_active_item_hover_styles',
	array(
		'label' => esc_html__( 'Hover', 'jet-smart-filters' ),
	)
);

$this->add_control(
	'dropdown_active_item_hover_color',
	array(
		'label'     => esc_html__( 'Text Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-active-item'] . ':hover' => 'color: {{VALUE}}',
		),
	)
);

$this->add_control(
	'dropdown_active_item_hover_background_color',
	array(
		'label'     => esc_html__( 'Background Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-active-item'] . ':hover' => 'background-color: {{VALUE}}',
		),
	)
);

$this->add_control(
	'dropdown_active_item_hover_border_color',
	array(
		'label'     => esc_html__( 'Border Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-active-item'] . ':hover' => 'border-color: {{VALUE}}',
		),
	)
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_group_control(
	Group_Control_Border::get_type(),
	array(
		'name'     => 'dropdown_active_item_border',
		'label'    => esc_html__( 'Border', 'jet-smart-filters' ),
		'default'  => '1px',
		'selector' => '{{WRAPPER}} ' . $css_scheme['dropdown-active-item'],
	)
);

$this->add_control(
	'dropdown_active_item_border_radius',
	array(
		'label'      => esc_html__( 'Border Radius', 'jet-smart-filters' ),
		'type'       => Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-active-item'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'dropdown_active_item_padding',
	array(
		'label'      => esc_html__( 'Padding', 'jet-smart-filters' ),
		'type'       => Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-active-item'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_control(
	'dropdown_body_heading',
	array(
		'label'     => esc_html__( 'Dropdown Body', 'jet-smart-filters' ),
		'type'      => Controls_Manager::HEADING,
		'separator' => 'before',
	)
);

$this->add_responsive_control(
	'dropdown_body_offset',
	array(
		'label'     => esc_html__( 'Offset', 'jet-smart-filters' ),
		'type'      => Controls_Manager::SLIDER,
		'range'     => array(
			'px' => array(
				'min' => 0,
				'max' => 100,
			),
		),
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-body'] => 'margin-top: {{SIZE}}{{UNIT}};'
		)
	)
);

$this->add_group_control(
	Group_Control_Border::get_type(),
	array(
		'name'     => 'dropdown_body_border',
		'default'  => '1px',
		'selector' => '{{WRAPPER}} ' . $css_scheme['dropdown-body'],
	)
);

$this->add_control(
	'dropdown_body_border_radius',
	array(
		'label'      => esc_html__( 'Border Radius', 'jet-smart-filters' ),
		'type'       => Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-body'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_control(
	'dropdown_body_background_color',
	array(
		'label'     => esc_html__( 'Background Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['dropdown-body'] => 'background-color: {{VALUE}};',
		),
	)
);

$this->add_responsive_control(
	'dropdown_body_items_padding',
	array(
		'label'      => esc_html__( 'Items Padding', 'jet-smart-filters' ),
		'type'       => Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', 'em', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['list-wrapper'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		)
	)
);

$this->end_controls_section();