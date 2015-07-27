
<?php
require_once ("./mysqli.class.php");
$db = new Mysqlii ( "localhost", "root", "dapeng9988", "yanjing", "utf8" );

require_once ("./WxConfig.php");
$wx = new WxConfig ( "############", "############" );
?>
<?php
if (isset ( $_POST ['Submit'] ) && $_POST ['Submit'] == "新增") {
	$name = $_POST ['name'];
	if ($_POST ['name'] == "") {
		echo "<font color =red>渠道名称不能为空！</font><br>";
	} else {
		$sql = "select count(id) from cms_qrcode where channel = '$name'";
		$isExit = $db->getOne ( $sql );
		if ($isExit == "0") {
			$sql = "insert into cms_qrcode (channel) VALUES ('$name')";
			$result = $db->query ( $sql );
			$newID = mysqli_insert_id ( $db->mysqli );
			$qrcode = $wx->get_qrcode ( $newID );
			if ($qrcode == "0") {
				echo "<font color =red>Token获取失败，请检查微信配置文件中appid和secret是否正确！</font><br>";
			} else if ($qrcode == "1") {
				echo "<font color =red>二维码获取失败！</font><br>";
			} else {
				echo "<font color=red>渠道保存成功！</font><br>";
			}
		} else {
			echo "已存在相同的渠道名称，新增失败！";
		}
	}
}
?>
<html>
<head>
<title>添加渠道二维码</title>
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
	<form method="POST" action="">
		<div>
			渠道名称：<input type="Text" name="name" size="20"><input type="Submit"
				name="Submit" value="新增">
	<?php
	$sql = "select id, channel, replykey, mark, clientlevel, qrcode from cms_qrcode";
	echo "渠道总数：" . $db->numRows ( $sql );
	echo "<br />";
	?>
		</div>
	</form>
	<table>
		<tr>
			<th>渠道编号</th>
			<th>渠道名称</th>
			<th>关键字</th>
			<th>标签</th>
			<th>等级</th>
			<th>二维码</th>
			<th>操作</th>
		</tr>
	<?php
	$result = $db->query ( $sql );
	while ( $row = mysqli_fetch_array ( $result ) ) {
		echo "<tr>";
		echo "<td>$row[0]</td>";
		echo "<td>$row[1]</td>";
		echo "<td>$row[2]</td>";
		echo "<td>$row[3]</td>";
		echo "<td>$row[4]</td>";
		echo "<td><img src=" . $row [5] . " style=\"border:0; width:80px;\"></td>";
		echo "<td><a href=\"WxChannelUpdate.php?id=$row[0]\">编辑</a> <a href=\"#\">停用</a></td>";
		echo "</tr>";
	}
	?>
	</table>
</body>




</html>