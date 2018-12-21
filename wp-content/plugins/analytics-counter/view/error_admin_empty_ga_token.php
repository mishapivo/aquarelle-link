<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$current_uri = home_url( add_query_arg( NULL, NULL ) );
?>

<div>
    <div style="text-align: center; float: left; padding-right: 20px;">
        <?php echo '<a href="'.WPAdm_GA::URL_GA_AUTH.'?fix&v='.urldecode(WPAdm_GA::get_plugin_version()).'&redirect='. urlencode(WPAdm_GA::getCurUrl()).'" class="btn btn-success" style="margin-top: 20px;"><b>'.__('Connect Google Analytics services', 'analytics-counter') .'</b></a>'; ?>
    </div>
    <div style="float:left; max-width: 460px;">
        <div style="margin-top: 20px;"><a href='https://analytics.google.com/analytics/web/#management/Settings//%3Fm.page%3DNewAccount/' class='btn btn-xs btn-success'><?php _e('Create Google Analytics account', 'analytics-counter');?></a></div>
        <p><?php _e('Since Google Analytics account was successfully created, please, connect the Google Analytics created account to this Google Analytics plugin, using the same access credentials data.', 'analytics-counter');?></p>
    </div>
    <div style="clear: both;"></div>
</div>

<div class="row" style="margin-top: 100px;">
    <div class="col-md-8" style=" display: flex;">
        <div class="wpadm_ga_code_tab_btn_active" style=" float: left; width: 50%; align-items: stretch; flex: 1;" id="wpadm_ga_tab_auto_btn" onclick="wpadm_ga_clickToTab('auto')">
            <?php _e('Automatically generate Google Analytics Code', 'analytics-counter');?>
        </div>
        <div class="wpadm_ga_code_tab_btn" id="wpadm_ga_tab_manual_btn"  onclick="wpadm_ga_clickToTab('manual')" style="border-left: none;  align-items: stretch; flex: 1;">
            <?php _e('Manually paste Google Analytics Code', 'analytics-counter');?>
        </div>
    </div>
</div>
<div class="row" id="wpadm_ga_manual_code_container">
    <div class="col-md-8">
        <div  class="wpadm_ga_code_tab" id="wpadm_ga_tab_auto">
            <p style="text-align: center">
                <?php printf(__('Click here to <a href="%s">connect your Google Analytics account</a>, automatically generate Google Analytics code <br>and automatically paste Google Analytics code in your website.', 'analytics-counter'), WPAdm_GA::URL_GA_AUTH.'?fix&v='.urldecode(WPAdm_GA::get_plugin_version()).'&redirect='. urlencode(WPAdm_GA::getCurUrl())); ?>
            </p>
        </div>
        <div class="wpadm_ga_code_tab" style="display: none;" id="wpadm_ga_tab_manual">
            <form method="post">
                <?php wp_nonce_field( 'manual_tracking_code_form' ); ?>
                <p><?php _e('Manually paste Google Analytics сode in HTML of your website, without to connect to Google Analytics services. More information about this you can read on <a href="https://support.google.com/analytics/answer/1008080">Google Analytics support</a> pages.', 'analytics-counter'); ?></p>
                <p><?php _e('Please, paste your Google Analytics code here:', 'analytics-counter'); ?></p>
                <?php
                    $code = get_option('wpadm_ga_manual_tracking_code', '');
                ?>

                <textarea class="form-control" rows="5" name="wpadm_ga_manual_tracking_code" id="wpadm_ga_manual_tracking_code"><?php echo stripslashes($code); ?></textarea>

                <?php
                $example_code = '<script>
  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');

  ga(\'create\', \'YOUR GOOGLE ANALYTICS ID\', \'auto\');
  ga(\'send\', \'pageview\');

</script>'; ?>

                <div style="float: left" title="<?php echo htmlentities($example_code); ?>">[<?php _e('example of code', 'analytics-counter');?>]</div>
                <div style="text-align: right; margin-top: 10px;">
                    <input type="submit" id="wpadm_ga_submit_code_btn" value="<?php _e('Save and integrate Google Analytics code', 'analytics-counter');?>" class="btn btn-default">
                </div>

            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    function wpadm_ga_clickToTab(tab) {
        var auto_btn = document.getElementById('wpadm_ga_tab_auto_btn');
        var manual_btn = document.getElementById('wpadm_ga_tab_manual_btn');

        var auto_cont = document.getElementById('wpadm_ga_tab_auto');
        var manual_cont = document.getElementById('wpadm_ga_tab_manual');

        if (tab == 'manual') {
            manual_btn.className = 'wpadm_ga_code_tab_btn_active';
            auto_btn.className = 'wpadm_ga_code_tab_btn';
            auto_cont.style.display = 'none'; 
            manual_cont.style.display = ''; 
        } else {
            manual_btn.className = 'wpadm_ga_code_tab_btn';
            auto_btn.className = 'wpadm_ga_code_tab_btn_active';
            auto_cont.style.display = '';
            manual_cont.style.display = 'none';
        }        
    }
    <?php 
        if($code)  {
            echo 'wpadm_ga_clickToTab("manual")'; 
        }
    ?>

</script>