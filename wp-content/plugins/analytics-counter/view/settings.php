<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if (isset($_GET['modal'])):
    wp_register_style( 'wpadm-ga-modal-css', plugins_url(WPADM_GA__PLUGIN_NAME. '/view/scripts/wpadm-ga-modal.css' ) );
    wp_enqueue_style( 'wpadm-ga-modal-css' );

endif;

require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'settings_ga_account.php';
