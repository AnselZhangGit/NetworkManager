<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/model/lan.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/authenticate.php");
?>
<?php
if ( file_exists( '/usr/mysys/logo.gif') )
{
	exec( 'mv /var/www/html/images/logo.gif /var/www/html/images/logo.gif.bak' );
	exec( 'cp -rf /usr/mysys/logo.gif /var/www/html/images');
}
else if ( file_exists( '/var/www/html/images/logo.gif.bak' ) )
{
	exec( 'mv /var/www/html/images/logo.gif.bak /var/www/html/images/logo.gif' );
}

	function getCurVersion($type)
	{
		$versionInfo = '';
		if($type == 'lib')
			$curversionInfos = file('/usr/private/feature-lib-ver');
		if($type=='urllib')
			$curversionInfos = file('/usr/webfilter/lists/url-lib-ver');
		if($type=='syshard')
			$curversionInfos = file('/usr/mysys/Firmware_version');
		$filename = '/usr/.lic/.ace_lic_info';
		if($type=='license' && file_exists($filename) )
		{
			if(function_exists('ace_get_lisence'))
			{
				$ret = ace_get_lisence();
			}
			$lines = file($filename);
			//echo $filename."<br>";
			//print_r( $lines );
			if($lines && $lines[1])
			{
				$splits = explode(':',$lines[1]);
				//echo "--1--";
				//print_r( $splits );
				//echo"<br>";
				$curversionInfos[0] = _gettext(trim($splits[1]));
				//echo "--2--".$curversionInfos[0]."<br>";
			}
				
			
		}   
		if($curversionInfos[0])
		{
			$splits = explode(',',$curversionInfos[0]);
			$versionInfo = $splits[0];
			//echo "--3--".$versionInfo[0]."<br>";
		}
			
		return trim($versionInfo);
	}
	
	function getproducttype()
	{
	  if ( file_exists('/usr/.lic/.ace_fsec.dat') )
	  {
	      $lic_lines = file('/usr/.lic/.ace_fsec.dat');

				foreach ( $lic_lines as $line )
				{
					if (strpos($line,"Product type")!==FALSE)
					{
			    	$splits = explode( ' ', $line );
			    	$splits[3]=trim($splits[3]);
	    	  	return trim($splits[3],"\"");
	    		}
				}
		}
		else
		{
			  return '';
		}
	}

	$curversion = getCurVersion('syshard');
	
	$producttype = getproducttype();
	$pos = strpos( $curversion, "-");
	$head = substr( $curversion, 0, $pos );
	$last = substr( $curversion, $pos );
	$curversion = $producttype.$last;

?>

<?php
	
	
	$auth = new authentication();
	$auther = $auth->getRegUser();
	if(!$auth->isAuthented())
	{
		echo "<script type='text/javascript'>window.top.location='/login.php';</script>";
	}
	$regTime = $auth->getRegTime();	//print_r($_SESSION);
	if(false===$regTime)
		jumpTo('','login.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document</title>
<link href="css/skin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/prototype.js"></script>
<script type="text/javascript" src="/js/base.js"></script>
<style type="text/css">
#logo{
	position:absolute;
	left:0;
	top:0;
}
#para{
	height:50px;
	line-height:50px;
	color:#FFFFFF;
	margin-right:30px;
	float:right;
	margin-bottom:50px;
	
}
a {
    color: #FFFFFF;
    text-decoration: none;
}
#para a{

	font-size:14px;
	/*font-weight:bold;*/
	text-decoration:none;
	color:#FFFFFF;display:inline-block; vertical-align:middle; text-align:center;
}

a:hover{
	color: #0033CC;
	text-decoration:none;
}
#select{
	margin:0 3px 0 0;
}

	
</style>

<script type="text/javascript">
function configsave(){
	if(!confirm('<?=_gettext("suresaveconf");?>'))
		return false;
	var url = 'view/systemConfig/systemMaintenance/SystemManager/configsave.php?randtime='+Math.random();
	//alert('aa');
	new Ajax.Request(url,{
		onSuccess:function(resp){
			alert(resp.responseText);
		},
		onFailure:function(){
			alert('<?=_gettext("savecfgfail");?>!');
		}
	});
}
</script>
<script type="text/javascript">
	var req; //定义变量，用来创建xmlhttprequest对象
  function creatReq() // 创建xmlhttprequest,ajax开始
  {
      var url="systime.php?date="+new Date().getTime();
      if(window.XMLHttpRequest) //非IE浏览器，用xmlhttprequest对象创建
      {
          req=new XMLHttpRequest();
      }
      else if(window.ActiveXObject) //IE浏览器用activexobject对象创建
      {
          req=new ActiveXObject("Microsoft.XMLHttp");
      }

      if(req) //成功创建xmlhttprequest
      {
          req.open("GET",url,true); //与服务端建立连接(请求方式post或get，地址,true表示异步)
          req.onreadystatechange = callback;
          req.send(null);
      }
  }
/*
  function callback() //回调函数，对服务端的响应处理，监视response状态
  {
      if(req.readyState ==4) //请求状态为4表示成功
      {
          if(req.status ==200) //http状态200表示OK
          {		//alert(req.responseText);
              document .getElementById ("systime").innerHTML =req.responseText;
          }
      }
  }
	//setInterval("creatReq()",10000);

	function display(){
		var form1 = document.form.system_timer_current_time.value ;
		var currentTime = timelast(form1);
		document.form.system_timer_current_time.value = currentTime;
		document .getElementById ("systime").innerHTML = currentTime;

		setTimeout('display()', 1000);
	}

	function timelast(timename)
	{

	var DaysToAdd = timename;
	var aTimes = DaysToAdd.split(" ");

	var aDate = aTimes[0].split('-');
	var aTime = aTimes[1].split(':');

	var Y = aDate[0];
	var M = aDate[1] - 1;
	var D = aDate[2];

	var H = aTime[0];
	var I = aTime[1];
	var S = aTime[2];

	var oldTime = new Date(Y, M, D, H, I, S);

	var oldtime = oldTime.getTime() + 1000;

	var newtime = new Date(oldtime);


	var vMonth = (newtime.getMonth()+1) ;
	var vDate = newtime.getDate() ;
	var vHour = newtime.getHours() ;
	var vMinute = newtime.getMinutes();
	var vSecond = newtime.getSeconds();

	var lasttime = newtime.getFullYear()+"-"+(vMonth<10 ? "0" + vMonth : vMonth)+"-"+(vDate<10 ? "0" + vDate : vDate)+" "+(vHour<10 ? "0" + vHour : vHour)+":"+(vMinute<10 ? "0" + vMinute : vMinute)+":"+(vSecond<10 ? "0" + vSecond : vSecond);

	return lasttime;
	}*/
	
	function openwin() { 
      window.open (
      "view/systemConfig/sys_user/edit_pwd.php","","dependent=yes,toolbar=no,scrollbars=no,locationbar=no,menubar=no,width=650,height=250,top=100,left=200");
　　}
</script>
</head>

<body >
<form style="margin-top:0px;" id="form1" name="form" method="post" action="">
<div id="fld_top">
   <p id="para">	
	<span>
    <?php echo _gettext("currentadmin"); ?>: <?php echo $auther; ?></span>
	</p>
<div style="position:absolute; right:320px; top:-5px ">
<table align="right"  width="320px" height="25px" cellpadding="0" cellspacing="0">
<tr>
<td >
<a id="logout" onfocus="this.blur()" href="#" onclick="openwin()">
<img src="images/upPwd.gif" style="vertical-align:middle"/> <?=_gettext("modifypwd")?>
</a>
</td>
<td><img src="images/line_top.gif" /></td>

<td style="text-align:center;"><a id="refresh" onfocus="this.blur()" target="mainFrame"  href="/view/toolDownload/list.php" >
<img src="images/down.gif" style="vertical-align:middle" /> <?=_gettext("m_tool_download")?>
</a></td> 
<td><img src="images/line_top.gif" /></td>
<td style="text-align:center;">
<a href="#" onfocus="this.blur()"  onclick="configsave()">
<img src="images/save.gif" style="vertical-align:middle"/> <?=_gettext("save")?></a></td> 
<td><img src="images/line_top.gif" /></td>
<td style="text-align:center;">
<a id="logout" onfocus="this.blur()"  href="loginout.php">
<img src="images/logout.gif" style="vertical-align:middle" /> 
<?=_gettext("logout")?></a></td>  
</tr>
</table>
</div>
</div>
<input type="hidden" name="system_timer_current_time" value="<?php echo date('Y-m-d H:i:s'); ?>">
</form>
</body>
</html>
