<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$error = filter_input(INPUT_GET, 'google_oauth2_error', FILTER_SANITIZE_SPECIAL_CHARS);
$error = str_replace('_', ' ', $error);

echo '<div class="error"><p>'.__('Google Analytics service reports', 'analytics-counter').' "'.$error.'"</p></div>';