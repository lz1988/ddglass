// JavaScript Document

$(function () {

    $(".page_nav .li_one").click(function (event) {
        $(this).find(".left_menu").show();
        $(document).one("click", function () {//对document绑定一个影藏Div方法 
            $(".left_menu").hide();
            $(".m_l_main").hide();
            $("a.m_list").removeClass("cur")
        });

        event.stopPropagation();//点击li阻止事件冒泡到document
    });
    $(".left_menu").click(function (event) {
        event.stopPropagation();//在Div区域内的点击事件阻止冒泡到document 
    });

    var aMenuTwo = $(".m_l_main");
    $(".left_menu li").each(function (i) {
        $(this).click(function () {
            if ($(aMenuTwo[i]).css("display") == "block") {
                $(document).one("touchmove", function () {//对document绑定一个影藏Div方法 
                    $(".left_menu").hide();
                    $(".m_l_main").hide();
                    $("a.m_list").removeClass("cur")
                });
                var myScroll,
                    hoverClassRegEx = new RegExp('(^|\\s)iScrollHover(\\s|$)'),
                    removeClass = function () {
                        if (this.hoverTarget) {
                            clearTimeout(this.hoverTimeout);
                            this.hoverTarget.className = this.hoverTarget.className.replace(hoverClassRegEx, '');
                            this.target = null;
                        }
                    };

                function loaded() {
                    myScroll = new iScroll('.wrapper', {
                        onBeforeScrollStart: function (e) {
                            var target = e.target;

                            clearTimeout(this.hoverTimeout);

                            while (target.nodeType != 1) target = target.parentNode;

                            this.hoverTimeout = setTimeout(function () {
                                if (!hoverClassRegEx.test(target.className)) target.className = target.className ? target.className + ' iScrollHover' : 'iScrollHover';
                            }, 80);

                            this.hoverTarget = target;

                            e.preventDefault();
                        },
                        onScrollMove: removeClass,
                        onBeforeScrollEnd: removeClass
                    });
                }

                document.addEventListener('touchmove', function (e) {
                    e.preventDefault();
                }, false);
                document.addEventListener('DOMContentLoaded', loaded, false);

            } else {
                for (var j = 0; j < aMenuTwo.length; j++) {
                    $(aMenuTwo[j]).hide();
                    $(aMenuTwo[j]).siblings("a.m_list").removeClass("cur");

                }
                $(aMenuTwo[i]).show();
                $(this).find("a.m_list").addClass("cur")
            }

        });
    })
})



