<?php
include "connect.php";
if($_SESSION['ExamAdmin']=="") header("location:index.php");
include "header.php";


$select="select * from quiz  group by EID,UID order by ID";

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
<?php
            if($_REQUEST['msg'])
            {
                echo "<tr><td colspan='3' style='color:red;'>".$_REQUEST['msg']."</td></tr>";
            }
            ?>	
				<tr>
								
					<th scope="col">No</a></th>
					<th scope="col">Exam Name</th>
					<th scope="col">Student Name</th>
                    <th scope="col">Grade</th>
                    <th scope="col"><a style="color:white" href="javascript:void(0)"></a></th>
                    
				</tr>
<?php
$j=1;
			while($row=mysql_fetch_array($rs))
				{
				?>
					<tr>
					<td><?php echo $j;?></td>
                    <?php
                    $eid="select * from exampaper where ID='".$row['EID']."'";
                    $eid_rs=mysql_query($eid) or die("Cannot Execute Query".mysql_error());
                    $e_row=mysql_fetch_array($eid_rs);
                    ?>
					<td><?php echo $e_row['Name']?></td>
                    <?php
                    $uid="select * from users where ID='".$row['UID']."'";
                    $uid_rs=mysql_query($uid) or die("Cannot Execute Query".mysql_error());
                    $u_row=mysql_fetch_array($uid_rs);
                    ?>
					<td><?php echo $u_row['Name']?></td>
                    <?php
                    $result="select * from result where student_id='".$row['UID']."' and Exam_ID='".$row['EID']."'";
                    $result_rs=mysql_query($result) or die("Cannot Execute Query".mysql_error());
                    if(mysql_num_rows($result_rs)>0)
                    {
                        $result_row=mysql_fetch_array($result_rs);
                        $grade=$result_row['Grade'];
                    }
                    else
                    {
                        $grade="-";
                    }
                    ?>
                    <td><b><font size="3px"><?php echo $grade;?></b></font></td>
					<td>
                    <a href="view_details.php?id=<?php echo $row['EID']?>&uid=<?php echo $row['UID']?>">View Exam Details</a>
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