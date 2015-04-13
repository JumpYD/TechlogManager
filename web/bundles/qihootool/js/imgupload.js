$(document).ready(function() {
    //添加图片
    var new_image_tpl = '<tr><td></td><td><a class="uploadurl" target="_blank" href=""></a></td>'
                    + '<td><div class="dropzone">请拖放图片到此处或者点击上传!</div></td>'
                    + '<td><input id="" type="file" name="" />'
                    + '<div class="progress hide">上传进度(<span class="percent">0%</span>)' 
                    + '<div class="bar"><div class="value bluebar" style="width: 0%;"></div></div>'
                    + '</div></td>'
                    + '<td class="actions"><a class="img_up" href="">上移</a><a class="img_down" href="">下移</a>'
                    + '<a class="img_del" href="">删除</a></td></tr>';
    
    
    
    //上移
    function image_up() {
        var $tr = $(this).parents("tr:eq(0)");
        var $prevTr = $tr.prev("tr");
        if ($prevTr.length > 0) {
            $tr.insertBefore($prevTr);
        }
        return false;
    }
    //下移
    function image_down() {
        var $tr = $(this).parents("tr:eq(0)");
        var $nextTr = $tr.next("tr");
        if ($nextTr.length > 0) {
            $tr.insertAfter($nextTr);
        }
        return false;
    }
    //删除
    function image_del() {
        var $tr = $(this).parents("tr:eq(0)");
        jConfirm("确定删除吗？", "提示", function(r) {
            if (r) {
                $tr.remove();
            }
        });
        return false;
    }
    
    function bindNewEnt($newTr) {
        $('.img_up', $newTr).click(image_up);
        $('.img_down', $newTr).click(image_down);
        $('.img_del', $newTr).click(image_del);
        $('.dropzone', $newTr).each(initDrop);
        //$newTr.find('.dropzone').each(initDrop);
        $('input:checkbox, input:radio, select.uniformselect, input:file', $newTr).uniform();
    }
    
    //添加新图事件
    bindNewImageEnt = function($addBtn, tpl) {
        $addBtn.click(function() {
            var $this = $(this);
            var $body = $this.parents("div:eq(0)").next("table").find("tbody");
            var $newImgTr = $(tpl);
            var obj = genFileId($body);
            var fileId = obj['uniq_id'];
            var seq = obj['seq'];
            $newImgTr.find(":file").attr("id", fileId).attr("name", fileId);            
            $body.append($newImgTr); //添加tr到末尾
            bindNewEnt($newImgTr);
            //$('input:checkbox, input:radio, select.uniformselect, input:file', $newImgTr).uniform();
            return false;
        });
    }
    
    //图片操作bind
    $('.img_up').click(image_up);
    $('.img_down').click(image_down);
    $('.img_del').click(image_del);
    
    //trId的规则: tableid + _ + seq
    function extractTrId(trId) {
        var reg = /_([0-9]+)$/;
        var group = trId.match(reg);
        return parseInt(group[1]);
    }
    
    //生成唯一的fileId
    function genFileId($body) {
        var tableId = $body.parents("table:eq(0)").attr("id");
        var max = -1;
        $body.find('tr').each(function() {
            var trId = $(this).find(":file").attr("id");
            var seq = extractTrId(trId);
            if (seq > max) {
                max = seq;
            }
        });
        max += 1;
        return {"uniq_id" : tableId + "_" + max, "seq" : max};
    }
    
    // ******************** 上传图片 *****************************
    
    //根据fileId获取对应的dropzone
    function getDropzone(fileId) {
        return $('#' + fileId).parents("tr:eq(0)").find(".dropzone");
    }
    
    //根据fileId获取progress
    function getProgress(fileId) {
        return $('#' + fileId).parents("tr:eq(0)").find(".progress");
    }
    
    //根据fileId获取url
    function getUrl(fileId) {
        return $('#' + fileId).parents("tr:eq(0)").find(".uploadurl");
    }
    
    //根据dropzone获取对应的fileId
    function getFileId($dropzone) {
        return $dropzone.parents("tr:eq(0)").find(":file").attr("id");
    }
    
    //初始化图片上传
    function imgUploadInit(fileId, file) {
        //更新对应的file的文件名
        var $dropzone = getDropzone(fileId);
        $('#' + fileId).siblings(".filename").text(file.name);
        var $image = $('<img/>');            
        var reader = new FileReader();        
        reader.onload = function(e){
            // e.target.result holds the DataURL which
            // can be used as a source of the image:
            $image.attr('src', e.target.result);
        };
        
        // Reading the file as a DataURL. When finished,
        // this will trigger the onload function above:
        reader.readAsDataURL(file);
        $dropzone.empty();
        $dropzone.append($image);
        
        var $progress = getProgress(fileId);
        $progress.show();
        updateProgress($progress, 0);
        return true;
    }
    
    //图片上传完成
    function imgUploadFinish(fileId, response, time) {
        if (response.code != 0) {
            jAlert(response.msg);
            return false;
        }        
        var $url = getUrl(fileId);
        updateUrl($url, response.url);
        
        var $progress = getProgress(fileId);
        updateProgress($progress, 100);
        $progress.hide();
        return true;
    }
    
    //更新url
    function updateUrl($url, url) {
        $url.attr("href", url);
    }
    
    //更新进度条
    function updateProgress($progress, progress) {
        $progress.find(".percent").text(progress + "%");
        $progress.find(".bar > div").width(progress + "%");
    }

    //初始化dropzone函数
    function initDrop() {
        var $this = $(this);
        var fileId = getFileId($this); //根据dropzone获取fileId
        $this.filedrop({
            fallback_id: fileId,   // an identifier of a standard file input element
            url: '/api/imgupload',  // upload handler, handles each file separately, can also be a function returning a url
            paramname: 'img',			// POST parameter name used on serverside to reference file
            error: function(err, file) {
                switch(err) {
                    case 'BrowserNotSupported':
                        jAlert('浏览器不支持拖拽（请用chrome，filefox或者安全浏览器6.0）');
                        break;
                    case 'TooManyFiles':
                        // user uploaded more than 'maxfiles'
                        jAlert("每次只能上传一个文件!");
                        break;
                    case 'FileTooLarge':
                        // program encountered a file whose size is greater than 'maxfilesize'
                        // FileTooLarge also has access to the file which was too large
                        // use file.name to reference the filename of the culprit file
                        jAlert("文件太大(> 20M)");
                        break;
                    case 'FileTypeNotAllowed':
                        jAlert("图片格式不支持（只支持jpg，png和gif）!");
                        // The file type is not in the specified list 'allowedfiletypes'
                    default:
                        jAlert("其他异常(" + err + ")");
                        break;
                }
            },
            allowedfiletypes: ['image/jpeg','image/png','image/gif'],	// filetypes allowed by Content-Type.  Empty array means no restrictions
            maxfiles: 1,
            maxfilesize: 20, 	// max file size in MBs
            uploadStarted: function(i, file, len) {
                // a file began uploading
                // i = index => 0, 1, 2, 3, 4 etc
                // file is the actual file of the index
                // len = total files user dropped
            },
            drop: function() {
            },
            uploadFinished: function(i, file, response, time) {
                // response is the data you got back from server in JSON format.
                return imgUploadFinish(this.fallback_id, response, time);
            },
            progressUpdated: function(i, file, progress) {
                // this function is used for large files and updates intermittently
                // progress is the integer value of file being uploaded percentage to completion
                
            },
            speedUpdated: function(i, file, speed) {
                // speed in kb/s
            },
            beforeSend: function(file, i, done) {
                // file is a file object
                // i is the file index
                // call done() to start the upload
                if (imgUploadInit(this.fallback_id, file)) { //初始化上传展示
                    done();
                }
            },
            afterAll: function() {
                // runs after all files have been uploaded or otherwise dealt with
            }
        });
    };
    
    $('.dropzone').each(initDrop);

});