<?php
class Whois_api {

    protected $CI;
    protected $api_key;
    protected $api_url;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->config->load('whoisapi');
        $this->api_key = $this->CI->config->item('whois_api_key');
        $this->api_url = $this->CI->config->item('whois_api_url');
    }

    public function get_domain_info($domain) {
        // Remove http:// or https:// if present
        $domain = preg_replace('#^https?://#', '', $domain);
        
        $params = array(
            'apiKey' => $this->api_key,
            'domainName' => $domain,
            'outputFormat' => 'JSON'
        );

        $url = $this->api_url . '?' . http_build_query($params);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response, true);
    }

    public function parse_expiration_date($whois_data) {
        if (isset($whois_data['WhoisRecord']['expiresDate'])) {
            return date('Y-m-d', strtotime($whois_data['WhoisRecord']['expiresDate']));
        } elseif (isset($whois_data['WhoisRecord']['registryData']['expiresDate'])) {
            return date('Y-m-d', strtotime($whois_data['WhoisRecord']['registryData']['expiresDate']));
        }
        return null;
    }

    public function parse_creation_date($whois_data) {
        if (isset($whois_data['WhoisRecord']['createdDate'])) {
            return date('Y-m-d', strtotime($whois_data['WhoisRecord']['createdDate']));
        } elseif (isset($whois_data['WhoisRecord']['registryData']['createdDate'])) {
            return date('Y-m-d', strtotime($whois_data['WhoisRecord']['registryData']['createdDate']));
        }
        return null;
    }

    public function parse_registrar($whois_data) {
        if (isset($whois_data['WhoisRecord']['registrarName'])) {
            return $whois_data['WhoisRecord']['registrarName'];
        }
        return null;
    }

    public function parse_status($whois_data) {
        if (isset($whois_data['WhoisRecord']['status'])) {
            if (is_array($whois_data['WhoisRecord']['status'])) {
                return implode(', ', $whois_data['WhoisRecord']['status']);
            }
            return $whois_data['WhoisRecord']['status'];
        }
        return null;
    }
}