<?php
$file = file_get_contents('caption.txt');
$str = array_filter(explode(PHP_EOL, $file));
$display = $_GET['captionMode'] ? $_GET['captionMode'] : null;
if(!$display){
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
			line-height: 2;
			font-size:114px;
		}
		.sections{
			height: 1080px;
			padding-top: 192px;
		}
	
		img{
			vertical-align: middle;
			max-height: 146px;
			max-width: 203px;
			margin-top: -36px;
		}
	</style>
	<script src="jquery-1.12.4.min.js"></script>
	<script>
		
		$(document).ready(function(){
			var sect = 1
			var cur_sect;
			var max_sect = document.querySelectorAll("#caption > div").length;
			console.log(max_sect);
			 $('body').bind('mousewheel', function(e){
				if(e.originalEvent.wheelDelta /120 > 0) {
					
					sect--;
					sect = sect < 1 ? max_sect : sect;
					console.log('scrolling up !', sect);
				}
				else{
					
					sect++;
					sect = sect > max_sect ? 1 : sect;
					console.log('scrolling down !', sect);
				}
				
				
				$('html, body').animate({
					   'scrollTop':   $('#section_'+sect).offset().top
					 }, 1, 'linear', function(){
						$('#section_'+sect).fadeIn(1000);
						
				});
				
			});
			/*
			setInterval(function(){
				//$('#section_'+sect).fadeOut();
				$('html, body').animate({
				   'scrollTop':   $('#section_'+sect).offset().top
				 }, 1, 'linear', function(){
					$('#section_'+sect).fadeIn(1000);
					$('#section_'+(sect - 1)).fadeOut();
				 });
				//location.hash = 'section_'+sect;
				sect++;
				sect = sect > max_sect ? 1 : sect;
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

if($db_value > 100){
	$condition = '不良';
}elseif($db_value < 100 && $db_value > 59){
	$condition = '普通';
}elseif($db_value <= 59){
	$condition = '良好';
}
$value = '<span style="color:yellow;">'.$db_value.'</span>';
$airCondition = '<span style="color:yellow;">'.$condition.'</span>';
foreach($str AS $section){
	$section = explode('|', $section);
	$div =  "<div id='section_".$sectionCount."' class='sections'>
			<a name='section_".$sectionCount."'></a>";
	foreach($section AS $paragraph){	
		if(preg_match("/%s年%s月%s日%s時/", $paragraph, $matches) === 1){
			$year = '<span style="color:yellow;">'.date('Y').'</span>';
			$mth = '<span style="color:yellow;">'.date('m').'</span>';
			$day = '<span style="color:yellow;">'.date('d').'</span>';
			$hr = '<span style="color:yellow;">'.date('H').'</span>';
			$paragraph = sprintf($paragraph, $year, $mth, $day, $hr);
		}
		
		if(preg_match("/µg/", $paragraph, $matches) === 1){
			$paragraph = sprintf($paragraph, $value);
		}
		
		if(preg_match("/空氣品質/", $paragraph, $matches) === 1){
			$paragraph = sprintf($paragraph, $airCondition);
		}
			

		
		$div .=	"<div>".$paragraph."</div>";
	}
	echo $div."</div>";
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
