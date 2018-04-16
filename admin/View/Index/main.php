<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo MOUDLE?>/Public/js/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo MOUDLE?>/Public/js/themes/icon.css">
    <script type="text/javascript" src="<?php echo MOUDLE?>/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo MOUDLE?>/Public/js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?php echo MOUDLE?>/Public/js/locale/easyui-lang-zh_CN.js"></script>

    <link rel="stylesheet" href="<?php echo MOUDLE?>/Public/js/kindeditor/themes/default/default.css"/>

    <script type="text/javascript" src="<?php echo MOUDLE?>/Public/js/kindeditor/kindeditor-all-min.js"></script>
    <script type="text/javascript" src="<?php echo MOUDLE?>/Public/js/uploadify/jquery.uploadify.min.js"></script>
    <link rel="stylesheet" href="<?php echo MOUDLE?>/Public/js/uploadify/uploadify.css"/>
</head>
<body class="easyui-layout">
<div data-options="region:'north',border:false" style="height:60px;background:#B3DFDA;padding:10px">north region</div>
<div data-options="region:'west',split:true,title:'<?php L('mainmenu');?>'" style="width:150px;">

    <!--左边的导航菜单-->
    <div class="easyui-accordion" data-options="fit:false,border:false">



        <?php foreach($menuArr as $key=>$value){?>


        <div title="<?php L($key);?>" style="padding:10px;" data-options="iconCls:'icon-<?php echo $iconArr[$key];?>'">
            <?php if($value!=''){

                foreach ($value as $key2 => $menu){

                ?>


            <a href="javascript:showContent('index.php?m=<?php echo MOUDLE;?>&c=<?php echo $menu['control']?>&a=<?php echo $menu['action']?>','<?php L($menu['title']);?>');" class="easyui-linkbutton" data-options="plain:true"><img src="<?php echo MOUDLE?>/Public/menupic/<?php echo $menu['icon']?>" style="float: left;width:20px;height:20px;"><?php L($menu['title']);?></a>

            <?php }}?>
        </div>

        <?php }?>

    </div>
  <!--导航菜单结束-->

</div>
<div data-options="region:'east',split:true,collapsed:true,title:'East'" style="width:100px;padding:10px;">east region</div>
<div data-options="region:'south',border:false" style="height:50px;background:#A9FACD;padding:10px;">south region</div>


<div data-options="region:'center',title:'Center'">
    <!--中间的内容区域，选项卡形式-->
    <div id="tabContainer" class="easyui-tabs" data-options="fit:true,border:false,plain:true,closable:true" style="padding: 5px;">

        <div title="DataGrid" style="padding:5px">

        </div>
    </div>
    <!--内容区域结束-->
</div>

</body>
<script type="text/javascript" src="<?php echo MOUDLE?>/Public/js/moudle/<?php echo CONTROLLER;?>/<?php echo ACTION;?>.js"></script>
</html>