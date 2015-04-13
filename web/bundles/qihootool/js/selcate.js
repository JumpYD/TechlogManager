//新版的分类选择
var CATE_LIST = {
    "软件" : {
        "系统输入" : ["手机安全", "输入法", "浏览器", "性能优化", "系统工具"],
        "通讯社交" : ["即时聊天", "社区交友", "通话辅助"],
        "影音娱乐" : ["视频", "音乐", "播放器", "娱乐", "直播"],
        "拍摄美化" : ["拍照", "照片美化", "特效"],
        "壁纸主题" : ["桌面", "锁屏", "壁纸", "桌面主题", "锁屏主题", "动态壁纸"],
        "阅读学习" : ["图书阅读", "学习", "考试", "漫画", "资讯", "儿童"],
        "生活地图" : ["天气日历", "购物", "健康医疗", "实用工具", "美食", "地图导航", "旅游出行", "生活服务"],
        "办公理财" : ["效率办公", "记事", "理财", "邮件"],
        "儿童亲子" : ["唱儿歌", "玩游戏", "小学堂", "讲故事", "大百科", "图书馆", "父母学"]
    },
    "游戏" : {
        "休闲游戏" : ["休闲益智", "消除精选", "密室解谜", "音乐节奏"],
        "策略经营" : ["策略塔防", "经营养成"],
        "RPG游戏" : ["角色扮演"],
        "动作冒险" : ["动作格斗", "跑酷狂奔"],   　   　
        "飞行射击" : ["飞行模拟",  "枪械射击"],
        "体育竞技" : ["体育运动", "赛车竞速"],
        "棋牌桌游" : ["精品桌游", "棋牌天地"],
        "网游精品" : ["网络游戏"],
        "模拟辅助" : ["街机模拟", "游戏辅助"]
    },
    "电子书" : {
        "网络原创" : ["玄幻", "言情", "都市", "历史", "军事", "科幻", "竞技", "悬疑", "武侠", "仙侠"],
        "传统图书" : ["传记",  "散文",  "情感", "名著", "惊悚", "哲学", "诗歌", "官场", "法律"],
        "母婴育儿" : ["早教", "胎教", "孕产", "喂养"],
        "教育考试" : ["家庭教育", "教材"],            
        "医药养生" : ["菜谱", "常见病", "生活小窍门", "两性生活"],
        "职场励志" : ["成功法则", "口才", "人脉", "创业"],
        "有声读物" : ["鬼故事", "奇幻", "女生", "幻侠", "游戏", "职场", "生活", "杂谈", "奇闻"],
        "杂志"     : ["新闻", "财经", "时尚", "娱乐", "旅游", "数码", "汽车", "体育"],
        "漫画"     : ["日本", "港台", "欧美", "内地", "全彩", "内涵小漫画"],
        "少儿读物" : ["童话故事", "寓言故事"]  
    }
}

var flag_input = 0;
function getLevel1TD(label, tags) {
    var checkedStr = $.inArray(label, tags) != -1 ? "checked" : "";
    var html = '<td><input id="input_' + (++flag_input) + '" type="checkbox" ' + checkedStr + ' value="' + label + '" class="j_taglv1"></input><label for="input_' + flag_input + '">' + label + '</label></td>';
    return html;
}

function getLevel2TD(labels, tags) {
    var html = '<td>'
    for (var i in labels) {
        var checkedStr = $.inArray(labels[i], tags) != -1 ? "checked" : "";
        html += '<input id="input_' + (++flag_input) + '" type="checkbox" ' + checkedStr + ' value="' + labels[i] + '" class="j_taglv2"></input><label for="input_' + flag_input + '">' + labels[i] + '</label> ';
    }
    html += "</td>";
    return html;
}

function renewSelectItem($target, $tagElem){
    var result = [];
    $target.closest("tr").find("input:checked").each(function(){
        result.push($(this).val()); 
    });
    $tagElem.val(result.reverse().join(" "));
}
function bindCateEvent($tagElem) {
    $('.j_taglv1').click(function() { //一级类操作
        if ($(this).is(":checked")) {
            $(this).closest("tr").siblings().find("input").each(function(){
                this.checked = false;
                $(this).closest("span").removeClass("checked");
            });
            $(this).closest("span").addClass("checked");
            //check_lv1_tag($(this), $tagElem);
        } else {
            $(this).closest("tr").find("input").each(function(){
                this.checked = false;
                $(this).closest("span").removeClass("checked");
            });
            //uncheck_lv1_tag($(this), $tagElem);
        }
        renewSelectItem($(this), $tagElem);
    });
    $('.j_taglv2').click(function() {
        if ($(this).is(":checked")) { //二级类操作
            $(this).closest("tr").siblings().find("input").each(function(){
                this.checked = false;
                $(this).closest("span").removeClass("checked");
            });
            $(this).closest("tr").find("input")[0].checked = true;
            $(this).closest("tr").find("input").eq(0).closest("span").addClass("checked");
            $(this).closest("td").find("input").each(function(){
                this.checked = false;
                $(this).closest("span").removeClass("checked");
            });
            this.checked = true;
            $(this).closest("span").addClass("checked");
            //check_lv2_tag($(this), $tagElem);
        } else {
            $(this).closest("span").removeClass("checked");
            //uncheck_lv2_tag($(this), $tagElem);
        }
        renewSelectItem($(this), $tagElem);
    });
}

//初始化tag表
function initCateTable(cateName, $tagElem, $table) {
    var tagDef = CATE_LIST[cateName];
    if (!tagDef) {
        return false;
    }
    var tag_str = $tagElem.val();
    var tags = tag_str.split(" ");
    var trHtml = "";
    for (var lv2Label in tagDef) {
        trHtml += "<tr>" + getLevel1TD(lv2Label, tags) + getLevel2TD(tagDef[lv2Label], tags) + "</tr>";
    }
    $tbody = $table.find("tbody");
    $tbody.html(trHtml);
    $tbody.find("input").uniform(); //生成统一样式
    bindCateEvent($tagElem);
}

//获取删除后的tag
function get_del_tag(src_tag, mod_tags) {
    var tags = [];
    var src_tag = $.trim(src_tag);
    if (src_tag) {
        src_tags = src_tag.split(" ");
        for (var i = 0; i < src_tags.length; i++) {
            if ($.inArray(src_tags[i], mod_tags) == -1) {
                tags.push(src_tags[i]);
            }
        }
    }
    return tags.join(" ");
}

//获取添加后的tag
function get_add_tag(src_tag, mod_tags) {
    var tags = [];
    var src_tag = $.trim(src_tag);
    if (src_tag) {
        src_tags = src_tag.split(" ");
        tags = $.unique($.merge(src_tags, mod_tags));
    } else {
        tags = mod_tags;
    }
    return tags.join(" ");
}

//点击1级tag
function check_lv1_tag($elem, $tagElem) {
    var mod_tags = [];
    mod_tags.push($elem.val());
    var new_tag = get_add_tag($tagElem.val(), mod_tags);
    //$tagElem.val(new_tag);
    $tagElem.importTags('');
    $tagElem.importTags(new_tag);
}

//取消1级tag
function uncheck_lv1_tag($elem, $tagElem) {
    var $tr = $elem.parents("tr:eq(0)");
    var lv2_td = $tr.find("td:eq(1)");
    var mod_tags = [];
    mod_tags.push($elem.val());
    lv2_td.find("input").each(function() {//对所有二级tag同步取消
        $input = $(this);
        if ($input.is(":checked")) {
            $input.attr("checked", false);
            $input.parent("span").removeClass("checked");
            mod_tags.push($input.val());
        }
    });
    var new_tag = get_del_tag($tagElem.val(), mod_tags);
    //$tagElem.val(new_tag);
    $tagElem.importTags('');
    $tagElem.importTags(new_tag);
}

//点击2级tag
function check_lv2_tag($elem, $tagElem) {
    var $tr = $elem.parents("tr:eq(0)");
    var lv1_td = $tr.find("td:eq(0)");
    var lv1_input = lv1_td.find("input:eq(0)");
    var mod_tags = [];
    mod_tags.push($elem.val());
    if (!lv1_input.is(":checked")) { //同步添加1级
        lv1_input.attr("checked", true);
        lv1_input.parent("span").addClass("checked");
        mod_tags.push(lv1_input.val());
    }
    var new_tag = get_add_tag($tagElem.val(), mod_tags);
    //$tagElem.val(new_tag);
    $tagElem.importTags('');
    $tagElem.importTags(new_tag);
}

//取消2级tag
function uncheck_lv2_tag($elem, $tagElem) {
    var $td = $elem.parents("td:eq(0)");
    var $tr = $td.parents("tr:eq(0)");
    var lv1_td = $tr.find("td:eq(0)");
    var lv1_input = lv1_td.find("input:eq(0)");
    var mod_tags = [];
    mod_tags.push($elem.val());
    var len = $td.find("input:checked").length;
    if (len == 0) { //如果只有0，则需要将父级别同步取消
        lv1_input.attr("checked", false);
        lv1_input.parent("span").removeClass("checked");
        mod_tags.push(lv1_input.val());
    }
    var new_tag = get_del_tag($tagElem.val(), mod_tags);
    //$tagElem.val(new_tag);
    $tagElem.importTags('');
    $tagElem.importTags(new_tag);
}
