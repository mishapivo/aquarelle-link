<?php

class WPAdm_GA_Options
{
    const OPTIONNAME = 'wpadm_ga';
    const TYPE_CODE_UNIVERSAL = 'universal';
    
    protected $ga_access_token = null;
    protected $ga_expires_in = null;
    protected $ga_created = null;
    protected $ga_id = null;
    protected $ga_url = null;
    protected $ga_webPropertyId = null;
    protected $ga_enableCode = null;
    protected $ga_enableAnonymization = null;
    protected $ga_typeCode = '';
    protected $ga_menuOnlyAdmin = 1;

    protected $wpadmin_token = null;
    
    protected $dt_install = '';


    /**
     * @var WPAdm_GA_Options
     */
    static protected $instance = null;
    
    protected function __construct() {
        $wpadm_ga = get_option(self::OPTIONNAME);
        if (is_array($wpadm_ga)) {
            $this->ga_access_token = (isset($wpadm_ga['ga_access_token'])) ? $wpadm_ga['ga_access_token'] : null;
            $this->ga_created = (isset($wpadm_ga['ga_created'])) ? $wpadm_ga['ga_created'] : null;
            $this->ga_expires_in = (isset($wpadm_ga['ga_expires_in'])) ? $wpadm_ga['ga_expires_in'] : null;
            $this->ga_id = (isset($wpadm_ga['ga_id'])) ? $wpadm_ga['ga_id'] : null;
            $this->ga_url = (isset($wpadm_ga['ga_url'])) ? $wpadm_ga['ga_url'] : null;
            $this->ga_webPropertyId = (isset($wpadm_ga['ga_webPropertyId'])) ? $wpadm_ga['ga_webPropertyId'] : null;
            $this->ga_enableCode = (isset($wpadm_ga['ga_enableCode'])) ? $wpadm_ga['ga_enableCode'] : 1;
            $this->ga_enableAnonymization = (isset($wpadm_ga['ga_enableAnonymization'])) ? $wpadm_ga['ga_enableAnonymization'] : 1;
            $this->ga_menuOnlyAdmin = (isset($wpadm_ga['ga_menuOnlyAdmin'])) ? $wpadm_ga['ga_menuOnlyAdmin'] : 1;
            $this->ga_typeCode = self::TYPE_CODE_UNIVERSAL;
        }
        
        
    }                                           
    
    protected static function  getInstance() {
        $instance = new WPAdm_GA_Options();
        self::$instance = $instance;
        $instance->__construct();
    }
    
    public static function getGAAccessToken() {
        return self::getVar('ga_access_token');        
    }

    public static function getGAExpiresIn() {
        return self::getVar('ga_expires_in');        
    }

    public static function getGACreated() {
        return self::getVar('ga_created');        
    }

    public static function getGAId() {
        return self::getVar('ga_id');        
    }

    public static function getGAUrl() {
        return self::getVar('ga_url');        
    }

    public static function setGAAccessToken($ga_access_token) {
        if (is_null(self::$instance)) {
            self::getInstance();
        }
        self::$instance->ga_access_token = $ga_access_token;
        self::saveOptions();

    }
    
    public static function setGAExpiresIn($ga_expires_in) {
        if (is_null(self::$instance)) {
            self::getInstance();
        }
        self::$instance->ga_expires_in = $ga_expires_in;
        self::saveOptions();

    }
    
    public static function setGACreated($ga_created) {
        if (is_null(self::$instance)) {
            self::getInstance();
        }
        self::$instance->ga_created = $ga_created;
        self::saveOptions();

    }
    
    public static function setGAId($ga_id) {
        if (is_null(self::$instance)) {
            self::getInstance();
        }
        self::$instance->ga_id = $ga_id;
        self::saveOptions();
    }
    
    public static function setGAUrl($ga_url) {
        if (is_null(self::$instance)) {
            self::getInstance();
        }
        self::$instance->ga_url = $ga_url;
        self::saveOptions();
    }

    
    /** webPropertyId */
    public static function setGAWebPropertyId($ga_webPropertyId) {
        if (is_null(self::$instance)) {
            self::getInstance();
        }
        self::$instance->ga_webPropertyId = $ga_webPropertyId;
        self::saveOptions();
    }
    public static function getGAWebPropertyId() {
        return self::getVar('ga_webPropertyId');
    }

    /** enableCode */
    public static function setGAEnableCode($ga_enableCode) {
        if (is_null(self::$instance)) {
            self::getInstance();
        }
        self::$instance->ga_enableCode = $ga_enableCode;
        self::saveOptions();
    }
    public static function getGAEnableCode() {
        return self::getVar('ga_enableCode');
    }

    /** enableAnonymization */
    public static function setGAEnableAnonymization($ga_enableAnonymization) {
        if (is_null(self::$instance)) {
            self::getInstance();
        }
        self::$instance->ga_enableAnonymization = $ga_enableAnonymization;
        self::saveOptions();
    }
    public static function getGAEnableAnonymization() {
        return self::getVar('ga_enableAnonymization');
    }

    /** menuOnlyAdmin */
    public static function setGAMenuOnlyAdmin($ga_menuOnlyAdmin) {
        if (is_null(self::$instance)) {
            self::getInstance();
        }
        self::$instance->ga_menuOnlyAdmin = $ga_menuOnlyAdmin;
        self::saveOptions();
    }

    public static function getGAMenuOnlyAdmin() {
        return self::getVar('ga_menuOnlyAdmin');
    }


    /** typeCode */
    public static function setGATypeCode($ga_typeCode) {
        if (is_null(self::$instance)) {
            self::getInstance();
        }
        self::$instance->ga_typeCode = $ga_typeCode;
        self::saveOptions();
    }
    public static function getGATypeCode() {
        return self::getVar('ga_typeCode');
    }

    protected static function getVar($var) {
        if (is_null(self::$instance)) {
            self::getInstance();
        }
        return self::$instance->$var;
    }
    
    
    
    
    
    protected static function saveOptions() {
        if (is_null(self::$instance)) {
            self::getInstance();
        }
        update_option(self::OPTIONNAME, array(
            'ga_access_token' => self::$instance->ga_access_token,
            'ga_created' => self::$instance->ga_created,
            'ga_expires_in' => self::$instance->ga_expires_in,
            'ga_id' => self::$instance->ga_id,
            'ga_url' => self::$instance->ga_url,
            'ga_webPropertyId' => self::getGAWebPropertyId(),
            'ga_enableCode' => self::getGAEnableCode(),
            'ga_enableAnonymization' => self::getGAEnableAnonymization(),
            'ga_menuOnlyAdmin' => self::getGAMenuOnlyAdmin(),
            'ga_typeCode' => self::TYPE_CODE_UNIVERSAL
        ));
        
    }

    public static function gaTokenIsExpired() {
            
//        if (!self::getGAExpiresIn()) {
//            return true;
//        }
//
//        if (!self::getGACreated()) {
//            return true;
//        }


        return ! (self::getGACreated()+self::getGAExpiresIn() > time());
    }
    
}