<?php

/*
	Plugin name: Custom Elementor Widgets by Immo
	Description: Add widgets for Elementor page builder
	Version: 1.0.0
	Author: Igor Mendes
	Author uri: https://immosolucoes.com.br
	License: GPLv2 or later
*/

namespace IMMO;

class CEWI_Widget_loader {
    
    private static $_instance = null;
    
    public static function instance() {
		
		if(is_null(self::$_instance)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
	
	private function include_widgets_files() {
		require_once(__DIR__ . '/widgets/product-tabs.php');
	}


	public function register_widgets() {
		
		$this->include_widgets_files();

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Product_Tabs());

	}


	public function __construct() {
		
		add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets'], 99);
		
		wp_register_style('cewi_bs4_style', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
		wp_enqueue_style('cewi_bs4_style');

		wp_register_script( 'cewi_jquery_script', 'https://code.jquery.com/jquery-3.3.1.slim.min.js');
		wp_enqueue_script('cewi_jquery_script');

		wp_register_script( 'cewi_popper_script', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js');
		wp_enqueue_script('cewi_popper_script');

		wp_register_script( 'cewi_bs4_script', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js');
		wp_enqueue_script('cewi_bs4_script');

		wp_register_style('cewi_owlcarousel_style', plugins_url('owlcarousel/dist/assets/owl.carousel.min.css', __FILE__ ));
		wp_enqueue_style('cewi_owlcarousel_style');

		wp_register_style('cewi_owlcarousel_default_style', plugins_url('owlcarousel/dist/assets/owl.theme.default.min.css', __FILE__ ));
		wp_enqueue_style('cewi_owlcarousel_default_style');

		wp_register_script( 'cewi_owlcarousel_script', plugins_url('owlcarousel/dist/owl.carousel.min.js', __FILE__ ));
		wp_enqueue_script('cewi_owlcarousel_script');

		wp_register_style('cewi_style', plugins_url('style.css',__FILE__ ));
		wp_enqueue_style('cewi_style');

		//wp_enqueue_script('jquery');
		wp_register_script( 'cewi_script', plugins_url('scripts.js',__FILE__ ));
		wp_enqueue_script('cewi_script');
		
	}

}

//Instantiate plugin class
CEWI_Widget_Loader::instance();