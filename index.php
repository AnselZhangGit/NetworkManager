<?php
	require_once($_SERVER["DOCUMENT_ROOT"]."model/lan.php");
	$timeLong  = time();
	if ( $timeLong - $_SESSION["lastActiveTime"] >= 600 )
	{
        require_once("login.php");
        exit;
	} else
	{
        $_SESSION["lastActiveTime"] = $timeLong ;
	}		
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>
<?php $diyfilename = '/usr/mysys/comname.txt';
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
?></title>
</head>
<frameset rows="79,*,20" cols="*" frameborder="no" border="5" framespacing="0">
	<frame src="top.php" name="topFrame" frameborder="no" scrolling="No" id="topFrame" title="topFrame" />
	<frameset rows="*" cols="205,*" id="mainFrameSet" framespacing="0" border="0" bordercolor="#99CCCC">
		<frame src="left.php" name="leftFrame" frameborder="no" scrolling="no" id="leftFrame" title="leftFrame" noresize="noresize" />
		<frame src="homepage.php" name="mainFrame" frameborder="no" id="mainFrame" class='mainFrame' title="mainFrame" scrollingbar="no" />
	</frameset>
	<frame src="bottom.php" name="bottomFrame" frameborder="no" scrolling="No" id="bottomFrame" title="bottomFrame" />
	
</frameset>
<noframes>
</noframes>
</html>
