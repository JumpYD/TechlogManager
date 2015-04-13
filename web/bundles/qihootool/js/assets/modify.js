$(document).ready(function() {
    var datetimeConfig = {
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
        showSecond: true
    };
    $('#returnTime').datetimepicker(datetimeConfig);

    //清除form
    function cleanForm() {
        $('#type').val("");
        $('#brand').val("");
        $('#modelType').val("");
        $('#state').val("");
        $('#memory').val("");
        $('#identifier').val("");
        $('#sn').val("");
        $('#imei').val("");
        $('#sdcard').val("");
        $('#dataline').val("");
        $('#power').val("");
        $('#battery').val("");
        $('#earline').val("");
        $('#guarantee').val("");
        $('#other').val("");
        $('#department').val("");
        $('#owner').val("");
        $('#whouse').val("");
        $('#returnTime').val("");
        $('#returnState').val("");
        $('#note').val("");
    }
    //创建或者修改应用
    $('#submitForm').submit(function() {
        var id = $('#entity_id').val();
        var modelType = $('#modelType').val();
        if (!modelType) {
            jAlert("(型号)不能为空!", "提示");
            return false;
        }
        var brand = $('#brand').val();
        if (!brand) {
            jAlert("(品牌)不能为空!", "提示");
            return false;
        }
        var identifier = $('#identifier').val();
        if (!identifier) {
            jAlert("(机器资产编号)不能为空!", "提示");
            return false;
        }
        var sn = $('#sn').val();
        var imei = $('#imei').val();
        if (!sn || !imei) {
            jAlert("(S/N 或 IMEI)不能为空!", "提示");
            return false;
        }
        var type = $('#type').val();
        var state = $('#state').val();
        var memory = $('#memory').val();
        var sdcard = $('#sdcard').val();
        var dataline = $('#dataline').val();
        var earline = $('#earline').val();
        var guarantee = $('#guarantee').val();
        var other = $('#other').val();
        var department = $('#department').val();
        var owner = $('#owner').val();
        var whouse = $('#whouse').val();
        var returnTime = $('#returnTime').val();
        var returnState = $('#returnState').val();
        var note = $('#note').val();
        var params = {
            "id" : id,
            "type" : type,
            "brand" : brand,
            "modelType" : modelType,
            "state" : state,
            "memory" : memory,
            "identifier" : identifier,
            "sn" : sn,
            "imei" : imei,
            "sdcard" : sdcard,
            "dataline" : dataline,
            "earline" : earline,
            "guarantee" : guarantee,
            "other" : other,
            "department" : department,
            "owner" : owner,
            "whouse" : whouse,
            "returnTime" : returnTime,
            "returnState" : returnState,
            "note" : note,
            "confirm" : 1
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
