<?php
session_start();
mysql_connect("sql1.njit.edu","smg28","ktxRGRVC") or die("Cannot Execute Query".mysql_error());
mysql_select_db("smg28") or die("Cannot select db".mysql_error());
?>