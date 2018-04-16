$(function() {
    var editor;
    window.editor = KindEditor.create('#myeditor', {
        resizeType: 1,
        urlType: 'domain', // 带有域名的绝对路径
    });
});


function addUserPost(){

    $("#pinfo").val(editor.html());

    $("#userform").form('submit',{
        url:'index.php?m=admin&c=user&a=addUser',
        success:function(data){
            $.messager.alert('Info', data, 'info');
        }

    });

}