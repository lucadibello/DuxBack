<?php
class ControllerExtensionModuleTGtgliteRevolutionSlider extends Controller {
	public function index($setting) {
		
		$this->load->model('slider/tg_tglite_revolution_slider');

		$data['slider'] = $this->model_slider_tg_tglite_revolution_slider->getSlider($setting['slider_id']);
		
		$data['language_id'] = $this->config->get('config_language_id');

		return $this->load->view('extension/module/tg_tglite_revolution_slider', $data);
	}
}
?>