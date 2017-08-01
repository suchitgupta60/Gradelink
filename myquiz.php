<?php
include "connect.php";
if($_SESSION['ExamAdmin']=="") header("location:index.php");
include "header.php";

if($_REQUEST['column'])
{
    $order=" order by ".$_REQUEST['column']." ".$_REQUEST['val'];
}
else
{
    $order=" order by ID desc";
}
if($_REQUEST['searchtext'])
{
$select="select * from exampaper where ".$_REQUEST['searchin']." like '%".$_REQUEST['searchtext']."%'  and ID in (select EID from quiz where UID='".$_SESSION['ExamAdmin']."' and Released!='1')".$order;
}
else
{
$select="select * from exampaper where ID in (select EID from quiz where UID='".$_SESSION['ExamAdmin']."' and Released!='1')" .$order;
}
?>
<div class="leftColumn" >
   <br /> <br />
  	<div class="operation"></div>
  	<ul class="subMenu">
	  <li>My Exam List</li>
    </ul>
    <div class="clear"></div>
				
				
				
				<table border="0" cellpadding="0" cellspacing="0">
				<?php
				/****************** PAGE COUNTER VARIABLES *******************/
			
			//Search Start
			$rs = mysql_query($select) or die("Cannot Execute Query : ".$select."<P>".mysql_error());
?>
<tr>
<td colspan="7">
    
<form method="post" action="myquiz.php" name="form2" id="form2">

<table>
<tr><td>Search</td><td><input type="text" name="searchtext" id="searchtext" value="<?php echo $_REQUEST['searchtext'];?>" /></td>
            <td>
             <select id="searchin" name="searchin">
                <option value="Name" <?php if($_REQUEST['searchin']=="Name") echo "selected";?>>Exam Name</option>
			</select>
            </td>
            <td>
            <input type="submit" id="sub" name="sub" value="Search" />
            </td>
			<td>
            <a href="myquiz.php">Remove Search</a>
            </td>
            </tr>
     </table>
 </form>
 <form id="dob" name="dob" method="post" action="quizlist.php">
	</td>
	</tr>
				
			<?php
            if($_REQUEST['msg'])
            {
                echo "<tr><td colspan='3' style='color:red;'>".$_REQUEST['msg']."</td></tr>";
            }
            ?>	
				<tr>
				<?php
                if($_REQUEST['val']=="asc")
                {
                    $val="desc";
                }
                else
                {
                    $val="asc";
                }
                ?>
				
					<th scope="col">No</a></th>
					<th scope="col"><a style="color: white;" href="myquiz.php?column=Name&val=<?php echo $val?>&searchtext=<?php echo $_REQUEST['searchtext']?>&searchin=<?php echo $_REQUEST['searchin']?>">Exam Name</a></th>
					
                    <th scope="col">Grade</th>
                    <th scope="col">Feedback</th>
                     <th scope="col">Total</th>
                      <th scope="col">Score</th>
                    
                    <th scope="col"><a style="color:white" href="javascript:void(0)"></a></th>
                    
				</tr>
 <style>
/* Tooltip container */
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
}

/* Tooltip text */
.tooltip .tooltiptext {
    visibility: hidden;
    width: 420px;
    height:100px;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;
    overflow: auto;
 
    /* Position the tooltip text - see examples below! */
    position: absolute;
    z-index: 1;
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltip:hover .tooltiptext {
    visibility: visible;
}
.tooltip .tooltiptext {
    top: -5px;
    left: 80%; 
}
</style>
<?php
$j=1;
			while($row=mysql_fetch_array($rs))
				{
				?>
					<tr>
					<td><?php echo $j;?></td>
					<td><?php echo $row['Name']?></td>
                    <?php
                     $result="select * from result where Student_id='".$_SESSION['ExamAdmin']."' and Exam_ID='".$row['ID']."'";
                    $result_rs=mysql_query($result) or die("Cannot Execute Query".mysql_error());
                    if(mysql_num_rows($result_rs)>0)
                    {
                        $result_row=mysql_fetch_array($result_rs);
                        $grade=$result_row['Grade'];
                        $feedback=$result_row['Feedback'];
                        $points=$result_row['Points'];
                    }
                    else
                    {
                        $grade="-";
                        $feedback=" NO Feedback";
                        $points="";
                    }
                    ?>
                    <td><b><font size="3px"><?php echo $grade;?></b></font></td>
                    <td>
                    <div class="tooltip">Feedback
                        <span class="tooltiptext"><?php echo $feedback?></span>
                   </div>
                    </td>
<?php
$totalPoints="select Points from result where Exam_ID='".$row['ID']."' and Student_ID='".$_SESSION['ExamAdmin']."'";
$totalPoints_rs=mysql_query($totalPoints) or die("Cannot Execute Query".mysql_error());
$totalPoints_row=mysql_fetch_array($totalPoints_rs);
$pointTotal=$totalPoints_row['Points'];
if($pointTotal==0){ 
	$totalPoints="select sum(Points) as total from quiz where EID='".$row['ID']."' and UID='".$_SESSION['ExamAdmin']."'";
	$totalPoints_rs=mysql_query($totalPoints) or die("Cannot Execute Query".mysql_error().$totalPoints);
	$totalPoints_row=mysql_fetch_array($totalPoints_rs);
	$pointTotal=$totalPoints_row['total'];
} 
$pointsObtained="select Score from result where Exam_ID='".$row['ID']."' and Student_ID='".$_SESSION['ExamAdmin']."'";
$pointsObtained_rs=mysql_query($pointsObtained) or die("Cannot Execute Query".mysql_error()); 
$pointsObtained_row=mysql_fetch_array($pointsObtained_rs);
$scoreTotal=$pointsObtained_row['Score'];
if($scoreTotal==0){
	$pointsObtained="select sum(Score) as total from quiz where EID='".$row['ID']."' and UID='".$_SESSION['ExamAdmin']."'";
	$pointsObtained_rs=mysql_query($pointsObtained) or die("Cannot Execute Query".mysql_error().$pointsObtained);
	$pointsObtained_row=mysql_fetch_array($pointsObtained_rs);
	$scoreTotal=$pointsObtained_row['total'];
}
?>
                    <td><?php echo $pointTotal ?></td>
                    <td><?php echo $scoreTotal ?></td>
					<td>
                    <a href="view.php?id=<?php echo $row['ID']?>">View Exam Details</a>
                     </td>
                     
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