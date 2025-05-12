<?php
class Domains extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('domain_model');
        $this->load->library('whois_api');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['domains'] = $this->domain_model->get_all_domains();
        $this->load->view('domains/list', $data);
    }

    public function add() {
        $this->form_validation->set_rules('domain_name', 'Domain Name', 'required|valid_url');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('domains/add');
        } else {
            $domain = $this->input->post('domain_name');
            $whois_data = $this->whois_api->get_domain_info($domain);

            $domain_data = array(
                'domain_name' => $domain,
                'registrar' => $this->whois_api->parse_registrar($whois_data),
                'creation_date' => $this->whois_api->parse_creation_date($whois_data),
                'expiration_date' => $this->whois_api->parse_expiration_date($whois_data),
                'status' => $this->whois_api->parse_status($whois_data),
                'updated_at' => date('Y-m-d H:i:s')
            );

            if ($domain_data['expiration_date']) {
                $expiry = new DateTime($domain_data['expiration_date']);
                $today = new DateTime();
                $interval = $today->diff($expiry);
                $domain_data['days_until_expiry'] = $interval->days;
            }

            $this->domain_model->add_domain($domain_data);
            redirect('domains');
        }
    }

    public function edit($id) {
        $this->form_validation->set_rules('domain_name', 'Domain Name', 'required');
        $this->form_validation->set_rules('expiration_date', 'Expiration Date', 'required');

        $data['domain'] = $this->domain_model->get_domain($id);

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('domains/edit', $data);
        } else {
            $post_data = $this->input->post();
            
            // Calculate days until expiry
            $expiry = new DateTime($post_data['expiration_date']);
            $today = new DateTime();
            $interval = $today->diff($expiry);
            $post_data['days_until_expiry'] = $interval->days;
            $post_data['updated_at'] = date('Y-m-d H:i:s');

            $this->domain_model->update_domain($id, $post_data);
            redirect('domains');
        }
    }

    public function delete($id) {
        $this->domain_model->delete_domain($id);
        redirect('domains');
    }

    public function refresh($id) {
        $domain = $this->domain_model->get_domain($id);
        $whois_data = $this->whois_api->get_domain_info($domain->domain_name);

        $domain_data = array(
            'registrar' => $this->whois_api->parse_registrar($whois_data),
            'creation_date' => $this->whois_api->parse_creation_date($whois_data),
            'expiration_date' => $this->whois_api->parse_expiration_date($whois_data),
            'status' => $this->whois_api->parse_status($whois_data),
            'updated_at' => date('Y-m-d H:i:s')
        );

        if ($domain_data['expiration_date']) {
            $expiry = new DateTime($domain_data['expiration_date']);
            $today = new DateTime();
            $interval = $today->diff($expiry);
            $domain_data['days_until_expiry'] = $interval->days;
        }

        $this->domain_model->update_domain($id, $domain_data);
        redirect('domains');
    }

    public function check_expiring() {
        $data['expiring_domains'] = $this->domain_model->get_expiring_domains(30); // Domains expiring in next 30 days
        $this->load->view('domains/expiring', $data);
    }
}