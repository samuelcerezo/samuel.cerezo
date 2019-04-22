<?php

namespace Samuel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

if (! defined('ABSPATH')) {
	exit;
}

class Elementor_Map extends Widget_Base {

	public function get_name() {
		return 'Elementor_Map';
	}

	public function get_title() {
		return 'Mapbox';
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return ['theme'];
	}

	public function get_script_depends() {
		return [];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => __('Configuration', 'theme'),
			]
		);

		$this->add_control(
			'autocenter',
			[
				'label' => __('Auto center', 'theme'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'returned_value' => 'yes'
			]
		);

		$this->add_control(
			'center',
			[
				'label' => __('Center', 'elementor'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'conditions' => [
					'terms' => [
						[
							'name' => 'autocenter',
							'operator' => '!=',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'center_padding',
			[
				'label' => __('Padding', 'theme'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
			]
		);

		$this->add_control(
			'zoom',
			[
				'label' => __('Zoom Level', 'theme'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20
					]
				]
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => __('Height', 'theme'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 300,
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1000,
						'step' => 10
					],
					'vh' => [
						'min' => 10,
						'max' => 1000,
						'step' => 10
					],
					'vw' => [
						'min' => 10,
						'max' => 1000,
						'step' => 10
					]
				],
				'size_units' => ['px', 'vh', 'vw'],
				'selectors' => [
					'{{WRAPPER}} .map-wrapper' => 'height: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'scroll',
			[
				'label' => __('Prevent Scroll', 'theme'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'returned_value' => 'yes'
			]
		);

		$this->add_control(
			'poi',
			[
				'label' => __('Show POIs', 'theme'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'returned_value' => 'yes'
			]
		);

		$this->add_control(
			'zoom_control',
			[
				'label' => __('Show zoom control', 'theme'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'returned_value' => 'yes'
			]
		);

		$this->add_control(
			'zoom_click',
			[
				'label' => __('Zoom when double click', 'theme'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'returned_value' => 'yes'
			]
		);

		$this->add_control(
			'dragging',
			[
				'label' => __('Available drag the map', 'theme'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'returned_value' => 'yes'
			]
		);

		$this->add_control(
			'token',
			[
				'label' => __('Token', 'theme'),
				'type' => Controls_Manager::TEXT
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __('Style. <a href="https://www.mapbox.com/studio" target="_blank">Get styles</a>.', 'theme'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Url', 'theme')
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_markers',
			[
				'label' => __('Markers', 'theme'),
				'type' => Controls_Manager::SECTION,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'address',
			[
				'label' => __('Coordinates', 'elementor'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label' => __('Choose icon', 'theme'),
				'type' => Controls_Manager::MEDIA
			]
		);

		$repeater->add_responsive_control(
			'size',
			[
				'label' => __('Size', 'theme'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1000,
						'step' => 1
					],
				],
				'size_units' => ['px'],
			]
		);

		$repeater->add_control(
			'position',
			[
				'label' => __('Position', 'theme'),
				'type' => Controls_Manager::SELECT,
				'default' => 'bc',
				'options' => [
					'tl' => __('Top left', 'theme'),
					'tc' => __('Top center', 'theme'),
					'tr' => __('Top right', 'theme'),
					'cl' => __('Center left', 'theme'),
					'cc' => __('Center', 'theme'),
					'cr' => __('Center right', 'theme'),
					'bl' => __('Bottom left', 'theme'),
					'bc' => __('Bottom center', 'theme'),
					'br' => __('Bottom right', 'theme'),
				]
			]
		);

		$repeater->add_control(
			'info',
			[
				'label' => __('Bubble info', 'theme'),
				'type' => Controls_Manager::TEXTAREA,
			]
		);

		$repeater->add_control(
			'bubble_show',
			[
				'label' => __('Open on click', 'theme'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'returned_value' => 'yes'
			]
		);

		$this->add_control(
			'markers',
			[
				'label' => __('Markers', 'theme'),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields' => array_values($repeater->get_controls()),
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();

		$center = null;

		if (is_numeric(str_replace(array(',', '.', '-', ' '), '', $settings['center']))) {
			$center = array('lat' => trim(explode(',', $settings['center'])[1]), 'lng' => trim(explode(',', $settings['center'])[0]));
		}

		wp_enqueue_script('mapbox', get_template_directory_uri().'/js/mapbox.js', array('jquery'), uniqid(), true);

		wp_enqueue_style('mapbox', get_template_directory_uri().'/css/mapbox.css', array());

		$out = '<div class="map-wrapper" id="map-'.$this->get_id().'" style="display: block;"></div>'."\n";
		$out .= '<script type="text/javascript">'."\n";
		$out .= '	var options_'.$this->get_id().' = {'."\n";
		if (!is_null($center) && ($center['lat'] != '' && $center['lng'] != '')) {
			$out .= '		center: ['.$center['lat'].', '.$center['lng'].'],'."\n";
		}
		$out .= '		zoom: '.$settings['zoom']['size'].','."\n";
		$out .= '		token: \''.$settings['token'].'\','."\n";
		if ($settings['zoom_control'] == 'yes') {
			$out .= '		showZoom: true,'."\n";
		} else {
			$out .= '		showZoom: false,'."\n";
		}
		if ($settings['zoom_click'] == 'yes') {
			$out .= '		doubleClickZoom: true,'."\n";
		} else {
			$out .= '		doubleClickZoom: false,'."\n";
		}
		if ($settings['scroll'] == 'yes') {
			$out .= '		scrollZoom: false,'."\n";
		} else {
			$out .= '		scrollZoom: true,'."\n";
		}
		if ($settings['style'] != '') {
			$out .= '		style: "'.$settings['style'].'",'."\n";
		} else {
			$out .= '		style: "mapbox://styles/mapbox/streets-v9",'."\n";
		}
		if (count($settings['markers']) > 0) {
			$out .= '		markers: ['."\n";
			foreach ($settings['markers'] as $marker) {
				$out .= '			{'."\n";
				$out .= '				position: ['.trim(explode(',', $marker['address'])[1]).', '.trim(explode(',', $marker['address'])[0]).'],'."\n";
				if ($marker['icon']) {
					$out .= '				icon: {'."\n";
					$out .= '					url: \''.$marker['icon']['url'].'\','."\n";
					$out .= '					size: ['.$marker['size']['size'].', '.($marker['size_tablet']['size'] ? $marker['size_tablet']['size'] : $marker['size']['size']).', '.($marker['size_mobile']['size'] ? $marker['size_mobile']['size'] : $marker['size']['size']).'],'."\n";
					switch ($marker['position']) {
						case 'tl':
							$anchor = [1, -1];
							break;
						case 'tc':
							$anchor = [0, -1];
							break;
						case 'tr':
							$anchor = [-1, -1];
							break;
						case 'cl':
							$anchor = [1, 0];
							break;
						case 'cc':
							$anchor = [0, 0];
							break;
						case 'cr':
							$anchor = [-1, 0];
							break;
						case 'bl':
							$anchor = [1, 1];
							break;
						case 'bc':
							$anchor = [0, 1];
							break;
						case 'br':
							$anchor = [-1, 1];
							break;
					}
					$out .= '					anchor: ['.$anchor[0].', '.$anchor[1].'],'."\n";
					$out .= '				},'."\n";
					$out .= '				info: {'."\n";
					$out .= '					text: \''.$marker['info'].'\','."\n";
					$out .= '					open: \''.$marker['bubble_show'].'\','."\n";
					$out .= '				}'."\n";
				}
				$out .= '			},'."\n";
			}
			$out .= '		],'."\n";
		}
		$out .= '	};'."\n";
		if ($settings['autocenter'] == 'yes' && count($settings['markers']) > 0) {
			$temp = array();
			foreach ($settings['markers'] as $marker) {
				array_push($temp, '['.trim(explode(',', $marker['address'])[1]).', '.trim(explode(',', $marker['address'])[0]).']');
			}
			$out .= '	options_'.$this->get_id().'.bounds = ['.implode(', ', $temp).'];'."\n";
			$temp = $padding = array();
			foreach ($settings['center_padding'] as $key => $value) {
				if (!in_array($key, array('unit', 'isLinked'))) {
					array_push($temp, $key.': '.$value);
				}
			}
			array_push($padding, '{'.implode(', ', $temp).'}');
			$temp = array();
			foreach ($settings['center_padding_tablet'] as $key => $value) {
				if (!in_array($key, array('unit', 'isLinked'))) {
					array_push($temp, $key.': '.$value);
				}
			}
			array_push($padding, '{'.implode(', ', $temp).'}');
			$temp = array();
			foreach ($settings['center_padding_mobile'] as $key => $value) {
				if (!in_array($key, array('unit', 'isLinked'))) {
					array_push($temp, $key.': '.$value);
				}
			}
			array_push($padding, '{'.implode(', ', $temp).'}');
			$out .= '	options_'.$this->get_id().'.padding = ['.implode(', ', $padding).'];'."\n";
		}

		$out .= '</script>'."\n";

		echo $out;

	}

	protected function content_template() {

	}
}
