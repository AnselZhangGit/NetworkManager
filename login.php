<?php 
require_once("model/lan.php");
require_once("model/common.inc.php");
$currentLan = trim($_SESSION['lan']);
$lans = getLinceseLan();

function getLicenseInfo()
{
	$record = array();
	$filename = '/usr/.lic/.ace_lic_info';
	$ret = -1;

	if(function_exists('ace_get_lisence'))
	{
		$ret = ace_get_lisence();
	}

	if(file_exists($filename))
	{
		$lines = file($filename);
		if(!$lines)
		{
			return $record;
		}
	
		if($lines[1])
		{
			$splits = explode(':',$lines[1]);
			$licenseType = $record['type'] =trim($splits[1]);
			$record['licenseType'] = _gettext(trim($splits[1]));
		}
		
		if($lines[3])
		{				
			$splits = explode(':',$lines[3]);
			$record['licenseIssuedDate'] = trim($splits[1]);
		}
	
		if($lines[4])
		{
			if($licenseType == 'Demo')
			{
				$splits = explode(':',$lines[4]);
				$record['demoExpiredDate'] = trim($splits[1]);
			}
			else 
			{
				$record['demoExpiredDate'] = '';
			}
		}
		if($lines[5])
		{
			$splits = explode(':',$lines[5]);
			$record['fwUpdateExpiredDate'] = trim($splits[1]);
		}
		if($lines[6])
		{
			$splits = explode(':',$lines[6]);
			$record['aisUpdateExpiredDate'] = trim($splits[1]);
		}
		if($lines[7])
		{
			$splits = explode(':',$lines[7]);
			$record['UrlDbUpdateExpiredDate'] = trim($splits[1]);
		}	
	}
	return $record;
}
function getLicenseNote()
{
	$licenseNote = '';
	$record = getLicenseInfo();
	/*if($record['type'] != 'Demo')
	{
		return $licenseNote;
	}*/
	if(function_exists('lic_reset_time') && function_exists('lic_firmware_reset_time') && function_exists('lic_ais_reset_time') && function_exists('lic_url_reset_time'))
	{
		$lic_reset_time_notes = array('1'=>_gettext('licRet1'),'2'=>_gettext('licRet2'));
		$lic_firmware_reset_time_notes = array('1'=>_gettext('licFwRet1'),'2'=>_gettext('licFwRet2'));
		$lic_ais_reset_time_notes = array('1'=>_gettext('licAisRet1'),'2'=>_gettext('licAisRet2'));
		$lic_url_reset_time_notes = array('1'=>_gettext('licUrlRet1'),'2'=>_gettext('licUrlRet2'));
		$licRe = lic_reset_time();
		$fwRe = lic_firmware_reset_time();
		$aisRe = lic_ais_reset_time();
		$urlRe = lic_url_reset_time();
		
		if( $record['type'] == 'Demo')
		{
			if($licRe == '1')
				$licenseNote = $lic_reset_time_notes['1'].$record['demoExpiredDate']._gettext('licenseExpireNote4');
			if($licRe == '2')
			{
				$licenseNote = $lic_reset_time_notes['2'];				
			}
			return $licenseNote;
		}
		if( $record['type'] == 'Unauthorized')
		{
			$licenseNote = _gettext('licenseUnauthorizedNote');
			return $licenseNote;
		}
		
		
		if($fwRe =='1')
			$licenseNote = $licenseNote.'<br>'.$lic_firmware_reset_time_notes['1'].$record['fwUpdateExpiredDate']._gettext('licenseExpireNote4');
		if($fwRe == '2')
			$licenseNote = $licenseNote.'<br>'.$lic_firmware_reset_time_notes['2'];
			
		if($aisRe =='1')
			$licenseNote = $licenseNote.'<br>'.$lic_ais_reset_time_notes['1'].$record['aisUpdateExpiredDate']._gettext('licenseExpireNote4');
		if($aisRe =='2')
			$licenseNote = $licenseNote.'<br>'.$lic_ais_reset_time_notes['2'];
	
		if($urlRe =='1')
			$licenseNote = $licenseNote.'<br>'.$lic_url_reset_time_notes['1'].$record['UrlDbUpdateExpiredDate']._gettext('licenseExpireNote4');
		if($urlRe =='2')
			$licenseNote = $licenseNote.'<br>'.$lic_url_reset_time_notes['2'];
		
	}
	return $licenseNote;
}

$licenseNote = getLicenseNote();
//$licenseNote = _gettext('licenseExpireNote1').'3'._gettext('licenseExpireNote2').'5'._gettext('licenseExpireNote3');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php 

$diyfilename = '/usr/mysys/comname.txt';
if ( file_exists( $diyfilename ) )
{
	$string = file( $diyfilename );
}

if ( isset( $string ) )
{
	echo $string[0];
}
else
{
	echo "";
}
?> Technology, Inc.</title>

<style type="text/css">
body {
	margin:0;
	overflow:hidden;
	background: #e6f7ff url(/images/l_bg.gif) repeat-x left top;
}

.form1 {
position:absolute;
text-align:center;
width:657px;
height:292px;
top:50%;
left:50%;
margin:-146px 0 0 -328px;
background:url(/images/login_bg.gif) no-repeat;	
}

#lang{
width:153px; 
height:22px; 
border:#025398 1px solid;
font-size:13px;
vertical-align:middle;
line-height:22px;
}

.text{
width:150px; 
height:20px; 
border:#025398 1px solid;
font-size:13px;
vertical-align:middle;
line-height:20px;
}
td
{
color:#FFFFFF;
font-size:14px;
}
.tip
{
	color:#fff;
	text-align:center;
	margin-top:20px;
	font-size:14px;
	
}

.button
{
background: url("images/login_button.gif") no-repeat scroll 0 0 #507CB8;
border-width: 0;
font-weight: bold;
height: 72px;
width: 86px;
}

img {
azimuth: expression(
this.pngSet?this.pngSet=true:(this.nodeName == "IMG" && this.src.toLowerCase().indexOf('.png')>-1?(this.runtimeStyle.backgroundImage = "none",
this.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + this.src + "', sizingMethod='image')",
this.src = "transparent.gif"):(this.origBg = this.origBg? this.origBg :this.currentStyle.backgroundImage.toString().replace('url("','').replace('")',''),
this.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + this.origBg + "', sizingMethod='crop')",
this.runtimeStyle.backgroundImage = "none")),this.pngSet=true);
}
</style>
<script type="text/javascript">
	function showVersion()
	{
		window.open('version.php','version','height=300,width=400,top=200,left=300,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,status=no');
	}
	function setLanguage()
	{		
		window.location.href = 'language_set.php?lan='+document.getElementById('lang').value;
	}
	
	function changeImage()
	{
	   if(document.getElementById('lang').value=="zh_CN")
	   {
	      document.getElementById('tiltle1').style.display="";
		  document.getElementById('tiltle2').style.display="none";
		  document.getElementById('tiltle3').style.display="none";
	   }
	   else if(document.getElementById('lang').value=="zh-TW")
	   {
		  document.getElementById('tiltle1').style.display="none";
		  document.getElementById('tiltle2').style.display="";
		  document.getElementById('tiltle3').style.display="none";
	   }
	   else
	   {
		  document.getElementById('tiltle1').style.display="none";
		  document.getElementById('tiltle2').style.display="none";
		  document.getElementById('tiltle3').style.display="";
	   }
	   
	}
	
	function checkEvnet()
	{		
	   	if(document.getElementById('checkbox_cert').checked)
		{
			window.open("login_ctrl.php", "hiddenFrame","");	
			document.getElementById('password').value = "";
			document.getElementById('password').disabled=true;
			document.getElementById('pwdHide').disabled=false;			
		}
		else
		{
			document.getElementById('password').disabled=false;
			document.getElementById('pwdHide').value = "";
			document.getElementById('pwdHide').disabled=true;
		}
	}
	
</script>
<body onload="document.getElementById('user_name').focus();changeImage();">
<!--form id="form1" style="margin-top:0px;" name="form1" method="post"  autocomplete="off" action="login_commit.php"-->
<div  class="tip">
<?php if($licenseNote) echo $licenseNote;?>
</div>
<form id="form1" name="form1" method="post"  action="login_commit.php">
<div class="form1">
<table style="margin-top:40px; margin-left:60px;" cellpadding="0" cellspacing="0" width="540" height="185">
<tr height="50">
 <td colspan="3" align="left" >
 <img id="tiltle1" src="/images/title.png" />
 <img id="tiltle2" style="display:none" src="/images/title_t.png" />
 <img id="tiltle3" style="display:none" src="/images/title_e.png" />
 </td>
</tr>
<tr height="135">
 <td align="right"><img  src="/images/l_admin.png" /></td>
 <td align="center">
  <table>
     <tr>
        <td width="80" align="right"><?=_gettext("language");?>&nbsp;</td>
        <td align="center"><select name="lang" id="lang" onchange="setLanguage()">
                    <?php
                        foreach ($lans as $key => $record)
                        {
                            $select = ($currentLan==$key)?'selected':'';
                    ?>
                        <option value="<?=$record['value'];?>"  <?=$select?> ><?=$record['text']?></option>
                    <?php
                        }
                    ?>
                       
                  </select></td>
        </tr>
        <tr>
        <td align="right"><?=_gettext("username");?>&nbsp;</td>
        <td align="center"><input type="text" class="text"  name="name" id="user_name" /></td>
        </tr>
        <tr>
        <td align="right"><?php echo _gettext("pwd"); ?>&nbsp;</td>
        <td align="center"><input type="password" class="text"  id="password" name="password" />
        <input name="pwdHide" id="pwdHide" type="hidden" value="" /></td>
        <?php gen_input();?>
        </tr>
        <tr>
        <td align="right"><?php echo _gettext("cert_auth"); ?></td>
        <td align="left"><input type="checkbox" class="chks_name" name="checkbox_cert" id="checkbox_cert" value="cert" onclick="checkEvnet();"/></td>
        </tr>
  </table>
 </td>
 <td>
    <input class="button" id="button"  type="submit" value=""  />
 </td>
</tr>
</table>

</div>

<iframe id="hiddenFrame"  name="hiddenFrame" style="display:none"></iframe>
</form>

</body>
</html>
