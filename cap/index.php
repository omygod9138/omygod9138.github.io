<?php
$file = file_get_contents('caption.txt');
$str = array_filter(explode(PHP_EOL, $file));
if(isset($_GET['displayMode']) && trim($_GET['displayMode']) === 'caption'){
	
	
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>花蓮縣環境保護局</title>
	<!--<link rel="stylesheet" href="normalize.css" />-->
	<style>
		body{
			width:1920px;
			height:1080px;
			background-color:black;
			color:white;
			overflow:hidden;
			white-space: nowrap;
		}
		#caption{
			
			width:100%;
			position:absolute;
			text-align:center;
			letter-spacing: 5px;
			line-height: 1;
			top:0px;
			
		}
		.sections{
			font-size:4cm;
			height: 1080px;
			display:hidden;
		}
		#section_1{
			font-size:4cm;
			height: 1080px;
			
		}
		img{
			vertical-align: middle;
			
		}
	</style>
	<script src="jquery-1.12.4.min.js"></script>
	<script>
		
		$(document).ready(function(){
			var sect = 1
			/*
			setInterval(function(){
				$('#section_'+sect).fadeOut();
				 $('html, body').animate({
				   'scrollTop':   $('#section_'+sect).offset().top
				 }, 100, 'linear', function(){
					$('#section_'+sect).fadeIn(3000);
				 });
				//location.hash = 'section_'+sect;
				sect++;
				sect = sect > 5 ? 1 : sect;
			}, 3000);
			*/
		})
	</script>
</head>
<body>
<div id="caption">
<?php
$sectionCount = 1;
$db_value = 100.11; // value taken from database
foreach($str AS $section){
	$section = explode(',', $section);
	switch ($sectionCount){
		case 2:
			$year = date('Y');
			$mth = date('m');
			$day = date('d');
			$hr = date('H');
			$value = '<span style="color:yellow;">'.$db_value.'</span>';
			$section[0] = sprintf($section[0], $year, $mth, $day, $hr);
			$section[1] = sprintf($section[1], $value);
		break;
		case 3:
			if($db_value > 100){
				$condition = '不良';
			}elseif($db_value < 100 && $db_value > 59){
				$condition = '普通';
			}elseif($db_value <= 59){
				$condition = '良好';
			}
			$airCondition = '<span style="color:yellow;">'.$condition.'</span>';
			$section[0] = sprintf($section[0], $airCondition);
		break;
	}
	echo "<div id='section_".$sectionCount."' class='sections'>
			<a name='section_".$sectionCount."'></a>
			<div>".$section[0]."</div>
			<div>".$section[1]."</div>
			</div>";
	$sectionCount++;
	
}
?>
<!--
	<div id="section_1">
	<a name="section_1"></a>
	<div>花蓮縣環境保護局</div>
	<div>河川揚塵監測計畫</div>
	</div>
	<div id="section_2">
	<a name="section_2"></a>
	<div style="font-size:4cm;"><span style="color:yellow;">2016</span>年<span style="color:yellow;">07</span>月<span style="color:yellow;">04</span>日<span style="color:yellow;">13</span>時</div>
	<div style="font-size:3cm;">懸浮微粒濃度為 <span style="color:yellow;">100.11</span> µg/m<sup>3</sup></div> 
	</div>
	<div id="section_3">
	<a name="section_3"></a>
	<div>空氣品質<span style="color:yellow;">良好</span></div>
	<div>揚塵防制不能少</div>
	</div>
	<div id="section_4">
	<a name="section_4"></a>
	<div>生活環境更美好</div>
	<div>花蓮縣環境保護局關心您</div>
	</div>
	<div id="section_5">
	<a name="section_5"></a>
	<div>威陞環境科技股份有限公司</div>
	<div><img src="logo.jpg">河川揚塵監控系統</div>
	</div>
-->
</div>
</body>
</html>
<?php } ?>