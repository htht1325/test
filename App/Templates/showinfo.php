<html>
<head>
<title>信息提示</title>
<style type="text/css">
.mainwindow{
	margin:15% auto;
	width:30%;
	height:20%;
	border:1px solid #ccc;
}
.header{
	width:100%;
	height:30px;
	background:#ccc;
	color:white;
}
.content{
	
	margin:0 auto;
	width:100%;
	text-align:center;
	padding-top:10%;
	font-size:18px;
}

</style>
</head>
<body>

<div class="mainwindow">
<div class="header"><?php echo $topinfo;?></div>
<div class="content">
<?php echo $info.'('.$time.'秒后跳转)'?>
</div>
</div>
</body>



</html>
