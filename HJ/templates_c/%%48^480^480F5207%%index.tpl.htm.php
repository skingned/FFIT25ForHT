<?php /* Smarty version 2.6.26, created on 2017-11-25 14:29:14
         compiled from ../tpl/index.tpl.htm */ ?>
<!doctype html>

<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en-gb" class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--[if lt IE 9]> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title><?php echo $this->_tpl_vars['COMPANY']; ?>
 - <?php echo $this->_tpl_vars['SYSNAME']; ?>
</title>
    <meta name="description" content="">
    <meta name="author" content="ffit.com">
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if lte IE 8]>
		<script type="text/javascript" src="http://explorercanvas.googlecode.com/svn/trunk/excanvas.js"></script>
	<![endif]-->
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
	<!-- Map Icons -->
	<!--<link rel="stylesheet" type="text/css" href="../bower_components/map-icons/dist/css/map-icons.min.css">-->
    <!-- Owl Carousel Assets -->
    <link rel="stylesheet" href="../css/styles.css" />
	<?php echo '
		<style>
		.btn{
			width:100px;
			margin:6px;
		}
		.btn img{
			width:24px;
		}
		#infox h3{
			color:blue;
		}
		td{
			color:black;
		}
		th{
			color:blue;		
		}
		table {
			margin-bottom:40px;
			width:100%;
		}
		</style>
	'; ?>

</head>
<body>
	<div class="row">
		<div class="form-group">
			<h2><?php echo $this->_tpl_vars['SYSNAME']; ?>
</h2>
			<button id="button0id" name="button0id" class="btn btn-default"><img src="../images/icon/busstop.png" />站牌</button>
			<a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
			<button id="button1id" name="button1id" class="btn btn-warning"><img src="../images/icon/shintoshrine.png" />景點</button>
			<a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
			<button id="button2id" name="button2id" class="btn btn-success"><img src="../images/icon/party-2.png" />活動</button>
			<button id="button3id" name="button3id" class="btn btn-success"><img src="../images/icon/restaurant1.png" />餐廳</button>
			<button id="button4id" name="button4id" class="btn btn-success"><img src="../images/icon/hostel_0star.png" />旅館</button>
			<button id="button6id" name="button6id" class="btn btn-success"><img src="../images/icon/wifi.png" />WIFI</button>
			<button id="button7id" name="button7id" class="btn btn-success"><img src="../images/icon/car.png" />車禍</button>
			<button id="button5id" name="button5id" class="btn btn-danger">Clear</button>
		</div>
	</div>
   <div class="row" style="background-color:white">
	
		<!--map-->
			<div id="map_area"  style="width: 100%">
			<div id="map_canvas" class="map" style="align-content: center;">map</div>				
			</div>  			
		<!--/map-->		
			<div id="setinfo" style="widht:100%;background-color:#D0F5A9">
			<h1>目標:  增加旅遊深度 方便規劃路線 節省交通費用</h1>
			<h2>分析假設及方法說明</h2>
			假設:使用者以公車路線為旅遊路線<br>
			使用者以特定景點為目標,以公車為旅遊路線,提供路線上的其它景點資訊<br>			
			經緯度  1度=約 111公里<br>
			用半徑0.005度 約550公尺 找出座標落在站牌 週邊  1.1公里正方 的資訊,加以註記,發現<BR>			
			 1.沒有任何公車站的景點<BR>
			 <table>
			<tr><th>#</th><TH>系統代號</tH><TH>系統編號</tH><TH>名稱</tH><TH>lat</tH><TH>lng</tH><TH>地址</tH></tr>
			 <?php unset($this->_sections['h']);
$this->_sections['h']['name'] = 'h';
$this->_sections['h']['loop'] = is_array($_loop=$this->_tpl_vars['SSCF']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['h']['show'] = true;
$this->_sections['h']['max'] = $this->_sections['h']['loop'];
$this->_sections['h']['step'] = 1;
$this->_sections['h']['start'] = $this->_sections['h']['step'] > 0 ? 0 : $this->_sections['h']['loop']-1;
if ($this->_sections['h']['show']) {
    $this->_sections['h']['total'] = $this->_sections['h']['loop'];
    if ($this->_sections['h']['total'] == 0)
        $this->_sections['h']['show'] = false;
} else
    $this->_sections['h']['total'] = 0;
if ($this->_sections['h']['show']):

            for ($this->_sections['h']['index'] = $this->_sections['h']['start'], $this->_sections['h']['iteration'] = 1;
                 $this->_sections['h']['iteration'] <= $this->_sections['h']['total'];
                 $this->_sections['h']['index'] += $this->_sections['h']['step'], $this->_sections['h']['iteration']++):
$this->_sections['h']['rownum'] = $this->_sections['h']['iteration'];
$this->_sections['h']['index_prev'] = $this->_sections['h']['index'] - $this->_sections['h']['step'];
$this->_sections['h']['index_next'] = $this->_sections['h']['index'] + $this->_sections['h']['step'];
$this->_sections['h']['first']      = ($this->_sections['h']['iteration'] == 1);
$this->_sections['h']['last']       = ($this->_sections['h']['iteration'] == $this->_sections['h']['total']);
?>
					<tr><th><b><?php echo $this->_sections['h']['index']+1; ?>
</b></th>
				<?php unset($this->_sections['x']);
$this->_sections['x']['name'] = 'x';
$this->_sections['x']['loop'] = is_array($_loop=$this->_tpl_vars['SSCF'][$this->_sections['h']['index']]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['x']['show'] = true;
$this->_sections['x']['max'] = $this->_sections['x']['loop'];
$this->_sections['x']['step'] = 1;
$this->_sections['x']['start'] = $this->_sections['x']['step'] > 0 ? 0 : $this->_sections['x']['loop']-1;
if ($this->_sections['x']['show']) {
    $this->_sections['x']['total'] = $this->_sections['x']['loop'];
    if ($this->_sections['x']['total'] == 0)
        $this->_sections['x']['show'] = false;
} else
    $this->_sections['x']['total'] = 0;
if ($this->_sections['x']['show']):

            for ($this->_sections['x']['index'] = $this->_sections['x']['start'], $this->_sections['x']['iteration'] = 1;
                 $this->_sections['x']['iteration'] <= $this->_sections['x']['total'];
                 $this->_sections['x']['index'] += $this->_sections['x']['step'], $this->_sections['x']['iteration']++):
$this->_sections['x']['rownum'] = $this->_sections['x']['iteration'];
$this->_sections['x']['index_prev'] = $this->_sections['x']['index'] - $this->_sections['x']['step'];
$this->_sections['x']['index_next'] = $this->_sections['x']['index'] + $this->_sections['x']['step'];
$this->_sections['x']['first']      = ($this->_sections['x']['iteration'] == 1);
$this->_sections['x']['last']       = ($this->_sections['x']['iteration'] == $this->_sections['x']['total']);
?>	
					<td><?php echo $this->_tpl_vars['SSCF'][$this->_sections['h']['index']][$this->_sections['x']['index']]; ?>
</td>
				<?php endfor; endif; ?>
					</tr>
			 <?php endfor; endif; ?>
			 </table>
			 
			 2.沒有任何公車站的餐廳<BR>
			 <table>
			 <tr><th>#</th><TH>系統代號</tH><TH>系統編號</tH><TH>名稱</tH><TH>lat</tH><TH>lng</tH><TH>地址</tH></tr>
			 <?php unset($this->_sections['h']);
$this->_sections['h']['name'] = 'h';
$this->_sections['h']['loop'] = is_array($_loop=$this->_tpl_vars['SSRF']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['h']['show'] = true;
$this->_sections['h']['max'] = $this->_sections['h']['loop'];
$this->_sections['h']['step'] = 1;
$this->_sections['h']['start'] = $this->_sections['h']['step'] > 0 ? 0 : $this->_sections['h']['loop']-1;
if ($this->_sections['h']['show']) {
    $this->_sections['h']['total'] = $this->_sections['h']['loop'];
    if ($this->_sections['h']['total'] == 0)
        $this->_sections['h']['show'] = false;
} else
    $this->_sections['h']['total'] = 0;
if ($this->_sections['h']['show']):

            for ($this->_sections['h']['index'] = $this->_sections['h']['start'], $this->_sections['h']['iteration'] = 1;
                 $this->_sections['h']['iteration'] <= $this->_sections['h']['total'];
                 $this->_sections['h']['index'] += $this->_sections['h']['step'], $this->_sections['h']['iteration']++):
$this->_sections['h']['rownum'] = $this->_sections['h']['iteration'];
$this->_sections['h']['index_prev'] = $this->_sections['h']['index'] - $this->_sections['h']['step'];
$this->_sections['h']['index_next'] = $this->_sections['h']['index'] + $this->_sections['h']['step'];
$this->_sections['h']['first']      = ($this->_sections['h']['iteration'] == 1);
$this->_sections['h']['last']       = ($this->_sections['h']['iteration'] == $this->_sections['h']['total']);
?>
					<tr><th><b><?php echo $this->_sections['h']['index']+1; ?>
</b></th>
				<?php unset($this->_sections['x']);
$this->_sections['x']['name'] = 'x';
$this->_sections['x']['loop'] = is_array($_loop=$this->_tpl_vars['SSRF'][$this->_sections['h']['index']]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['x']['show'] = true;
$this->_sections['x']['max'] = $this->_sections['x']['loop'];
$this->_sections['x']['step'] = 1;
$this->_sections['x']['start'] = $this->_sections['x']['step'] > 0 ? 0 : $this->_sections['x']['loop']-1;
if ($this->_sections['x']['show']) {
    $this->_sections['x']['total'] = $this->_sections['x']['loop'];
    if ($this->_sections['x']['total'] == 0)
        $this->_sections['x']['show'] = false;
} else
    $this->_sections['x']['total'] = 0;
if ($this->_sections['x']['show']):

            for ($this->_sections['x']['index'] = $this->_sections['x']['start'], $this->_sections['x']['iteration'] = 1;
                 $this->_sections['x']['iteration'] <= $this->_sections['x']['total'];
                 $this->_sections['x']['index'] += $this->_sections['x']['step'], $this->_sections['x']['iteration']++):
$this->_sections['x']['rownum'] = $this->_sections['x']['iteration'];
$this->_sections['x']['index_prev'] = $this->_sections['x']['index'] - $this->_sections['x']['step'];
$this->_sections['x']['index_next'] = $this->_sections['x']['index'] + $this->_sections['x']['step'];
$this->_sections['x']['first']      = ($this->_sections['x']['iteration'] == 1);
$this->_sections['x']['last']       = ($this->_sections['x']['iteration'] == $this->_sections['x']['total']);
?>	
					<td><?php echo $this->_tpl_vars['SSRF'][$this->_sections['h']['index']][$this->_sections['x']['index']]; ?>
</td>
				<?php endfor; endif; ?>
					</tr>
			 <?php endfor; endif; ?>
			 </table>			 
			 3.沒有任何公車站的旅館<BR>			 
			 <table>
			  <tr><th>#</th><TH>系統代號</tH><TH>系統編號</tH><TH>名稱</tH><TH>lat</tH><TH>lng</tH><TH>地址</tH></tr>
			 <?php unset($this->_sections['h']);
$this->_sections['h']['name'] = 'h';
$this->_sections['h']['loop'] = is_array($_loop=$this->_tpl_vars['SSHF']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['h']['show'] = true;
$this->_sections['h']['max'] = $this->_sections['h']['loop'];
$this->_sections['h']['step'] = 1;
$this->_sections['h']['start'] = $this->_sections['h']['step'] > 0 ? 0 : $this->_sections['h']['loop']-1;
if ($this->_sections['h']['show']) {
    $this->_sections['h']['total'] = $this->_sections['h']['loop'];
    if ($this->_sections['h']['total'] == 0)
        $this->_sections['h']['show'] = false;
} else
    $this->_sections['h']['total'] = 0;
if ($this->_sections['h']['show']):

            for ($this->_sections['h']['index'] = $this->_sections['h']['start'], $this->_sections['h']['iteration'] = 1;
                 $this->_sections['h']['iteration'] <= $this->_sections['h']['total'];
                 $this->_sections['h']['index'] += $this->_sections['h']['step'], $this->_sections['h']['iteration']++):
$this->_sections['h']['rownum'] = $this->_sections['h']['iteration'];
$this->_sections['h']['index_prev'] = $this->_sections['h']['index'] - $this->_sections['h']['step'];
$this->_sections['h']['index_next'] = $this->_sections['h']['index'] + $this->_sections['h']['step'];
$this->_sections['h']['first']      = ($this->_sections['h']['iteration'] == 1);
$this->_sections['h']['last']       = ($this->_sections['h']['iteration'] == $this->_sections['h']['total']);
?>
					<tr><th><b><?php echo $this->_sections['h']['index']+1; ?>
</b></th>
				<?php unset($this->_sections['x']);
$this->_sections['x']['name'] = 'x';
$this->_sections['x']['loop'] = is_array($_loop=$this->_tpl_vars['SSHF'][$this->_sections['h']['index']]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['x']['show'] = true;
$this->_sections['x']['max'] = $this->_sections['x']['loop'];
$this->_sections['x']['step'] = 1;
$this->_sections['x']['start'] = $this->_sections['x']['step'] > 0 ? 0 : $this->_sections['x']['loop']-1;
if ($this->_sections['x']['show']) {
    $this->_sections['x']['total'] = $this->_sections['x']['loop'];
    if ($this->_sections['x']['total'] == 0)
        $this->_sections['x']['show'] = false;
} else
    $this->_sections['x']['total'] = 0;
if ($this->_sections['x']['show']):

            for ($this->_sections['x']['index'] = $this->_sections['x']['start'], $this->_sections['x']['iteration'] = 1;
                 $this->_sections['x']['iteration'] <= $this->_sections['x']['total'];
                 $this->_sections['x']['index'] += $this->_sections['x']['step'], $this->_sections['x']['iteration']++):
$this->_sections['x']['rownum'] = $this->_sections['x']['iteration'];
$this->_sections['x']['index_prev'] = $this->_sections['x']['index'] - $this->_sections['x']['step'];
$this->_sections['x']['index_next'] = $this->_sections['x']['index'] + $this->_sections['x']['step'];
$this->_sections['x']['first']      = ($this->_sections['x']['iteration'] == 1);
$this->_sections['x']['last']       = ($this->_sections['x']['iteration'] == $this->_sections['x']['total']);
?>	
					<td><?php echo $this->_tpl_vars['SSHF'][$this->_sections['h']['index']][$this->_sections['x']['index']]; ?>
</td>
				<?php endfor; endif; ?>
					</tr>
			 <?php endfor; endif; ?>
			 </table>
		 4.站牌的景點數 (排名)<BR>
			<table>
			 <tr><th>#</th><TH>景點數</tH><TH>站牌名稱</tH></tr>
			 <?php unset($this->_sections['h']);
$this->_sections['h']['name'] = 'h';
$this->_sections['h']['loop'] = is_array($_loop=$this->_tpl_vars['SSST']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['h']['show'] = true;
$this->_sections['h']['max'] = $this->_sections['h']['loop'];
$this->_sections['h']['step'] = 1;
$this->_sections['h']['start'] = $this->_sections['h']['step'] > 0 ? 0 : $this->_sections['h']['loop']-1;
if ($this->_sections['h']['show']) {
    $this->_sections['h']['total'] = $this->_sections['h']['loop'];
    if ($this->_sections['h']['total'] == 0)
        $this->_sections['h']['show'] = false;
} else
    $this->_sections['h']['total'] = 0;
if ($this->_sections['h']['show']):

            for ($this->_sections['h']['index'] = $this->_sections['h']['start'], $this->_sections['h']['iteration'] = 1;
                 $this->_sections['h']['iteration'] <= $this->_sections['h']['total'];
                 $this->_sections['h']['index'] += $this->_sections['h']['step'], $this->_sections['h']['iteration']++):
$this->_sections['h']['rownum'] = $this->_sections['h']['iteration'];
$this->_sections['h']['index_prev'] = $this->_sections['h']['index'] - $this->_sections['h']['step'];
$this->_sections['h']['index_next'] = $this->_sections['h']['index'] + $this->_sections['h']['step'];
$this->_sections['h']['first']      = ($this->_sections['h']['iteration'] == 1);
$this->_sections['h']['last']       = ($this->_sections['h']['iteration'] == $this->_sections['h']['total']);
?>
					<tr><th><b><?php echo $this->_sections['h']['index']+1; ?>
</b></th>
				<?php unset($this->_sections['x']);
$this->_sections['x']['name'] = 'x';
$this->_sections['x']['loop'] = is_array($_loop=$this->_tpl_vars['SSST'][$this->_sections['h']['index']]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['x']['show'] = true;
$this->_sections['x']['max'] = $this->_sections['x']['loop'];
$this->_sections['x']['step'] = 1;
$this->_sections['x']['start'] = $this->_sections['x']['step'] > 0 ? 0 : $this->_sections['x']['loop']-1;
if ($this->_sections['x']['show']) {
    $this->_sections['x']['total'] = $this->_sections['x']['loop'];
    if ($this->_sections['x']['total'] == 0)
        $this->_sections['x']['show'] = false;
} else
    $this->_sections['x']['total'] = 0;
if ($this->_sections['x']['show']):

            for ($this->_sections['x']['index'] = $this->_sections['x']['start'], $this->_sections['x']['iteration'] = 1;
                 $this->_sections['x']['iteration'] <= $this->_sections['x']['total'];
                 $this->_sections['x']['index'] += $this->_sections['x']['step'], $this->_sections['x']['iteration']++):
$this->_sections['x']['rownum'] = $this->_sections['x']['iteration'];
$this->_sections['x']['index_prev'] = $this->_sections['x']['index'] - $this->_sections['x']['step'];
$this->_sections['x']['index_next'] = $this->_sections['x']['index'] + $this->_sections['x']['step'];
$this->_sections['x']['first']      = ($this->_sections['x']['iteration'] == 1);
$this->_sections['x']['last']       = ($this->_sections['x']['iteration'] == $this->_sections['x']['total']);
?>	
					<td><?php echo $this->_tpl_vars['SSST'][$this->_sections['h']['index']][$this->_sections['x']['index']]; ?>
</td>
				<?php endfor; endif; ?>
					</tr>
			 <?php endfor; endif; ?>
			 </table>
		5.站牌的餐廳數 (排名)<BR>
			<table>
			 <tr><th>#</th><TH>餐廳數</tH><TH>站牌名稱</tH></tr>
			 <?php unset($this->_sections['h']);
$this->_sections['h']['name'] = 'h';
$this->_sections['h']['loop'] = is_array($_loop=$this->_tpl_vars['SSST']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['h']['show'] = true;
$this->_sections['h']['max'] = $this->_sections['h']['loop'];
$this->_sections['h']['step'] = 1;
$this->_sections['h']['start'] = $this->_sections['h']['step'] > 0 ? 0 : $this->_sections['h']['loop']-1;
if ($this->_sections['h']['show']) {
    $this->_sections['h']['total'] = $this->_sections['h']['loop'];
    if ($this->_sections['h']['total'] == 0)
        $this->_sections['h']['show'] = false;
} else
    $this->_sections['h']['total'] = 0;
if ($this->_sections['h']['show']):

            for ($this->_sections['h']['index'] = $this->_sections['h']['start'], $this->_sections['h']['iteration'] = 1;
                 $this->_sections['h']['iteration'] <= $this->_sections['h']['total'];
                 $this->_sections['h']['index'] += $this->_sections['h']['step'], $this->_sections['h']['iteration']++):
$this->_sections['h']['rownum'] = $this->_sections['h']['iteration'];
$this->_sections['h']['index_prev'] = $this->_sections['h']['index'] - $this->_sections['h']['step'];
$this->_sections['h']['index_next'] = $this->_sections['h']['index'] + $this->_sections['h']['step'];
$this->_sections['h']['first']      = ($this->_sections['h']['iteration'] == 1);
$this->_sections['h']['last']       = ($this->_sections['h']['iteration'] == $this->_sections['h']['total']);
?>
					<tr><th><b><?php echo $this->_sections['h']['index']+1; ?>
</b></th>
				<?php unset($this->_sections['x']);
$this->_sections['x']['name'] = 'x';
$this->_sections['x']['loop'] = is_array($_loop=$this->_tpl_vars['SSST'][$this->_sections['h']['index']]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['x']['show'] = true;
$this->_sections['x']['max'] = $this->_sections['x']['loop'];
$this->_sections['x']['step'] = 1;
$this->_sections['x']['start'] = $this->_sections['x']['step'] > 0 ? 0 : $this->_sections['x']['loop']-1;
if ($this->_sections['x']['show']) {
    $this->_sections['x']['total'] = $this->_sections['x']['loop'];
    if ($this->_sections['x']['total'] == 0)
        $this->_sections['x']['show'] = false;
} else
    $this->_sections['x']['total'] = 0;
if ($this->_sections['x']['show']):

            for ($this->_sections['x']['index'] = $this->_sections['x']['start'], $this->_sections['x']['iteration'] = 1;
                 $this->_sections['x']['iteration'] <= $this->_sections['x']['total'];
                 $this->_sections['x']['index'] += $this->_sections['x']['step'], $this->_sections['x']['iteration']++):
$this->_sections['x']['rownum'] = $this->_sections['x']['iteration'];
$this->_sections['x']['index_prev'] = $this->_sections['x']['index'] - $this->_sections['x']['step'];
$this->_sections['x']['index_next'] = $this->_sections['x']['index'] + $this->_sections['x']['step'];
$this->_sections['x']['first']      = ($this->_sections['x']['iteration'] == 1);
$this->_sections['x']['last']       = ($this->_sections['x']['iteration'] == $this->_sections['x']['total']);
?>	
					<td><?php echo $this->_tpl_vars['SSST'][$this->_sections['h']['index']][$this->_sections['x']['index']]; ?>
</td>
				<?php endfor; endif; ?>
					</tr>
			 <?php endfor; endif; ?>
			 </table>	 
			<div id="infox" style="widht:100%;background-color:#F2F5A9">
			<h2>發現問題</h2>
				<h3>1.以新竹觀光為例:外國或無開車的旅客多以大眾交通工具或遊覽車為交通替代方案,但以景點在地圖上的分佈來看並沒有很完善的機制!</h3>
				<h3>2.公車業者以上班族為主要服務對像,但未來捷運竣工後,公車必需進行轉型,將影響公車司機生計?</h3>
				<h3>3.增加站牌能產生有多少效率?以地圖上顯示出交通工具與景點之間的關連,各其所需</h3>
				<h3>4.業者有無自行改善的方法?如景點業者週邊無站牌,可以結合週邊其它業者推出共乘機制,增加收入</h3>				
				
			<h2>資料用途及效益</h2>
				<ul>
					<li><h3>"政府單位":進行路線及人數管制,(如陽明山花季公車)</h3></li>				
					<li><h3>"旅客":推廣公車旅遊(*遊輪式公車),取代自行開車,=>減少 塞車,停車,空污,交通安全 問題</h3></li>
					<li><h3>       增加旅遊深度,方便規劃路線,節省交通費用</h3></li>
					<li><h3>"景點"業者可分析改善交通便利性,增加回客率及營收</h3></li>
					<li><h3>"公車"業者可分析改善交通路線,增加載客率,提升服務品質</h3></li>
				</ul>
			</div>		
			</div>		
			<!--</div>-->
		</div>	<!--/.-->
    </div>
	<!--/news-->
		<div class="result"></div>
	</div>

    <!--[if lte IE 8]><script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script><![endif]-->
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=<?php echo $this->_tpl_vars['MAPKEY']; ?>
"></script>
	

	<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>  

	
	<script type="text/javascript" src="../js/gmaps.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js" ></script>
    <script src="../js/hj.js"></script>	
	
<?php echo '
    <script type="text/javascript">
	/*$(function(){
	
	});*/
    </script>
	
	
	'; ?>

</body>
</html>