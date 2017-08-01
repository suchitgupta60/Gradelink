<?php
include "connect.php";
if($_SESSION['ExamAdmin']=="") header("location:login.php");
include "header.php";
if($_REQUEST['subval'])
{
        $time=time();
        if($_FILES['Pic']['name'])	
        {
            if(file_exists("../".$_REQUEST['oldpic']))
            {
                
                unlink("../".$_REQUEST['oldpic']);
            }
           $path="../img/news/".$time."_".$_FILES['Pic']['name'];
           	move_uploaded_file($_FILES['Pic']['tmp_name'],$path) or die("Cannot Upload Image".$_FILES['Pic']['tmp_name']);
            $dbPath=str_replace("../","",$path);
        }
        else
        {
            $dbPath=$_REQUEST['oldpic'];
        }
        $df=date("Y/m/d",strtotime($_REQUEST['startdate']));
        if($_REQUEST['id'])
        { 
            $update="update news set Title='".mysql_real_escape_string($_REQUEST['title'])."', Content='".mysql_real_escape_string($_REQUEST['Details'])."',Pic='".$dbPath."',Date='".$df."' where ID='".$_REQUEST['id']."'";
            $message="Updated Successfully";
            $title="Admin Updated a News - ".mysql_real_escape_string($_REQUEST['title']);
            $work="Updated";
        
        }
        else
        {
            $update="insert into news(Title,Content,Pic,Date) values ('".mysql_real_escape_string($_REQUEST['title'])."','".mysql_real_escape_string($_REQUEST['Details'])."','".$dbPath."','".$df."')";
            $message="Inserted Successfully";
            $title="Admin Added a News - ".mysql_real_escape_string($_REQUEST['title']);
            $work="Added";
        }
        
        mysql_query($update) or die("Cannot Execute Query".mysql_error().$update);
        if($_REQUEST['id'])
        {
            $title="<a target='_blank' href='news_single.php?id=".$_REQUEST['id']."'>".$title."</a>";
            $id=$_REQUEST['id'];
        }
        else
        {
             $id=mysql_insert_id();
            $title="<a target='_blank' href='news_single.php?id=".$id."'>".$title."</a>";
        }
        $recent="insert into recenthappenings (Creater,Date,ReferenceID,Tablename,Content,Title,work) values('0',now(),'".$id."','news','".mysql_real_escape_string($content)."','".mysql_real_escape_string($title)."','".$work."')";
        mysql_query($recent) or die("Cannot Execute Query".mysql_error().$recent);
	?>
	<script>
	document.location="news.php?msg=<?php echo $message;?>";
	</script>
	<?php
}
?>
<script src="ckeditor/ckeditor.js"></script>
<!-- start content-outer ........................................................................................................................START -->
<div class="leftColumn">
  	<div class="operation"></div>
  	<ul class="subMenu">
    	
  		<li><?php
          if($_REQUEST['id']) echo "Edit Question"; else echo "Add Question";?></li>
    </ul>
    
    <div class="clear"></div>
    <div id="form" style="width:700px;">
    <?php
          if($_REQUEST['id'])
          {
          $select="select * from questions where QID='".$_REQUEST['id']."'";
          $select_rs=mysql_query($select) or die("Cannot Execute Query".mysql_error());
          $select_row=mysql_fetch_array($select_rs);
          }
		  ?>
          
		<form id="events" name="events"  method="post" action='add_edit_question.php?id=<?php echo $_REQUEST['id'];?>' enctype="multipart/form-data">
	      <table border="0" cellpadding="0" cellspacing="0">
	      <tr>
		  	<td colspan="3"><?php if($Msg)echo "<font color='red' size='2px'>". $Msg."</font>"; ?></td>
		  </tr>
			<tr>
				<td class="coRight" style="vertical-align: top;">Question:</td>
				<td colspan="2" >
                <textarea aria-required="true" rows="15" cols="45" name="details" id="details" class="form-control requiredField mezage"><?php  if($_REQUEST['details']){ echo $_REQUEST['details'];} else { echo $user_row['Content'];}?></textarea>
                                           
   	                <script>
            CKEDITOR.replace( 'details' );
        </script>
                <br /><br />
                </td>
			
			</tr>
            
            
		<tr>
		<td>&nbsp;</td>
		<td valign="top">
			<input type="button" value="Submit" id="big_button" name="subfrm" onclick="check()" class="form-submit" />
            <input type="button" id="big_button" value="Back" class="form-reset" onclick="document.location='news.php'"  />
			
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

	if(trim(CKEDITOR.instances.details.getData())=="")
	{
		alert("Please enter the Title");
		document.getElementById("title").focus();
		return false;
	}
	else
	{
		document.getElementById("subval").value=1;
		document.events.submit();
	}
}
</script>
