<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Free Sign Up to WPAdm</h2>
            
            <?php 
                if ($wpadm_account_form->errors) {
                    echo '<div class="error">';
                    foreach($wpadm_account_form->errors as $errors) {
                        foreach($errors as $error) {
                            echo esc_html($error) . '<br>';
                        }
                    }
                    echo '</div>';
                } 
            ?>


            <form class="form-horizontal"  method="post" onsubmit="return wpadm_form_validate();">
                <input type="hidden" name="form_name" value="wpadm-account">
                <div class="form-group">
                    <label for="wpadm_username" class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-5">
                        <input type="email" class="form-control" name="wpadm_username" id="wpadm_username" value="<?php echo esc_attr($wpadm_account_form->getValue('wpadm_username'));?>" autofocus required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="wpadm_password" class="col-sm-4 control-label">Password</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" name="wpadm_password" id="wpadm_password"  <?php echo esc_attr($wpadm_account_form->getValue('wpadm_password'));?> required>
                    </div>
                </div>
                <div class="form-group" id="cont_password_cont" <?php echo ($wpadm_account_form->getValue('wpadm_imnewuser_checkbox').value !=1) ? 'style="display: none;"' : '';?>>
                    <label for="wpadm_password_confirm" class="col-sm-4 control-label">Password confirm</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" name="wpadm_password_confirm" id="wpadm_password_confirm" <?php echo esc_attr($wpadm_account_form->getValue('wpadm_username_confirm'));?>>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="wpadm_imnewuser_checkbox" name="wpadm_imnewuser_checkbox"
                                       value="1"
                                    <?php echo ($wpadm_account_form->getValue('wpadm_imnewuser_checkbox').value == 1) ? 'checked' : '';?>
                                       onchange="wpadm_ga_checked_iamnewuser(this)" > I am a new user
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-10">
                        <button type="submit" class="btn btn-default" id="wpadm_sign_in_button" value="Sign In">Sign in</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
