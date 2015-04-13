$(document).ready(function() {
    var showProgress = function() {
        $('#loaders').show();
    }
    var hideProgress = function() {
        $('#loaders').hide();
    }

    hideProgress();

    var getParams = function() {
       var brand      = $.trim($('#brand').val());
       var modelType  = $.trim($('#modelType').val());
       var department = $.trim($('#department').val());
       var owner      = $.trim($('#owner').val());
       var params     = {
           "brand"     : brand,
           "modelType" : modelType,
           "department": department,
           "owner"     : owner,
       };

       return params;
    }

    $('#queryform').submit(function() {
       var params = getParams();
       var url = GLOBAL_CONF['action_query'];
       var exportUrl = GLOBAL_CONF['action_export'] + '?';

       for (x in params) {
           exportUrl = exportUrl + x + '=' + params[x] + '&';
       }

       showProgress();

       $.ajax({
            "url": url,
            "type": "post",
            "data" : params,
            "dataType" : "html",
            "error" : function (jqXHR, textStatus, errorThrown) {
                hideProgress();
                var errMsg = errorThrown == 'Forbidden' ? "亲，没权限呢!" : "亲，服务器忙!"; jAlert(errMsg, "提示");
            },
            "success" : function (data) {
                hideProgress();
                $("#query_result").html(data);
                $("#queryform_export").attr("href", exportUrl);
                bindEvt(true);
            }
        });

       return false;
    });

    //查询结果(page为0表示当前页)
    var queryResult = function(page) {
        if (!page) {
            page = $('#p').val();
        }
        var params = getParams();
        params["p"] = page;
        params["pn"] = $('#pn').val();

        showProgress();

        var url = GLOBAL_CONF['action_query'];
        $.ajax({
            "url": url,
            "type": "post",
            "data" : params,
            "dataType" : "html",
            "error" : function (jqXHR, textStatus, errorThrown) {
                hideProgress();
                var errMsg = errorThrown == 'Forbidden' ? "亲，没权限呢!" : "亲，服务器忙!"; jAlert(errMsg, "提示");
            },
            "success" : function (data) {
                $("#query_result").html(data);
                hideProgress();
                bindEvt(true);
            }
        });
    }

    //bind分页及其他事件
    var bindEvt = function(needUniform) {
        //对bind的页面样式处理
        if (needUniform) {
            $("#query_result").find('input:checkbox, input:radio, select.uniformselect, input:file').uniform();
        }

        //删除
        $('.app_delete').click(function() {
            var id = $(this).parents("tr:eq(0)").find("td:eq(0)").text();
            var url = GLOBAL_CONF['action_delete'];
            jConfirm("是否删除?", "提示", function(r) {
                if (!r) {
                    return false;
                }
                $.ajax({
                    "url": url,
                    "type": "post",
                    "data" : {"id" : id},
                    "dataType" : "json",
                    "error" : function (jqXHR, textStatus, errorThrown) {
                        var errMsg = errorThrown == 'Forbidden' ? "亲，没权限呢!" : "亲，服务器忙!"; jAlert(errMsg, "提示");
                    },
                    "success" : function (data) {
                        if (data['code'] != 0) {
                            jAlert("error: " + data['msg'], "提示");
                        } else {
                            queryResult(0);
                        }
                    }
                });
            });

            return false;
        });

        //分页
        $("#pager").paginate({
            count: $('#totalPages').val(),
            start: $('#p').val(),
            display: $('#pn').val(),
            border_color: '#CCCCCC',
            text_color: '#666666',
            background_color: '#EDEDED',
            border_hover_color: '#71ad69',
            text_hover_color: '#FFFFFF',
            background_hover_color: '#71ad69',
            onChange: function(page) {
                queryResult(page);
            }
        });
    };

    bindEvt(false);

})
