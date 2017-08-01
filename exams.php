<?php
include "connect.php";
if($_SESSION['ExamAdmin']=="") header("location:index.php");
include "header.php";
if($_REQUEST['delid'])
{
  $delete="delete from product where  product_id='".$_REQUEST['delid']."'";
	mysql_query($delete) or die("Cannot Execute Query".mysql_error().$delete);
    $_REQUEST['msg']="Record deleted successfully";  
}
if($_REQUEST['column'])
{
    $order=" order by ".$_REQUEST['column']." ".$_REQUEST['val'];
}
if($_REQUEST['searchtext'])
{
$select="select * from product where ".$_REQUEST['searchin']." like '%".$_REQUEST['searchtext']."%' ".$order;
}
else
{
$select="select * from product" .$order;
}
?>
<div class="leftColumn">
   <br /> <br />
  	<div class="operation"></div>
  	<ul class="subMenu">
	  <li>Product Info</li>
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
<form method="post" action="productlist.php" name="form2" id="form2">

<table>
<tr><td>Search</td><td><input type="text" name="searchtext" id="searchtext" value="<?php echo $_REQUEST['searchtext'];?>" /></td>
            <td>
             <select id="searchin" name="searchin">
                <option value="product_id" <?php if($_REQUEST['searchin']=="product_id") echo "selected";?>>Product Id</option>
				<option value="product_title" <?php if($_REQUEST['searchin']=="product_title") echo "selected";?>>Product Title</option>
			</select>
            </td>
            <td>
            <input type="submit" id="sub" name="sub" value="Search" />
            </td>
			<td>
            <a href="productlist.php">Remove Search</a>
            </td>
            </tr>
     </table>
 </form>
 <form id="dob" name="dob" method="post" action="productlist.php">
	</td>
	</tr>
				
				
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
				
					<th scope="col"><a href="productlist.php?column=product_id&val=<?php echo $val?>&searchtext=<?php echo $_REQUEST['searchtext']?>&searchin=<?php echo $_REQUEST['searchin']?>">ID</a></th>
					<th scope="col"><a href="productlist.php?column=product_title&val=<?php echo $val?>&searchtext=<?php echo $_REQUEST['searchtext']?>&searchin=<?php echo $_REQUEST['searchin']?>">Product Name</a></th>
					<th scope="col"><a style="color:white" href="javascript:void(0)">Options</a></th>
                    
				</tr>
<?php
			while($row=mysql_fetch_array($rs))
				{
				?>
					<tr>
					<td><?php echo $row['product_id']?></td>
					<td><?php echo $row['product_title']?></td>
					<td>
					<a href="edit_product.php?id=<?php echo $row['product_id']?>" title="Edit">
					<img src="images/edit2.gif" border="0"/></a>
					<a href="javascript:void(0)" onClick="del('<?php echo $row['product_id'];?>')" title="Delete"><img src="images/del.jpg" border="0"/></a>
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
    
      <input type="button" name="button" onClick="document.location='add_product.php'"  id="big_button" value="+ Add New Page" />
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
	var ans = confirm("Are you sure you want to delete this Room?");
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