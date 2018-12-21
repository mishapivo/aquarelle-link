<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$url = admin_url('options-general.php?page=wpadm-ga-menu-settings');
echo '<div class="error"><p>'.__('The site reports about error! Please deactivate and activate plugin', 'analytics-counter'). ' '. WPADM_GA__PLUGIN_NAME . '</p></div>';
