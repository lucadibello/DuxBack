<?php
class ControllerInformationFinder extends Controller {

    private $errors = array();

    /**
     * Default function used when the controller it's called.
     */
	public function index() {
		// Optional. This calls for your language file
		$this->load->language('information/finder');

		$this->document->addScript('https://cdn.jsdelivr.net/npm/flatpickr');
		$this->document->addScript('https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.js');
		$this->document->addScript('https://rawgit.com/moment/moment/2.2.1/min/moment.min.js');

		// Optional. Set the title of your web page
		$this->document->setTitle($this->language->get('heading_title'));

        if($_SERVER["REQUEST_METHOD"] == "POST" && self::validate_booking()){

            // Load model class
            $this->load->model("tool/booking");

            $this->request->post["user_id"] = 1;

            if($this->model_tool_booking->isUnique($this->request->post)){
                // Add to database
                $this->model_tool_booking->addBooking($this->request->post);

                // Retrieve data for modal notification
                $data["booking_date"] = $this->request->post["date"];
                $data["booking_time"] = $this->request->post["time"];
                $data["booking_success"] = True;
            }
            else{
                // If it's not unique
                array_push($this->errors,$this->language->get('unique_error'));
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
		
		// Load coordinates for markers
		$data["markers"] = array();
		
		$this->load->model("information/finder");
		$data["markers"] = self::htmlEntries($this->model_information_finder->getSuppliers());

		//TODO: FINISH HERE
		// Load bookings
        $data["bookings"] = array();

        $this->load->model("tool/booking");
        $data["bookings"] = $this->model_tool_booking->getBookings();

		// Get "heading_title" from language file
        $data['heading_title'] = $this->language->get('heading_title');

		// All the necessary page elements
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		// Set the token for the Google Maps API
		$data["maps_token"] = "AIzaSyCop8v9D-EOlJbnc1nno_OIq6iOJ4bNrlU";

		// Check if user is logged
		// TODO: MUST change THIS
		$data["logged"] = $this->customer->isLogged();

		$data["errors"] = $this->errors;

		// Get time and date from server
        date_default_timezone_set("Europe/Dublin");
        $data["time"] = date("H:i");
        $data["date"] = date("Y-m-d");

        // Load the template file and show output
		$this->response->setOutput($this->load->view('information/finder', $data));
	}

    /**
     * This function validate all the data recived from a POST request.
     * @return bool True if all the data is valid, otherwise False.
     */
    private function validate_booking(): bool {
	    $this->errors = array();

        // Clear data using test_input function
        foreach ($this->request->post as $key => $value) {
            $this->request->post[$key] = self::test_input($this->request->post[$key]);
        }

        // Time
        if(!(preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $this->request->post["time"]))){
            array_push($this->errors,$this->language->get('time_error'));
        }

        // Date
        $temp = new DateTime();

        // Create date object (without time)
        $date = DateTime::createFromFormat('Y-m-d', $this->request->post["date"]);

        // Remove time from datetime string
        $now = DateTime::createFromFormat("Y-m-d", $temp->format("Y-m-d"));

        // Extract data
        $year = $date->format("Y");
        $month = $date->format("m");
        $day = $date->format("d");

        if($date < $now){
            array_push($this->errors,$this->language->get('date_past_error'));
        }
        else if(!checkdate($month,$day,$year)) {
            //$this->errors["date"] = $this->language->get('date_error');
            array_push($this->errors,$this->language->get('date_value_error'));
        }

        //TODO: REMOVE
        return count($this->errors) == 0;
    }

    /**
     * @param array $data Cycle through all the data in the passed array and parse all the ASCII
     * characters to HTML-valid characters.
     *
     * @return array Parsed data.
     */
    private function htmlEntries(array $data)
    {
        foreach ($data as $row) {
            foreach ($row as $key => $value) {
                $row[$key] = htmlentities($value);
            }
        }

        return $data;
    }

    private function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
