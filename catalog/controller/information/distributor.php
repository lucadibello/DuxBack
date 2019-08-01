<?php
class ControllerInformationDistributor extends Controller {
    private $errors = array();
    public function index() {
		$this->load->language('information/distributor');
		$this->document->addScript('https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js');
        $this->document->addScript('https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.js');
        $this->document->addScript('catalog/view/javascript/validator.js');

		$this->document->setTitle($this->language->get('Distributor'));


        // Check if a form has been submitted
		if($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validate()) {

			// If all the data is valid -> Add data to the database using the model class
            $this->load->model("information/distributor");

            // Add to database
            $this->model_information_distributor->addDistributor($this->request->post);

            // Redirect to success page
			$this->response->redirect($this->url->link('event/success'));
		}

		// Breadcrumbs for the page
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/distributor')
		);

		// Get "heading_title" from language file
		$data['heading_title'] = $this->language->get('heading_title');

		$data['google_token'] = "AIzaSyCop8v9D-EOlJbnc1nno_OIq6iOJ4bNrlU";

		// All the necessary page elements
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['conte$(document).ready(function () {nt_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
        $data["errors"] = $this->errors;


		// Load the template file and show output
		$this->response->setOutput($this->load->view('information/distributor', $data));
	}

    private function validate(): bool
    {
        $this->errors = array();

        $regions = array("Antrim", "Armagh", "Carlow", "Cavan", "Clare", "Cork", "Derry",
            "Donegal", "Down", "Dublin", "Fermanagh", "Galway", "Kerry", "Kildare",
            "Kilkenny", "Laois", "Leitrim", "Limerick", "Longford", "Louth", "Mayo",
            "Meath", "Monaghan", "Offaly", "Roscommon", "Sligo", "Tipperary", "Tyrone",
            "Waterford", "Westmeath", "Wexford", "Wicklow");

            
        foreach ($this->request->post as $key => $value) {
            $this->request->post[$key] = self::test_input($value);
        }

        // Company name
        if (!(strlen($this->request->post['company_name']) < 255 && ctype_alnum(str_replace(' ', '',$this->request->post['company_name'])))) {
            array_push($this->errors,$this->language->get('error_company_name'));
        }

        // Region
        if (!(in_array(ucfirst(strtolower($this->request->post["region"])), $regions))) {
            array_push($this->errors,$this->language->get('error_region'));
        }

        // Email
        if (!(strlen($this->request->post['email']) < 255 && filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL))){
            array_push($this->errors,$this->language->get('error_email'));
        }

        // Website
        if(!(strlen($this->request->post['company_website']) < 255 && filter_var($this->request->post['company_website'], FILTER_VALIDATE_URL))){
            array_push($this->errors,$this->language->get('error_website'));
        }

        // Phone number
        if(!(self::phone_validation($this->request->post["phone"]))){
            array_push($this->errors,$this->language->get('error_phone'));
        }

        // Manager first name
        if (!(strlen($this->request->post['manager_firstname']) < 255 && ctype_alpha(str_replace(' ', '', $this->request->post['manager_firstname'])))) {
            array_push($this->errors,$this->language->get('error_manager_firstname'));
        }

        // Manager last name
        if (!(strlen($this->request->post['manager_lastname']) < 255 && ctype_alpha(str_replace(' ', '', $this->request->post['manager_lastname'])))) {
            array_push($this->errors,$this->language->get('error_manager_lastname'));
        }

        // Street
        if (!(strlen($this->request->post['street']) < 255 && ctype_print($this->request->post['street']))) {
            array_push($this->errors,$this->language->get('error_street'));
        }

        // City
        if (!(strlen($this->request->post['city']) < 255 && ctype_alnum(str_replace(' ', '', $this->request->post['city'])))) {
            array_push($this->errors,$this->language->get('error_city'));
        }

        // House number
        if (!(strlen($this->request->post['house_number']) <= 10 && ctype_alnum(str_replace(' ', "", $this->request->post['house_number'])))) {
            array_push($this->errors,$this->language->get('error_house_number'));
        }

        // Latitude
        if (!is_numeric($this->request->post['lat'])){
            array_push($this->errors,$this->language->get('error_lat'));
        }

        // Logitude
        if (!is_numeric($this->request->post['lng'])){
            array_push($this->errors,$this->language->get('error_lng'));
        }

        return count($this->errors) == 0;
	}

    private function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

	private function phone_validation($phone){
        // Allow +, - and . in phone number
        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);

        // Remove "-" from number
        $phone_to_check = str_replace("-", "", $filtered_phone_number);

        // Check the lenght of number
        // This can be customized if you want phone number from a specific country
        if (strlen($phone_to_check) < 8 || strlen($phone_to_check) > 14) {
            return false;
        } else {
            return true;
        }
    }
}