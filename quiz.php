
<?php
include "connect.php";
if($_SESSION['ExamAdmin']=="") header("location:index.php");
include "header.php";
require_once("grading.php");
if($_REQUEST['subfrm'])
{
    //question
    $question1="select * from questions where QID='".$_REQUEST['qid']."'";
    $question_rs1=mysql_query($question1) or die("Cannot Execute Query".mysql_error());
    $question_row1=mysql_fetch_array($question_rs1);
    
    //answer
     $answer1="select * from solutions where QID='".$_REQUEST['qid']."'";
    $answer_rs1=mysql_query($answer1) or die("Cannot Execute Query".mysql_error());
    $answer_row1=mysql_fetch_array($answer_rs1);
    
    $insert="insert into quiz(EID,UID,QID,Question,Right_Answer,User_Answer,Date,Points) values('".base64_decode($_REQUEST['id'])."','".$_SESSION['ExamAdmin']."','".$_REQUEST['qid']."','".mysql_real_escape_string($question_row1['Question'])."','".mysql_real_escape_string($answer_row1['Solution'])."','".mysql_real_escape_string($_REQUEST['details'])."',now(),'"."')";
    mysql_query($insert) or die("Cannot Execute Query".mysql_error());
}
if(base64_decode($_REQUEST['id'])>0)
{
$select="select * from exampaper where ID='".base64_decode($_REQUEST['id'])."'";
$rs=mysql_query($select) or die("Cannot Execute Query".mysql_error());
$row=mysql_fetch_array($rs);
}
$question="SELECT * FROM `exam_question` WHERE EID='".base64_decode($_REQUEST['id'])."'and  `QID`  NOT IN (SELECT QID FROM quiz WHERE EID='".base64_decode($_REQUEST['id'])."' and UID='".$_SESSION['ExamAdmin']."')";
$question_rs=mysql_query($question) or die("cannot execute query".mysql_error());

?>
<!--<script src="ckeditor/ckeditor.js"></script>-->
<div class="leftColumn" style="margin-left: 192px;">
	<div class="operation"/>
	<ul class="subMenu">
		<li style="text-transform: uppercase;">
			<?php echo $row['Name'];?>
		</li>
	</ul>
	<div class="clear"/>



	<?php
                if(mysql_numrows($question_rs)>0)
                {
                $question_row=mysql_fetch_array($question_rs);
                ?>

	<form id="fm" action="quiz.php" method="post" onsubmit="return check()">
		<table border="1" cellpadding="0" cellspacing="0" style="border: 0px solid red;">
			<tr>
				<th style="width: 100px;" scope="col">
                        Question :
				</th>
				<?php
                        $question1="select * from questions where QID='".$question_row['QID']."'";
                        $question_rs1=mysql_query($question1) or die("Cannot Execute Query".mysql_error());
                        $question_row1=mysql_fetch_array($question_rs1);
                        ?>
				<th scope="col" style="text-align: left;">
					<?php echo $question_row1['Question']?>
					<input type="hidden" name="qid" id="qid" value="<?php echo $question_row['QID']?>">
						</th>
					</tr>
					<tr>
						<td style="vertical-align: top;">Answer:</td>
						<td>
							<textarea aria-required="true" rows="15" cols="45" name="details"  id="details" class="form-control" required></textarea>
								<br />
								<br />
							</td>
						</tr>
						<tr>

							<td colspan="2">
								<input type="submit" style="float: right;" value="Next Question" id="big_button" name="subfrm" class="form-submit" />
								<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id'];?>">
									</td>
								</tr>
								</tr>
						
							</table>
						</form>
						<?php
                }
                else
                {?>
						<table border="1" cellpadding="0" cellspacing="0" style="border: 0px solid red;">
						
						<?php
							$select="select QID from quiz where EID='".base64_decode($_REQUEST['id'])."'";
							$array=mysql_query($select) or die("can't do it".mysql_error());
							while($rows=mysql_fetch_array($array)){
								$QID=$rows['QID'];
								$query=mysql_query("select Points from exam_question where EID='".base64_decode($_REQUEST['id'])."' and QID='".$QID."'");
								$ar=mysql_fetch_array($query);
								$points=$ar['Points'];
								if($points==0){
									$query2=mysql_query("select Points from questions where QID='".$QID."'");
									$arr=mysql_fetch_array($query2);
									$points=$arr['Points'];
								}
								$selection=mysql_query("select * from questions where QID='".$QID."'");
								$selectionRows=mysql_fetch_array($selection);
								$testCases=$selectionRows['TestCases'];
								$keywords=$selectionRows['Keywords'];
								$type=$selectionRows['Type'];
								$selectAnswer=mysql_query("select * from quiz where QID='".$QID."' and EID='".base64_decode($_REQUEST['id'])."'");
								$answerRow=mysql_fetch_array($selectAnswer);
								$answer=$answerRow['User_Answer'];
								$score=gradeQuestion($testCases,$keywords,$answer,$points,$type);
								$sql="update quiz set Score = '".$score[0]."', Points='".$points."', Comments='".$score[1]."' where EID = '".base64_decode($_REQUEST['id'])."' and QID = '".$QID."' and UID='".$_SESSION['ExamAdmin']."'";
								mysql_query($sql) or die("Cannot Execute Query".mysql_error());
							}
						?>
							<tr>
								<td>
									<br />
									<br />
									<br />
									<center>
										<font color="green" size='5px'>Thank you for taking the exam.</font>
										<br />
										<br />
										<br />
									</center> 
									<br />
									<center>
										<font color="green" size='5px'>You will see your grade shortly in the "Graded Exams" section.</font>
										<br />
										<br />
										<br />
									</center> 
								</td>
							</tr>

						</table>

						<?php
                }
                ?>
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
function check()
{
	if(trim(CKEDITOR.instances.details.getData())=="")
	{
		alert("Please enter the Answer");
		document.getElementById("details").focus();
		return false;
	}
    else
    {
        return true;
    }
}

					</script>