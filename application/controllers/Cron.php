<?php
class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('domain_model');
        $this->load->library('whois_api');
        $this->load->library('email');
    }

    public function check_domains() {
        // Only allow this to be run from the command line
        if (!$this->input->is_cli_request()) {
            show_error('Direct access is not allowed');
        }

        $domains = $this->domain_model->get_all_domains();
        $expiring_soon = array();

        foreach ($domains as $domain) {
            // Refresh domain info
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

                if ($interval->days < 30) {
                    $expiring_soon[] = $domain;
                }
            }

            $this->domain_model->update_domain($domain->id, $domain_data);
        }

        // Send email notification if domains are expiring soon
        if (!empty($expiring_soon)) {
            $this->send_expiration_notification($expiring_soon);
        }

        echo "Domain check completed. " . count($expiring_soon) . " domains expiring soon.\n";
    }

    protected function send_expiration_notification($domains) {
        $this->load->config('email');
        
        $message = "The following domains are expiring soon:\n\n";
        
        foreach ($domains as $domain) {
            $message .= "Domain: {$domain->domain_name}\n";
            $message .= "Expires: {$domain->expiration_date} (in {$domain->days_until_expiry} days)\n";
            $message .= "Registrar: {$domain->registrar}\n";
            $message .= "----------------------------------------\n";
        }

        $this->email->from('noreply@yourdomain.com', 'Domain Monitor');
        $this->email->to('admin@yourdomain.com');
        $this->email->subject('Domain Expiration Alert');
        $this->email->message($message);
        
        $this->email->send();
    }
}