<?php
/**
 * More Less style controls
 */

namespace Elementor;

use Elementor\Core\Schemes\Typography as Scheme_Typography;

$this->start_controls_section(
	'more_less_style_section',
	[
		'label'     => esc_html__( 'More Less Toggle', 'jet-smart-filters' ),
		'tab'       => Controls_Manager::TAB_STYLE,
		'condition' => array(
			'moreless_enabled' => 'yes'
		)
	]
);

$this->add_group_control(
	Group_Control_Typography::get_type(),
	array(
		'name'     => 'more_less_button_typography',
		'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
		'selector' => '{{WRAPPER}} ' . $css_scheme['more-less-toggle'],
	)
);

$this->start_controls_tabs( 'more_less_button_style_tabs' );

$this->start_controls_tab(
	'more_less_button_normal_styles',
	array(
		'label' => esc_html__( 'Normal', 'jet-smart-filters' ),
	)
);

$this->add_control(
	'more_less_button_normal_color',
	array(
		'label'     => esc_html__( 'Text Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['more-less-toggle'] => 'color: {{VALUE}}',
		),
	)
);

$this->add_control(
	'more_less_button_normal_background_color',
	array(
		'label'     => esc_html__( 'Background Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['more-less-toggle'] => 'background-color: {{VALUE}}',
		),
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'more_less_button_hover_styles',
	array(
		'label' => esc_html__( 'Hover', 'jet-smart-filters' ),
	)
);

$this->add_control(
	'more_less_button_hover_color',
	array(
		'label'     => esc_html__( 'Text Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['more-less-toggle'] . ':hover' => 'color: {{VALUE}}',
		),
	)
);

$this->add_control(
	'more_less_button_hover_background_color',
	array(
		'label'     => esc_html__( 'Background Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['more-less-toggle'] . ':hover' => 'background-color: {{VALUE}}',
		),
	)
);

$this->add_control(
	'more_less_button_hover_border_color',
	array(
		'label'     => esc_html__( 'Border Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['more-less-toggle'] . ':hover' => 'border-color: {{VALUE}}',
		)
	)
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_group_control(
	Group_Control_Border::get_type(),
	array(
		'name'     => 'more_less_button_border',
		'label'    => esc_html__( 'Button Border', 'jet-smart-filters' ),
		'selector' => '{{WRAPPER}} ' . $css_scheme['more-less-toggle'],
	)
);

$this->add_control(
	'more_less_button_border_radius',
	array(
		'label'      => esc_html__( 'Border Radius', 'jet-smart-filters' ),
		'type'       => Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['more-less-toggle'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_group_control(
	Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'more_less_button_shadow',
		'selector' => '{{WRAPPER}} ' . $css_scheme['more-less-toggle'],
	)
);

$this->add_responsive_control(
	'more_less_button_padding',
	array(
		'label'      => esc_html__( 'Padding', 'jet-smart-filters' ),
		'type'       => Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['more-less-toggle'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		)
	)
);

$this->add_control(
	'more_less_heading',
	array(
		'label'     => esc_html__( 'Holder', 'jet-smart-filters' ),
		'type'      => Controls_Manager::HEADING,
		'separator' => 'before',
	)
);

$this->add_control(
	'more_less_background_color',
	array(
		'label'     => esc_html__( 'Background Color', 'jet-smart-filters' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['more-less'] => 'background-color: {{VALUE}}',
		),
	)
);

$this->add_group_control(
	Group_Control_Border::get_type(),
	array(
		'name'     => 'more_less_border',
		'selector' => '{{WRAPPER}} ' . $css_scheme['more-less'],
	)
);

$this->add_responsive_control(
	'more_less_padding',
	array(
		'label'      => esc_html__( 'Padding', 'jet-smart-filters' ),
		'type'       => Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} ' . $css_scheme['more-less'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		)
	)
);
$this->add_responsive_control(
	'more_less_button_alignment',
	array(
		'label'     => esc_html__( 'Alignment', 'jet-smart-filters' ),
		'type'      => Controls_Manager::CHOOSE,
		'toggle'    => false,
		'default'   => 'left',
		'options'   => array(
			'left'   => array(
				'title' => esc_html__( 'Left', 'jet-smart-filters' ),
				'icon'  => 'fa fa-align-left',
			),
			'center' => array(
				'title' => esc_html__( 'Center', 'jet-smart-filters' ),
				'icon'  => 'fa fa-align-center',
			),
			'right'  => array(
				'title' => esc_html__( 'Right', 'jet-smart-filters' ),
				'icon'  => 'fa fa-align-right',
			),
		),
		'separator' => 'before',
		'selectors' => array(
			'{{WRAPPER}} ' . $css_scheme['more-less'] => 'text-align: {{VALUE}};',
		)
	)
);

$this->end_controls_section();