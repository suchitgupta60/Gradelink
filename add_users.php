<?php
include "connect.php";
if($_SESSION['ExamAdmin']=="") header("location:login.php");
include "header.php";
if($_REQUEST['subval'])
{
	
	$error="";
    
    //slider 1 image
    $select="select * from users where Email='".$_REQUEST['email']."'";
    $select_rs=mysql_query($select) or die("Cannot Execute Query".mysql_error().$select);
    if(mysql_num_rows($select_rs)>0)
    {
        $msg="Sorry Email already exist";
    }
    else
    {
        $insert="insert into users set Password='".$_REQUEST['password']."',Name='".$_REQUEST['username']."',Email='".$_REQUEST['email']."',groupid='".$_REQUEST['group']."'";
	    mysql_query($insert) or die("Cannot Execute Query".mysql_error());
        //Send Email to the Admin:
			
        $msg="Inserted Successfully";
        ?>
        <script>
            document.location="users.php?msg=<?php echo $msg;?>";
        </script>
        <?php
    }
        
        
    
    ?>
	
	<?php
}
?>
<style>
.form-control
{
    width: 250px !important;
    padding:8px !important;
    border-radius: 3px !important;
    border:1px solid #ccc;
    height:22px;
}
.form-control1
{
    width: 250px !important;
    padding:8px !important;
    border-radius: 3px !important;
    border:1px solid #ccc;
   
}
</style>
<!-- start content-outer ........................................................................................................................START -->
<div class="leftColumn">
  	<div class="operation"></div>
  	<ul class="subMenu">
    	
  		<li>Add  Users</li>
    </ul>
    
    <div class="clear"></div>
    <div id="form" style="width:700px;">
    
         
		<form id="events" name="events"  method="post" action='add_users.php' enctype="multipart/form-data">
	      <table border="0" cellpadding="0" cellspacing="0">
	      <tr>
		  	<td colspan="3"><?php if($msg)echo "<font color='red' size='2px'>". $msg."</font>"; ?></td>
		  </tr>
		<tr>
			<td class="coRight">Name:</td>
			<td colspan="2"><input type="text" class="form-control" id="username" name="username" value="<?php if($_REQUEST['username']=="")echo $select_row['Name']; else echo $_REQUEST['username']; ?>"></td>
			</td>
			
		</tr>
        <tr>
			<td class="coRight">Group:</td>
			<td colspan="2">
            <select class="form-control1" id="group" name="group">
                <?php
                    $group="select * from groups";
                    $group_rs=mysql_query($group) or die("Cannot Execute Query".mysql_error());
                    while($group_row=mysql_fetch_array($group_rs))
                    {?>
                       <option value="<?php echo $group_row['ID']?>"><?php echo $group_row['Name']?></option> 
                    <?php
                    }
                    ?>
            </select>
            
            </td>
			
		</tr>
         <tr>
			<td class="coRight">Email:</td>
			<td colspan="2"><input type="text" class="form-control"  id="email" name="email" value="<?php if($_REQUEST['email']=="")echo $select_row['Email']; else echo $_REQUEST['email']; ?>"></td>
		
		</tr>
        <tr>
			<td class="coRight">Password:</td>
			<td colspan="2"><input type="password" class="form-control"  id="password" name="password" value="<?php if($_REQUEST['password']=="")echo $select_row['Password']; else echo $_REQUEST['password']; ?>"></td>
			
		</tr>
        
        <tr>
			<td class="coRight">Confirm Password:</td>
			<td><input type="password" class="form-control"  id="cpassword" name="cpassword" value=""></td>
			<td></td>
		</tr>
       
		<tr>
		<td>&nbsp;</td>
		<td valign="top">
			<input type="button" value="Submit" id="big_button" name="subfrm" onclick="check()" class="form-submit" />
            
		</td>
		<td>
        <input type="hidden" name="imageIndex" id="imageIndex" value="<?php echo $j-1?>">
		<input type="hidden" name="subval" id="subval" value="">
		</td>
	</tr>
		  </table>
			</form>
			 </div>
  </div>
  
  </div>
<?php
include "footer.php";
?>
<script>
var j=0;
function check()
{
   if(trim(document.getElementById("username").value)=="")
	{
		alert("Please enter the Name");
		document.getElementById("username").focus();
		return false;
	}
   else if(trim(document.getElementById("password").value)=="")
	{
		alert("Please enter the Password");
		document.getElementById("password").focus();
		return false;
	}
    else if(trim(document.getElementById("cpassword").value)=="")
	{
		alert("Please enter the Confirm Password");
		document.getElementById("cpassword").focus();
		return false;
	}
    else if(document.getElementById("cpassword").value!=document.getElementById("password").value)
	{
		alert("Password and Confirm Password must be same");
		document.getElementById("password").focus();
		return false;
	}
    else if(trim(document.getElementById("email").value)=="")
	{
		alert("Please enter the Email");
		document.getElementById("email").focus();
		return false;
	}
    else if(echeck(document.getElementById("email").value)==false)
    {
        alert("Please mention the valid Email");
        document.getElementById("email").focus();
    }
	else
	{
		document.getElementById("subval").value=1;
		document.events.submit();
	}
}
function echeck(str) {
		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   //alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   //alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		   // alert("Invalid E-mail ID")
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    //alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    //alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    //alert("Invalid E-mail ID")
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    //alert("Invalid E-mail ID")
		    return false
		 }

 		 return true					
	}

</script>

