
<?php
class MY_Form_validation extends CI_Form_validation {
    
    public function __construct($rules = array()) {
        parent::__construct($rules);
    }

    public function valid_domain($domain) {
        $domain = preg_replace('#^https?://#', '', $domain);
        
        // Check if domain is valid and has at least one dot
        if (!preg_match('/^([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,}$/i', $domain)) {
            $this->set_message('valid_domain', 'The %s field must contain a valid domain name');
            return false;
        }
        
        return true;
    }
}