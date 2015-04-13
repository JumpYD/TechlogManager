$(document).ready(function() {
    $( "#datepickfrom, #datepickto" ).datepicker();
    var showProgress = function() {
        $('#loaders').show();
    }
    var hideProgress = function() {
        $('#loaders').hide();
    }
   
    var datetimeConfig = {
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
        showSecond: true
    };
    
    hideProgress();
    
    var getParams = function() {
       var begin = $.trim($('#datepickfrom').val());
       var end = $.trim($('#datepickto').val());
       
       var params = {
           "begin" : begin,
           "end" : end,
       };
       return params;
    }
    
    $('#queryform').submit(function() {
       var params = getParams();
       var url = GLOBAL_CONF['action_query'];
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
                bindEvt(true);
            }
        });
       return false; 
    });
    
    //查询结果(page为0表示当前页)
    var queryResult = function(page) {
        if (!page) {
            page = $('#page').val();
        }
        var params = getParams();
        params["page"] = page;
        params["page_size"] = $('#page_size').val();
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
        //分页
        $('.pagination').jqPagination({
            current_page: $('#page').val(),
            max_page: $('#totalPages').val(),
            page_string: '当前页 {current_page} 共 {max_page} 页', 
            paged: function(page) {
                queryResult(page);
            }
        });
    };
    
    bindEvt(false);
    
})