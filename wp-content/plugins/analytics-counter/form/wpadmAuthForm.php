<?php
class wpadmAuthForm extends wpadmForm
{
    public function isValid() {
        $data = $this->data;

        if (empty($data['wpadm_username'])) {
            $this->addError('Please enter e-mail', 'wpadm_username');
        } elseif (!filter_var($data['wpadm_username'], FILTER_VALIDATE_EMAIL)) {
            $this->addError('Please enter correct e-mail', 'wpadm_username');
        }

        if (empty($data['wpadm_password'])) {
            $this->addError('Please enter password', 'wpadm_password');
        }
        
        if (!empty($data['wpadm_imnewuser_checkbox'])) {
            if (empty($data['wpadm_password_confirm'])) {
                $this->addError('Please enter confirm password', 'wpadm_password_confirm');
            }
            
            if ($data['wpadm_password'] != $data['wpadm_password_confirm']) {
                $this->addError('Confirm password same as password', 'wpadm_password_confirm');
            }
        }
        return empty($this->errors);
    }
}