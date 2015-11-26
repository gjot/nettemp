<div id="container" style="height: 400 ; min-width: 310px"></div>
<script type="text/javascript">
var start = +new Date();
function getUrlVars() {
        var vars = {};
	    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
	    vars[key] = value;
    });
    return vars;
    }
    var type = getUrlVars()["type"];
    var max = getUrlVars()["max"];

if (type=='temp') { var xval = " °C"}
if (type=='humid') { var xval = " %"}
if (type=='press') { var xval = " hPa"}
if (type=='gonoff') { var xval = " H/L"}
if (type=='host') { var xval = " ms"}
if (type=='system') { var xval = " %"}
if (type=='lux') { var xval = " lux"}
if (type=='water') { var xval = " m3"}
if (type=='gas') { var xval = " m3"}
if (type=='elec') { var xval = " kWh"}
if (type=='hosts') { var xval = " ms"}



$(function () {
    var seriesOptions = [],
        seriesCounter = 0,

<?php
parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $url);
$type=$url[type];

if ($type == 'system') {
    $array[]=cpu;
    $array[]=memory;
    $array[]=memory_cached;
}

elseif ($type == 'hosts') {
    $dirb = "sqlite:dbf/hosts.db";
    $dbh = new PDO($dirb) or die("cannot open database");
    $query = "SELECT name FROM hosts";
    foreach ($dbh->query($query) as $row) {
	$array[]=$row[0];
    }
}
elseif ($type == 'gonoff') {
    $root = "/var/www/nettemp";
    $dir = "$root/db";
    $lg=glob($dir.'/gonoff*');
    foreach($lg as $li) {
	$array[]=basename($li, ".sql");
    }
}
else {
// sensors
$dirb = "sqlite:dbf/nettemp.db";
$dbh = new PDO($dirb) or die("cannot open database");
$query = "select name FROM sensors WHERE type='$type' AND charts='on'";
foreach ($dbh->query($query) as $row) {
    $array[]=$row[0];
    }
}



$js_array = json_encode($array);
echo "names = ". $js_array . ";\n";
?>
	

        // create the chart when all data is loaded
        createChart = function () {
            $('#container').highcharts('StockChart', {

		chart: {
	        spacingBottom: 0,
		zoomType: 'x',

		events: {
                    load: function () {
                        if (!window.isComparing) {
                            this.setTitle(null, {
                                text: 'Built chart in ' + (new Date() - start) + 'ms'
                            });
                        }
                    }
                },


		},

		legend: {
		enabled: true,
    	        verticalAlign: 'bottom',
		align: 'center',
		y: 0,
        	labelFormatter: function() {
                var lastVal = this.yData[this.yData.length - 1];
                    return '<span style="color:' + this.color + '">' + this.name + ': </span> <b>' + lastVal + xval +'</b> </n>';
        	    }
		},

		rangeSelector: {
	inputEnabled: $('#container').width() > 480,
	selected: 0,
	buttons: [{
	type: 'hour',
	count: 1,
	text: '1H'
	},
	{
	type: 'day',
	count: 1,
	text: '1D'
	}, {
	type: 'day',
	count: 7,
	text: '7D'
	}, {
	type: 'month',
	count: 1,
	text: '1M'
	}, {
	type: 'ytd',
	text: 'YTD'
	}, {
	type: 'year',
	count: 1,
	text: '1Y'
	}, {
	type: 'all',
	text: 'All'
	}]
	},

                yAxis: {
                },

		plotOptions: {
    		series: {
		type: 'spline',
                
    		}
		},

                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y} '+ xval +'</b><br/>',
                    valueDecimals: 2
                },

                series: seriesOptions

	    
            });
	
        };

    $.each(names, function (i, name) {

        $.getJSON('hc_data.php?type='+type+'&name='+name+'&max='+max,  function (data) {

            seriesOptions[i] = {
                name: name,
                data: data
	    };
	    

            // As we're loading the data asynchronously, we don't know what order it will arrive. So
            // we keep a counter and create the chart when all the data is loaded.
            seriesCounter += 1;
	    
            if (seriesCounter === names.length) {
               createChart();
	    
            }
        });
    });
});
</script>

