<?php
include "connect.php";
if($_SESSION['ExamAdmin']=="") header("location:index.php");
include "header.php";
if($_REQUEST['delid'])
{
  $delete="update exampaper set Action='DeActive' where  ID='".$_REQUEST['delid']."'";
	mysql_query($delete) or die("Cannot Execute Query".mysql_error().$delete);
    $_REQUEST['msg']="Record deleted successfully";  
    
   
}
if($_REQUEST['column'])
{
    $order=" order by ".$_REQUEST['column']." ".$_REQUEST['val'];
}
if($_REQUEST['searchtext'])
{
$select="select * from exampaper where Action!='DeActive' and ".$_REQUEST['searchin']." like '%".$_REQUEST['searchtext']."%' ".$order;
}
else
{
$select="select * from exampaper where Action!='DeActive' " .$order;
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

<form method="post" action="setlist.php" name="form2" id="form2">

<table>
<tr><td>Search</td><td><input type="text" name="searchtext" id="searchtext" value="<?php echo $_REQUEST['searchtext'];?>" /></td>
            <td>
             <select id="searchin" name="searchin">
                <option value="Name" <?php if($_REQUEST['searchin']=="Name") echo "selected";?>>Name</option>
			</select>
            </td>
            <td>
            <input type="submit" id="sub" name="sub" value="Search" />
            </td>
			<td>
            <a href="setlist.php">Remove Search</a>
            </td>
            </tr>
     </table>
 </form>

 <form id="dob" name="dob" method="post" action="setlist.php">
	</td>
	</tr>
				
			<?php
            if($_REQUEST['msg'])
            {
                echo "<tr><td colspan='4' style='color:red;'>".$_REQUEST['msg']."</td></tr>";
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
				
					<th scope="col"><a style="color: white;" href="setlist.php?column=ID&val=<?php echo $val?>&searchtext=<?php echo $_REQUEST['searchtext']?>&searchin=<?php echo $_REQUEST['searchin']?>">ID</a></th>
					<th scope="col"><a style="color: white;" href="setlist.php?column=Name&val=<?php echo $val?>&searchtext=<?php echo $_REQUEST['searchtext']?>&searchin=<?php echo $_REQUEST['searchin']?>">Exam Name</a></th>
					<th scope="col">Total Questions</th>
                    <th scope="col"><a style="color:white" href="javascript:void(0)">Options</a></th>
                    
				</tr>
<?php
			while($row=mysql_fetch_array($rs))
				{
				?>
					<tr>
					<td><?php echo $row['ID']?></td>
					<td><?php echo $row['Name']?></td>
                    <?php
                    $total="select count(*) as val from exam_question where EID='".$row['ID']."'";
                    $total_rs=mysql_query($total) or die("Cannot Execute Query".mysql_error());
                    $total_row=mysql_fetch_array($total_rs);
                    ?>
                    <td><?php echo $total_row['val']?></td>
					<td>
					<a href="add_edit_set.php?id=<?php echo $row['ID']?>" title="Edit">
					<img src="" border="0"/></a>
					<a href="javascript:void(0)" onClick="del('<?php echo $row['ID'];?>')" title="Delete"><img src="images/del.jpg" border="0"/></a>
				     </td>
                     
				</tr>
				<?php
				}
				
				?>
				<input type="hidden" name="delid" id="delid" value="" />
				</table>
				<!--  end product-table................................... --> 
				</form>
				</div>
	<div class="rightColumn" >
  <div id="action">
    <p>
    
      <input type="button" name="button" onClick="document.location='add_edit_set.php'"  id="big_button" value="+ Create New Exam" />
    </p>
    <p class="helpText">&nbsp;</p>
  </div>
  
  </div>

<?php
include "footer.php";
?>
<script>
function del(id)
{
	var ans = confirm("Are you sure you want to delete this exam?");
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