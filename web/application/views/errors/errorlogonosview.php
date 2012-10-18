<?php 
/**
 * Cobub Razor
 *
 * An open source analytics for mobile applications
 *
 * @package		Cobub Razor
 * @author		WBTECH Dev Team
 * @copyright	Copyright (c) 2011 - 2012, NanJing Western Bridge Co.,Ltd.
 * @license		http://www.cobub.com/products/cobub-razor/license
 * @link		http://www.cobub.com/products/cobub-razor/
 * @since		Version 1.0
 * @filesource
 */?>
<section id="main" class="column"  style="height:1250px;">
<article class="module width_full">
  <header>
  <h3><?php echo  lang('m_rpt_errorsOnOS')?></h3>
  <ul class="tabs2">
	<li><a id="errornum11" href="javascript:changetypename('errorNumber')"><?php echo  lang('v_rpt_err_errorNums')?></a></li>
	<li><a id="errorstartnum11" href="javascript:changetypename('errorAndStart')"><?php echo  lang('v_rpt_err_errorNumsInSessions')?></a></li>
  </ul>
  </header>
  
 <article class="">
	     <div id="container"  class="module_content" style="height:300px"></div>
 </article>
</article>

<script type="text/javascript">
var changetype='errorNumber';
var title='';
var options;
var errorCountData = [];
var errorCountPerSessionData = [];
var myurl = "<?php echo site_url()?>/report/erroronos/geterroralldata/";
</script>
<!-- report -->
<script type="text/javascript">
var options;
$(document).ready(function() {
	options = {
            chart: {
                renderTo: 'container',
                type:'column'
            },
            title: {
                text: '   '
            },
            subtitle: {
                text: ' '
            },
            xAxis: {
            	categories:'',
            	labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '11px',
                        fontFamily: ' sans-serif'
                    }
                }
            	//,title:{text:"version"}
            },
            yAxis: {
                title: { text:''},
                min:0
            },
            plotOptions: {
                column: {
                    pointPadding: 0.3,
                    borderWidth: 0
                }
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.series.name +': '+ this.y +'<br>'+'<?php echo lang("m_rpt_os");?>'+':'+this.x;
                }
            },
            credits: {
                enabled: false
            },
            series: [
                {
  	             data:''
                }
            ]
        };
	renderCharts(myurl);
	
});

    function renderCharts(myurl)
    {		
    	 var chart_canvas = $('#container');
    	    var loading_img = $("<img src='<?php echo base_url();?>/assets/images/loader.gif'/>");
    		    
    	    chart_canvas.block({
    	        message: loading_img,
    	        css:{
    	            width:'32px',
    	            border:'none',
    	            background: 'none'
    	        },
    	        overlayCSS:{
    	            backgroundColor: '#FFF',
    	            opacity: 0.8
    	        },
    	        baseZ:997
    	    });
    	   
    	jQuery.getJSON(myurl, null, function(data) { 
    		
        	if(data==null)
        	{
        		chart_canvas.unblock();
        		return;
            }

    		var obj = data.content;
    		if(obj==null)
    		{
        		chart_canvas.unblock();
        		return;
            }
            
    		var categories = [];
    		
    	    for(var j=0;j<obj.length;j++)
    	    {
            	
            	errorCountData.push(parseInt(obj[j].count));
            	errorCountPerSessionData.push(parseFloat(obj[j].percentage));
		    	categories.push(obj[j].deviceos_name);
    	    }
    	    
   		    options.series[0].data = errorCountData;
      		options.series[0].name = '<?php echo lang("v_rpt_err_errorCount");?>';
			options.xAxis.categories = categories; 
			options.title.text = '<?php echo $reportTitle['errorCount'] ?>';
			options.subtitle.text = '<?php echo $reportTitle['timePhase'];?>';
    	    chart = new Highcharts.Chart(options);
    		chart_canvas.unblock();
    		});  
    } 
</script>
<script type="text/javascript">

function changetypename(name)
{
	if(name == "errorNumber")
	{
		options.series[0].data = errorCountData;
		options.series[0].name = 'error count';
		options.title.text = '<?php echo $reportTitle['errorCount'] ?>';
		chart = new Highcharts.Chart(options);
	}

	if(name == "errorAndStart")
	{
		options.series[0].data = errorCountPerSessionData;
		options.series[0].name = '<?php echo lang("v_rpt_err_errorCountInSessions")?>';
		options.title.text = '<?php echo $reportTitle['errorCountPerSession'] ?>';
		chart = new Highcharts.Chart(options);
	}
}

//Init tab selector of report
$(".tab_content").hide(); 
$("ul.tabs2 li:first").addClass("active").show(); 
$(".tab_content:first").show();

//On Click Event
$("ul.tabs2 li").click(function() {
	$("ul.tabs2 li").removeClass("active"); 
	$(this).addClass("active");
	var activeTab = $(this).find("a").attr("id");
	$(activeTab).fadeIn(); 
	return true;
});
</script>

