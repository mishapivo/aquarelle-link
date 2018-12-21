
function wpadm_ga_checked_iamnewuser(cb) {
    if (cb.checked) {
        wpadm_e('cont_password_cont').style.display = '';
        wpadm_e('wpadm_sign_in_button').value = 'Register & Activate';
    } else {
        wpadm_e('cont_password_cont').style.display = 'none';
        wpadm_e('wpadm_sign_in_button').value = 'Sign In';
    }

    if(wpadm_e('wpadm_username').value == '') {
        wpadm_e('wpadm_username').focus();
    } else if(wpadm_e('wpadm_password').value == '') {
        wpadm_e('wpadm_password').focus();
    }else if(cb.checked && wpadm_e('wpadm_password_confirm').value == '') {
        wpadm_e('wpadm_password_confirm').focus();
    }
}

function wpadm_form_validate() {
    return true;
    if (wpadm_e('wpadm_username').value == '') {
        alert('Please enter e-mail');
        wpadm_e('wpadm_username').focus();
        return false;                                       
    }    
    if (wpadm_e('wpadm_password').value == '') {
        alert('Please enter password');
        wpadm_e('wpadm_password').focus();
        return false;
    }        
    
    if (wpadm_e('wpadm_imnewuser_checkbox').checked ) {
        if (wpadm_e('wpadm_password_confirm').value == '') {
            alert('Please enter password');
            wpadm_e('wpadm_password_confirm').focus();
            return false;
        }

        if (wpadm_e('wpadm_password_confirm').value != wpadm_e('wpadm_password').value) {
            alert('Confirm password same as password');
            wpadm_e('wpadm_password_confirm').focus();
            return false;
        }
    }
    return true;
}


function wpadm_e(id) {
    return (document.getElementById(id)) ? document.getElementById(id) : undefined;
}

function wpadm_clickMenuSettings(id) {
    var menu = document.getElementsByClassName('menu');
    for(i in menu) {
        if (menu[i].tagName == 'TD') {
            if (menu[i].id == id) {
                menu[i].className = 'menu active';
            } else {
                menu[i].className = 'menu';
            }
        }
    }


    var menu = document.getElementsByClassName('menu_container');
    for(i in menu) {
        if (menu[i].tagName == 'DIV') {
            if (menu[i].id == id + '_container') {
                menu[i].style.display = '';
            } else {
                menu[i].style.display = 'none';
                
            }
        }
    }

}


function setStatusSuccess(id, html) {
    if (typeof html !== 'undefined') {
        jQuery('#'+id).find('.report-result').html(html);
    }
    jQuery('#'+id).find('.report-error').hide();
    jQuery('#'+id).find('.report-loader').hide();
}

function setStatusError(id, error) {
    error = error.replace(/\.$/, '');
    var html = jQuery('#gapi_error').html();
    if (html.indexOf(error) == -1) {
        if (html != '') {
            html = html + '<br><br>';
        }
        html = html + wpadm_ga_formatError(error);

        jQuery('#gapi_error').html(html);
        jQuery('#gapi_error').show();
    }

    jQuery('#'+id).find('.report-loader').hide();
}

function setStatusLoading(id) {
    jQuery('#'+id).find('.report-error').hide();
    jQuery('#'+id).find('.report-loader').show();
}

function wpadm_ga_secondsToTime(secs)
{
    var date = new Date(null);
    date.setSeconds(secs); // specify value for SECONDS here
    return date.toISOString().substr(11, 8);

}

function wpadm_ga_formatError(error) {

    error = error.replace(/\.$/, '');

    html = 'Google Analytics service reports "'+error+'"';

    if (error == 'Invalid Credentials') {
        html = html + ' <a class="btn btn-success btn-xs" href="'+wpadm_ga_url_GA_AUTH+'?fix">To fix</a>';
    }
    else if (error == 'User does not have any Google Analytics account') {
        var url = 'https://analytics.google.com/analytics/web/#management/Settings//%3Fm.page%3DNewAccount/';
        html = html
            + "<br><br>Since Google Analytics account was successfully created, please, connect the Google Analytics created account to this Google Analytics plugin, using the same access credentials data."
            + "<br><br><div style='text-align: center'><a href='"+url+"' class='btn btn-success'>Create Google Analytics account</a></div>";

    }
    else if (error == 'User does not have sufficient permissions for this profile') {
        html = html + '<br><br>Please select the correct profile(site) in the plugin settings'
        + "<br><br><div style='text-align: center'><a href='"+wpadm_ga_url_GA_SETTINGS+"' class='btn btn-success'>Select the correct profile</a></div>";


    }



    return html;
}


function wpadm_ga_getCache(gapi_object) {

    try {
        //if (!gapi_object.wc || !gapi_object.wc.chart || !gapi_object.wc.chart.container || !gapi_object.wc.chart.container.innerHTML) {
        if (
            !gapi_object.hasOwnProperty('Ka') ||
            !gapi_object.Ka.hasOwnProperty('chart') ||
            !gapi_object.Ka.chart.hasOwnProperty('container') ||
            undefined == gapi_object.Ka.chart.container.innerHTML
        ) {
            gapi_object.execute();
            return;
        }

        var query = gapi_object.Ka.query;
        var object_type = (undefined !== gapi_object.Ka.chart) ? 'chart' : 'data';

        query['start-index'] = (undefined == query['start-index']) ? 1 : query['start-index'];
        query['max-results'] = (undefined == query['max-results']) ? 1000 : query['max-results'];

        var data = {
            'action': 'getCache',
            'security': jQuery('#wpadm_ga_cache_security').val(),

            'query': query,
            'request_type': 'success',
            'object_type': object_type


        }
        jQuery.post(ajaxurl, data, function (response) {
            try {
                var res = jQuery.parseJSON(response);
                if (res && res.status == 'success') {
                    if (object_type == 'chart') {
                        if (res.html) {
                            gapi_object.Ka.chart.container.innerHTML = '<div class="gapi-analytics-data-chart">' + res.html + '</div>';
                        }
                    }

                    var result = jQuery.parseJSON(res.result);

                    if (object_type == 'chart' || object_type == 'data') {
                        for (i in gapi_object.zt.zt.success) {
                            var fun = gapi_object.zt.po[gapi_object.zt.zt.success[i] + 1];
                            if (fun.toString().indexOf('wpadm_ga_setCache') < 0) {
                                fun(result);
                            }
                        }
                        return;
                    }


                }
            } catch (e) {
            }
            gapi_object.execute();
        });
    } catch (e) {
        gapi_object.execute();
    }
    
}

function wpadm_ga_setCache(result, type) {
    //if(undefined !== result.query) {
    var query;
    if(result.hasOwnProperty('query')) {
        var query = result.query;
        var html = '';
        var object_type = 'data';
    }
    if (!result.hasOwnProperty('query') &&
        result.hasOwnProperty('response') &&
        result.response.hasOwnProperty('query') &&
        result.hasOwnProperty('chart') &&
        result.chart.hasOwnProperty('ma') &&
        result.chart.ma.hasOwnProperty('innerHTML'))
    {
        var query = result.response.query;
        var html = result.chart.ma.innerHTML;
        var object_type = 'chart';
    }

    if (undefined !== query ) {
        var data = {
            'action': 'setCache',
            'security': jQuery('#wpadm_ga_cache_security').val(),

            'query': query,
            'html': html,
            'result': (object_type == 'data') ? result : {},
            //'result': result,
            'request_type': type,
            'object_type': object_type

        }

        jQuery.post(ajaxurl, data, function (response) {
            try {
                var res = jQuery.parseJSON(response);
            } catch (e) {
            }

        });
    } else {
//        console.log('empty query');
//        console.dir(result);
    }
}

function wpadm_ga_sendSupportText() {

    if(jQuery('#wpadm-ga_support_text').val().trim() == '') {
        alert('Please, describe your suggestion or issue and then click "Send" button.');
        return;
    }

    var data = {
        'action': 'sendSupport',
        'security': jQuery('#wpadm-ga_support_security').val(),
        'message': jQuery('#wpadm-ga_support_text').val()
    }

    jQuery.post(ajaxurl, data, function (response) {
        try {
            var res = jQuery.parseJSON(response);
            if (res) {
                jQuery('#wpadm-ga_support_text_container').hide();
                jQuery('#wpadm-ga-support_send_button').hide();
                if(res.status=='success') {
                    jQuery('#wpadm-ga_support_thank_container').show();
                } else if(res.status=='error') {
                    jQuery('#wpadm-ga_support_error_container').show();
                }
            } else {
                jQuery('.tb-close-icon').click();
            }
        } catch (e) {
            jQuery('.tb-close-icon').click();
        }
    });
}

function wpadm_ga_supportFormNormalize() {
    if (jQuery('#wpadm-ga_support_text_container')[0].style.display == 'none') {
        jQuery('#wpadm-ga_support_text').val('');
    }
    jQuery('#wpadm-ga_support_text_container').show();
    jQuery('#wpadm-ga-support_send_button').show();
    jQuery('#wpadm-ga_support_thank_container').hide();
    jQuery('#wpadm-ga_support_error_container').hide();
}

function wpadm_ga_stopNotice5Stars() {
    jQuery('.wpadm-ga-notice-5stars-content').hide( "slow" );
    var data = {
        'action': 'stopNotice5Stars',
        'security': jQuery('#wpadm_ga_stopNotice5Stars_security').val(),
        'stop': 1
    }
    jQuery.post(ajaxurl, data, function (response) {
    });
}

function wpadm_ga_hideGetProDescription() {
    jQuery('#wpadm_ga_getpro_description').hide( "slow" );
    jQuery('#wpadm_ga_getpro_notice').show( "slow" );
    
    var data = {
        'action': 'hideGetProDescription',
        'security': jQuery('#wpadm_ga_GetProDescription_security').val(),
        'hide': 1
    }
    jQuery.post(ajaxurl, data, function (response) {
    });
}

function wpadm_ga_showGetProDescription() {
    jQuery('#wpadm_ga_getpro_notice').hide( "slow" );
    jQuery('#wpadm_ga_getpro_description').show( "slow" );

    var data = {
        'action': 'hideGetProDescription',
        'security': jQuery('#wpadm_ga_GetProDescription_security').val(),
        'hide': 0
    }
    jQuery.post(ajaxurl, data, function (response) {
    });
}

