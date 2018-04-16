<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php L('login-title')?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo MOUDLE?>/Public/js/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo MOUDLE?>/Public/js/themes/icon.css">
    <script type="text/javascript" src="<?php echo MOUDLE?>/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo MOUDLE?>/Public/js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?php echo MOUDLE?>/Public/js/locale/easyui-lang-zh_CN.js"></script>
</head>
<body>

<div id="win" class="easyui-window" title="<?php L('login-title')?>" style="width:300px;height:200px;" data-options="iconCls:'icon-tip',modal:true,closable:false">
    <form style="padding:10px 20px 10px 40px;" id="userform" action="index.php?m=admin&c=index&a=login" method="post">
        <p>用户名: <input class="easyui-textbox" type="text" name="name" required="true"></p>
        <p>密&nbsp;&nbsp;&nbsp;码: <input class="easyui-textbox" type="password" name="userpwd" required="true"></input></p>
        <p>验证码: <input class="easyui-textbox" type="text" name="vcode"  style="width: 60px;" data-options="required:true"></input><image src="index.php?m=admin&c=util&a=createVcode" style="float: right;cursor:pointer" onclick=this.src=this.src></p>
        <div style="padding:5px;text-align:center;">
            <a href="javascript:userLogin();" class="easyui-linkbutton" icon="icon-ok">提交</a>
            <a href="#" class="easyui-linkbutton" icon="icon-cancel">重置</a>
        </div>
    </form>
</div>
</body>
<script>

    function userLogin(){

        $('#userform').form({
            url:'index.php?m=admin&c=index&a=login',
            onSubmit:function(){
                return $(this).form('validate');
            },
            success:function(data){
                $.messager.alert('Info', data, 'info');
            }
        });

        $("#userform").submit();

    }

</script>
</html>

