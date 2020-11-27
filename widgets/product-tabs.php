<?php

namespace IMMO\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if(!defined('ABSPATH')) exit; // Exit if accessed directly

class Product_Tabs extends Widget_Base {
	
	public function get_name() {
		
		return 'product-tabs';
	}

	public function get_title() {
		
		return 'Product Tabs';
	}

	public function get_icon() {
		
		return 'fa fa-folder';
	}

	public function get_categories() {
		
		return ['general'];
	}

	protected function _register_controls() {

		// Init CONTENT TAB
		$this->start_controls_section(
			'section_content',
			[
				'label' => 'Settings',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => __( 'Title', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'List Title' , 'plugin-domain' ),
				'label_block' => true,
			]
		);

		$posts = get_posts([
			'post_type' => 'produtos',
			'post_status' => 'publish',
			'numberposts' => -1
		]);

		//var_dump($posts);
		$produtos = array();
		foreach ($posts as $k => $value) {
			$key = $value->ID . '$' . get_the_post_thumbnail_url($value->ID) . '$' . $value->post_title;
			$produtos[$key] = $value->post_title;
		}

		$repeater->add_control(
			'produtos',
			[
				'label' => __( 'Produtos', 'plugin-domain' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $produtos,
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Tabs', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => __( 'Title #1', 'plugin-domain' ),
					],
					[
						'list_title' => __( 'Title #2', 'plugin-domain' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->add_control(
			'active_tab',
			[
				'label' => __( 'Active Tab', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .product-tabs__tab-content, .active' => 'background-color: {{VALUE}}!important',
				],
			]
		);

		$this->add_control(
			'secondary_tab',
			[
				'label' => __( 'Secondary Tab', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .product-tabs__nav-item' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// END CONTENT TAB

		// INIT STYLE TAB

		$this->start_controls_section(
			'tabs_style',
			[
				'label' => 'Tabs Style',
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'tab_typography',
				'label' => __( 'Tab Typography', 'plugin-domain' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .product-tabs__nav-link',
			]
		);

		$this->add_control(
			'tab_width',
			[
				'label' => __( 'Tab Width', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 500
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .product-tabs__nav-item' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'active_tab_height',
			[
				'label' => __( 'Active Tab Height', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 100
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} .product-tabs__nav-link.active' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'secondary_tab_height',
			[
				'label' => __( 'Secondary Tab Height', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 100
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .product-tabs__nav-item' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_style',
			[
				'label' => 'Content Style',
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text color', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .product-tabs__item-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'item_typography',
				'label' => __( 'Item Typography', 'plugin-domain' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .product-tabs__item-text',
			]
		);

		$this->add_control(
			'panel_content_padding',
			[
				'label' => __( 'Content Padding', 'plugin-domain' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .product-tabs__tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_height',
			[
				'label' => __( 'Item Height', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 250,
				],
				'selectors' => [
					'{{WRAPPER}} .product-tabs__item img' => 'height: {{SIZE}}{{UNIT}}!important;',
				],
			]
		);

		$this->add_control(
			'items',
			[
				'label' => __( 'Items', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 3,
			]
		);

		$this->add_control(
			'margin_items',
			[
				'label' => __( 'Margin Items', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 150,
				]
			]
		);

		$this->end_controls_section();

		// END STYLE TAB
	}


	// PHP RENDER
	protected function render() {
		$settings = $this->get_settings_for_display();

		?>
			<nav>
				<ul class="nav product-tabs__nav-tab nav-tabs justify-content-center align-items-end font-weight-bold" role="tablist">

				<?php	
				if ( $settings['list'] ) {
					
					for ($i = 0; $i < count($settings['list']); $i++) {
						$item = $settings['list'][$i];

						if ($i == 0) {
						?>
							<li class="product-tabs__nav-item rounded-0 d-flex justify-content-center align-items-center">
								<a class="product-tabs__nav-link nav-link d-flex justify-content-center align-items-center active" id="nav-tab-<?= $item['list_title'] . "-" . $item['_id'] ?>" data-toggle="tab" href="#nav-<?= $item['list_title'] . "-" . $item['_id'] ?>" role="tab" aria-controls="nav-<?= $item['list_title'] . "-" . $item['_id'] ?>" aria-selected="true"> <?= $item["list_title"] ?> </a>
							</li>
						<?php
						} else {
						?>
							<li class="product-tabs__nav-item rounded-0 d-flex justify-content-center align-items-center">
								<a class="product-tabs__nav-link nav-link d-flex justify-content-center align-items-center" id="nav-tab-<?= $item['list_title'] . "-" . $item['_id'] ?>" data-toggle="tab" href="#nav-<?= $item['list_title'] . "-" . $item['_id'] ?>" role="tab" aria-controls="nav-<?= $item['list_title'] . "-" . $item['_id'] ?>" aria-controls="nav-home" aria-selected="true"><?= $item['list_title'] ?></a>
							</li>
						<?php
						}
						// echo '<dt class="elementor-repeater-item-' . $item['_id'] . '">' . $item['list_title'] . '</dt>';
						// echo '<dd>' . $item['list_content'] . '</dd>';
					}
					
				}
				?>
				</ul>
			</nav>
			<div class="product-tabs__tab-content tab-content">

				<?php	
				if ( $settings['list'] ) {
					
					for ($i = 0; $i < count($settings['list']); $i++) {
						$item = $settings['list'][$i];
						
						if ($i == 0) {
						?>
							<div class="tab-pane fade show active" id="nav-<?= $item['list_title'] . "-" . $item['_id'] ?>" role="tabpanel" aria-labelledby="nav-tab-<?= $item['list_title'] . "-" . $item['_id'] ?>">

								<div class="owl-carousel">
							<?php		
							foreach ( $item['produtos'] as $keys ) {

								$carousel_item = explode('$', $keys);
							?>
								<div class="product-tabs__item">
									<img src="<?= $carousel_item[1] ?>">
									<p class="product-tabs__item-text"><?= $carousel_item[2] ?></p>
								</div>
							<?php
							}
							?>
								</div>

							</div>
						<?php
						} else {
							?>
							<div class="tab-pane fade show" id="nav-<?= $item['list_title'] . "-" . $item['_id'] ?>" role="tabpanel" aria-labelledby="nav-tab-<?= $item['list_title'] . "-" . $item['_id'] ?>">
								<div class="owl-carousel">
							<?php		
							foreach ( $item['produtos'] as $keys ) {

								$carousel_item = explode('$', $keys);
							?>
								<div class="product-tabs__item">
									<img src="<?= $carousel_item[1] ?>">
									<p class="product-tabs__item-text"><?= $carousel_item[2] ?></p>
								</div>
							<?php
							}
							?>
								</div>
							</div>
						<?php
						}
						// echo '<dt class="elementor-repeater-item-' . $item['_id'] . '">' . $item['list_title'] . '</dt>';
						// echo '<dd>' . $item['list_content'] . '</dd>';
					}
					
				}
				?>
				
			</div>
			
			<script>
				$(document).ready(function (){
					$(".owl-carousel").owlCarousel({
						items: <?= $settings['items'] ?>,
						margin: <?= $settings['margin_items']['size'] ?>,
					});
				});
			</script>
		<?php
	}

	// JS RENDER
	protected function _content_template() {
		
		?>

			<nav>
				<ul class="nav product-tabs__nav-tab nav-tabs justify-content-center align-items-end font-weight-bold" role="tablist">
					
				<# if ( settings.list.length ) { 
					
					_.each( settings.list, function( item, i ) {

						if (i == 0) {
				#>
							<li class="product-tabs__nav-item rounded-0 d-flex justify-content-center align-items-center">
								<a class="product-tabs__nav-link nav-link d-flex justify-content-center align-items-center active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{{ item.list_title }}}</a>
							</li>
				<#
						} else {
				#>
							<li class="product-tabs__nav-item rounded-0 d-flex justify-content-center align-items-center">
								<a class="product-tabs__nav-link nav-link d-flex justify-content-center align-items-center" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{{ item.list_title }}}</a>
							</li>
				<#	
						}
				#>
						<!-- <dt class="elementor-repeater-item-{{ item._id }}">{{{ item.list_title }}}</dt>
						<dd>{{{ item.list_content }}}</dd> -->
				<# });
				}
				#>
				</ul>
			</nav>
			<div class="product-tabs__tab-content tab-content px-5 py-4">
				
				<# if ( settings.list.length ) { 
					
					_.each( settings.list, function( item, i ) {
						
						if (i == 0) {
				#>
							<div class="tab-pane fade show active" id="nav-{{ item.list_title }}-{{ item._id }}" role="tabpanel" aria-labelledby="nav-tab-{{ item.list_title }}-{{ item._id }}">

								<div class="owl-carousel">
							<#		
							_.each( item.produtos, function( keys, index ) {
								var carousel_item = keys.split("$");
							#>
								
									<div class="product-tabs__item">
										<img src="{{ carousel_item[1] }}">
										<p class="product-tabs__item-text">{{{ carousel_item[2] }}}</p>
									</div>
							<#
							});
							#>
								</div>

							</div>
				<#
						} else {
				#>
							<div class="tab-pane fade show" id="nav-{{ item.list_title }}-{{ item._id }}" role="tabpanel" aria-labelledby="nav-tab-{{ item.list_title }}-{{ item._id }}">
								<div class="owl-carousel">
							<#		
							_.each( item.produtos, function( keys, index ) {
								var carousel_item = keys.split("$");
							#>
								
									<div class="product-tabs__item">
										<img src="{{ carousel_item[1] }}">
										<p class="product-tabs__item-text">{{{ carousel_item[2] }}}</p>
									</div>
							<#
							});
							#>
								</div>
							</div>
				<#	
						}
				#>
						<!-- <dt class="elementor-repeater-item-{{ item._id }}">{{{ item.list_title }}}</dt>
						<dd>{{{ item.list_content }}}</dd> -->
				<# });
				}
				#>
				
			</div>
			<script>
				$(document).ready(function (){
					$(".owl-carousel").owlCarousel({
						items: {{{ settings.items }}},
						margin: {{{ settings.margin_items.size }}},
					});
				});
			</script>

		<?php

	}
}
