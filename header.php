<?php error_reporting(0);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>NJIT - ONLINE EXAM MANAGEMENT SYSTEM</title>
    <script>
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML =
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<link href="css/globalReset.css" rel="stylesheet" type="text/css" />
<link href="css/browserStyle.css" rel="stylesheet" type="text/css" />
<script src="validation.js"></script>
</head>
<?php
if($_SESSION['ExamAdmin'])
{
  $admin="select * from users where ID='".$_SESSION['ExamAdmin']."'";
  $admin_rs=mysql_query($admin) or die("Cannot Execute Query".mysql_error());
  $admin_row=mysql_fetch_array($admin_rs);
    ?>
<body onload="startTime()">
<div class="logo"><font size="5px" >
    <div id="txt"> </div>
    <marquee behavior="slide" direction="right" scrolldelay="" scrollamount="20" ><strong><p style="font-size:150%">CS490 Exam System</p></strong></marquee></font></div> 
<div class="container">
    
 <div class="account">Hi, <a href="settings.php"><?php echo $admin_row['Name'];?></a> | <a href="logout.php">Logout</a><br /><br /></div>
  <div class="header">
   
    <ul class="menu" >
	
    <?php if($_SESSION['Group']=="2") 
	{
	   ?>
        <?php  if(strstr($_SERVER["SCRIPT_NAME"],"questionlist.php")){?>
     <!--   <div id = "stripe"> -->
        <li>Questions</li><?php } else {?><li><a href="questionlist.php">Questions </a></li><?php }?>
	    <?php  if(strstr($_SERVER["SCRIPT_NAME"],"setlist.php")){?><li>Exams</li><?php } else {?><li><a href="setlist.php">Exams  </a></li><?php }?>
	 <?php  if(strstr($_SERVER["SCRIPT_NAME"],"teacher_quiz.php")){?><li>Submitted Exams</li><?php } else {?><li><a href="teacher_quiz.php">Submitted Exams </a></li><?php }?>
	   
     <!--   </div>-->
	 <?php
      }
      else if($_SESSION['Group']=="1") 
	{
	   ?>
       <?php  if(strstr($_SERVER["SCRIPT_NAME"],"quizlist.php")){?><li>Exams</li><?php } else {?><li><a href="quizlist.php">Exams </a></li><?php }?>
	    <?php  if(strstr($_SERVER["SCRIPT_NAME"],"myquiz.php")){?><li>Graded Exams </li><?php } else {?><li><a href="myquiz.php">Graded Exams  </a></li><?php }?>
	
       <?php
	   }
       else
       {?>
        <?php  if(strstr($_SERVER["SCRIPT_NAME"],"users.php")){?><li>Users</li><?php } else {?><li><a href="users.php">Users  </a></li><?php }?>
       
       <?php
       }
	   ?>
	</ul>
   
  </div>	
<?PHP
}
?>
