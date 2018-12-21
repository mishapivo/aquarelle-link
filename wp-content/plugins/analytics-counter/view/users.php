<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$start_date = date("Y-m-d", strtotime("-30 day"));
$end_date = date("Y-m-d", strtotime("-1 day"));

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'error_no_data.php';

?>

<div class="error" id="gapi_error" style="display: none;"></div>


<div style="float: left; padding-right: 30px; margin-bottom: 20px;">
    <div style="font-weight: bold;"><?php _e('Date range', 'analytics-counter');?></div>
    <div id="reportrange" class="pull-left">
        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
        <span></span> <b class="caret"></b>
    </div>
</div>
<div style="float: left; padding-right: 30px; margin-bottom: 20px;">
    <div style="font-weight: bold;"><?php  _e('Group statistics data by', 'analytics-counter');?></div>
    <div class="btn-group" role="group" aria-label="...">
        <button class="group_by btn btn-default" onclick="changeGroupBy('dateHour', this)"><?php _e('Hour', 'analytics-counter');?></button>
        <button class="group_by active_group_by btn btn-default" onclick="changeGroupBy('date', this)"><?php _e('Day', 'analytics-counter');?></button>
        <button class="group_by btn btn-default" onclick="changeGroupBy('yearWeek', this)"><?php _e('Week', 'analytics-counter');?></button>
        <button class="group_by btn btn-default" onclick="changeGroupBy('yearMonth', this)"><?php _e('Month', 'analytics-counter');?></button>
    </div>
</div>


<div style="float: left; padding-right: 50px; margin-bottom: 20px;">

    <br>
    <?php _e('If you have any suggestions or wishes', 'analytics-counter');?>  <a class="btn btn-info thickbox" href="#TB_inline?width=650&height=550&inlineId=wpadm-ga-support_container" style="margin-right: 0px;" onclick="wpadm_ga_supportFormNormalize()"><?php _e('Contact us', 'analytics-counter');?></a>

</div>
<div style="float:left; margin-bottom: 20px;">
    <br>
    <a class="btn btn-info thickbox" href="<?php echo admin_url() . 'options-general.php?page=wpadm-ga-menu-settings&modal&TB_iframe=true&height=470'; ?>"><?php _e('Settings', 'analytics-counter');?></a>

</div>


<div class="clear"></div>



<div class="panel panel-default report report-data" id="data-users-container">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php _e('Users', 'analytics-counter');?><div class="report-loader"></div></div>
    
    <div class="report-result"></div>

</div>

<div class="panel panel-default report report-data" id="data-newUsers-container">
    <div class="panel-heading"><?php _e('New users', 'analytics-counter');?><div class="report-loader"></div></div>
    
    <div class="report-result"></div>
</div>
<div class="clear"></div>

<div class="panel panel-default report report-groupable" id="chart-1-container">
    <div class="panel-heading"><?php _e('All unique users and new users', 'analytics-counter');?><div class="report-loader"></div></div>
    
    <div class="report-result"></div>
</div>

<div class="container" style="width: 95%">                    
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default report" id="table-country-container">
                <div class="panel-heading"><?php _e('Top countries by users', 'analytics-counter');?><div class="report-loader"></div></div>
                
                <div class="report-result report-result-table"></div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default report" id="chart-country-container">
                <div class="panel-heading"><?php _e('Geo statistics data by users', 'analytics-counter');?><div class="report-loader"></div></div>
                <div class="report-result"></div>
            </div>
        </div>        
    </div>
</div>


<div class="container" style="width: 95%">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default report" id="pie-browser-container">
                <div class="panel-heading"><?php _e('Top browsers', 'analytics-counter');?><div class="report-loader"></div></div>
                
                <div class="report-result"></div>
            </div>
        </div> 
        <div class="col-md-4">
            <div class="panel panel-default report" id="pie-os-container">
                <div class="panel-heading"><?php _e('Top operating systems', 'analytics-counter');?><div class="report-loader"></div></div>
                
                <div class="report-result"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default report" id="pie-screenResolution-container">
                <div class="panel-heading"><?php _e('Top screen resolutions', 'analytics-counter');?><div class="report-loader"></div></div>
                
                <div class="report-result"></div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>

<div class="container" style="width: 95%">
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default report" id="table-city-container">
				<div class="panel-heading"><?php _e('Top cities by users', 'analytics-counter');?><div class="report-loader"></div></div>

				<div class="report-result report-result-table"></div>
			</div>
		</div>
	</div>
</div>

<div style="display: none" class="wpadm-gapi-analytics-data-chart-styles-table-tr-odd"></div>

<script>
    (function(w,d,s,g,js,fjs){
        g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
        js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
        js.src='https://apis.google.com/js/platform.js';
        fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
    }(window,document,'script'));
</script>

<script>
    var dataChartTable1;
    var dataChart1;

    function changeGroupBy(by, button) {
        var conts = jQuery('.report-groupable');
        for(var i = 0; i<conts.length; i++ ) {
            setStatusLoading(conts[i].id);
        }
        dataChart1.set({query: {'dimensions': 'ga:'+by}}).wpadmExecute();

        jQuery(".group_by").removeClass('active_group_by');
        jQuery(button).addClass('active_group_by');
    }


    jQuery(document).ready(function($){

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        cb(moment().subtract(30, 'days'), moment());

        $('#reportrange').daterangepicker({
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Last 3 Month': [moment().subtract(3, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Last 6 Month': [moment().subtract(6, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Last Year': [moment().subtract(12, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            var reports = [dataChart1, data1, dataChartCountry, dataTableCountry, dataTableCity, dataPieBrowser, dataPieOS, dataPieScreenResolution];
            
            var conts = jQuery('.report');
            for(var i = 0; i<conts.length; i++ ) {
                setStatusLoading(conts[i].id);
            }
            
            for(var i = 0; i<reports.length; i++ ) {
                reports[i].set({query: {'start-date': picker.startDate.format('YYYY-MM-DD'), 'end-date': picker.endDate.format('YYYY-MM-DD')}}).wpadmExecute();
            }
        });

    });


    gapi.analytics.ready(function() {
        /**
         * Authorize the user with an access token obtained server side.
         */
        var access_token = '<?php echo WPAdm_GA_Options::getGAAccessToken();?>';
        var id = '<?php echo WPAdm_GA_Options::getGAId();?>';

        var start_date = '<?php echo date("Y-m-d", strtotime("-30 day")) ?>';
        var end_date = '<?php echo date("Y-m-d", strtotime("-1 day")) ?>';

        gapi.analytics.auth.authorize({
            'serverAuth': {
                'access_token': access_token
            }
        });

        function wpadmExecute() {
            try {
                this.on('success', function (result) {
                    wpadm_ga_setCache(result, 'success');
                })
                wpadm_ga_getCache(this);
            } catch(e) {}
        }

        gapi.analytics.googleCharts.DataChart.prototype.wpadmExecute = wpadmExecute;
        gapi.analytics.report.Data.prototype.wpadmExecute = wpadmExecute;

        //////////////////////////////////
        window['dataChartCountry'] = new gapi.analytics.googleCharts.DataChart({
            query: {
                'ids': 'ga:'+id,
                'start-date': start_date,
                'end-date': end_date,
                'metrics': 'ga:users',
                'dimensions': 'ga:country'
            },
            chart: {
                'container': document.getElementById('chart-country-container').getElementsByClassName('report-result')[0],
                'type': 'GEO',
                'options': {
                    'width': '100%'
                }
            }
        });
        
        dataChartCountry.on('error', function(result) {
            setStatusError('chart-country-container', result.error.message);
        })
        dataChartCountry.on('success', function(result) {
            setStatusSuccess('chart-country-container');
        })
        //////////////////////////////////
        window['dataTableCountry'] = new gapi.analytics.googleCharts.DataChart({
            query: {
                'ids': 'ga:'+id,
                'start-date': start_date,
                'end-date': end_date,
                'metrics': 'ga:users',
                'dimensions': 'ga:country',
                'sort': '-ga:users',
                'max-results': 8
            },
            chart: {
                'container': document.getElementById('table-country-container').getElementsByClassName('report-result')[0],
                'type': 'TABLE',
                'options': {
                    'width': '100%'
                }
            }
        });
        
        dataTableCountry.on('error', function(result) {
            setStatusError('table-country-container', result.error.message);
        })
        dataChartCountry.on('success', function(result) {
            setStatusSuccess('table-country-container');
            jQuery('.gapi-analytics-data-chart-styles-table-tr-odd').css('background-color', jQuery('.wpadm-gapi-analytics-data-chart-styles-table-tr-odd').css('background-color'));
        })
        
        //////////////////////////////////       
        window['dataTableCity'] = new gapi.analytics.googleCharts.DataChart({
            query: {
                'ids': 'ga:'+id,
                'start-date': start_date,
                'end-date': end_date,
                'metrics': 'ga:users',
                'dimensions': 'ga:city',
                'sort': '-ga:users',
                'max-results': 10
            },
            chart: {
                'container': document.getElementById('table-city-container').getElementsByClassName('report-result')[0],
                'type': 'TABLE',
                'options': {
                    'width': '100%'
                }
            }
        });

	    dataTableCity.on('error', function(result) {
            setStatusError('table-city-container', result.error.message);
        })
	    dataTableCity.on('success', function(result) {
            setStatusSuccess('table-city-container');
            jQuery('.gapi-analytics-data-chart-styles-table-tr-odd').css('background-color', jQuery('.wpadm-gapi-analytics-data-chart-styles-table-tr-odd').css('background-color'));
        })
        
        //////////////////////////////////
        window['dataPieBrowser'] = new gapi.analytics.googleCharts.DataChart({
            query: {
                'ids': 'ga:'+id,
                'start-date': start_date,
                'end-date': end_date,
                'metrics': 'ga:users',
                'dimensions': 'ga:browser',
                'sort': '-ga:users',
                'max-results': 5
            },
            chart: {
                'container': document.getElementById('pie-browser-container').getElementsByClassName('report-result')[0],
                'type': 'PIE',
                'options': {
                    'width': '100%'
                }
            }
        });
        
        dataPieBrowser.on('error', function(result) {
            setStatusError('pie-browser-container', result.error.message);
        })
        dataPieBrowser.on('success', function(result) {
            setStatusSuccess('pie-browser-container');
        })
        
        //////////////////////////////////
        window['dataPieOS'] = new gapi.analytics.googleCharts.DataChart({
            query: {
                'ids': 'ga:'+id,
                'start-date': start_date,
                'end-date': end_date,
                'metrics': 'ga:users',
                'dimensions': 'ga:operatingSystem',
                'sort': '-ga:users',
                'max-results': 5
            },
            chart: {
                'container': document.getElementById('pie-os-container').getElementsByClassName('report-result')[0],
                'type': 'PIE',
                'options': {
                    'width': '100%'
                }
            }
        });
        
        dataPieOS.on('error', function(result) {
            setStatusError('pie-os-container', result.error.message);
        })
        dataPieOS.on('success', function(result) {
            setStatusSuccess('pie-os-container');
        })
        
        //////////////////////////////////
        window['dataPieScreenResolution'] = new gapi.analytics.googleCharts.DataChart({
            query: {
                'ids': 'ga:'+id,
                'start-date': start_date,
                'end-date': end_date,
                'metrics': 'ga:users',
                'dimensions': 'ga:screenResolution',
                'sort': '-ga:users',
                'max-results': 5
            },
            chart: {
                'container': document.getElementById('pie-screenResolution-container').getElementsByClassName('report-result')[0],
                'type': 'PIE',
                'options': {
                    'width': '100%'
                }
            }
        });
        
        dataPieScreenResolution.on('error', function(result) {
            setStatusError('pie-screenResolution-container', result.error.message);
        })
        dataPieScreenResolution.on('success', function(result) {
            setStatusSuccess('pie-screenResolution-container');
        })
        
        ///////////////////////

        window['data1'] = new gapi.analytics.report.Data({
            query: {
                'ids': 'ga:'+id,
                'start-date': start_date,
                'end-date': end_date,
                'metrics': 'ga:users,ga:newUsers'
//                'dimensions': 'ga:date'
            }
        });
        
        data1.on('error', function(result) {
            setStatusError('data-users-container', result.error.message);
            setStatusError('data-newUsers-container', result.error.message);
        })
        data1.on('success', function(result) {
            if (!result.hasOwnProperty('rows')) {
                jQuery('#btn_modal_error_no_data').click();
                ga_setTitleNoDataWindow();
                return;
            }
            setStatusSuccess('data-users-container', result.rows[0][0]);
            setStatusSuccess('data-newUsers-container', (((result.rows[0][1]-0)/((result.rows[0][0]-0)/100)).toFixed(2))+'%');
        })
//////////////////////
        window['dataChart1'] = new gapi.analytics.googleCharts.DataChart({
            query: {
                'ids': 'ga:'+id,
                'start-date': start_date,
                'end-date': 'yesterday',
                'metrics': 'ga:users,ga:newUsers',
                'dimensions': 'ga:date'
            },
            chart: {
                'container': document.getElementById('chart-1-container').getElementsByClassName('report-result')[0],
                'type': 'LINE',
                'options': {
                    'width': '100%'
                }
            }
        });
        dataChart1.wpadmExecute();
        dataChart1.on('error', function(result) {
            setStatusError('chart-1-container', result.error.message);
            jQuery('.report-loader').hide();
        })
        dataChart1.on('success', function(result) {
            setStatusSuccess('chart-1-container');

            dataChartCountry.wpadmExecute();
            data1.wpadmExecute();
            dataPieScreenResolution.wpadmExecute();
            dataPieOS.wpadmExecute();
            dataTableCountry.wpadmExecute();
            dataTableCity.wpadmExecute();
            dataPieBrowser.wpadmExecute();
            
        })


    });


</script>