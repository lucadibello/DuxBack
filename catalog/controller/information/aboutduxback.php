<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 21.06.2019
 * Time: 09:39
 */

class ControllerInformationAboutDuxback extends Controller
{
    public function index()
    {
        // Optional. This calls for your language file
        $this->load->language('information/aboutduxback');

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

        // Load language data from language file
        $data['heading_title'] = $this->language->get('heading_title');
        $data['about_duxback'] = $this->language->get('about_duxback');

        // Load image paths
        $data['img1'] = "image/catalog/about_duxback/about_pic1.jpg";
        $data['img2'] = "image/catalog/about_duxback/about_pic2.jpg";

        // All the necessary page elements
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');


        // Load the template file and show output
        $this->response->setOutput($this->load->view('information/aboutduxback', $data));
    }
}