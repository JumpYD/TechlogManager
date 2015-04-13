// ******************** 全新的采用fileupload （更新函数请采用updateCallback方式） *****************************
function initApkUpload($apkFile, $apkDropzone, updateCallback) {
    $($apkFile).fileupload({
        dropZone: $apkDropzone,
        url: '/api/apkupload',
        dataType: 'json',
        done: function (e, data) {
            var result = data.result;
            if (result['code'] != 0) {
                $apkDropzone.html('文件处理失败:' + result['msg']);
            } else {
                var info = result['info'];
                updateCallback(info);
                $apkFile.siblings(".filename").text(info['name']);
                $apkDropzone.html("文件处理完毕!");
            }
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#apk_percent').text(progress + "%");
            $('#apk_bar').css('width', progress + "%");
            if (progress == 100) {
                $apkDropzone.html("文件已上传，服务器正在处理中，请稍等...");
            }
        }
    });
    
    //拖动改变颜色
    $(document).bind('dragover', function (e) {
        var dropZone = $apkDropzone,
            timeout = window.dropZoneTimeout;
        if (!timeout) {
            dropZone.addClass('in');
        } else {
            clearTimeout(timeout);
        }
        if (e.target === dropZone[0]) {
            dropZone.html("请释放文件!");
            dropZone.addClass('hover');
        } else {
            dropZone.html("请拖放apk包到此处或者点击右侧上传!");
            dropZone.removeClass('hover');
        }
        window.dropZoneTimeout = setTimeout(function () {
            window.dropZoneTimeout = null;
            dropZone.removeClass('in hover');
        }, 100);
    });
}
