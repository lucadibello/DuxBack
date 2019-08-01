<?php

class ControllerToolBooking extends Controller
{

    public function index()
    {
        // Optional. This calls for your language file
        $this->load->language('information/finder');
        $this->document->addScript('https://cdn.jsdelivr.net/npm/flatpickr');
        $this->document->addScript('//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js');

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

        // Load coordinates for markers
        $data["markers"] = array();

        $this->load->model("information/finder");
        $data["markers"] = $this->model_information_finder->getSuppliers();

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
        // MUST change THIS
        $data["logged"] = /*$this->customer->isLogged()*/
            true;


        // Load the template file and show output
        $this->response->setOutput($this->load->view('information/finder', $data));
    }
}