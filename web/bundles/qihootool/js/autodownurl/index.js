$(document).ready(function() {
    var bindEvt = function() {
        //js过滤任务
        $('#select_filter').change(function() {
            var selectMap = {
                "-1" : "",
                "0" : "未开始",
                "1" : "进行中",
                "2" : "成功结束",
                "3" : "失败结束"
            };
            var sel = $(this).val();  
            var selText = selectMap[sel];
            $('#apptable > tbody').find("tr").each(function() {
                var $this = $(this);
                var $stateTd = $this.find("td").eq(4);
                var stateText = $.trim($stateTd.text());
                if (selText == '' || stateText == selText) {
                    $this.show();
                } else {
                    $this.hide();
                }
            });
        });
        
        //删除任务
        $('.j_del').click(function() {
            var $tr = $(this).parents("tr").eq(0);
            var id = $.trim($tr.find("td").eq(0).text());
            var reqUrl = GLOBAL_CONF['action_del'];
            if (!confirm("是否删除？")) {
                return false;
            }
            $.ajax({
                type : "post",
                url : reqUrl,
                data : {"id" : id},
                dataType: "json",
                success : function(data) {
                    if (data['code'] != 0) {
                        alert(data['result']);
                    } else {
                        $tr.remove();
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
            return false;
        });
    }
    
    //添加应用
    $('#urlsub').click(function() {
        var urlStr = $('#url').val();
        if (!urlStr) {
            alert("请输入url!");
            return false;
        }
        var reqUrl = GLOBAL_CONF['action_add'];
        $.ajax({
            type : "post",
            url : reqUrl,
            data : {"url" : urlStr},
            dataType: "json",
            success : function(data) {
                if (data['code'] != 0) {
                    alert(data['result']);
                } else {
                    $('#applist').html(data['result']);
                    bindEvt(); //重新bind事件
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
        return false;
    });
    
    bindEvt(); //初始化绑定事件
});