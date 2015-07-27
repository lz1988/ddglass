/// <reference path="jquery-1.4.1-vsdoc.js" />
$(document).ready(function() { $("input[type='text'],textarea").bind("focus", function() { $(this).addClass("txt_focus"); }).bind("blur", function() { $(this).removeClass("txt_focus"); }) });
function resolve_url(url) {
    var obj, _obj = "";
    var paraArr = url.substr(1).split("&");
    var count_para = paraArr.length;
    for (var index = 0; index < count_para; index++) {
        var _arr = paraArr[index].split("=");
        _obj += "\"" + _arr[0] + "\"" + ":" + "\"" + _arr[1] + "\","
    }
    obj = "{" + _obj.substr(0, _obj.length - 1) + "}"
    var myObject = eval('(' + obj + ')');
    return myObject;
}
//全删事件
function check_gridview(para, deleid) {
    var ids = null; var Result = new Array();
    if ($("#" + para + " input[@type='checkbox'][@id!='" + deleid + "'][checked]").length > 0) {
        $("#" + para + " input[@type='checkbox'][@id!='" + deleid + "'][checked]").each(function() {
            if ($(this).attr("id") != deleid)
                Result.push($(this).val());
        });
        return Result.toString();
    }
    else {
        alert("您没有选择!");
        return false;
    }
};
//全选操作
function check_all(checkallid, tableid, ff) {
    var colls = $("input[type='checkbox'][id!='" + checkallid + "']", $("#" + tableid));
    var ischecked = $("#" + checkallid).attr("checked");

    ff = ff || ischecked;

    if (ff) {
        colls.attr("checked", "checked");
    }
    else {
        colls.removeAttr("checked");
    }
};
//change url
function chan_url(url) {
    location.href = url;
}
//change url
function open_url(url) {
    var iTop = window.screen.availHeight;
    var iLeft = window.screen.availWidth;
    window.open(url, '', 'menubar=yes,top=0,left=0,width=' + iLeft + ',height=' + iTop);
}
//checkgridview
function ui_check(parameter, deleid, delcontrol, info) {
    var _info = "确认删除吗?";
    if (info != null)
        _info = info;
    var _result = check_gridview(arguments[0], deleid);
    if (_result) {
        if (window.confirm(_info)) {
            $("#" + delcontrol).val(_result);
            return true;
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }
}

function ui_check1(parameter, deleid, delcontrol, info) {
    var _info = "确认删除吗?";
    if (info != null)
        _info = info;
    check_all('checkall', 'rjgl', true)
    var _result = check_gridview(arguments[0], deleid);
    if (_result) {
        if (window.confirm(_info)) {
            $("#" + delcontrol).val(_result);
            return true;
        }
        else {
            check_all('checkall', 'rjgl', false)
            return false;
        }
    }
    else {
        check_all('checkall', 'rjgl', false)
        return false;
    }
    //return false;
}

//checkgridview
function ui_change(parameter, deleid, title, delcontrol) {
    var _result = check_gridview(parameter, deleid);
    if (_result) {
        if (window.confirm(title)) {
            $(delcontrol).val(_result);
            return true;
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }
}
function overtabs(index) {
    $(document).ready(function() {
        var api = $("ul.tabs").data("tabs");
        api.click(index);
    });
};
function unBlock() {
    var _window = window.parent;
    _window.$.unfunkyUI();
};
function document_print() {
    document.WebBrowserwc.ExecWB(7, 1);
}
function check_empty(str) {
    if (str == "") {
        return 0;
    }
    else {
        return parseInt(str);
    }
}
Date.prototype.getTimeUTC = function() {
    return this.getTime() + this.getTimezoneOffset() * 60 * 1000;
}

var CheckInput = {};
CheckInput.regularexpression = {
    regInt: /^[+-]*[1-9]\d*$/,
    regRequested: /^\S+$/
}
CheckInput.inttype = function(opt) {
    if (!CheckInput.regularexpression.regInt.test($(opt.id).val())) {
        alert(opt.message);
        return false;
    }
    else {
        return true;
    }
}
CheckInput.Requested = function(opt) {
    if (!CheckInput.regularexpression.regRequested.test($(opt.id).val())) {
        alert(opt.message);
        return false;
    }
    else {
        return true;
    }
}
Array.prototype.toStr = function() {
    var _list = new Array();
    for (var index = 0; index < this.length; index++) {
        if (this[index] != undefined) { _list.push(this[index]); }
    }
    return _list.join("&nbsp;>&nbsp;");
}
var checkdatatype = new Object();
checkdatatype.intkeyup = function(reevent) {
    var _event = reevent.target || event.srcElement;
    _event.value = _event.value.replace(/[^\d]/g, '');
};
checkdatatype.intbeforepaste = function(reevent) {
    //var _event = reevent.target || event.srcElement;
    //_event.value = _event.value.replace(/[^\d]/g, '');
    clipboardData.setData('text', clipboardData.getData('text').replace(/[^\d]/g, ''))
};
function viewbig(img) {
    window.top.open("/Tree/SourceImg.htm?filepath=" + img);
}
//打開新的窗口
function opwin(url) {
    var newwin = window.open(url, "酒店預訂", "fullscreen");
    return false;
};
//获取两个时间间的天数
function DateDiff(beginDate, endDate) {    //beginDate和endDate都是2007-8-10格式
    var localOffset = (new Date()).getTimezoneOffset() * 60000;
    var arrbeginDate, Date1, Date2, arrendDate, iDays;
    arrbeginDate = beginDate.split("-");
    Date1 = new Date(arrbeginDate[1] + '-' + arrbeginDate[2] + '-' + arrbeginDate[0]);
    arrendDate = endDate.split("-");
    Date2 = new Date(arrendDate[1] + '-' + arrendDate[2] + '-' + arrendDate[0]);
    iDays = parseInt(((Date1 - Date2) - localOffset) / 1000 / 60 / 60 / 24);
    return iDays;
}
// 初始化选择数字
function Initselect(Control, Num) {
    var str = "";
    for (var i = 0; i <= Num; i++) {
        str = "<option value='" + i + "'>" + i + "</option>";
        $(str).appendTo(Control);
    };
};
function block(parajson) {
    tipsWindown(parajson.title, "iframe:" + parajson.url, parajson.w, parajson.h, "true", "", "true", "leotheme");
};
function deletefile(_id) {
    var _result = Ajax.DeleteFileID(_id).value;
    if (_result) {
        $("#" + _id).remove();
    }
}
function checktype(file, allowfiletype, size) {
    var _filevalue = file.value, _v = false;
    var _dot = _filevalue.lastIndexOf(".");
    var _filetype = _filevalue.slice(_dot + 1).toLowerCase();
    if (allowfiletype.indexOf(_filetype) < 0) {
        alert("文件格式不对");
        if (file.outerHTML) {
            file.outerHTML = file.outerHTML;
        }
        else {
            file.value = "";
        }
    }
}
var _txt = "";
function txt_focus(element) {
    alert(element);
    _txt = $(element).val();
    $(element).empty();
};
function txt_onblur(element) {
    $(element).val(_txt);
};
function uploadfile() {
    if ($("#FContain div").length == 0) {
        alert("没有要上传的图片");
        return false;
    }
    var _result = Ajax.UploadFile().value;
    if (_result) alert("上传成功");
    else alert("上传失败");
}
//单个文件上传脚本开始
function onUploadImgChange(sender, _preview, _preview_fake, _preview_size_fake) {
    if (!sender.value.match(/.jpg|.gif|.png|.bmp/i)) {
        alert('图片格式无效！');
        return false;
    }
    $("#" + _preview_fake).show();
    var objPreview = document.getElementById(_preview);
    var objPreviewFake = document.getElementById(_preview_fake);
    var objPreviewSizeFake = document.getElementById(_preview_size_fake);

    if (sender.files && sender.files[0]) {
        objPreview.style.display = 'block';
        objPreview.style.width = 'auto';
        objPreview.style.height = 'auto';

        // Firefox 因安全性问题已无法直接通过 input[file].value 获取完整的文件路径
        objPreview.src = sender.files[0].getAsDataURL();
    } else if (objPreviewFake.filters) {
        // IE7,IE8 在设置本地图片地址为 img.src 时出现莫名其妙的后果
        //（相同环境有时能显示，有时不显示），因此只能用滤镜来解决

        // IE7, IE8因安全性问题已无法直接通过 input[file].value 获取完整的文件路径
        sender.select();
        var imgSrc = document.selection.createRange().text;
        alert(objPreviewFake.filters.item('DXImageTransform.Microsoft.AlphaImageLoader'));
        objPreviewFake.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = imgSrc;
        objPreviewSizeFake.filters.item(
            'DXImageTransform.Microsoft.AlphaImageLoader').src = imgSrc;

        autoSizePreview(objPreviewFake,
            objPreviewSizeFake.offsetWidth, objPreviewSizeFake.offsetHeight);
        objPreview.style.display = 'none';
    }
}
function clearvalue(elementid) {
    _doc = document.getElementById(elementid);
    if (_doc.outerHTML) {
        _doc.outerHTML = _doc.outerHTML;
    }
    else {
        _doc.value = "";
    }
}
function onPreviewLoad(sender) {
    autoSizePreview(sender, sender.offsetWidth, sender.offsetHeight);
}

function autoSizePreview(objPre, originalWidth, originalHeight) {
    var zoomParam = clacImgZoomParam(100, 100, originalWidth, originalHeight);
    objPre.style.width = zoomParam.width + 'px';
    objPre.style.height = zoomParam.height + 'px';
    objPre.style.marginTop = zoomParam.top + 'px';
    objPre.style.marginLeft = zoomParam.left + 10 + 'px';
}

function clacImgZoomParam(maxWidth, maxHeight, width, height) {
    var param = { width: width, height: height, top: 0, left: 0 };

    if (width > maxWidth || height > maxHeight) {
        rateWidth = width / maxWidth;
        rateHeight = height / maxHeight;

        if (rateWidth > rateHeight) {
            param.width = maxWidth;
            param.height = height / rateWidth;
        } else {
            param.width = width / rateHeight;
            param.height = maxHeight;
        }
    }

    param.left = (maxWidth - param.width) / 2;
    param.top = (maxHeight - param.height) / 2;

    return param;
}
//单个文件上传脚本结束
function bindchar(control) {
    var _chars = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
    var _length = 26;
    for (var index = 0; index < _length; index++) {
        $(control).append("<option value=\"" + _chars[index] + "\">" + _chars[index] + "</option>");
    }
}
function SetCwinHeight(obj) {
    var cwin = obj;
    if (document.getElementById) {
        if (cwin && !window.opera) {
            if (cwin.contentDocument && cwin.contentDocument.body.offsetHeight)
                cwin.height = cwin.contentDocument.body.offsetHeight + 20; //FF NS
            else if (cwin.Document && cwin.Document.body.scrollHeight)
                cwin.height = cwin.Document.body.scrollHeight + 10; //IE
        }
        else {
            if (cwin.contentWindow.document && cwin.contentWindow.document.body.scrollHeight)
                cwin.height = cwin.contentWindow.document.body.scrollHeight; //Opera
        }
    }
};
$.fn.extend({
    selection: function() {
        var txt = '';
        var doc = this.get(0).document;
        if (doc) {
            var sel = doc.selection.createRange();
            if (sel.text.length > 0)
                txt = sel.text;
        }
        else if (this.get(0).selectionStart || this.get(0).selectionStart == '0') {
            var s = this.get(0).selectionStart;
            var e = this.get(0).selectionEnd;
            if (s != e) {
                txt = this.get(0).value.substring(s, e);
            }
        }
        return $.trim(txt);
    },
    parseHtml: function(t) {
        var doc = this.get(0).document;
        if (doc) {
            this.get(0).focus();
            doc.selection.createRange().collapse;
            this.get(0).document.selection.createRange().text = t;
        }
        else if (this.get(0).selectionStart || this.get(0).selectionStart == '0') {
            var s = this.get(0).selectionStart;
            var e = this.get(0).selectionEnd;
            var val = this.get(0).value;
            var start = val.substring(0, s);
            var end = val.substring(e);
            this.get(0).value = start + t + end;
        }
    }
});
function chongaddpay() {
    var url = "/api/pay/alipaydefault.aspx";
    if (document.getElementById("isself")) {
        if (document.getElementById("isself").value == "0") {
            url = "/api/alipay/default.aspx";
        }
        else if (document.getElementById("isself").value == "2") {
            url = "/api/suanalipay/default.aspx";
        }
    }
    if (document.getElementById("kindid").value == "1") {
        document.forms[0].target = "_blank";
        document.forms[0].action = url;
    }
    else if (document.getElementById("kindid").value == "2") {
        document.forms[0].action = "/api/chinabank/send.aspx";
    }
    else if (document.getElementById("kindid").value == "3") {
        url = "/api/tenpayzhong/index.aspx";
        if (document.getElementById("isselften").value == "0") {
            document.forms[0].target = "_blank";
            url = "/api/tenpay/index.aspx";
        }
        document.forms[0].target = "_blank";
        document.forms[0].action = url
    }
    else {
        document.forms[0].action = "?action=consumesave";
    }
}

// Initializes a new instance of the StringBuilder class
// and appends the given value if supplied
function StringBuilder(value) {
    this.strings = new Array("");
    this.append(value);
}

// Appends the given value to the end of this instance.
StringBuilder.prototype.append = function(value) {
    if (value) {
        this.strings.push(value);
    }
}

// Clears the string buffer
StringBuilder.prototype.clear = function() {
    this.strings.length = 1;
}

// Converts this instance to a String.
StringBuilder.prototype.toString = function() {
    return this.strings.join("");
};
//返回val的字节长度
function getByteLen(val) {
    var len = 0;
    for (var i = 0; i < val.length; i++) {
        if (val[i].match(/[^x00-xff]/ig) != null) //全角
            len += 2;
        else
            len += 1;
    }
    return len;
}
//返回val在规定字节长度max内的值
function getByteVal(val, max) {
    var returnValue = '';
    var byteValLen = 0;
    for (var i = 0; i < val.length; i++) {
        if (val[i].match(/[^x00-xff]/ig) != null)
            byteValLen += 2;
        else
            byteValLen += 1;
        if (byteValLen > max)
            break;
        returnValue += val[i];
    }
    return returnValue;
}