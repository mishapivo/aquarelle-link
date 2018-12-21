<h2><?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    _e('Google Analytics Account', 'analytics-counter');?></h2>
<?php

$token = WPAdm_GA_Options::getGAAccessToken();

$type = 'empty_token';

if ($token) {
    if (time() < WPAdm_GA_Options::getGACreated() + WPAdm_GA_Options::getGAExpiresIn()) {
        $type = 'is_token';
    } else {
        $type = 'bad_token';
    }
}    
 
if($type == 'empty_token') {
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'error_admin_empty_ga_token.php';
    return;
}
?>

<script>
    (function(w,d,s,g,js,fs){
        g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
        js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
        js.src='https://apis.google.com/js/platform.js';
        fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
    }(window,document,'script'));
</script>


<div class="error" id="gapi_error" style="display: none;"></div>
<!--<div id="ga-accounts-container-loading">loading...</div>-->

<div id="ga-accounts-container">
    <div class="container">
        <form class="form-horizontal" method="post">
            <?php wp_nonce_field( 'wpadm_settings_ga_account' ); ?>
            <input type="hidden" name="form_name" value="ga-account">
            <div class="form-group">
                <label for="ga-id" class="col-xs-1 control-label"><?php _e('Site', 'analytics-counter');?></label>
                
                <div class="col-md-5">
                    <select id='ga-accounts-select' style="width: 100%;" name="ga-id" onchange="onChangeAccount(this.options[this.selectedIndex].value)" onclick="wpadm_loadSites()">
                        <option></option>
                        <?php
                            if ($ga_accout_form->getValue('ga-url')) {
                                echo "<option value='{$ga_accout_form->getValue('ga-id')}' selected>{$ga_accout_form->getValue('ga-url')}</option>";
                            }
                        ?>
                        <option><?php _e('loading...', 'analytics-counter');?></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                    </select>
                    <input type="hidden" name="ga-url" id="ga_url" value="<?php echo $ga_accout_form->getValue('ga-url')?>">
                    <input type="hidden" name="ga-webPropertyId" id="ga_webPropertyId"  value="<?php echo $ga_accout_form->getValue('ga-webPropertyId')?>">
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-1 col-xs-10">
                    <div class="checkbox">
                        <?php if (isset($_GET['modal'])): ?>
                            <input onchange="changeEnableCode(this)" type="checkbox" name="ga-enableCode" id="ga-enableCode" value="1" <?php if($ga_accout_form->getValue('ga-enableCode')) echo 'checked="checked"'; ?>><label for="ga-enableCode"> <?php _e('Enable google analytics tracking code on subpages of selected website', 'analytics-counter');?></label>
                        <?php else: ?>
                            <label for="ga-enableCode"><input  onchange="changeEnableCode(this)" type="checkbox" name="ga-enableCode" id="ga-enableCode" value="1" <?php if($ga_accout_form->getValue('ga-enableCode')) echo 'checked="checked"'; ?>> <?php _e('Enable google analytics tracking code on subpages of selected website', 'analytics-counter');?></label>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-1 col-xs-10">
                    <div class="checkbox" >
                        <fieldset  <?php if(!$ga_accout_form->getValue('ga-enableCode')) echo 'disabled style="color:gray;"'; ?> id="set-ga-enableAnonymization">
                        <?php if (isset($_GET['modal'])): ?>
                            <input   type="checkbox" name="ga-enableAnonymization" id="ga-enableAnonymization" value="1" <?php if($ga_accout_form->getValue('ga-enableAnonymization')) echo 'checked="checked"'; ?>><label for="ga-enableAnonymization"> <?php _e('Enable IP Anonymization', 'analytics-counter');?></label> <a href="https://support.google.com/analytics/answer/2763052"  target="_blank"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a>

                        <?php else: ?>
                            <label  for="ga-enableAnonymization"><input type="checkbox" name="ga-enableAnonymization" id="ga-enableAnonymization" value="1" <?php if($ga_accout_form->getValue('ga-enableAnonymization')) echo 'checked="checked"'; ?>> <?php _e('Enable IP Anonymization', 'analytics-counter');?></label> <a href="https://support.google.com/analytics/answer/2763052" target="_blank"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a>
                        <?php endif; ?>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-1 col-xs-10">
                    <div class="checkbox">
                        <?php if (isset($_GET['modal'])): ?>
                            <input type="checkbox" name="ga-menuOnlyAdmin" id="ga-menuOnlyAdmin" value="1" <?php if($ga_accout_form->getValue('ga-menuOnlyAdmin')) echo 'checked="checked"'; ?>><label for="ga-menuOnlyAdmin"> <?php _e('Appear in menu for admins only', 'analytics-counter');?></label>
                        <?php else: ?>
                            <label for="ga-menuOnlyAdmin"><input type="checkbox" name="ga-menuOnlyAdmin" id="ga-menuOnlyAdmin" value="1" <?php if($ga_accout_form->getValue('ga-menuOnlyAdmin')) echo 'checked="checked"'; ?>> <?php _e('Appear in menu for admins only', 'analytics-counter');?></label>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-offset-1 col-xs-10">
                    <button type="submit" class="btn btn-success"><?php _e('Save', 'analytics-counter');?></button>
                </div>
            </div>
	        
	        <hr>
            <?php _e('Status', 'analytics-counter');?>: <span style="color: green; font-weight: bold; margin-right: 50px; "><?php _e('connected', 'analytics-counter');?></span><button type="submit" name="ga-disconnect-btn" value="disconnect" class="btn btn-link" onclick="return confirm('<?php _e('Are you sure you want to disconnect from your Google Analytics account?', 'analytics-counter');?>');"><?php _e('Disconnect your Google Analytics Account', 'analytics-counter');?></button>
	        
        </form>
    </div>
</div>

<script>

var ga_accounts = {};

gapi.analytics.ready(function () {

    var ACCESS_TOKEN = '<?php echo WPAdm_GA_Options::getGAAccessToken();?>';
    gapi.analytics.auth.authorize({
        'serverAuth': {
            'access_token': ACCESS_TOKEN
        }
    });

//        var request = gapi.client.analytics.management.webproperties.list({
//            'accountId': '~all'
//        });

    window['ga_request'] = gapi.client.analytics.management.profiles.list({
        'accountId': '~all',
        'webPropertyId': '~all'
    });

    

    window['wpadm_loadSites'] = function () {
        if (list_sites_loaded) {
            return;
        }
        ga_request.execute(function (result) {
            if (undefined === result.error) {
                wpadm_requestSuccess(result);
            } else {
                wpadm_reauestError(result);
            }
        });
    }

    window['list_sites_loaded'] = false;

    window['wpadm_requestSuccess'] = function (results) {
        var sel = wpadm_e('ga-accounts-select');
        var selected_id = '<?php echo $ga_accout_form->getValue('ga-id'); ?>';

        var  accounts = results.items;
        if (accounts.length == 0) {
            setStatusError('ga-accounts-container-loading', "<?php _e('User does not have any Google Analytics account', 'analytics-counter');?>");
            jQuery('#ga-accounts-container-loading').hide();
            return;
        }
        sel.remove(6);
        sel.remove(5);
        sel.remove(4);
        sel.remove(3);
        sel.remove(2);
        for (var i = 0, account; account = accounts[i]; i++) {
            if (selected_id != account.id) {
                var option = document.createElement("option");
                option.text = account.websiteUrl;
                option.value = account.id;
                sel.add(option);
            }

            ga_accounts['id'+account.id] = {
                'id': account.id,
                'websiteUrl': account.websiteUrl,
                'webPropertyId': account.webPropertyId
            }
        }
        window['list_sites_loaded'] = true;

//        wpadm_e('ga-accounts-container-loading').style.display = 'none';
//        wpadm_e('ga-accounts-container').style.display = '';
    }

    window['wpadm_reauestError'] = function(result){
        var error = results.error.message;
        error = error.replace(/\.$/, '');
        var html = jQuery('#gapi_error').html();
        if (html.indexOf(error) == -1) {
            html = html + wpadm_ga_formatError(error) + '<br>';

            jQuery('#gapi_error').html(html);
            jQuery('#gapi_error').show();
        }
        jQuery('#ga-accounts-container-loading').hide();

    }


});
    
    
    function onChangeAccount(id) {
        document.getElementById('ga_url').value = ga_accounts['id'+id].websiteUrl;
        document.getElementById('ga_webPropertyId').value = ga_accounts['id'+id].webPropertyId;
    }

    function changeEnableCode(ch) {
        if(ch.checked) {
            jQuery('#set-ga-enableAnonymization').attr('disabled', false);
            jQuery('#set-ga-enableAnonymization').css('color', 'black');

        } else {
            jQuery('#set-ga-enableAnonymization').attr('disabled', true);
            jQuery('#set-ga-enableAnonymization').css('color', 'gray');
        }
    }
</script>

