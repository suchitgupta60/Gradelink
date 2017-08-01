<?php
error_reporting(0);
include "connect.php";
if($_REQUEST['loginbut'])
{
	$message="";
	 $select="select * from users where Email='".mysql_real_escape_string($_REQUEST['email'])."' and password='".mysql_real_escape_string($_REQUEST['password'])."'";
	$select_rs=mysql_query($select) or die("Cannot Execute Query".mysql_error().$select);
	$select_row=mysql_fetch_array($select_rs);
	if(mysql_num_rows($select_rs)>0)
	{
		$_SESSION['ExamAdmin']=$select_row['ID'];
		$_SESSION['Group']=$select_row['groupid'];
		header("location:settings.php");
	}
	else
	{
		$message="Username and Password not match";
	}
}
include "header.php";
?>
<body id="login">
<div class="loginBox" id="form">
  <p align="center"> <font size="5px" >CS490 EXAM SYSTEM</font></p>
  <?php
  if($message) echo "<font color='red'>".$message."</font>";
  ?>
  <form id="login" name="login" action="" method="post" onSubmit="return check_login()">
  <table border="0" cellspacing="10" cellpadding="0">
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td>Email</td>
    <td><label>
      <input name="email" type="text" id="email" value="" />
    </label></td>
  </tr>
  <tr>
    <td>Password</td>
    <td><label>
      <input name="password" type="password" id="password" value="" />
    </label>      </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><label></label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="loginbut"  id="big_button" value="Login" /></td>
  </tr>
</table>
</form>
</div>
</body>
</html>
