<?php
include "connect.php";
if($_SESSION['ExamAdmin']=="") header("location:index.php");
include "header.php";
if($_REQUEST['delid'])
{
  $delete="delete from questions where  QID='".$_REQUEST['delid']."'";
	mysql_query($delete) or die("Cannot Execute Query".mysql_error().$delete);
    $_REQUEST['msg']="Record deleted successfully";  
}
if($_REQUEST['column'])
{
    $order=" order by ".$_REQUEST['column']." ".$_REQUEST['val'];
}
if($_REQUEST['searchtext'])
{
	if(empty($_REQUEST['difficulty']) && empty($_REQUEST['type'])){
		$select="select * from questions where ".$_REQUEST['searchin']." like '%".$_REQUEST['searchtext']."%' ".$order;
	}
	else if(empty($_REQUEST['type'])){
		$select="select * from questions where ".$_REQUEST['searchin']." like '%".$_REQUEST['searchtext']."%' and Difficulty like '".$_REQUEST['difficulty']."' ".$order;
	}
	else if(empty($_REQUEST['difficulty'])){
		$select="select * from questions where ".$_REQUEST['searchin']." like '%".$_REQUEST['searchtext']."%' and Type like '".$_REQUEST['type']."' ".$order;
	}
	else{
		$select="select * from questions where ".$_REQUEST['searchin']." like '%".$_REQUEST['searchtext']."%' and Difficulty like '".$_REQUEST['difficulty']."' and Type like '".$_REQUEST['type']."' ".$order;
	}
}
else if(empty($_REQUEST['searchtext']) && empty($_REQUEST['type']) && $_REQUEST['difficulty']){
	$select="select * from questions where Difficulty like '".$_REQUEST['difficulty']."' ".$order;
}
else if(empty($_REQUEST['searchtext']) && empty($_REQUEST['difficulty']) && $_REQUEST['type']){
	$select="select * from questions where Type like '".$_REQUEST['type']."' ".$order;
}
else if(empty($_REQUEST['searchtext']) && !empty($_REQUEST['type']) && !empty($_REQUEST['difficulty'])){
	$select="select * from questions where Difficulty like '".$_REQUEST['difficulty']."' and Type like '".$_REQUEST['type']."' ".$order;
}
else
{
$select="select * from questions" .$order;
}
?>
<div class="leftColumn">
   <br /> <br />
  	<div class="operation"></div>
  	<ul class="subMenu">
	  <li>Question List</li>
    </ul>
    <div class="clear"></div>
				
				
				
				<table border="0" cellpadding="0" cellspacing="0">
				<?php
				/****************** PAGE COUNTER VARIABLES *******************/
			
			//Search Start
			$rs = mysql_query($select) or die("Cannot Execute Query : ".$select."<P>".mysql_error());
?>
<tr>
<td colspan="3">
    
<form method="post" action="questionlist.php" name="form2" id="form2">
<p>Search text and any selection from the drop down menus are optional when doing a search. A selected category with no text will return
    all results in that category. Text with no category chosen will search all questions by default.</p>
<table>
<col width ="100">
<tr>
<td>Search:</td><td><input type="text" name="searchtext" id="searchtext" value="<?php echo $_REQUEST['searchtext'];?>" /></td>
            <td>
             <select id="searchin" name="searchin">
				<option value="Question">Search In</option>
                <option value="Question" <?php if($_REQUEST['searchin']=="searchin") echo "searchin";?>>Question</option>
                <option value="Keywords" <?php if($_REQUEST['searchin']=="searchin") echo "searchin";?>>Keywords</option>
			</select>
            </td>
			<td>
			<select id="difficulty" name="difficulty">
				<option value="0">Difficulty</option>
				<option value="Easy" <?php if($_REQUEST['difficulty']=="difficulty") echo "difficulty";?>>Easy</option>
				<option value="Medium" <?php if($_REQUEST['difficulty']=="difficulty") echo "difficulty";?>>Medium</option>
				<option value="Hard" <?php if($_REQUEST['difficulty']=="difficulty") echo "difficulty";?>>Hard</option>
			</select>
			</td>
			<td>
			<select id="type" name="type">
				<option value="0">Select Type</option>
				<option value="Function" <?php if($_REQUEST['type']=="type") echo "type";?>>Function</option>
				<option value="Exponent" <?php if($_REQUEST['type']=="type") echo "type";?>>Exponent</option>
				<option value="Loop" <?php if($_REQUEST['type']=="type") echo "type";?>>Loop</option>
				<option value="Recursion" <?php if($_REQUEST['type']=="type") echo "type";?>>Recursion</option>
			</select>
			</td>
            <td>
            <input type="submit" id="sub" name="sub" value="Search" />
            </td>
			<td>
            <a href="questionlist.php">Remove Search</a>
            </td>
            </tr>
     </table>
	 <br><p>Select a column name to sort the question list in that column's order. Select again to toggle ascending/descending.
 </form>
</td>
	</tr>
 <form id="dob" name="dob" method="post" action="questionlist.php">
	
			
			<?php
            if($_REQUEST['msg'])
            {
                echo "<tr><td colspan='3' style='color:red;'>".$_REQUEST['msg']."</td></tr>";
            }
            ?>
     <table>
    <colgroup>
    <col span="5" style="background-color:red">
  </colgroup>
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
					<th scope="col"><a style="color: white;" href="questionlist.php?column=QID&val=<?php echo $val?>&searchtext=<?php echo $_REQUEST['searchtext']?>&searchin=<?php echo $_REQUEST['searchin']?>">ID</a></th>
					<th scope="col"><a style="color: white;" href="questionlist.php?column=Question&val=<?php echo $val?>&searchtext=<?php echo $_REQUEST['searchtext']?>&searchin=<?php echo $_REQUEST['searchin']?>">Question</a></th>
					<th scope="col"><a style="color: white;" href="questionlist.php?column=Type&val=<?php echo $val?>&searchtext=<?php echo $_REQUEST['searchtext']?>&searchin=<?php echo $_REQUEST['searchin']?>">Type</a></th>
					<th scope="col"><a style="color: white;" href="questionlist.php?column=Difficulty&val=<?php echo $val?>&searchtext=<?php echo $_REQUEST['searchtext']?>&searchin=<?php echo $_REQUEST['searchin']?>">Difficulty</a></th>
					<th scope="col"><a style="color: white;" href="questionlist.php?column=Points&val=<?php echo $val?>&searchtext=<?php echo $_REQUEST['searchtext']?>&searchin=<?php echo $_REQUEST['searchin']?>">Points</a></th>
					<th scope="col"><a style="color:white" href="javascript:void(0)">Options</a></th>
                    
				</tr>
    
<?php
			while($row=mysql_fetch_array($rs))
				{
				?>
					<tr>
					<td><?php echo $row['QID']?></td>
					<td><?php echo $row['Question']?></td>
					<td><?php echo $row['Type']?></td>
					<td><?php echo $row['Difficulty']?></td>
					<td><?php echo $row['Points']?></td>
					<td>
                        
					<a href="add_edit_question.php?id=<?php echo $row['QID']?>" title="Edit">
                        
					<img src="images/edit2.gif" border="0"/></a>
					<a href="javascript:void(0)" onClick="del('<?php echo $row['QID'];?>')" title="Delete"><img src="images/del.jpg" border="0"/></a>
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
    
      <input type="button" name="button" style="vertical-align:top" onClick="document.location='add_edit_question.php'"  id="big_button" value="+ Create New Question" />
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
	var ans = confirm("Are you sure you want to delete this question?");
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
