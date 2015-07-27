//存储参数,进行页面跳转的方法,页面上请定义一个全局变量 toURLBase
function toURL(pname, pvalue, maodian, url) {
    maodian = maodian || "";
    url = url || toURLURL;
    var para = eval("({" + pname + ":\"" + pvalue + "\"})");
    jQuery.extend(toURLBase, para);
    var urlPara = jQuery.param(toURLBase);
    if (maodian == "") {
        location.replace(url + urlPara);
    } else {
        location.replace(url + urlPara + "#" + maodian);
    }
}
function toURLS(para, maodian, url) {
    maodian = maodian || "";
    url = url || toURLURL;
    para = para || {};
    jQuery.extend(toURLBase, para);
    var urlPara = jQuery.param(toURLBase);
    if (maodian == "") {
        location.replace(url + urlPara);
    } else {
        location.replace(url + urlPara + "#" + maodian);
    }
}
function addfavor(url, title) {
    if (confirm("网站名称：" + title + "\n网址：" + url + "\n确定添加收藏?")) {
        var ua = navigator.userAgent.toLowerCase();
        if (ua.indexOf("msie 8") > -1) {
            external.AddToFavoritesBar(url, title, ''); //IE8
        } else {
            try {
                window.external.addFavorite(url, title);
            } catch (e) {
                try {
                    window.sidebar.addPanel(title, url, ""); //firefox
                } catch (e) {
                    alert("加入收藏失败，请使用Ctrl+D进行添加");
                }
            }
        }
    }
    return;
}

function SetHome(obj, vrl) {
    try {
        obj.style.behavior = 'url(#default#homepage)'; obj.setHomePage(vrl);
    }
    catch (e) {
        if (window.netscape) {
            try {
                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
            }
            catch (e) {
                alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。");
            }
            var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
            prefs.setCharPref('browser.startup.homepage', vrl);
        }
    }
}
//不定自动比率
function DrawImg(imgId, boxWidth, boxHeight) {

    var imgWidth = $("#" + imgId).width();
    var imgHeight = $("#" + imgId).height();
    //比较imgBox的长宽比与img的长宽比大小
    if ((boxWidth / boxHeight) >= (imgWidth / imgHeight)) {
        //重新设置img的width和height
        $("#" + imgId).width((boxHeight * imgWidth) / imgHeight);
        $("#" + imgId).height(boxHeight);
        //让图片居中显示
        var margin = (boxWidth - $("#" + imgId).width()) / 2;
        $("#" + imgId).css("margin-left", margin);
    }
    else {
        //重新设置img的width和height
        $("#" + imgId).width(boxWidth);
        $("#" + imgId).height((boxWidth * imgHeight) / imgWidth);
        //让图片居中显示
        var margin = (boxHeight - $("#" + imgId).height()) / 2;
        $("#" + imgId).css("margin-top", margin);
    }
}
//固定宽度
function DrawImg1(imgId, boxWidth) {

    var imgWidth = $("#" + imgId).width();
    var imgHeight = $("#" + imgId).height();
    $("#" + imgId).width(boxWidth);
    $("#" + imgId).height((boxWidth * imgHeight) / imgWidth);
    var margin = (boxWidth - $("#" + imgId).width()) / 2;
    $("#" + imgId).css("margin-left", margin);

}
function BindMediaPlay(address, width, height) {
    var so = new SWFObject("/JS/CuPlayerMiniV20_Gray_S.swf", "CuPlayer", width, height, "9", "#000000");
    so.addParam("allowfullscreen", "true");
    so.addParam("allowscriptaccess", "always");
    so.addParam("wmode", "opaque");
    so.addParam("quality", "high");
    so.addParam("salign", "lt");
    so.addVariable("CuPlayerFile", address);
    so.addVariable("CuPlayerShowImage", "true");
    so.addVariable("CuPlayerWidth", width);
    so.addVariable("CuPlayerHeight", height);
    so.addVariable("CuPlayerAutoPlay", "true");
    so.addVariable("CuPlayerAutoRepeat", "true");
    so.addVariable("CuPlayerShowControl", "true");
    so.addVariable("CuPlayerAutoHideControl", "false");
    so.addVariable("CuPlayerAutoHideTime", "6");
    so.addVariable("CuPlayerVolume", "80");
    so.write("CuPlayer");
};
function ShowBaiduDitu(id, x, y) {
    var _doc = window.parent.document;
    var _markerlng = x;
    var _markerlat = y;

    var _Markerlng = x,
            _Markerlat = y;

    var map = new BMap.Map(id);          // 创建地图实例
    var point = new BMap.Point(113.331213, 23.143274);  // 创建点坐标
    if (_Markerlng != 0 && _Markerlat != 0) {
        point = new BMap.Point(_Markerlng, _Markerlat);
        var marker = new BMap.Marker(point);
        marker.enableDragging();
        //        marker.addEventListener("dragend", function(e) {
        //        });
        map.addOverlay(marker);
        //         window.isaddmarker = true;
    }

    map.centerAndZoom(point, 15);                 // 初始化地图，设置中心点坐标和地图级别
    map.enableScrollWheelZoom();
    map.addControl(new BMap.NavigationControl());
    map.addControl(new BMap.ScaleControl());
    map.addControl(new BMap.OverviewMapControl());

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
function GetGetLogin() {
    var _usid = $.cookie("Synlogin");
    $.get("/Handler/GetLogin.ashx",
    { usid: _usid },
     function(data) {
         $("#loginInfo").html(data);
     });
};

function GetUrlPars(){
    var url=location.search;
    var theRequest = new Object();
    if(url.indexOf("?")!=-1)
    {
       var str = url.substr(1);
       strs = str.split("&");
       for(var i=0;i<strs.length;i++)
      {
          var sTemp = strs[i].split("=");
          theRequest[sTemp[0]]=(sTemp[1]);
      }
    }
    return theRequest;
}