
<body>
<br>
<table id="usertable" class="easyui-datagrid" style="width:100%;height:auto;text-align-all: center";
       data-options="title:'人员信息列表',singleSelect:false,collapsible:true,url:'index.php?m=admin&c=user&a=userlist',method:'post',align:'center'" toolbar="#tb" pagination="true">
    <thead>
    <tr>
        <th data-options="field:'ck',checkbox:true"><input type="checkbox" id="ckAll" name="DataGridCheckbox" /></th>
        <th data-options="field:'id',width:80,align:'center'">用户id</th>
        <th data-options="field:'username',width:100,align:'center'"">用户名</th>
        <th data-options="field:'sex',width:80,align:'right',align:'center'"">性别</th>
        <th data-options="field:'age',width:80,align:'right',align:'center'"">年龄</th>
        <th data-options="field:'mobile',width:80,align:'right',align:'center'"">手机号码</th>
        <th data-options="field:'regdate',width:250,align:'center'"">注册时间</th>
    </tr>
    </thead>
</table>

<div id="tb" style="padding:3px">
    <div>

        <a href="javascript:addUser();" class="easyui-linkbutton" plain="true" onclick="doSearch()" icon="icon-add">新增用户</a>

    </div>
    <span>信息查询:</span>
    <span>姓名:</span>
    <input id="itemid" style="line-height:20px;border:1px solid #ccc">
    <span>手机号码:</span>
    <input id="productid" style="line-height:20px;border:1px solid #ccc">
    <a href="#" class="easyui-linkbutton" plain="true" onclick="" icon="icon-search">Search</a>
</div>
<!--弹出窗口-->
<div id="userwin" class="easyui-window" title="<?php L('login-title')?>" style="width:800px;height:450px;" data-options="iconCls:'icon-tip',modal:true,closable:true,closed:true">
<form style="padding:10px 20px 10px 40px;" id="userform" action="index.php?m=admin&c=index&a=login" method="post">



    <div style="padding:5px;text-align:center;">
        <a href="javascript:userLogin();" class="easyui-linkbutton" icon="icon-ok">提交</a>
        <a href="#" class="easyui-linkbutton" icon="icon-cancel">重置</a>
    </div>
</form>
</div>

<script>

    function addUser(){

        $("#tabContainer").tabs('add',{
            title:'添加人员',
            closable:true,
            href:'index.php?m=admin&c=user&a=addUser'
        })

    }

</script>

<script>

    $(function(){

        $('.datagrid-cell').css("text-align","center"); //使表头居中

        $("#uploadFile").uploadify({
            'swf':'./<?php echo MOUDLE?>/Public/js/uploadify/uploadify.swf',
            'uploader':'index.php?m=admin&c=util&a=uploadFile',
            'height':30,
            'width':100,
            'fileObjName':'uploadify',
            'multi':true,
            'auto':true,
            'buttonText':'选择文件',
            'buttonCursor':'hand',
            'debug':false,
            'cancelImg':'./<?php echo MOUDLE?>/Public/js/uploadify/cancel.png',
            'fileTypeExts':'*.jpg;*gif;*.pdf',
            'formData': {
                'timestamp': '<?php $timestamp = time();echo $timestamp;?>',
                'token': '<?php echo md5('unique_salt' . $timestamp);?>'
            },
            'method':'post',

            'onUploadSuccess': function(file,data){


                if(data==1){

                    $.messager.alert('消息', 'id: ' + file.id
                        + ' - 索引: ' + file.index
                        + ' - 文件名: ' + file.name
                        + ' - 文件大小: ' + file.size
                        + ' - 类型: ' + file.type
                        + ' - 创建日期: ' + file.creationdate
                        + ' - 修改日期: ' + file.modificationdate
                        + ' - 文件状态: ' + file.filestatus
                    );
                }


            }

        });


    });
</script>

</body>


</html>
