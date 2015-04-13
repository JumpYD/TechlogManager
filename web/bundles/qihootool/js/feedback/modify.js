$(document).ready(function() {
    //清除form
    function cleanForm() {
        $('#question').val("");
        $('#state').val("");
        $('#process').val("");
        $('#version').val("");
    }
    //创建或者修改应用
    $('#submitForm').submit(function() {
        var id   = $('#entity_id').val();
        var type = $('#type').val();
        var question = $('#question').val();
        if (!question) {
            jAlert("(反馈问题)不能为空!", "提示");
            return false;
        }

        var question = $('#question').val();
        var state    = $('#state').val();
        var process  = $('#process').val();
        var version  = $('#version').val();
        var params   = {
            "id"       : id,
            "question" : question,
            "state"    : state,
            "process"  : process,
            "version"  : version,
            "confirm"  : 1
        };

        var url = GLOBAL_CONF['action_add'];

        $.ajax({
            "url": url,
            "type": "post",
            "data" : params,
            "dataType" : "json",
            "error" : function (jqXHR, textStatus, errorThrown) {
                var errMsg = errorThrown == 'Forbidden' ? "亲，没权限呢!" : "亲，服务器忙!"; jAlert(errMsg, "提示");
            },
            "success" : function (data) {
                if (data['code'] != 0) {
                    jAlert("error: " + data['msg']);
                } else {
                    jAlert("提交成功!", "提示", function() {
                        if (id) {
                            window.close();
                        } else {
                            cleanForm();
                        }
                    });
                }
            }
        });
        return false;
    });
});
