$.ajaxSetup({
    cache: false
});

//绑定顶部ajax菜单
function navload() {
    $('.nav" a').live("click",
        function () {
            url = $(this).attr("href");
            if (url !== '' && url !== '#') {
                $.get(url, function (result) {
                    $("#nav").html(result);
                });
            }
            return false;
        });
}


//绑定ajax超链接
function hrftload() {
    $('.load a,.url').live("click",
        function () {
            url = $(this).attr("href");
            len = url.substring(url.length - 1, url.length);
            if (len == "" || len == '#') {
                return false;
            }
            ajaxload(url);
            return false;
        });
    $('#nav ul a').live("click", function () {
        $("#nav ul a").parent().removeClass('active');
        $(this).parent().addClass('active');
    });
}


//绑定ajax超链接
function hrftloadleft() {
    $(' a,.url').live("click",
        function () {
            url = $(this).attr("href");
            len = url.substring(url.length - 1, url.length);
            if (len == "" || len == '#') {
                return false;
            }
            ajaxload(url);
            return false;
        });
}


function ajaxload(url) {
    main_load(url);
}
//菜单超链接跳转
function menuload(url) {
    window.top.main_load(url);
}
//绑定表格隔行变色
function livetable() {
}


//提交锁屏
function sub_lock() {
    var txt = '系统正在处理您的请求，请稍后...';

    //IE6位置
    if (!window.XMLHttpRequest) {
        $("#targetFixed").css("top", $(document).scrollTop() + 2);
    }
    //创建半透明遮罩层
    if (!$("#overLay").size()) {
        $('<div id="overLay"></div>').prependTo($("body"));
        $("#overLay").css({
            width: "100%",
            backgroundColor: "#000",
            opacity: 0.1,
            position: "absolute",
            left: 0,
            top: 0,
            zIndex: 99
        }).height($(document).height());
    }
    art.dialog.tips(txt, 60);
}
//锁屏关闭
function sub_lock_close() {
    var txt = '系统已经将您的请求处理完毕！';
    $("#overLay").remove();
    art.dialog.tips(txt, 0);
}

$(document).ready(function () {
    livetable();
})

//ajax提交含有确认提示
function ajaxpost(config, url, data, tip, success, failure, cancel) {
    if (!config.name) {
        var config = {
            name: config,
            url: url,
            data: data,
            tip: tip,
            success: success,
            failure: failure,
            cancel: cancel
        };
    }
    var hintDialog = art.dialog({
        content: config.name,
        lock: true,
        icon: 'warning',
        button: [
            {
                value: '确认操作',
                callback: function () {
                    window.top.sub_lock();
                    $.ajax({
                        type: 'POST',
                        url: config.url,
                        data: config.data,
                        dataType: 'json',
                        success: function (json) {
                            window.top.sub_lock_close();
                            if (config.tip) {
                                art.dialog.tips(json.message, 3);
                            }
                            if (json.status == 1) {
                                if (typeof config.success == "function") {
                                    config.success(json.message);
                                }
                            } else {
                                if (typeof config.failure == "function") {
                                    config.failure(json.message);
                                }
                            }
                        }
                    });
                },
                focus: true
            },
            {
                value: '取消',
                callback: function () {
                    if (typeof config.cancel == "function") {
                        config.cancel();
                    }
                }
            }
        ]
    });
    hintDialog.hidden();
    setTimeout(function () {
        hintDialog.visible();
    }, 150);

}

//ajax提交无确认提示
function ajaxpost_w(config, data, tip, success, failure, msg) {
    if (!config.url) {
        var config = {
            url: config,
            data: data,
            tip: tip,
            success: success,
            failure: failure,
            msg: msg
        };
    }
    art.dialog.tips('系统正在处理您的请求，请稍后...', 3);
    $.ajax({
        type: 'POST',
        url: config.url,
        data: config.data,
        dataType: 'json',
        success: function (json) {
            art.dialog.tips('系统已经将您的请求处理完毕！', 3);
            if (config.tip == 1) {
                art.dialog.tips(json.message, 3);
            }
            if (config.tip == 2 && msg != '') {
                art.dialog.tips(config.msg, 3);
            }
            if (json != null) {
                if (json.status == 1) {
                    if (typeof config.success == "function") {
                        config.success(json.message);
                    }
                } else {
                    if (typeof config.failure == "function") {
                        config.failure(json.message);
                    }
                }
            }
        }
    });
}

//弹出窗口
function urldialog(config, url) {
    if (!config.title) {
        var config = {
            title: config,
            url: url
        };
    }
    if (!config.width) {
        config.width = 640;
    }
    art.dialog.open(
        config.url,
        {
            width: config.width,
            height: config.height,
            padding: config.padding
        }
    );
}

//对话框
function dialog(config) {
    art.dialog.through({
        title: config.title,
        content: config.content,
        lock: true,
        button: config.button
    });
}

//tip
function tip(config) {
    if (!config.time) {
        config.time = 3;
    }
    if (!config.msg) {
        config.msg = '无法处理您的请求！';
    }
    art.dialog.tips(config.msg, config.time);

}


//标准表单保存---数据添加
function addlistform(config, listurl, data) {
    if (!config.addurl) {
        var config = {
            addurl: config,
            listurl: listurl,
            data: data
        };
    }
//$('#form').submit(function() {
    savebutton(0);
    if (typeof config.data == "function") {
        config.data();
    }
    setTimeout(function () {
            $('#form').ajaxSubmit({
                dataType: "json",
                type: 'post',
                success: function (json) {
                    savebutton(1);
                    if (json.status == 0) {
                        //art.dialog(json.message);
                        art.dialog({
                            title: '操作失败',
                            content: json.message
                        });
                        //art.dialog.tips(json.message, 3);
                    } else {
                        var hintDialog = art.dialog({
                            title: '操作成功！',
                            content: json.message + ' 3秒后自动返回列表! ',
                            lock: true,
                            icon: 'succeed',
                            width: 270,
                            height: 80,
                            initialize: function () {
                                this.hidden();
                            },
                            beforeunload: function () {
                                this.hidden();
                                return false;
                            },
                            button: [
                                {
                                    name: '继续添加',
                                    callback: function () {
                                        window.location.href = config.addurl
                                    },
                                    focus: true
                                },
                                {
                                    name: '返回列表',
                                    callback: function () {
                                        window.location.href = config.listurl
                                    }
                                }
                            ]
                        });
                        hintDialog.hidden();
                        setTimeout(function () {
                            hintDialog.visible();
                        }, 150);
                        setTimeout(function () {
                            window.location.href = config.listurl
                        }, 3000);

                    }

                }
            });
        },
        100);
    //return false;
//});
}

//标准表单保存--数据编辑
function savelistform(config, listurl, data) {
    if (!config.addurl) {
        var config = {
            addurl: config,
            listurl: listurl,
            data: data
        };
    }
//$('#form').submit(function() {
    savebutton(0);
    if (typeof config.data == "function") {
        config.data();
    }
    setTimeout(function () {
            $('#form').ajaxSubmit({
                dataType: "json",
                type: 'post',
                success: function (json) {
                    savebutton(1);
                    if (json.status == 0) {
                        art.dialog({
                            title: '操作失败',
                            content: json.message
                        });
                        //art.dialog(json.message);
                        //art.dialog.tips(json.message, 3);
                    } else {
                        var hintDialog = art.dialog({
                            title: '操作成功！',
                            content: json.message + ' 3秒后自动返回列表! ',
                            lock: true,
                            icon: 'succeed',
                            width: 270,
                            height: 80,
                            initialize: function () {
                                this.hidden();
                            },
                            beforeunload: function () {
                                this.hidden();
                                return false;
                            },
                            button: [
                                {
                                    name: '继续编辑',
                                    callback: function () {
                                        window.location.href = config.addurl
                                    },
                                    focus: true
                                },
                                {
                                    name: '返回列表',
                                    callback: function () {
                                        window.location.href = config.listurl
                                    }
                                }
                            ]
                        });
                        hintDialog.hidden();
                        setTimeout(function () {
                            hintDialog.visible();
                        }, 150);
                        setTimeout(function () {
                            window.location.href = config.listurl
                        }, 3000);

                    }

                }
            });
        },
        100);
    //return false;
//});
}


//表单直接保存
function saveform(config, failure) {
    if (!config.success) {
        var config = {
            success: config,
            failure: failure
        };
    }
    $("#form").Validform({
        tiptype: 2,
        callback: function () {
            //提交表单
            savebutton(0);
            if (typeof config.data == "function") {
                config.data();
            }
            setTimeout(function () {
                    $('#form').ajaxSubmit({
                        dataType: "json",
                        success: function (json) {
                            //var last=JSON.stringify(json); //将JSON对象转化为JSON字符
                            //alert(last);
                            savebutton(1);
                            if (json.status == 1) {
                                //alert(json.message);
                                if (typeof config.success == "function") {
                                    config.success(json.message);
                                }
                            } else {
                                alert(json.message);
                                if (typeof config.failure == "function") {
                                    config.failure(json.message);
                                }
                            }
                        }
                    });
                },
                100);
            return false;
        }
    });
}

//按钮锁定
function savebutton(type, id) {
    var type;
    var id;
    if (!id) {
        id = ":submit";
    }
    if (type == 1) {
        txt = $(id).text();
        txt = txt.replace("中...", "");
        $(id).text(txt);
        $(id).removeClass('button_ds');
        $(id).removeAttr("disabled");
    } else {
        $(id).text($(id).text() + '中...');
        $(id).addClass('button_ds');
        $(id).attr("disabled", "disabled");
    }
}


