<?php
include "connect.php";
if($_SESSION['ExamAdmin']=="") header("location:login.php");
include "header.php";
if($_REQUEST['subval'])
{
        if($_REQUEST['id'])
        { 
            $update="update exampaper set Name='".mysql_real_escape_string($_REQUEST['setname'])."' where ID='".$_REQUEST['id']."'";
            $message="Updated Successfully";
            
              mysql_query($update) or die("Cannot Execute Query".mysql_error().$update);
              
              $delete="delete from exam_question where EID='".$_REQUEST['id']."'";
              mysql_query($delete) or die("Cannot Execute Query".mysql_error());
              
              for($j=1;$j<$_REQUEST['total'];$j=$j+1)
              {
                if($_REQUEST['ch_'.$j])
                {
                    $insert="insert into exam_question (EID,QID) values ('".$_REQUEST['id']."','".$_REQUEST['ch_'.$j]."')";
                    mysql_query($insert) or die("Cannot Execute Query".mysql_error());
                }
              }
        }
        else
        {
            $update="insert into exampaper(Name) values ('".mysql_real_escape_string($_REQUEST['setname'])."')";
            $message="Inserted Successfully";
            mysql_query($update) or die("Cannot Execute Query".mysql_error());
            $eid=mysql_insert_id();
            for($j=1, $i=1;$j<$_REQUEST['total'];$j=$j+1, $i++)
              {
				if($_REQUEST['c_'.$i]){
					if(is_numeric($_REQUEST['c_'.$i])){
						$insert="insert into exam_question (EID,QID,Points) values ('".$eid."','".$_REQUEST['ch_'.$j]."','".$_REQUEST['c_'.$i]."')";
						mysql_query($insert) or die("Cannot Execute Query".mysql_error());
					}
                    else{
						$insert="insert into exam_question (EID,QID,Points) values ('".$eid."','".$_REQUEST['ch_'.$j]."','0')";
						mysql_query($insert) or die("Cannot Execute Query".mysql_error());
					}
				}
                else if($_REQUEST['ch_'.$j])
                {
                    $insert="insert into exam_question (EID,QID) values ('".$eid."','".$_REQUEST['ch_'.$j]."')";
                    mysql_query($insert) or die("Cannot Execute Query".mysql_error());
                }
             }
        }
        
        Header('Location: questionlist.php?msg='.$message.'');
	?>
	<script>
	document.location="setlist.php?msg=<?php echo $message;?>";
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
          if($_REQUEST['id']) echo "Edit Question Set"; else echo "Add Question Set";?></li>
    </ul>
    
    <div class="clear"></div>
    <div id="form" style="width:700px;">
    <?php
          if($_REQUEST['id'])
          {
          $select="select * from exampaper where ID='".$_REQUEST['id']."'";
          $select_rs=mysql_query($select) or die("Cannot Execute Query".mysql_error());
          $select_row=mysql_fetch_array($select_rs);
   
          }
		  ?>
          <style>
    .container12 { border:2px solid #ccc; width:500px; height: 500px; min-height: 300px; overflow-y: scroll; }
    .form-control
    {
        width:255px;
        border-radius: 5px;
        border: 1px solid black;
        height:22px;
        padding:8px;
    }
    </style>
		<form id="events" name="events"  method="post" action='add_edit_set.php?id=<?php echo $_REQUEST['id'];?>' enctype="multipart/form-data">
	      <table border="0" cellpadding="0" cellspacing="0">
	      <tr>
		  	<td colspan="3"><?php if($Msg)echo "<font color='red' size='2px'>". $Msg."</font>"; ?></td>
		  </tr>
			<tr>
				<td class="coRight" style="vertical-align: top;">Question Set Name:</td>
				<td colspan="2" >
                <input type="text" name="setname" id="setname" class="form-control" value="<?php if($_REQUEST['Name']) echo $_REQUEST['Name']; else echo $select_row['Name'];?>">
                                           
                    <br /><br />
                </td>
			
            
            
			</tr>
            	<tr>
				<td class="coRight" style="vertical-align: top;">Select Questions</td>
				<td colspan="2" >
                <div class="container12">
                <table>
                <?php
				$i=1;
                $j=1;
                $question="select * from questions";
                $question_rs=mysql_query($question) or die("Cannot Execute Query".mysql_error());
                while($question_row=mysql_fetch_array($question_rs))
                {
                  $examq="select * from exam_question where QID='".$question_row['QID']."' and EID='".$_REQUEST['id']."'";  
                  $examq_rs=mysql_query($examq) or die("Cannot Execute Query".mysql_error());
				  ?>
                
                    
                    <tr><td>
                  <input type="checkbox" <?php if(mysql_num_rows($examq_rs)>0)echo "checked";?> name="ch_<?php echo $j;?>" id="ch_<?php echo $j;?>" value="<?php echo $question_row['QID']?>"/><?php echo  strip_tags($question_row['Question'])?>
				  <br><br>Difficulty: <?php echo $question_row['Difficulty'];?><br>Number of points: <?php echo $question_row['Points'];?><br><br>Change this question's point value for this exam (optional):<br><br>
				  <input type="text" name="c_<?php echo $i;?>"/>
				  
				  <!--<a href="add_edit_question.php?id=<#?php echo $question_row['QID']?>" title="Edit">
                        
					<img src="images/edit2.gif" border="0"/></a>-->
              </td></tr>
              
              <?php
				$i=$i+1;
                $j=$j+1;
                }
                ?>
                </table> 
                <input type="hidden" name="total" id="total" value="<?php echo $j?>">
                </div>
                <br /><br />
                </td>
			
			</tr>
            
            
		<tr>
		<td>&nbsp;</td>
		<td valign="top">
			<input type="button" value="Submit" id="big_button" name="subfrm" onclick="check()" class="form-submit" />
            <input type="button" id="big_button" value="Back" class="form-reset" onclick="document.location='setlist.php'"  />
			
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
   var m=0
   var total=document.getElementById("total").value;
   for(var k=1;k<total;k=k+1)
   {
    if(document.getElementById("ch_"+k).checked==true)
    {
        m=1;
        break;
        
    }
   }
	if(trim(document.getElementById("setname").value)=="")
	{
		alert("Please enter the exam name.");
		document.getElementById("setname").focus();
		return false;
	}
    else if(m==0)
	{
		alert("Please select at least one question");
		return false;
	}
	else
	{
		document.getElementById("subval").value=1;
		document.events.submit();
	}
}
</script>
