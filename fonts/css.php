<?php

header("Content-type: text/css; charset: UTF-8");

require_once('../../../../wp-load.php');

$fonts = array();

foreach (scandir(get_template_directory().'/fonts') as $family) {

	if (!in_array($family, array('.', '..', 'css.php'))) {

		$fonts[$family] = array();

		foreach (scandir(get_template_directory().'/fonts/'.$family) as $variant) {

			if (!in_array($variant, array('.', '..'))) {

				$ext = pathinfo($variant)['extension'];

				$italic = false;

				if (strpos($variant, 'italic')) {
					$italic = true;
				}

				switch (pathinfo($variant)['filename']) {

					case 'bold':
					case 'bold-italic':
						$width = 'bold';
						break;

					case 'normal':
					case 'regular':
					case 'italic':
						$width = 'normal';
						break;

					case 'semibold':
					case 'semibold-italic':
					case 'semi-bold':
					case 'semi-bold-italic':
						$width = '600';
						break;

					case 'light':
					case 'light-italic':
						$width = '300';
						break;

					case 'thin':
					case 'thin-italic':
						$width = '100';
						break;

				}

				$fonts[$family][$width.($italic ? '-italic' : '')][$ext] = $variant;

			}

		}


	}

}

$out = '';

foreach ($fonts as $family => $variant) {

	foreach ($variant as $width => $variant) {

		$italic = false;

		if (strpos($width, 'italic')) {

			$italic = true;

			$width = str_replace('-italic', '', $width);

		}

		$out .= '@font-face {'."\n";
		$out .= '	font-family: \''.$family.'\';'."\n";

		if (isset($variant['eot'])) {
			$out .= '	src: url(\'../fonts/'.$family.'/'.$variant['eot'].'\');'."\n";
		}

		$i = 1;

		foreach ($variant as $ext => $name) {

			$out .= '	'.($i == 1 ? 'src:' : '	').' url(\'../fonts/'.$family.'/'.$name.($ext == 'eot' ? '?#iefix' : '').'\') format(\''.strtr($ext, array('eot' => 'embedded-opentype', 'ttf' => 'truetype')).'\')'.($i == count($variant) ? ';' : ',')."\n";

			$i++;

		}

		$out .= '	font-weight: '.$width.';'."\n";
		$out .= '	font-style: '.($italic ? 'italic' : 'normal').';'."\n";
		$out .= '}'."\n";
		$out .= ''."\n";

	}

}

echo $out;

?>