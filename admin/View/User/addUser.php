
<br>

    <form id="userform" method="post">


        <table style="padding-left:10px;border:1px solid #9cc8f7;width: 100%">
           <tr><td>用户名:</td><td><input class="easyui-textbox" type="text" name="name" required="true"></td></tr>
            <tr><td>出生年月:</td><td><input class="easyui-datebox" required="true" name="birthday"></td></tr>
            <tr><td>性别:</td><td><select class="easyui-combobox" style="width:100px;" name="sex"><option value="男">男</option> <option value="女">女</option></select></td></tr>
            <tr><td>手机号码:</td><td><input class="easyui-numberbox" required="true" name="mobile"></td></tr>
            <tr><td>个人简介:</td><td><textarea id="myeditor" style="width:600px;height:400px;" name="personinfo"></textarea><input type="hidden" name="pinfo" id="pinfo"> </td></tr>
            <tr><td colspan="2">


                    <div style="padding:5px;text-align:center;">
                        <a href="javascript:addUserPost();" class="easyui-linkbutton" icon="icon-ok">提交</a>&nbsp;&nbsp;
                        <a href="#" class="easyui-linkbutton" icon="icon-cancel">重置</a>
                    </div>
                </td></tr>
        </table>


    </form>

<script type="text/javascript" src="<?php echo MOUDLE?>/Public/js/moudle/<?php echo CONTROLLER;?>/<?php echo ACTION;?>.js"></script>



