<?php
require_once("model/lan.php");
include_once("authenticate.php");
$auth = new authentication();
$auther = $auth->getRegUser();

function get_func_recordsets()
{
	$filename = '/var/www/html/js/func.conf';
	if (!$handle = fopen($filename, 'r'))
	{
		return false;
	}
	
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$funcdata = json_decode($contents, true);
	
	//print_r($funcdata);
	return $funcdata;		
}		

$fuctions_array = get_func_recordsets();
$show_array = array();
if (isset($_SESSION["all"]))
{
	$show_array = $fuctions_array;
}
else 
{
	$show_idx=0;
	$totalnum = count($fuctions_array);

	$hide = 0;
	for($idx = 0 ; $idx < $totalnum ; $idx++)
	{

		if ( $fuctions_array[$idx]['level']=='2' )
		{
			if (isset($_SESSION[$fuctions_array[$idx]['name']]))	
			{
				$hide = 0;
			}
			else
			{
				$hide = 0;	
			}
		}
		
		if ($fuctions_array[$idx]['level']=='1')
		{
			$show_array[$show_idx] = $fuctions_array[$idx];
			$show_idx++;
			continue;
		}
		else if ($fuctions_array[$idx]['level']=='2')
		{
			if ($hide == 0)
			{
				$show_array[$show_idx] = $fuctions_array[$idx];
				$show_idx++;
			}	
			else
			{
				
			}	
			continue;		
		}										
		else
		{
			if ($hide == 0)
			{
				$show_array[$show_idx] = $fuctions_array[$idx];
				$show_idx++;
			}	
			else
			{
				
			}	
			continue;		
		}
	}			
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">



<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<LINK href="/css/xtree.css" type=text/css rel=STYLESHEET>
<link href="css/skin.css" rel="stylesheet" type="text/css" />
<TITLE>New Document</TITLE>
<style type="text/css">

#navBox2 {
	position: absolute;
	padding-bottom:0px;
	width:191px;
	margin-left:10px;
	height:98.5%;
	*height:99%;
	border: solid #00829e 1px;
	background-color:#a7dbeb;
	
}

#navBox2 a{
color:#333333;
margin-left:5px; 
font-size:12px; 
font-weight:normal;
}

#navBox2 a:hover
{
color: #CC0033;

font-weight:bold;

}
#navBox2 a:active
{
color: #CC0033;

}
#navBox2 a.active
{
color: #CC0033;

font-weight:bold;
}


#body{
	background:#51abca ;
}




.td_right1
{
display: inline-block;

background:url(images/b_first_right.gif);
width:189px;
padding:5px 0;
text-decoration:none;
color: #FF0000; 
font-size:13px; 
font-weight:bold;
}
#navBox2 a.td_right1
{
color:#0642B0;
font-size:13px;
font-weight:bold;
display: inline-block;
}

#navBox2 a.td_right1:hover
{
display: inline-block;
color: #AF2E1F;
font-size:14px;
font-weight:bold;
background:url(images/b_first_right1.gif) no-repeat;
width:189px;
padding:5px 0;
text-decoration:none;
}
.td_right
{
display: inline-block;
background:url(images/b_main_right.gif) no-repeat;
width:189px;
padding:5px 0;
text-decoration:none;
}
#navBox2 a.td_right
{
color:#0642B0;
font-size:13px;
font-weight:bold;
display: inline-block;
}

#navBox2 a.td_right:hover
{
display: inline-block;
color: #AF2E1F;
font-size:14px;
font-weight:bold;
background:url(images/b_main_right1.gif) no-repeat;
width:189px;
padding:5px 0;
text-decoration:none;
}
.td_right2
{
display: inline-block;
width:189px;
padding:5px 0;
text-decoration:none;
}
#navBox2 a.td_right2
{
display: inline-block;
color: #AF2E1F;
font-size:14px;
font-weight:bold;
background:url(images/b_main_right22.gif) no-repeat;
}

#navBox2 a.td_right2:hover
{
display: inline-block;
color: #AF2E1F;
font-size:14px;
font-weight:bold;
background:url(images/b_main_right22.gif) no-repeat;
width:189px;
padding:5px 0;
text-decoration:none;
}
.td_child_left1
{ 
text-align:right ;
width:26%;
height:30px;
line-height:30px;
vertical-align:middle;
}

.td_child_left2
{  
text-align:right ;
width:31%;
height:30px;
line-height:30px;
vertical-align:middle;
}



.div1,.div2,.div3,.div4,.div5,.div6
{

background:#e6f9ff;
border:#087c2e 1px solid;
width:187px;
width:189px\9;
margin-left:5px;
/*height:250px;*/
overflow:auto;
}

.table
{
padding:0px;
margin:0px;
width:100%;
background-color:#e6f9ff;

}
.aa
{}

</style>
</HEAD>

<script type="text/javascript" src="/js/prototype.js"></script>
<body id="body">

<div id="nav_container">
	<input type="hidden" id="reporterurl" value="">
	<div id="navBox2">
		
<?php 

	$m=1;
	$f=1;
	$last_m=$m;
	$totalnum = count($show_array);
	for($idx = 0 ; $idx < $totalnum ; $idx++)
	{
			if ($show_array[$idx]['hide']==1)
			{
				continue;	
			}
		
			if ($show_array[$idx]['level']=='1')
			{
				if (($idx+1 == $totalnum) &&(strcmp(trim($show_array[$idx]['link']),"null")!=0))
				{
?>						
						
			<table width="189px" cellpadding="0" cellspacing="0" style="margin-left:-5px;">
			
			<tr>
			<td colspan="2" style="text-align:left;"><a class="td_right1" onFocus="this.blur()" onClick="checkFirst()" id="m0" href="<?php echo $show_array[$idx]['link'];?>" target="mainFrame" >
			<img style="border:0; margin-left:10px;" src="<?php echo $show_array[$idx]['image'];?>"/><span style=" margin-left:7px;" ><?php echo _gettext($show_array[$idx]['name']);?></span></a></td>
		</tr>
							
							
						</table>						
<?php	
				}
				else if ($show_array[$idx+1]['level'] == '1')
				{
					
					if (strcmp(trim($show_array[$idx]['link']),"null")!=0)
					{
?>						
			<table width="189px" cellpadding="0" cellspacing="0" style="margin-left:-5px;">
										<tr>
			<td colspan="2" style="text-align:left;"><a class="td_right1" onClick="checkFirst()" onFocus="this.blur()" href="<?php echo $show_array[$idx]['link'];?>" target="mainFrame">
			<img style="border:0; margin-left:10px;"   src="<?php echo $show_array[$idx]['image'];?>"/><span style=" margin-left:7px;" ><?php echo _gettext($show_array[$idx]['name']);?></span></a></td>
		</tr>
						</table>						
<?php						
					}
				}
				else if ($show_array[$idx+1]['level'] == '2')
				{
?>
				<table width="189px" cellpadding="0" cellspacing="0" style="margin-left:-5px;" >		
						<tr>
		    <td colspan="2" style="text-align:left;"><a class="td_right" onFocus="this.blur()" href="#" onClick="clickA('m<?=$m?>','<?=$m?>')" id="m<?=$m?>" >
			<img style="border:0; margin-left:10px;"   src="<?php echo $show_array[$idx]['image'];?>"/><span style=" margin-left:7px;" ><?php echo _gettext($show_array[$idx]['name']);?></span></a></td>
		</tr>
						
						<tr id="m<?=$m?>d" style="display:none">
						 <td colspan="2">
						     <DIV class="div<?=$m?>" id="div<?=$m?>">
							 <table class="table" >
							<?php $m++; ?>
<?php 
				}
				else
				{
					
				}
				continue;
			}		
			else if ($show_array[$idx]['level']=='2')
			{
				if ($idx+1 == $totalnum)
				{
?>
			<tr>
				<td  class="td_child_left1" ><img src="images/aw.png"/></td>
				<td ><a onFocus="this.blur()" onClick="set_current('f<?=$f?>')" href="<?php echo $show_array[$idx]['link'];?>" id="f<?=$f?>" target="mainFrame" ><?php echo _gettext($show_array[$idx]['name']);?></a></td>
							<?php $f++ ?>
			</tr>
			</table>
			</DIV>
		 </td>
		</tr>
				</table>
<?php
				}
				else if ($show_array[$idx+1]['level'] == '1')
				{
?>
			<tr>
				<td  class="td_child_left1" ><img src="images/aw.png"/></td>
				<td ><a onFocus="this.blur()" onClick="set_current('f<?=$f?>')"  href="<?php echo $show_array[$idx]['link'];?>" id="f<?=$f?>" target="mainFrame" ><?php echo _gettext($show_array[$idx]['name']);?></a></td>
							<?php $f++ ?>
			</tr>
			</table>
  </DIV>
		 </td>
		</tr>
		</table>
<?php
				}
				else if ($show_array[$idx+1]['level'] == '2')
				{
?>
			<tr>
				<td  class="td_child_left1" ><img src="images/aw.png"/></td>
				<td ><a onFocus="this.blur()" onClick="set_current('f<?=$f?>')"  href="<?php echo $show_array[$idx]['link'];?>" id="f<?=$f?>" target="mainFrame" ><?php echo _gettext($show_array[$idx]['name']);?></a></td>
							<?php $f++ ?>
			</tr>
<?php
				}
				else /* '3' */
				{
?>
			<tr>
				<td  class="td_child_left1" ><img id="f<?=$f?>img" src="images/ar.png"/></td>
				<td id="f<?=$f?>w"><a onFocus="this.blur()" href="#" class="aa" onClick="clickA('f<?=$f?>',<?=$m-1?>);set_current('f<?=$f?>');" id="f<?=$f?>" ><?php echo _gettext($show_array[$idx]['name']);?></a></td>
			</tr>
			<tr id="f<?=$f?>d" style="display:none">
				<td colspan="2">  
					 <table cellpadding="0" cellspacing="0" width="100%">
							<?php $f++ ?>
<?php
							//echo "[\""._gettext($show_array[$idx]['name'])."\",null,null,\r\n";	
				}
				continue;							
			}		
			else
			{
				if ($idx+1 == $totalnum)
				{
?>
					 <tr>
						<td class="td_child_left2"><img src="images/aw.png"/></td>
						<td ><a onFocus="this.blur()" onClick="set_current('<?=$f?>')"  href="<?php echo $show_array[$idx]['link'];?>" id="<?=$f?>" target="mainFrame" ><?php echo _gettext($show_array[$idx]['name']);?></a></td>
					 </tr>
					 <?php $f++ ?>
					</table>
			    </td> 
  				</tr>
		      </table>					 
<?php
				}
				else if ($show_array[$idx+1]['level'] == '1')
				{
?>
					 <tr>
						<td class="td_child_left2"><img src="images/aw.png"/></td>
						<td ><a onFocus="this.blur()" onClick="set_current('<?=$f?>')"  href="<?php echo $show_array[$idx]['link'];?>" id="<?=$f?>" target="mainFrame" ><?php echo _gettext($show_array[$idx]['name']);?></a></td>
					 </tr>
					 <?php $f++ ?>
					</table>
			    </td> 
			    </tr>
		      </table>
					</DIV>
					</td>
					</tr>	
					</table>      					 
<?php
				}
				else if ($show_array[$idx+1]['level'] == '2')
				{
?>
					 <tr>
						<td class="td_child_left2"><img src="images/aw.png"/></td>
						<td ><a onFocus="this.blur()" onClick="set_current('<?=$f?>')"  href="<?php echo $show_array[$idx]['link'];?>" id="<?=$f?>" target="mainFrame" ><?php echo _gettext($show_array[$idx]['name']);?></a></td>
					 </tr>
					 <?php $f++ ?>
					</table>
			    </td> 
			    </tr>
<?php
				}
				else /* '3' */
				{
?>
					 <tr>
						<td class="td_child_left2"><img src="images/aw.png"/></td>
						<td ><a onFocus="this.blur()" onClick="set_current('<?=$f?>')"  href="<?php echo $show_array[$idx]['link'];?>" id="<?=$f?>" target="mainFrame" ><?php echo _gettext($show_array[$idx]['name']);?></a></td>
					 </tr>
					 <?php $f++ ?>
<?php
				}
				continue;				
			}		
	}
	
					
					
?>							
		<!--
		<table width="189px" cellpadding="0" cellspacing="0" style="margin-left:-5px;">
			
			<tr>
			<td colspan="2" style="text-align:left;"><a class="td_right1" onFocus="this.blur()" id="m20" href="#" onClick="window.open('/view/syslog/index.php')">
			<img style="border:0; margin-left:10px;" src="images/aa.gif"/><span style=" margin-left:7px;" >ddddddddd</span></a></td>
		</tr>
							
							
						</table>	
		
		

		<!--<script>
			/*var tree1 = new COOLjsTree("tree1", TREE_NODES, TREE_FORMAT);*/
			var tree1 = new COOLjsTreePRO("tree1", TREE_NODES, TREE_FORMAT);
			tree1.init();
		</script>
		<div class="clear"></div>
		-->
</div>
	
</div>

</body>

<script language="javascript">
var h= document.body.clientHeight-218;
for(var i=1;i<10;i++)
{
  if(document.getElementById('div'+i))
  {
     $('div'+i).style.height   = h+'px' ;
  }
}

//alert(document.body.clientHeight);
var menu_flag=1;
function clickA(obj,index)
{
 
 for(i=1;i<=<?=$m-1;?>;i++)
 {
    if(index!=i)
    {
    $('m'+i+'d').style.display="none";
    $('m'+i).className="td_right";
    }
	else
	{
   var targetid;
   var tdid;
   var targetimg;
   targetid=obj+"d";
   tdid=obj+"w";
   targetimg=obj+"img";
   var f="f";  

   if($(targetid).style.display=="none")
   { 
      if(obj.indexOf(f)>-1)
	  { 
        menu_flag=0;
        $(targetid).style.display=""; 
		$(targetimg).src="images/ad.png";
		
		$(obj).className="active";
		
	  }
	  else
	  {
	   $(obj).className="td_right2";
	    menu_flag=0;
       $(targetid).style.display=""; 
		
	  }
   }
   else
   {
   
      
	  for(j=1;j<<?php echo $f-1 ?>;j++)
      {
	   var id=j;
	 
	   if(id!=obj && $(id).className=="aa") 
	   {
		  $(id+'d').style.display="none";
		  $(id+"img").src="images/ar.png";
	   }
      }  
	  
      if(obj.indexOf(f)>-1)
	  {
		  menu_flag=1;
		  $(targetid).style.display="none"; 
		  $(targetimg).src="images/ar.png";
		  
		  $(obj).className="aa";

	  }  
	  else
	  {
	    $(obj).className="td_right";
		 menu_flag=1;
		 $(targetid).style.display="none"; 
		 
	  }
   }
	}
 }
  
}

var cur_id="";
function set_current(id)
{
 
    if(id.indexOf("f")>-1)
{
	
		for(j=1;j<<?php echo $f-1 ?>;j++)
		  {

		   var obj="f"+j;
		   
		   if (document.getElementById(obj)==null||document.getElementById(obj+"d")==null) 
		      continue;
			  
			  //alert(document.getElementById(obj));
		   if(id!=obj ) 
		   {   
			  $(obj+'d').style.display="none";
			  $(obj+"img").src="images/ar.png";
			  $(obj).className="aa";
		   }
		 }
	}
	cur_link=document.getElementById(cur_id)
   if(cur_link)
      cur_link.className="aa";
   cur_link=document.getElementById(id);
   if(cur_link)
      cur_link.className="active";
   cur_id=id;

}

function checkFirst()
{
   for(i=1;i<=<?=$m-1;?>;i++)
   {
      $('m'+i+'d').style.display="none";
      $('m'+i).className="td_right";
   }
}
</script>
</HTML>
