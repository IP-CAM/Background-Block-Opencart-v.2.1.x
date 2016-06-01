<?php
class ControllerModulePvnmBackgroundBlock extends Controller {
	public function index($setting) {
		$filename = 'pvnm_background_block.' . md5(http_build_query($setting)) . '.' . (int)$this->config->get('config_store_id') . '.js';

		if (file_exists(DIR_CACHE . $filename) && $setting['cache'] == 1) {
			$this->document->addScript('system/storage/cache/' . $filename);
		} else {
			$script = '$(document).ready(function(){$(\'' . $setting['selector'] . '\').css({';

			if (!empty($setting['color'])) {
				$script .= '\'background-color\':\'' . $setting['color'] . '\'';

				if (!empty($setting['image']) || !empty($setting['position']) || !empty($setting['repeat'])) {
					$script .= ',';
				}
			}

			if (!empty($setting['image'])) {
				$script .= '\'background-image\':\'url(' . DIR_IMAGE . $setting['image'] . ')\'';

				if (!empty($setting['position']) || !empty($setting['repeat'])) {
					$script .= ',';
				}
			}

			if (!empty($setting['position'])) {
				$script .= '\'background-position\':\'' . $setting['position'] . '\',';
			}

			if (!empty($setting['repeat'])) {
				$script .= '\'background-repeat\':\'' . $setting['repeat'] . '\'';
			}

			$script .= '});});';

			$fileopen = DIR_CACHE . $filename;
			$open = fopen($fileopen, 'w+');
			fwrite ($open, $script);
			fclose ($open);

			$this->document->addScript('system/storage/cache/' . $filename);
		}
	}
}
