<?php
class ControllerInformationContactUs extends Controller {

    // Stores all the errors found during the validation process
    private $errors = array();

    public function index() {
		// Optional. This calls for your language file
		$this->load->language('information/contactus');
		
		// Optional. Set the title of your web page
		$this->document->setTitle($this->language->get('heading_title'));

        // Check if a form has been submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validate()) {

            // If all the data is valid -> Add data to the database using the model class
            $this->load->model("information/contactus");

            // Send message with SMTP Server
            $status = $this->model_information_contactus->sendMail($this->request->post);

            // Email data recived
            $data["email"] = true;

            // Set flag for modal
            if (!$status) {
                // Email error
                $data["emailError"];
            }
        }

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
		
		// Get "heading_title" from language file
		$data['heading_title'] = $this->language->get('heading_title');

		// All the necessary page elements
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		// Load the template file and show output
		$this->response->setOutput($this->load->view('information/contactus', $data));
	}

	private function validate(): bool{

        $message_types = ["Information", "Bug report", "Other"];

        // Clear all the data
        foreach ($this->request->post as $key => $value) {
            $this->request->post[$key] = self::test_input($this->request->post[$key]);
        }
        /*
         * Start validation process
         */

        // First name
        if (!(strlen($this->request->post['firstname']) < 255 && ctype_alpha($this->request->post['firstname']))) {
            $this->error['firstname'] = $this->language->get('error_manager_firstname');
        }

        // Last name
        if (!(strlen($this->request->post['surname']) < 255 && ctype_alpha($this->request->post['surname']))) {
            $this->error['surname'] = $this->language->get('error_manager_lastname');
        }

        // Email address
        if (!(strlen($this->request->post['mailFrom']) < 255 && filter_var($this->request->post['mailFrom'], FILTER_VALIDATE_EMAIL))){
            $this->error['mailFrom'] = $this->language->get('error_email');
        }

        // Message type
        if (!(in_array(ucfirst(strtolower($this->request->post["messageType"])), $message_types))) {
            $this->errors['messageType'] = $this->language->get('error_message_type');
        }

        // Message body
        if(!(strlen($this->request->post["messageType"]) > 10 && strlen($this->request->post["messageType"]) < 512)){
            $this->errors["messageBody"] = $this->language->get('error_message_body');
        }

        var_dump($this->errors);

        // Return data
        return count($this->errors) == 0;
	}

	private function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
