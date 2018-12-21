<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

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
    <div style="font-weight: bold;"><?php _e('Group statistics data by', 'analytics-counter');?></div>
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

<div class="report panel panel-default" id="chart-1-container">
    <div class="panel-heading"><?php _e('Sessions and page views', 'analytics-counter');?><div class="report-loader"></div></div>
    
    <div class="report-result"></div>
</div>

<div class="report report-data panel panel-default" id="data-sessions-container">
    <div class="panel-heading"><?php _e('Sessions', 'analytics-counter');?><div class="report-loader"></div></div>
    
    <div class="report-result"></div>
</div>

<div class="report report-data panel panel-default" id="data-pageviews-container">
    <div class="panel-heading"><?php _e('Page views', 'analytics-counter');?><div class="report-loader"></div></div>
    
    <div class="report-result"></div>
</div>

<div class="report report-data panel panel-default" id="data-users-container">
    <div class="panel-heading"><?php _e('Unique users', 'analytics-counter');?><div class="report-loader"></div></div>
    
    <div class="report-result"></div>
</div>
<div class="report report-data panel panel-default" id="data-bounces-container">
    <div class="panel-heading"><?php _e('Bounces', 'analytics-counter');?><div class="report-loader"></div></div>

    <div class="report-result"></div>
</div>
<div class="report report-data panel panel-default" id="data-percentNewSessions-container">
    <div class="panel-heading"><?php _e('Percent new sessions', 'analytics-counter');?><div class="report-loader"></div></div>

    <div class="report-result"></div>
</div>
<div class="clear"></div>
<div class="panel panel-default">
    <div class="panel-heading"><?php _e('Averages', 'analytics-counter');?></div>
    <div class="panel-body">
        <div class="report report-data panel panel-default" id="data-pageviewsPerSession-container">
            <div class="panel-heading"><?php _e('Page views per session', 'analytics-counter');?><div class="report-loader"></div></div>

            <div class="report-result"></div>
        </div>
        <div class="report report-data panel panel-default" id="data-avgSessionDuration-container">
            <div class="panel-heading"><?php _e('Session duration', 'analytics-counter');?><div class="report-loader"></div></div>

            <div class="report-result"></div>
        </div>
    </div>
</div>
<div class="clear"></div>


<div class="container" style="width: 95%">
    <div class="row">
        <div class="col-md-6">
            <div class="report panel panel-default" id="table-hits-container">
                <div class="panel-heading"><?php _e('Most popular pages', 'analytics-counter');?><div class="report-loader"></div></div>
                
                <div class="report-result report-result-table"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="report panel panel-default" id="table-search-container">
                <div class="panel-heading"><?php _e('Most popular keywords', 'analytics-counter');?><div class="report-loader"></div></div>
                
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
        
        setStatusLoading('chart-1-container');

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
            var reports = [data1, dataChart1,tableHits,tableSearch];
            
            var conts = jQuery('.report');
            for(var i = 0; i<conts.length; i++ ) {
                setStatusLoading(conts[i].id);
            }

            for(var i = 0; i<reports.length; i++ ) {
                reports[i].set({query: {'start-date': picker.startDate.format('YYYY-MM-DD'), 'end-date': picker.endDate.format('YYYY-MM-DD')}}).wpadmExecute();
            }
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
                this.on('success', function(result) {
                    wpadm_ga_setCache(result, 'success');
                })
                wpadm_ga_getCache(this);
            }

            gapi.analytics.googleCharts.DataChart.prototype.wpadmExecute = wpadmExecute;
            gapi.analytics.report.Data.prototype.wpadmExecute = wpadmExecute;

            window['tableHits'] = new gapi.analytics.googleCharts.DataChart({
                query: {
                    'ids': 'ga:'+id,
                    'start-date': start_date,
                    'end-date': end_date,
                    'metrics': 'ga:pageviews',
                    'dimensions': 'ga:pagePath',
                    'sort': '-ga:pageviews',
                    'max-results': 10
                },
                chart: {
                    'container': document.getElementById('table-hits-container').getElementsByClassName('report-result')[0],
                    'type': 'TABLE',
                    'options': {
                        'width': '100%'
                    }
                }
            });
            tableHits.on('error', function(result) {
                setStatusError('table-hits-container', result.error.message);
            })
            tableHits.on('success', function(result) {
                setStatusSuccess('table-hits-container');
                jQuery('.gapi-analytics-data-chart-styles-table-tr-odd').css('background-color', jQuery('.wpadm-gapi-analytics-data-chart-styles-table-tr-odd').css('background-color'));
                jQuery("#table-hits-container .gapi-analytics-data-chart-styles-table-tr-even, #table-hits-container .gapi-analytics-data-chart-styles-table-tr-odd").each(
                    function(index) {
                        var site_url = '';
                        var html = jQuery(this).children()[0].innerHTML;

                        if (html.indexOf("a href") < 0) {
                            html += ' <a href="' + site_url + html + '"><span class="glyphicon glyphicon-share"></span></a>';
                            jQuery(this).children()[0].innerHTML = html;
                        }
                    }
                );
                jQuery("#table-hits-container .glyphicon").css("font-family", "Glyphicons Halflings");

            })


            window['tableSearch'] = new gapi.analytics.googleCharts.DataChart({
                query: {
                    'ids': 'ga:'+id,
                    'start-date': start_date,
                    'end-date': end_date,
                    'metrics': 'ga:organicSearches',
                    'dimensions': 'ga:keyword',
                    'sort': '-ga:organicSearches',
                    'max-results': 10
                },
                chart: {
                    'container': document.getElementById('table-search-container').getElementsByClassName('report-result')[0],
                    'type': 'TABLE',
                    'options': {
                        'width': '100%'
                    }
                }
            });
            tableSearch.on('error', function(result) {
                setStatusError('table-search-container', result.error.message);

            })
            tableSearch.on('success', function(result) {
                setStatusSuccess('table-search-container');
                jQuery('.gapi-analytics-data-chart-styles-table-tr-odd').css('background-color', jQuery('.wpadm-gapi-analytics-data-chart-styles-table-tr-odd').css('background-color'));
            })


            window['data1'] = new gapi.analytics.report.Data({
                query: {
                    'ids': 'ga:'+id,
                    'start-date': start_date,
                    'end-date': end_date,
                    'metrics': 'ga:sessions,ga:pageviews,ga:users,ga:pageviewsPerSession,ga:avgSessionDuration,ga:bounces,ga:percentNewSessions',
                }
            });
            data1.on('error', function(result) {
                setStatusError('data-sessions-container', result.error.message);
                setStatusError('data-pageviews-container', result.error.message);
                setStatusError('data-users-container', result.error.message);
                setStatusError('data-pageviewsPerSession-container', result.error.message);
                setStatusError('data-avgSessionDuration-container', result.error.message);
                setStatusError('data-bounces-container', result.error.message);
                setStatusError('data-percentNewSessions-container', result.error.message);
            })
            data1.on('success', function(result) {
                if (!result.hasOwnProperty('rows')) {
                    jQuery('#btn_modal_error_no_data').click();
                    ga_setTitleNoDataWindow();
                    return;
                }
                setStatusSuccess('data-sessions-container', result.rows[0][0]);
                setStatusSuccess('data-pageviews-container', result.rows[0][1]);
                setStatusSuccess('data-users-container', result.rows[0][2]);
                setStatusSuccess('data-pageviewsPerSession-container', (result.rows[0][3]-0).toFixed(2));
                setStatusSuccess('data-avgSessionDuration-container', wpadm_ga_secondsToTime(Math.round(result.rows[0][4]-0)));
                setStatusSuccess('data-bounces-container', ((result.rows[0][5]-0)/((result.rows[0][0]-0)/100)).toFixed(2)+'%');
                setStatusSuccess('data-percentNewSessions-container', (result.rows[0][6]-0).toFixed(2)+'%');
            })

            window['dataChart1'] = new gapi.analytics.googleCharts.DataChart({
                query: {
                    'ids': 'ga:'+id,
                    'start-date': start_date,
                    'end-date': end_date,
                    'metrics': 'ga:sessions,ga:pageviews',
                    'dimensions': 'ga:date'
                },
                chart: {
                    'container': document.getElementById('chart-1-container').getElementsByClassName('report-result')[0],
                    'type': 'LINE',
                    'options': {
                        'width': '99%'
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

                data1.wpadmExecute();
                tableSearch.wpadmExecute();
                tableHits.wpadmExecute();
            })
        });
    });
</script>