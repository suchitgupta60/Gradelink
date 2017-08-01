<?php
include "connect.php";
if($_SESSION['ExamAdmin']=="") header("location:index.php");
$info="select * from quiz  where EID='".$_REQUEST['id']."' and UID='".$_REQUEST['uid']."' group by UID order by ID";
$info_rs=mysql_query($info) or die("Cannot Execute Query".mysql_error());
$info_row=mysql_fetch_array($info_rs);

//result table
$result="select * from result where student_id='".$_REQUEST['uid']."' and Exam_ID='".$_REQUEST['id']."'";
$result_rs=mysql_query($result) or die("Cannot Execute Query".mysql_error());
$result_row=mysql_fetch_array($result_rs);

if($_REQUEST['sub'])
{
    $points=0;
    // $_REQUEST['totalrecord'];
        for($m=1;$m<$_REQUEST['totalrecord'];$m=$m+1)
        {
            if($_REQUEST['status_'.$m])
            {
                 $update="update  quiz set Status='".$_REQUEST['status_'.$m]."' where ID='".$_REQUEST['recid_'.$m]."'";
                mysql_query($update) or die("Cannot Execute Query".mysql_error());
            }
        }
    if(mysql_num_rows($result_rs)>0)
    {
      //$update="update result set Points='".$points."', Grade='".$_REQUEST['grade']."',Feedback='".mysql_real_escape_string($_REQUEST['feedback'])."' where student_id='".$_REQUEST['uid']."' and Exam_ID='".$_REQUEST['id']."'";
      //mysql_query($update) or die("Cannot Execute Query".mysql_error());
	  $update2="update quiz set Released='0' where EID='".$_REQUEST['id']."'";
	  mysql_query($update2) or die("Cannot Execute Query".mysql_error());
    }
    else
    {
        
       $insert="insert into result (Student_ID,Teacher_ID,Exam_ID,Feedback,Grade,Points) values('".$_REQUEST['uid']."','".$_SESSION['ExamAdmin']."','".$_REQUEST['id']."','".mysql_real_escape_string($_REQUEST['feedback'])."','".$_REQUEST['grade']."','".$points."')";
       mysql_query($insert) or die("Cannot Execute Query".mysql_error());
	  $update2="update quiz set Released='0' where EID='".$_REQUEST['id']."'";
	  mysql_query($update2) or die("Cannot Execute Query".mysql_error());
    }
    header("location:teacher_quiz.php");
    
}
if($_REQUEST['newPoints']){
	$ins="update result set Points='".$_REQUEST['newPoints']."' where Exam_ID='".$_REQUEST['id']."'";
	mysql_query($ins) or die("Cannot Execute Query".mysql_error());
}
if($_REQUEST['newScore']){
	$ins="update result set Score='".$_REQUEST['newScore']."' where Exam_ID='".$_REQUEST['id']."'";
	mysql_query($ins) or die("Cannot Execute Query".mysql_error());
}

//$ins="insert into result(Points,Score) values('".$totalPoints."','".$totalScore."') where Exam_ID='".base64_decode($_REQUEST['id'])."'";
//mysql_query($ins);

$select="select * from quiz where EID='".$_REQUEST['id']."' and UID='".$_REQUEST['uid']."' ";
include "header.php";
?>

<div class="leftColumn">
   <br /> <br />
  	<div class="operation"></div>
  	<ul class="subMenu">
	  <li>Exam Details</li>
    </ul>
    
    <div class="clear"></div>
				
				
				
				<table border="0" cellpadding="0" cellspacing="0">
                <tr><td colspan="5"><a href="teacher_quiz.php"><< Back to submitted exams</a></td></tr>
				<?php
				/****************** PAGE COUNTER VARIABLES *******************/
			
			//Search Start
			$rs = mysql_query($select) or die("Cannot Execute Query : ".$select."<P>".mysql_error());
?>
<tr>
<td></td>
<td colspan="2">
<?php
                    $uid="select * from users where ID='".$info_row['UID']."'";
                    $uid_rs=mysql_query($uid) or die("Cannot Execute Query".mysql_error());
                    $u_row=mysql_fetch_array($uid_rs);
                    ?>
<?php
$exam="select * from exampaper where ID='".$info_row['EID']."'";
$exam_rs=mysql_query($exam) or die("Cannot Execute Query".mysql_error());
$exam_row=mysql_fetch_array($exam_rs);
?>

<br /><br />
<font size="5px"><b>Student Name: <?php echo $u_row['Name']?></b>&nbsp;&nbsp;&nbsp;
</td><td colspan="2"><br /><br />
<font size="5px"><b>Exam Name: <?php echo $exam_row['Name']?></b></font>

</center>

<br /><br />
 <form id="dob" name="dob" method="post" action="" onsubmit="return check()">
	</td>
	</tr>
 <tr>
    <td>Grade:</td>
    <td colspan="2">
        <select id="grade" name="grade" style="width: 355px;padding:10px">
            <option value="">Please Select</option>
            <option value="A" <?php if($result_row['Grade']=="A") echo "selected";?>>A</option>
            <option value="B" <?php if($result_row['Grade']=="B") echo "selected";?>>B</option>
            <option value="C" <?php if($result_row['Grade']=="C") echo "selected";?>>C</option>
            <option value="D" <?php if($result_row['Grade']=="D") echo "selected";?>>D</option>
            <option value="F" <?php if($result_row['Grade']=="F") echo "selected";?>>F</option>
        </select>
    </td>
 <?php
 
 $totalPoints="select Points from result where Exam_ID='".$_REQUEST['id']."' and Student_ID='".$_REQUEST['uid']."'";
 $totalPoints_rs=mysql_query($totalPoints) or die("Cannot Execute Query".mysql_error());
 $totalPoints_row=mysql_fetch_array($totalPoints_rs);
 $pointTotal=$totalPoints_row['Points'];
 if($pointTotal==0){ 
	 $totalPoints="select sum(Points) as total from quiz where EID='".$_REQUEST['id']."' and UID='".$_REQUEST['uid']."'";
	 $totalPoints_rs=mysql_query($totalPoints) or die("Cannot Execute Query".mysql_error().$totalPoints);
	 $totalPoints_row=mysql_fetch_array($totalPoints_rs);
	 $pointTotal=$totalPoints_row['total'];
 }
 $pointsObtained="select Score from result where Exam_ID='".$_REQUEST['id']."' and Student_ID='".$_REQUEST['uid']."'";
 $pointsObtained_rs=mysql_query($pointsObtained) or die("Cannot Execute Query".mysql_error().$pointsObtained);
 $pointsObtained_row=mysql_fetch_array($pointsObtained_rs);
 $scoreTotal=$pointsObtained_row['Score'];
 if($scoreTotal==0){ 
	 $pointsObtained="select sum(Score) as total from quiz where EID='".$_REQUEST['id']."' and UID='".$_REQUEST['uid']."'";
	 $pointsObtained_rs=mysql_query($pointsObtained) or die("Cannot Execute Query".mysql_error().$pointsObtained);
	 $pointsObtained_row=mysql_fetch_array($pointsObtained_rs);
	 $scoreTotal=$pointsObtained_row['total'];
 }
 ?>
    <td colspan="2"><font size="5px"><b>Total: <?php echo $pointTotal?></b></font>
	<br><br>New total: <input type="text" name="<?php echo "newPoints";?>"/>
	</td>
 </tr>
 <tr>
    <td style="vertical-align: top;">Feedback:</td>
    <td colspan="2">
        <textarea rows="4" cols="50" id="feedback" name="feedback"><?php echo $result_row['Feedback']?></textarea><br /><br />
    <input type="submit" id="big_button" name="sub" value="Submit" class="form-reset" /></td>
    <td colspan="2" style="vertical-align: top;"><font size="5px"><b>Score: <?php echo $scoreTotal;?></b></font>
	<br><br><pre>New score: <input type="text" name="<?php echo "newScore";?>"/></pre><br><br>Note: Enter 00 for new score or new point total to reset to original results.</td>
 </tr>
 
				
			<?php
            if($_REQUEST['msg'])
            {
                echo "<tr><td colspan='3' style='color:red;'>".$_REQUEST['msg']."</td></tr>";
            }
            ?>	
				<tr>
				
					<th scope="col">No</a></th>
					<th scope="col">Question</th>
                    <th scope="col">Student's Answer</th>
                    <th scope="col">Correct Answer</th>
                    <th scope="col">Comments</th>
				</tr>
<?php
$j=1;
			while($row=mysql_fetch_array($rs))
				{
				?>
					<tr>
					<td><?php echo $j;?></td>
					<td>
                    <div style="width: 250px;border:1px solid black;height:200px;padding:8px;overflow:auto;">
                    <?php echo $row['Question']?>
                    </div>
                    </td>
                    <td>
                    <div style="width: 300px;border:1px solid black;height:200px;padding:8px;overflow:auto;">
                    <pre><?php echo $row['User_Answer']?></pre>
                    </div></td>
					<td>
                    <div style="width: 300px;border:1px solid black;height:200px;padding:8px;overflow:auto;">
                    <pre><?php echo $row['Right_Answer']?></pre>
                    </div></td>
					<td>
                    <div style="width: 400px;border:1px solid black;height:200px;padding:8px;overflow:auto;">
                    <pre><?php echo $row['Comments']?></pre>
                    </div></td>
                     
				</tr>
				<?php
                $j=$j+1;
				}
				
				?>
                	<input type="hidden" name="totalrecord" id="totalrecord" value="<?php echo $j?>" />
				<input type="hidden" name="delid" id="delid" value="" />
				</table>
				<!--  end product-table................................... --> 
				</form>
				</div>
	<div class="rightColumn" >
  <div id="action">
   
    <p class="helpText">&nbsp;</p>
  </div>
  
  </div>
</form>
<?php
include "footer.php";
?>
<script>
function check()
{
    var nm=0;
    var count=0;
    var total=document.getElementById("totalrecord").value;
    
    for(var m=1;m<total;m=m+1)
    {
        //alert(m);
        if(document.getElementById("status_"+m).value=="")
        {
            nm=1;
            count=m;
            break;
        }
        else
        {
            nm=0;
        }
    }
    
	if(document.getElementById("grade").value=="")
    {
        alert("Please select the grade");
        document.getElementById("grade").focus();
        return false;
    }
    else if(document.getElementById("feedback").value=="")
    {
        alert("Please enter the feedback");
        document.getElementById("feedback").focus();
        return false;
    }
    
}
function go()
{ 
document.getElementById('searchtext').value="";
document.form2.submit();

}
</script>