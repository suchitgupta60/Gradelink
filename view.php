<?php
include "connect.php";
if($_SESSION['ExamAdmin']=="") header("location:index.php");
include "header.php";

$select="select * from quiz where EID='".$_REQUEST['id']."' and UID='".$_SESSION['ExamAdmin']."' ";

?>
<div class="leftColumn" style="margin-left: 122px;;">
   <br /> <br />
  	<div class="operation"></div>
  	<ul class="subMenu">
	  <li>Exam Details</li>
    </ul>
    <div class="clear"></div>
				
				
				
				<table border="0" cellpadding="0" cellspacing="0">
				<?php
				/****************** PAGE COUNTER VARIABLES *******************/
			
			//Search Start
			$rs = mysql_query($select) or die("Cannot Execute Query : ".$select."<P>".mysql_error());
?>
<tr>
<td></td>
<td colspan="5">
<?php
$exam="select * from exampaper where ID='".$_REQUEST['id']."'";
$exam_rs=mysql_query($exam) or die("Cannot Execute Query".mysql_error());
$exam_row=mysql_fetch_array($exam_rs);
?>
<a href="myquiz.php"><< Back</a>
<br /><br />
<center><font size="5px"><b>Exam Name: <?php echo $exam_row['Name']?></b></font></center>
<br /><br />
<?php
                     $result="select * from result where student_id='".$_SESSION['ExamAdmin']."' and Exam_ID='".$_REQUEST['id']."'";
                    $result_rs=mysql_query($result) or die("Cannot Execute Query".mysql_error());
                    if(mysql_num_rows($result_rs)>0)
                    {
                        $result_row=mysql_fetch_array($result_rs);
						
						$totalPoints="select Points from result where Exam_ID='".$_REQUEST['id']."' and Student_ID='".$_SESSION['ExamAdmin']."'";
						$totalPoints_rs=mysql_query($totalPoints) or die("Cannot Execute Query".mysql_error());
						$totalPoints_row=mysql_fetch_array($totalPoints_rs);
						$pointTotal=$totalPoints_row['Points'];
						if($pointTotal==0){echo "hello";
							$totalPoints="select sum(Points) as total from quiz where EID='".$_REQUEST['id']."' and UID='".$_SESSION['ExamAdmin']."'";
							$totalPoints_rs=mysql_query($totalPoints) or die("Cannot Execute Query".mysql_error());
							$totalPoints_row=mysql_fetch_array($totalPoints_rs);
							$pointTotal=$totalPoints_row['total'];
						}
						
						$pointsObtained="select Score from result where Exam_ID='".$_REQUEST['id']."' and Student_ID='".$_SESSION['ExamAdmin']."'";
						$pointsObtained_rs=mysql_query($pointsObtained) or die("Cannot Execute Query".mysql_error()); 
						$pointsObtained_row=mysql_fetch_array($pointsObtained_rs);
						$scoreTotal=$pointsObtained_row['Score'];
						if($scoreTotal==0){
							$pointsObtained="select sum(Score) as total from quiz where EID='".$_REQUEST['id']."' and UID='".$_SESSION['ExamAdmin']."'";
							$pointsObtained_rs=mysql_query($pointsObtained) or die("Cannot Execute Query".mysql_error().$pointsObtained);
							$pointsObtained_row=mysql_fetch_array($pointsObtained_rs);
							$scoreTotal=$pointsObtained_row['total'];
						}
						
						
                        echo "<tr><td colspan='3'><font size='4px'><b>Grade: ".$result_row['Grade']."</b></td></font>";
                        echo "<td colspan='3'><font size='4px'><b>Total: ".$pointTotal."</b></td></font></tr>";
                        echo "<tr><td colspan='3'><font size='4px'><b>Feedback: ".$result_row['Feedback']."</b></td></font>";
                        echo "<td colspan='2x'><font size='4px'><b> Score: ".$scoreTotal."</b></td></font></tr>";
                        
                    }
                    else
                    {
                        $grade="-";
                        $feedback="-";
                    }
                    ?>
 <form id="dob" name="dob" method="post" action="view.php">
	</td>
	</tr>
				
			<?php
            if($_REQUEST['msg'])
            {
                echo "<tr><td colspan='3' style='color:red;'>".$_REQUEST['msg']."</td></tr>";
            }
            ?>	
				<tr>
				
					<th scope="col">No.</a></th>
					<th scope="col">Question</th>					
                    <th scope="col">Correct Answer</th>
                    <th scope="col">Your Answer</th>
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
                    <div style="width: 350px;border:1px solid black;height:200px;padding:8px;overflow:auto;">
                   <pre> <?php echo $row['Right_Answer'];?></pre>
                    </div></td>
					<td>
                    <div style="width: 350px;border:1px solid black;height:200px;padding:8px;overflow:auto;">
                   <pre> <?php echo $row['User_Answer'];?></pre>
                    </div></td>
					<td>
                    <div style="width: 400px;border:1px solid black;height:200px;padding:8px;overflow:auto;">
                   <pre> <?php echo $row['Comments'];?></pre>
                    </div></td>
					
                     
				</tr>
				<?php
                $j=$j+1;
				}
				
				?>
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

<?php
include "footer.php";
?>
<script>
function del(id)
{
	var ans = confirm("Are you sure you want to delete this Question?");
	if(ans==true)
	{
		document.getElementById("delid").value=id;
		document.dob.submit();
	}
}
function go()
{ 
document.getElementById('searchtext').value="";
document.form2.submit();

}
</script>