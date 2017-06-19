<!doctype html>
<html>


<?PHP
if (empty($_POST['launch_presentation_return_url']))
{
	echo "<link rel='stylesheet' type='text/css' href='css/messages.css'>";

        echo "<br /><br /><br /><center>";
	echo "<div style='width: 60%; text-align: left' class=css_btn_class >";
	echo "<img src='images/board.png' align=left hspace=20 vspace=20 width=100 />";
        echo "<br />Welcome to the Learning Gamification project.  You need to setup this link as a Web Link tool in Blackboard.  Ask your administrator to add the LTI and REST configuration and then use Build Content -> Web Link with Tool Provider option.";
	echo "<br /><br /><center><a href='https://szymonmachajewski.wordpress.com/?p=802course-gamification-tools-for-blackboard-learn'>Read more</a> about instructions and background research.</center>";
	echo "</div></center>";
        die();

}

require("get_data.php");
require("names.php");

$user_label = $user->name->given." ".$user->name->family;
$user_data = 0;
foreach($g as $row)
{
if ($user->id == $row->userId) {
	$user_label = $name;
} else {
	$random_name = $names[mt_rand(0, sizeof($names) - 1)];
	$random_surname = $surnames[mt_rand(0, sizeof($surnames) - 1)];
        $labels .=  '"'.$random_name . ' ' . $random_surname. '", ';
	//$labels .=  '"'.$row->id.'",';
}
}

foreach($g as $row)
{
        $sum += $row->score;
}
	if (count($g)==0) {
		$avg=0; } else {
	$avg = round($sum / count($g));}

foreach($g as $row)
{
if ($user->id == $row->userId) {
	$user_data = round($row->score - $avg);
} else {
        $data .= round($row->score - $avg).",";
}

}

$labels = substr('"'.$user_label.'",'.$labels,0,-1);
$data = substr($user_data.','.$data,0,-1);



?>
<head>
    <title>Leaderboard</title>
    <script src="chart/Chart.bundle.js"></script>
    <script src="chart/utils.js"></script>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.3.ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    </style>
</head>

<body>
<?PHP

/*
if (count($g) < 30)
{ 
	//$c=count($g) * 25;
	//$canvasHeight="style='height:".$c."px !important'";
} else {
	$c=count($g) * 80;
	$canvasHeight="width=800 style='height:".$c."px'";
}
*/

?>
<center>
    <div id="container" style="width: 85%;">
        <canvas id="canvas" <?PHP echo $canvasHeight; ?> ></canvas>
    </div>
</center>

<?PHP 
if (!empty($_GET['analysis']))
{
?>
<center>
    <button id="randomizeData">Change Instructor</button>
    <button id="addDataset">Simulate Semester</button>


    <button id="reset">Reset Data</button>
</center>
<br /><br />
<blockquote>The grade simulations below are a result of an advanced Artificial Intelligence (AI) system called Sherlock. It uses design patters outlined by the IBM Watson system and prototyped on the Bluemix Watson Developer Cloud.  Through analysis of Big Data available at your school and other institutions, such as logins to Blackboard, student course reviews, years of gradebook archives, Sherlock is able to accurately simulate what your grade would be if you studied under a different instructor or if you took this class in a different semester.<br /><br />
</blockquote>
<?PHP
}
?>
<blockquote>
Note: The names of students, other than your own, have been changed.  The zero on the horizontal axis represents the class average currenty calculated to be <?PHP echo $avg; ?> points for this class.  Any values to the right of the graph signify above average progress.
</blockquote>

    <script>
        var MONTHS = [
	<?PHP echo $labels; ?>
];
        var color = Chart.helpers.color;

        var horizontalBarChartData = "";
	
var dataToTable = function (dataset) {
    var html = '<table border=1 cellpadding=5><caption>Course progress in points</caption>';
    html += '<thead><tr><th scope=col style="width:120px;">Names</th>';
    
    var columnCount = 0;
    jQuery.each(dataset.datasets, function (idx, item) {
        html += '<th scope=col style="background-color:' + item.fillColor + ';">' + item.label + '</th>';
        columnCount += 1;
    });

    html += '</tr></thead>';

    jQuery.each(dataset.labels, function (idx, item) {
        html += '<tr><td scope=row >' + item + '</td>';
        for (i = 0; i < columnCount; i++) {
            html += '<td scope=row style="background-color:' + dataset.datasets[i].fillColor + ';">' + (dataset.datasets[i].data[idx] === '0' ? '-' : dataset.datasets[i].data[idx]) + '</td>';
        }
        html += '</tr>';
    });

    html += '</tr><tbody></table>';

    return html;
};

function initData() {
        window.horizontalBarChartData = {
            labels: [
	<?PHP echo $labels; ?>
],
            datasets: [{
                label: 'My Grades: <?PHP echo $finalGradeName; ?>',
                backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                borderColor: window.chartColors.red,
                borderWidth: 1,
                data: [
	<?PHP
		echo $data;
	?>
                ]
            	}

		]

        };
	jQuery('#AccessibleTable').html(dataToTable(horizontalBarChartData));
	}
	initData();
        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myHorizontalBar = new Chart(ctx, {
                type: 'horizontalBar',
                data: horizontalBarChartData,
                options: {
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each horizontal bar to be 2px wide
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                        }
                    },
                    responsive: true,
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: '<?PHP echo "$course_title ($course_batchUID) :: $name"; ?>'
                    }
                }
            });
	jQuery('#AccessibleTable').html(dataToTable(horizontalBarChartData));

        };

    
    



        document.getElementById('randomizeData').addEventListener('click', function() {
            var zero = Math.random() < 0.2 ? true : false;
            horizontalBarChartData.datasets.forEach(function(dataset) {
                dataset.data = dataset.data.map(function() {
                    return zero ? 0.0 : randomScalingFactor();
                });

            });
            window.myHorizontalBar.update();
	jQuery('#AccessibleTable').html(dataToTable(horizontalBarChartData));
        });

        var colorNames = Object.keys(window.chartColors);

        document.getElementById('addDataset').addEventListener('click', function() {
            var colorName = colorNames[horizontalBarChartData.datasets.length % colorNames.length];;
            var dsColor = window.chartColors[colorName];
            var newDataset = {
                label: 'Alt Semester ' + horizontalBarChartData.datasets.length,
                backgroundColor: color(dsColor).alpha(0.5).rgbString(),
                borderColor: dsColor,
                data: []
            };

            for (var index = 0; index < horizontalBarChartData.labels.length; ++index) {
                newDataset.data.push(randomScalingFactor());
            }

            horizontalBarChartData.datasets.push(newDataset);
            window.myHorizontalBar.update();
	jQuery('#AccessibleTable').html(dataToTable(horizontalBarChartData));
        });

<?PHP 
/*
        document.getElementById('addData').addEventListener('click', function() {
            if (horizontalBarChartData.datasets.length > 0) {
                var month = MONTHS[horizontalBarChartData.labels.length % MONTHS.length];
                horizontalBarChartData.labels.push(month);

                for (var index = 0; index < horizontalBarChartData.datasets.length; ++index) {
                    horizontalBarChartData.datasets[index].data.push(randomScalingFactor());
                }

                window.myHorizontalBar.update();
            }
        });
*/
/*
        document.getElementById('removeDataset').addEventListener('click', function() {
            horizontalBarChartData.datasets.splice(1, 1);
            window.myHorizontalBar.update();
        });
*/
?>
        document.getElementById('reset').addEventListener('click', function() {
                window.myHorizontalBar.destroy();
		initData();
		window.onload();
        });
<?PHP

/*
        document.getElementById('removeData').addEventListener('click', function() {
            horizontalBarChartData.labels.splice(-1, 1); // remove the label first

            horizontalBarChartData.datasets.forEach(function (dataset, datasetIndex) {
                dataset.data.pop();
            });

            window.myHorizontalBar.update();
        });
    <button style='visibility: hidden;' id="removeDataset">Remove Course</button>
    <button style='visibility: hidden;' id="addData">Add Student</button>
    <button style='visibility: hidden;' id="removeData">Remove Student</button>
*/
?>





</script>


<div id="AccessibleTable">

</div>


</body>

</html>

