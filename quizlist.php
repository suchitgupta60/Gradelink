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
$select="select * from exampaper where Action!='DeActive' and ".$_REQUEST['searchin']." like '%".$_REQUEST['searchtext']."%' and ID not in (select EID from quiz where UID='".$_SESSION['ExamAdmin']."')".$order;
}
else
{
$select="select * from exampaper where Action!='DeActive' and ID not in (select EID from quiz where UID='".$_SESSION['ExamAdmin']."') " .$order;
}
?>
<div class="leftColumn">
   <br /> <br />
  	<div class="operation"></div>
  	<ul class="subMenu">
	  <li>Exam List</li>
    </ul>
    <div class="clear"></div>
				
				
				
				<table border="0" cellpadding="0" cellspacing="0">
				<?php
				/****************** PAGE COUNTER VARIABLES *******************/
			
			//Search Start
			$rs = mysql_query($select) or die("Cannot Execute Query : ".$select."<P>".mysql_error());
?>
<tr>
<td colspan="4">
<form method="post" action="quizlist.php" name="form2" id="form2">

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
            <a href="quizlist.php">Remove Search</a>
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
					<th scope="col"><a style="color: white;" href="quizlist.php?column=Name&val=<?php echo $val?>&searchtext=<?php echo $_REQUEST['searchtext']?>&searchin=<?php echo $_REQUEST['searchin']?>">Exam Name</a></th>
					
                    <th scope="col">Total Questions</th>
                    <th scope="col"><a style="color:white" href="javascript:void(0)"></a></th>
                    
				</tr>
<?php
$j=1;
			while($row=mysql_fetch_array($rs))
				{
				?>
					<tr>
					<td><?php echo $j;?></td>
					<td><?php echo $row['Name']?></td>
                    <?php
                    $total="select count(*) as val from exam_question where EID='".$row['ID']."'";
                    $total_rs=mysql_query($total) or die("Cannot Execute Query".mysql_error());
                    $total_row=mysql_fetch_array($total_rs);
                    ?>
                    <td><?php echo $total_row['val']?></td>
					<td>
                    <input type="button" id="big_button" value="Start Exam" class="form-reset" onclick="document.location='quiz.php?id=<?php echo base64_encode($row['ID']);?>'"  />
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