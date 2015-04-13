$(document).ready(function() {
    var showProgress = function() {
        $('#loaders').show();
    }
    var hideProgress = function() {
        $('#loaders').hide();
    }

    hideProgress();

    var getParams = function() {
       var md5 = $.trim($('#md5').val());
       var frm = $.trim($('#frm').val());
       var state = $.trim($('#state').val());
       var params = {
           "md5" : md5,
           "frm"   : frm,
           "state"  : state
       };

       return params;
    }
    
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
                var errMsg = errorThrown == 'Forbidden' ? "亲，没权限呢!" : "亲，服务器忙!";jAlert(errMsg, "提示");
            },
            "success" : function (data) {
                $("#query_result").html(data);
                hideProgress();
                bindEvt(true);
            }
        });
    }

    $('#queryform').submit(function() {
       queryResult(1);// 显示第一页的结果
       return false;
    });

    //bind分页及其他事件
    var bindEvt = function(needUniform) {
        //对bind的页面样式处理
        if (needUniform) {
            $("#query_result").find('input:checkbox, input:radio, select.uniformselect, input:file').uniform();
        }

        //分页
        $('.pagination').jqPagination({
            current_page: $('#p').val(),
            max_page: $('#totalPages').val(),
            page_string: '当前页 {current_page} 共 {max_page} 页', 
            paged: function(page) {
                // do something with the page variable
                queryResult(page);
            }
        });
    };

    bindEvt(false);

})
