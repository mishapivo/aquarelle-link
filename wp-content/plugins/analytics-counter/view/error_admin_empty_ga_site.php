<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$url = admin_url('options-general.php?page=wpadm-ga-menu-settings');
echo '<div class="error">
    <p>'.__('Google Analytics service was unable to determine the site', 'analytics-counter') . '</p>
    <div style="text-align: center">
        <a href="'.$url.'" class="btn btn-success" >' . __('Select a site', 'analytics-counter') . '</a>
    </div>
</div>';
