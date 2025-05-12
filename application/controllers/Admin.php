<?php
class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('License_model');
    }

    public function index() {
        $data['licenses'] = $this->License_model->get_all();
        $this->load->view('admin/list', $data);
    }

    public function add() {
        if ($_POST) {
            $this->License_model->insert($this->input->post());
            redirect('admin');
        }
        $this->load->view('admin/form');
    }

    public function edit($id) {
        if ($_POST) {
            $this->License_model->update($id, $this->input->post());
            redirect('admin');
        }
        $data['license'] = $this->License_model->get($id);
        $this->load->view('admin/form', $data);
    }

    public function delete($id) {
        $this->License_model->delete($id);
        redirect('admin');
    }
}
