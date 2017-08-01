<?php
include "connect.php";
if($_SESSION['ExamAdmin']=="") header("location:login.php");
include "header.php";
if($_REQUEST['delid'])
{
    $delete="delete from users where ID='".$_REQUEST['delid']."'";
    mysql_query($delete) or die("Cannot Execute Query".mysql_error());
    $msg="User Deleted Successfully";
}
?>
<div class="leftColumn">
   <br> <br>
  	<div class="operation"></div>
  	<ul class="subMenu">
	  <li>Users List</li>
    </ul>
    <div class="clear"></div>
				<form id="dob" name="dob" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>?pageno=<?php echo ($pageno-1); ?>&view_num_records=<?php echo $viewnumrecords;?>&SearchIn=<?php echo $_REQUEST['SearchIn']?>&txtsearch=<?php echo $_REQUEST['txtsearch'];?>&orderby=<?php echo $_REQUEST['orderby']?>&order=<?php echo $_REQUEST['order']?>">
				<!--Search Start-->
<?php
$searchArr = array("Name"=>"Name","Email"=>"Email");
?>
				<table>
                    
				<tr>
                    		<td>Search:</td>
                    		<td style="padding-right:.1px"><input type="text" style="height:25px;width:120px;" size="30px" id="txtsearch" name="txtsearch" value="<?php echo $_REQUEST['txtsearch'];?>"></td>
                    		<td style="padding-right:1px">in</td>
                    		<td style="padding-right:2px">
							<select name="SearchIn" id="SearchIn" style="height:20px">
<?php
$keys = array();
foreach($searchArr as $key => $value) 
{
	array_push($keys,$key);
?>
	<option value="<?php echo $key;?>" <?php echo ($_REQUEST['SearchIn']==$key)?"selected":"";?>><?php echo $value; ?></option>
<?php								
}
?>								
							</select>
						</td>
						<td style="padding-right:20px"><input type="submit" name="search" id="search" value="Search" class="form-submit"></td>
						<td style="padding-right:20px"><a href="<?php echo $_SERVER["PHP_SELF"]; ?>?pageno=<?php echo $_REQUEST['pageno']; ?>&view_num_records=<?php echo $_REQUEST['view_num_records'];?>&orderby=<?php echo $keys[0];?>&order=<?php echo $order;?>" class="classh1">Remove Search</a></td>
					</tr>
                    <tr>
                    <td colspan="6">
                    <?php
                    if($_REQUEST['msg']) echo "<font color='red'>".$_REQUEST['msg']."</font>";
                    ?>   
    
                    </td>
                    </tr>
				</table>
				<!--Search End-->
				
				<table border="0" cellpadding="0" cellspacing="0">
				<?php
				/****************** PAGE COUNTER VARIABLES *******************/
			$sql = "select * from users ";
			//Search Start
			$where = "";
			$orderby = " order by ";
			if($_REQUEST['SearchIn'] and $_REQUEST['txtsearch'])
			{
				$where .= " where ".$_REQUEST['SearchIn']." like '%".$_REQUEST['txtsearch']."%' and Name!='admin'";
			}
            else
            {
                $where.=" where Name!='admin'";
            }
			$sql .= $where;
			if($_REQUEST['order']=='desc') $order = "asc"; 
			else if($_REQUEST['order']=='asc') $order = "desc"; 
			else $order = "desc";
			if($_REQUEST['order']=="") $_REQUEST['order'] = "asc";
			if($_REQUEST['orderby']!="") $orderby .= $_REQUEST['orderby']." ".$_REQUEST['order'];
			else $orderby .= $keys[0]." ".$_REQUEST['order'];
			$sql .= $orderby;
			//Search End
			//Pagination Starts
			if($_REQUEST['view_num_records']) $norpp = $_REQUEST['view_num_records'];
			else $norpp = 20;
			$countingrs=mysql_query($sql) or die("query cannot execute:<p>".$sql."<p>".mysql_error());
			$noofrecs=mysql_num_rows($countingrs);
			if($_REQUEST['view_num_records']=="All") $norpp=$noofrecs; 
			$i=0;
			$j=1;
			While($i<$noofrecs)
			{
				$pagestart="Page".$j."Start";
				$pageend="Page".$j."End";
				$$pagestart=$i;
				$$pageend=$i+($norpp-1);
				$i+=$norpp;
				$j+=1;
			}
			if (!$_GET['pageno']) $pageno=1;
			else $pageno=$_GET['pageno'];
			if($_REQUEST['view_num_records']=="All") { $pageno=$pageno-1; $j=$j-1;}
			if ($pageno<1) $pageno=1;
			if ($pageno>=$j) $pageno=$j-1;
			$pagestart="Page".$pageno."Start";
			$pageend="Page".$pageno."End";
			if(isset($$pagestart))	$sql.= " Limit ".$$pagestart.", ".$norpp;
			$viewnumrecords=$_REQUEST['view_num_records'];
			//Pagination Ends
            //echo $sql;
			$rs = mysql_query($sql) or die("Cannot Execute Query : ".$sql."<P>".mysql_error());
?>
				<tr>
					<th scope="col"><a style="color:white" href="<?php echo $_SERVER["PHP_SELF"]; ?>?pageno=<?php echo $_REQUEST['pageno']; ?>&view_num_records=<?php echo $_REQUEST['view_num_records'];?>&SearchIn=<?php echo $_REQUEST['SearchIn']?>&txtsearch=<?php echo $_REQUEST['txtsearch'];?>&orderby=<?php echo $keys[0];?>&order=<?php echo $order;?>">Name</a></th>
					<th scope="col"><a style="color:white" href="<?php echo $_SERVER["PHP_SELF"]; ?>?pageno=<?php echo $_REQUEST['pageno']; ?>&view_num_records=<?php echo $_REQUEST['view_num_records'];?>&SearchIn=<?php echo $_REQUEST['SearchIn']?>&txtsearch=<?php echo $_REQUEST['txtsearch'];?>&orderby=<?php echo $keys[1];?>&order=<?php echo $order;?>">Email</a></th>
					<th scope="col">Group</th>
                    <th scope="col"><a style="color:white" href="javascript:void(0)">Options</a></th>
				</tr>
<?php
			while($row=mysql_fetch_array($rs))
				{?>
					<tr>
					<td><?php echo $row['Name']?></td>
                    
                    <td><?php echo $row['Email']?></td>
                    <?php
                    $group="select * from groups where ID='".$row['groupid']."'";
                    $group_rs=mysql_query($group) or die("Cannot Execute Query".mysql_error());
                    $group_row=mysql_fetch_array($group_rs);
                    ?>
                    <td><?php echo $group_row['Name']?></td>
					<td>
					<a href="javascript:void(0)" onclick="del('<?php echo $row['ID'];?>')" title="Delete"><img src="images/del.jpg" border="0"/></a>
					
                    </td>
				</tr>
				<?php
				}
				
				?>
				<input type="hidden" name="delid" id="delid" value="">
				</table>
				<!--  end product-table................................... --> 
				</form>
				</div>
                <div class="rightColumn" >
  <div id="action">
    <p>
    
      <input type="button" name="button" onClick="document.location='add_users.php'"  id="big_button" value="+ Add Users" />
    </p>
    <p class="helpText">&nbsp;</p>
  </div>
  
  </div>
<!--Start Pagination-->

<?php

if($noofrecs>20)
{

?>
<div id="pagination">
<table border="0" width=400 align="left">

				<tr>

					<td width=5>&nbsp;</td>

					<td>

						<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?pageno=<?php echo ($pageno-1); ?>&view_num_records=<?php echo $viewnumrecords;?>&SearchIn=<?php echo $_REQUEST['SearchIn']?>&txtsearch=<?php echo $_REQUEST['txtsearch'];?>&orderby=<?php echo $_REQUEST['orderby']?>&order=<?php echo $_REQUEST['order']?>"  method="post">

							<Table Align=left border=0 cellpadding=0 cellspacing=5 width="400px">

								<TR>

									<TD>

										<a href="<?php echo $_SERVER["PHP_SELF"]; ?>?pageno=<?php echo "0"; ?>&view_num_records=<?php echo $viewnumrecords;?>&SearchIn=<?php echo $_REQUEST['SearchIn']?>&txtsearch=<?php echo $_REQUEST['txtsearch'];?>&orderby=<?php echo $_REQUEST['orderby']?>&order=<?php echo $_REQUEST['order']?>" class="page-far-left"></a> <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?pageno=<?php echo ($pageno-1); ?>&view_num_records=<?php echo $viewnumrecords;?>&SearchIn=<?php echo $_REQUEST['SearchIn']?>&txtsearch=<?php echo $_REQUEST['txtsearch'];?>&orderby=<?php echo $_REQUEST['orderby']?>&order=<?php echo $_REQUEST['order']?>" class="page-left"></a>

									</td>

									<td>

										<div id="page-info">Page <strong><?php if($pageno==0) echo "1"; else echo $pageno; ?></strong> / <?php if(($j-1)==0) echo "1"; else echo ($j-1); ?></div>

									</td>

									<td>

										<a href="<?php echo $_SERVER["PHP_SELF"]; ?>?pageno=<?php echo ($pageno+1); ?>&view_num_records=<?php echo $viewnumrecords;?>&SearchIn=<?php echo $_REQUEST['SearchIn']?>&txtsearch=<?php echo $_REQUEST['txtsearch'];?>&orderby=<?php echo $_REQUEST['orderby']?>&order=<?php echo $_REQUEST['order']?>" class="page-right"></a> <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?pageno=<?php echo ($j-1); ?>&view_num_records=<?php echo $viewnumrecords;?>&SearchIn=<?php echo $_REQUEST['SearchIn']?>&txtsearch=<?php echo $_REQUEST['txtsearch'];?>&orderby=<?php echo $_REQUEST['orderby']?>&order=<?php echo $_REQUEST['order']?>" class="page-far-right"></a>

									</td>

									<td>&nbsp;</td>

									<td colspan=3 align=left>

										Records per page

										<select name="view_num_records" onChange='submit()'>

											<option value=5 <?php if(($norpp==5) && (!$_REQUEST['view_num_records'])){ echo 'selected'; } elseif($_REQUEST['view_num_records']==5) echo 'selected';?>>5</option>

											<option value=10 <?php if(($norpp==10) && (!$_REQUEST['view_num_records'])){ echo 'selected'; } elseif($_REQUEST['view_num_records']==10) echo 'selected';?>>10</option>

											<option value=15 <?php if(($norpp==15) && (!$_REQUEST['view_num_records'])){ echo 'selected'; } elseif($_REQUEST['view_num_records']==15) echo 'selected';?>>15</option>

											<option value=20 <?php if(($norpp==20) && (!$_REQUEST['view_num_records'])){ echo 'selected'; } elseif($_REQUEST['view_num_records']==20) echo 'selected';?>>20</option>

												<option value=25 <?php if(($norpp==25) && (!$_REQUEST['view_num_records'])){ echo 'selected'; } elseif($_REQUEST['view_num_records']==25) echo 'selected';?>>25</option>

											<option value=30 <?php if(($norpp==30) && (!$_REQUEST['view_num_records'])){ echo 'selected'; } elseif($_REQUEST['view_num_records']==30) echo 'selected';?>>30</option>

											<option value="All" <?php if($_REQUEST['view_num_records']=="All") echo 'selected'; ?>> All </option>

										</select>

									</td>

								</tr>

							</Table>

						</form>

					</td>

					<td><span class="redText"><p><?php echo $errorMsg;?></p></span></td>

				</tr>

			</table>
            </div>

<?php

}

?>

<!--End Pagination-->				

  </div>
<?php
include "footer.php";
?>
<script>
function del(id)
{
	var ans = confirm("Are you sure you want to delete this User?");
	if(ans==true)
	{
		document.getElementById("delid").value=id;
		document.dob.submit();
	}
}
</script>