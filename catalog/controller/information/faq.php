<?php
class ControllerInformationFaq extends Controller {

	public function index() {
		// Optional. This calls for your language file
		$this->load->language('information/faq');
		
		// Optional. Set the title of your web page
		$this->document->setTitle($this->language->get('heading_title'));

		// Breadcrumbs for the page
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/static')
		);

		// Load questions and answers
        $data["questions"] = array();
        $data["answers"] = array();

        for($i = 1; $i < 8; $i++){
            array_push($data["questions"],$this->language->get('question_'.$i));
            array_push($data["answers"],$this->language->get('answer_'.$i));
        }

		// All the necessary page elements
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		// Load the template file and show output
		$this->response->setOutput($this->load->view('information/faq', $data));
	}
}
