<div style="display: none;" id="modal_error_no_data">
    <div style="padding-left: 30px; margin-top: 20px; vertical-align: middle; display: block; height: 360px; text-align:center;">
        <?php echo nl2br(__("Dear User,

Since your website was recently added in Google Analytics account,
usually it takes up to 24 hours to collect data about your website.
For now, Google Analytics Service has reported, that the analytics data (stats data) is still not available for your website.

Please, have a patience, wait up to 24 hours and check this page again.

Thank you for understanding!", 'analytics-counter'));
        
?>
		<div style="text-align: center; padding-top: 40px;">
            <button type="button" class="btn btn-success" style="width: 150px; font-weight: bold" onclick="tb_remove()">Ok</button>
        </div>

    </div>
</div><!-- /.modal -->
<a class="btn btn-info thickbox" href="#TB_inline?width=400&height=390&inlineId=modal_error_no_data" style="display: none;" id="btn_modal_error_no_data"
    onclick="ga_setTitleNoDataWindow()"
    >error</a>
<?php add_thickbox(); ?>
<div style="display: none;" id="modal_buy_pro_christmas">
	<div style="text-align: center;">
		<form action="<?php echo WPADM_GA__SSERVER; ?>api/" name="buy_pro_christmas" method="post" style="position:relative">
			<img src="<?php echo plugins_url('/img/google-analytics_gift.jpg',__FILE__);?>" title="Get PRO version" alt="Get PRO version" style="z-index:1; width: 100%;" />
			<a href="javascript:void(0);" onclick="document.buy_pro_christmas.submit();" style="width: 265px; height: 45px; position:absolute; left: 267px; top: 296px;z-index:2;"></a>
			<input type="hidden" value="<?php echo home_url();?>" name="site">
			<input type="hidden" value="proBackupPay" name="actApi">
			<input type="hidden" value="<?php echo get_option('admin_email');?>" name="email">
			<input type="hidden" value="ga" name="plugin">
			<input type="hidden" value="<?php echo $calback_url . '&pay=success'; ?>" name="success_url">
			<input type="hidden" value="<?php echo $calback_url . '&pay=cancel'; ?>" name="cancel_url">
			<a style="position:absolute; right: 5px; top: -3px; font-size: 13px; font-weight: 600; color:blue;" href="javascript:void(0);" onclick="document.form_christmas_later.submit();">Show me this gift later</a>
	<a href="javascript:void(0);" onclick="document.form_christmas_end.submit();" style="position:absolute; right: 155px; top: -3px; font-size: 12px; font-weight: 500; color:blue;">Close and forget this offer</a>
		</form>
	</div>
	<div style="position:relative;text-align: right;margin-top: 10px;">
		<form name="form_christmas_later" method="post" onsubmit="tb_remove()">
			<input type="hidden" value="1" name="christmas_later">
		</form>
		
		<form name="form_christmas_end" method="post" onsubmit="tb_remove()">
			<input type="hidden" value="1" name="christmas_end">
		</form>
	</div>
</div>
<a class="thickbox" href="#TB_inline?width=500&height=500&inlineId=modal_buy_pro_christmas" style="display: none;" id="btn_modal_buy_pro_christmas" >error</a>
<script>
	<?php if (isset($show_holiday)) {?>
		jQuery(document).ready(function($){
			setTimeout(showModalChristmas, 15000);
			function showModalChristmas() {
				if (jQuery('#TB_title').length == 0) {
					$('#btn_modal_buy_pro_christmas').click();
					jQuery('#TB_title').css('display', 'none');
					jQuery('#TB_ajaxContent').css({'padding':'0', 'width' : 'auto', 'height' : 'auto'});
					jQuery('#TB_window').css( {'width':'550px', 'height' : '550px'} );
					ga_setTitleNoDataWindow();
				} else {
					setTimeout( showModalChristmas, 3000 );
				}
			}
		});
	<?php } ?>
    function ga_setTitleNoDataWindow() {
        jQuery('#TB_title').html(
            '<span style=\'\'>' +
            '<?php _e('Information', 'analytics-counter');?></span>'
        );

        jQuery('#TB_title').css('background', '#fcfcfc');
        jQuery('#TB_title').css('border-bottom', '1px solid #ddd');
        jQuery('#TB_title').css('height', '29px');
        jQuery('#TB_title').css('background-color', '#4285ba');
        jQuery('#TB_title').css('color', 'white');
        jQuery('#TB_title').css('letter-spacing', '1px');
        jQuery('#TB_title').css('font-weight', 'bold');
        jQuery('#TB_title').css('padding-left', '15px');
        jQuery('#TB_title').css('line-height', '45px');
        jQuery('#TB_title').css('height', '45px');
        jQuery('#TB_title').css('font-size', '18px');
    }
</script>
