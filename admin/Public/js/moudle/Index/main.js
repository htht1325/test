
$(function(){

    $("#tabContainer").tabs({

        onSelect:function(title,index){
            refreshTab(title);

        }
    });

});

function showContent(url,title){

    if($("#tabContainer").tabs('exists',title)){

        $("#tabContainer").tabs('select',title);

        refreshTab(title);

    }else{


        $("#tabContainer").tabs('add',{

            title:title,
            href:url,
            closable:true,

            tools: [{
                iconCls: 'icon-mini-refresh',
                handler: function () {
                    var tt = $('#tabContainer');
                    tt.tabs('select', title);//跳转到指定tab
                    var cruuTab = tt.tabs('getTab', title);//获取到当前tab的title
                    var url = $(cruuTab.panel('options').content).attr('src');//获取当前tab的url
                    tt.tabs('update', {
                        tab: cruuTab,
                        options: {
                            title: title,
                            href: url // the new content URL
                        }
                    });
                }
            }]

        })

    }



}

function refreshTab(title){

    var tt = $('#tabContainer');
    tt.tabs('select', title);//跳转到指定tab
    var cruuTab = tt.tabs('getTab', title);//获取到当前tab的title
    var url = $(cruuTab.panel('options').content).attr('src');//获取当前tab的url
    tt.tabs('update', {
        tab: cruuTab,
        options: {
            title: title,
            href: url // the new content URL
        }
    });
}