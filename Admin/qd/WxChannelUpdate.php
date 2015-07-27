
<?php
require_once ("./mysqli.class.php");
$db = new Mysqlii ( "localhost", "root", "dapeng9988", "yanjing", "utf8" );
?>
<?php

if (isset ( $_GET ["id"] )) {
	$id = $_GET ["id"];
	$sql = "select id, channel, replykey, mark, clientlevel, qrcode from cms_qrcode where id = $id";
	$rs = $db->getRow ( $sql );
}

if (isset ( $_POST ['Submit'] ) && $_POST ['Submit'] == "保存") {
	$name = $_POST ['name'];
	$oldname = $_POST ['oldname'];
	$replykey = $_POST ['replykey'];
	$mark = $_POST ['mark'];
	$clientlevel = $_POST ['clientlevel'];
	if ($_POST ['name'] == "") {
		echo "<font color =red>渠道名称不能为空！</font><br>";
		return;
	}
	if ($oldname != $name) {
		$sql = "select count(id) from cms_qrcode where channel = '$name'";
		$isExit = $db->getOne ( $sql );
		if ($isExit != "0") {
			echo "已存在相同的渠道名称，新增失败！";
			return;
		}
	}
	
	$new = array ();
	$new ["channel"] = $name;
	$new ["replykey"] = $replykey;
	$new ["mark"] = $mark;
	$new ["clientlevel"] = $clientlevel;
	
	$where = array (
			"id" => "$id" 
	);
	
	$rtn = $db->update ( "cms_qrcode", $new, $where );
	echo $rtn;
}
?>
<html>
<head>
<title>编辑渠道二维码</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="main.css" rel="stylesheet" type="text/css" />
<style type="text/css">
table {
	width: 98%;
}

th,td {
	border: solid 1px #000;
	color: #000;
	text-align: center;
}

td {
	font-size: 12px;
}
</style>
</head>
<body>


<body>
	<form method="POST" action="">
		<table style="border: solid 1px green;">
			<tr>
				<td colspan="2"><input type="Submit" name="Submit" value="保存"></td>
			</tr>
			<tr>
				<td>渠道编号</td>
				<td><?php echo $rs["id"]; ?></td>
			</tr>
			<tr>
				<td>渠道名称</td>
				<td><input type="Text" name="name"
					value="<?php echo $rs["channel"]; ?>"></td>
			</tr>
			<tr>
				<td>关键字</td>
				<td><input type="Text" name="replykey"
					value="<?php echo $rs["replykey"]; ?>"></td>
			</tr>
			<tr>
				<td>标签</td>
				<td><input type="Text" name="mark"
					value="<?php echo $rs["mark"]; ?>"></td>
			</tr>
			<tr>
				<td>等级</td>
				<td><input type="Text" name="clientlevel"
					value="<?php echo $rs["clientlevel"]; ?>"></td>
			</tr>
			<tr>
				<td>二维码</td>
				<td><img src="<?php echo $rs["qrcode"]; ?>" style="""border:0; width:80px;\"></td>
			</tr>
		</table>
		<input type="Hidden" name="oldname"
			value="<?php echo $rs["channel"]; ?>">
	</form>
</body>




</html>