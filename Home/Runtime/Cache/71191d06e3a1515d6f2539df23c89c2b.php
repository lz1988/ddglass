<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE  html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,width=device-width,initial-scale=1.0"/>
        <title><?php echo ($seo_title); ?></title>
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/Home/css/style.css" />
        <link rel="stylesheet" href="__ROOT__/Public/Home/css/font-awesome.min.css" />
        <script src="__PUBLIC__/Home/js/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=nBUMHeVema0heWoVAdd895TX"></script>
        <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script src="__PUBLIC__/Home/js/cityTransport1.js"></script>
        <script src="__PUBLIC__/Home/js/zepto.js"></script>
        <script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script>
        <style type="text/css">
            .progressBar { position: absolute; top: 45%; left: 30%;width:40%; padding: 8px; background-color: white; z-index:1002; overflow: auto;
            }
            .progressBar p{
                text-align:center
            }
        </style>
        <script type="text/javascript">
            var exp = new Date();
            var shangjiaStr = '';
            var p = 0;
            var paixuStr = '';
            var fuwuStr = '';
            var fenbuStr = '';
            var txt = '';
            var url = location.search;
            /****微信经纬度获取开始**/
            wx.config({
                debug: false, //这里是开启测试，如果设置为true，则打开每个步骤，都会有提示，是否成功或者失败
                appId: '<?php echo ($signPackage[appId]); ?>',
                timestamp: '<?php echo ($signPackage[timestamp]); ?>', //这个一定要与上面的php代码里的一样。
                nonceStr: '<?php echo ($signPackage[nonceStr]); ?>', //这个一定要与上面的php代码里的一样。
                signature: '<?php echo ($signPackage[signature]); ?>',
                jsApiList: [
                    // 所有要调用的 API 都要加到这个列表中
                    'checkJsApi',
                    //'onMenuShareTimeline',
                    //'onMenuShareAppMessage',
                    //'onMenuShareQQ',
                    //'onMenuShareWeibo',
                    'openLocation',
                    'getLocation'
                ]
            });
            wx.error(function(res) {
            });

            function mygetlocation()
            {
                topDiv("on");
//                wx.ready(function() {
//                    wx.getLocation({
//                        success: function(res) {
//                            var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
//                            var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
//                            gpsToBaidu(latitude, longitude);
//                        },
//                        fail: function() {
//                            //调用百度gps
//                            var geolocation = new BMap.Geolocation();
//                            geolocation.getCurrentPosition(function(r) {
//                                if (this.getStatus() === BMAP_STATUS_SUCCESS) {
//                                    changevalues(r.point.lat, r.point.lng);
//                                } else {
//                                    changevalues("22.531179", "113.935259");
//                                }
//                            }, {enableHighAccuracy: true});
//
//                        }
//                    });
//                });

                var geolocation = new BMap.Geolocation();
                geolocation.getCurrentPosition(function(r) {
                    if (this.getStatus() === BMAP_STATUS_SUCCESS) {
                        changevalues(r.point.lat, r.point.lng);
                    } else {
                        changevalues("22.531179", "113.935259");
                    }
                }, {enableHighAccuracy: true});

            }

            //gps坐标点转化
            var gpsToBaidu = function(lats, lons) {
                var gpsPoint = new BMap.Point(lons, lats);
                BMap.Convertor.translate(gpsPoint, 0, function(p) {
                    changevalues(p.lat, p.lng);
                });
            };
            function changevalues(lat, lng)
            {
                getCity(lat, lng);
                localStorage.lat = lat;
                localStorage.lon = lng;
                var exp = new Date();
                localStorage.expires = exp.getTime();
                topDiv("off");
            }

            //城市回调

            function getCity(lat, lng) {
                // var cityName = result.name;
                // localStorage.city = cityName;
                //  $(".city>span").html(localStorage.city);

                $.ajax({
                    type: "GET",
                    url: "__URL__/getCity",
                    data: {lat: lat, lng: lng},
                    dataType: "json",
                    async: false,
                    success: function(o) {
                        $(".city>span").html(o.result.addressComponent.city);
                        $("#rego").html(o.result.addressComponent.city);
                        localStorage.city = o.result.addressComponent.city;
                        localStorage.gpscity = o.result.addressComponent.city;
                        localStorage.province = o.result.addressComponent.province;
                        localStorage.district = o.result.addressComponent.district;
                        localStorage.street = o.result.addressComponent.street;
                        localStorage.street_number = o.result.addressComponent.street_number;
                    },
                    error: function(o) {

                    }
                });

            }

            //进程显示层
            var topDiv = function(status) {
                if (status === "on") {
                    $(".main_index_h").hide();
                    $('.mask_index').show();
                    $(".main_index_con").html("GPS定位中.....");
                    $(".main_index_con").html("<div class='progressBar'><p>GPS定位中.....</p></div>");
                    p = 0;
                }
                if (status === "off") {
                    $(".main_index_con").html("");
                    $(".main_index_h").show();
                    $('.mask_index').hide();
                    p = 0;

                    mainfn();
                }
            };

            function myurl() {
                var p = 0;
                var url = '__URL__/get_shop_list';
                url += '?&sort=' + paixuStr + '&distribute=' + fenbuStr + '&serve=' + fuwuStr + '&youhui=' + shangjiaStr + '&lat=' + localStorage.lat + '&lon=' + localStorage.lon + '&city=' + localStorage.city + '&p=' + p++,
                        //经纬判断正确开始执行
                        // alert(localStorage.lon);
                        toUrl(url);
            }


            function toUrl(url) {
                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'json',
                    async: false,
                    success: function(data) {
                        var html = '';
                        if (data) {
                            for (var i = 0; i < data.length; i++) {

                                var htmls = '';
                                if (data[i].shop_activity === '') {
                                    htmls = "";
                                } else {
                                    s = data[i].shop_activity;

                                    s = s.substring(0, s.length - 1);
                                    var strs = new Array();
                                    strs = s.split(",");
                                    $.each(strs, function(index, tx) {
                                        if (tx == 0) {
                                            // alert(tx);
                                            htmls += "<span>减 </span>";
                                        }
                                        if (tx == 1) {
                                            //alert(tx);
                                            htmls += "<span>折</span>";
                                        }
                                        if (tx == 2) {
                                            //alert(tx);
                                            htmls += "<span>送</span>";
                                        }

                                    });
                                }
                                if (parseInt(data[i].all_score).toFixed(1) == "0.0") {
                                    var urlImages = '<img class="star" src="__PUBLIC__/Home/images/006.png"/>';
                                }
                                if (parseInt(data[i].all_score).toFixed(1) == "1.0") {
                                    var urlImages = '<img class="star" src="__PUBLIC__/Home/images/001.png"/>';
                                }
                                if (parseInt(data[i].all_score).toFixed(1) == "2.0") {
                                    var urlImages = '<img class="star" src="__PUBLIC__/Home/images/002.png"/>';
                                }
                                if (parseInt(data[i].all_score).toFixed(1) == "3.0") {
                                    var urlImages = '<img class="star" src="__PUBLIC__/Home/images/003.png"/>';
                                }
                                if (parseInt(data[i].all_score).toFixed(1) == "4.0") {
                                    var urlImages = '<img class="star" src="__PUBLIC__/Home/images/004.png"/>';
                                }
                                if (parseInt(data[i].all_score).toFixed(1) == "5.0") {
                                    var urlImages = '<img class="star" src="__PUBLIC__/Home/images/005.png"/>';
                                }
                                html += '<a href="__URL__/shop_detail/id/' + data[i].id + '"><dl class="clearfix">' +
                                        '<dt>' +
                                        '<img src="/' + data[i].shop_images + '">' +
                                        '</dt>' +
                                        '<dd>' +
                                        '<h3>' + data[i].name + '</h3>' +
                                        '<div class="comment">' +
                                        '<span>评价' + '<i>' + data[i].num + '</i>' + '条</span><span>' + urlImages + '</span>' +
                                        '</div>' +
                                        '<div class="area">' +
                                        '<span>' + data[i].addr + '</span>' +
                                        //'<span>'+111111+'</span>'+
                                        '</div>' +
                                        '<div class="tips">' +
                                        '<div>' +
                                        htmls +
                                        '</div>' +
                                        '<p>&lt; ' + '<span>' + data[i].juli + '</span>km</p>' +
                                        '</div>' +
                                        '</dd>' +
                                        '</dl></a>';
                            }
                        }
                        $('.main_index_con').html(html);
                    }
                });
            }
            ;

            //向下滑动加载列表数据
            // var p = 0; //当前页数为第一页

            function mainfn() {
                var fuwu = $('#fuwuStr').val();
                var fenbu = $('#fenbuStr').val();
                var paixu = $('#paixuStr').val();
                var youhui = $('#shangjiaStr').val();
                if (url.indexOf('act=1') > -1) {
                    youhui = 1;
                    $('#all').removeClass('cur');
                    $('#discount').addClass('cur');
                }
                if (url.indexOf('act=2') > -1) {
                    txt = '免费调洗';
                    /*  $('#sort_btn1').html(txt + '<i></i>'); */
                    $('#sort_btn1').addClass('cur');
                    $('#fuwuStr').val("");
                    fuwu = '';
                }
                if (url.indexOf('act=3') > -1) {
                    txt = '有售隐形';
                    $('#sort_btn1').html(txt + '<i></i>');
                    $('#yinxing').addClass('cur');
                    $('#fuwuStr').val("17");
                    fuwu = 17;

                }
                $.ajax({
                    url: '__URL__/get_shop_list',
                    type: 'get',
                    dataType: 'json',
                    async: false,
                    data: '&sort=' + paixu + '&distribute=' + fenbu + '&serve=' + fuwu + '&youhui=' + youhui + '&lat=' + localStorage.lat + '&lon=' + localStorage.lon + '&city=' + localStorage.city + '&p=' + p++,
                    success: function(data) {
                        //     alert(data);
                        //     alert( '__URL__/get_shop_list &sort=' + paixu + '&distribute=' + fenbu + '&serve=' + fuwu + '&youhui=' + shangjiaStr + '&lat=' + localStorage.lat + '&lon=' + localStorage.lon + '&city=' + localStorage.city + '&p=' + p++);
                        var html = '';
                        if (data) {
                            for (var i = 0; i < data.length; i++) {
                                var htmls = '';
                                if (data[i].shop_activity == '') {
                                    htmls = "";
                                } else {
                                    s = data[i].shop_activity;

                                    s = s.substring(0, s.length - 1);
                                    var strs = new Array();
                                    strs = s.split(",");
                                    $.each(strs, function(index, tx) {
                                        if (tx == 0) {
                                            // alert(tx);
                                            htmls += "<span>减 </span>";
                                        }
                                        if (tx == 1) {
                                            //alert(tx);
                                            htmls += "<span>折</span>";
                                        }
                                        if (tx == 2) {
                                            //alert(tx);
                                            htmls += "<span>送</span>";
                                        }

                                    });
                                }
                                if (parseInt(data[i].all_score).toFixed(1) == "0.0") {
                                    var urlImages = '<img class="star" src="__PUBLIC__/Home/images/006.png"/>';
                                }
                                if (parseInt(data[i].all_score).toFixed(1) == "1.0") {
                                    var urlImages = '<img class="star" src="__PUBLIC__/Home/images/001.png"/>';
                                }
                                if (parseInt(data[i].all_score).toFixed(1) == "2.0") {
                                    var urlImages = '<img class="star" src="__PUBLIC__/Home/images/002.png"/>';
                                }
                                if (parseInt(data[i].all_score).toFixed(1) == "3.0") {
                                    var urlImages = '<img class="star" src="__PUBLIC__/Home/images/003.png"/>';
                                }
                                if (parseInt(data[i].all_score).toFixed(1) == "4.0") {
                                    var urlImages = '<img class="star" src="__PUBLIC__/Home/images/004.png"/>';
                                }
                                if (parseInt(data[i].all_score).toFixed(1) == "5.0") {
                                    var urlImages = '<img class="star" src="__PUBLIC__/Home/images/005.png"/>';
                                }

                                if (data[i].shop_images=="") {
                                    var shop_images = "./Uploads/shop/shop_images/no_picture.jpg";
                                } else {
                                    var shop_images = data[i].shop_images;
                                }
                                html += '<a href="__URL__/shop_detail/id/' + data[i].id + '"><dl class="clearfix">' +
                                        '<dt>' +
                                        '<img src="/' + shop_images + '">' +
                                        '</dt>' +
                                        '<dd>' +
                                        '<h3>' + data[i].name + '</h3>' +
                                        '<div class="comment">' +
                                        '<span>评价' + '<i>' + data[i].num + '</i>' + '条</span><span>' + urlImages + '</span>' +
                                        '</div>' +
                                        '<div class="area">' +
                                        '<span>' + data[i].addr + '</span>' +
                                        '</div>' +
                                        '<div class="tips">' +
                                        '<div>' +
                                        htmls +
                                        '</div>' +
                                        '<p>&lt; ' + '<span>' + data[i].juli + '</span>km</p>' +
                                        '</div>' +
                                        '</dd>' +
                                        '</dl></a>';
                            }
                        }
                        $('.main_index_con').append(html);
                    }
                });
            }

            $(window).scroll(function(event) {
                var sct = ($(document).height() - $(window).height()) - 80;
                var sct2 = $(document).scrollTop();
                if (sct2 >= sct) {
                    mainfn();
                }
            });
        </script>
    </head>
    <body>
        <header class="h_index">
            <div class="h_index_in">
                <span class="city map" onclick="$.city.showCityListSort()">
                    <!-- <span></span>
                     <i></i>-->
                    <a href="__URL__/searchMap/" class="fa fa-square fa-stack-2x"><i class="fa  fa-map-marker fa-stack-1x"></i></a>
                </span>
                <div class="store">
                    <button id='all' class="cur" data-shangjia='0'>全部</button>
                    <button id='discount' data-shangjia='1'>优惠</button>
                </div>
                <span class="map">
                    <!--<a href="__URL__/searchMap/" class="fa fa-square fa-stack-2x"><i class="fa  fa-map-marker fa-stack-1x"></i></a>-->
                    <a href="__URL__/myInfo/"  class="fa fa-square fa-stack-2x"><i class="fa fa-user fa-stack-1x"></i></a>
                </span>
            </div>
        </header>
        <div class="region_list">
            <div class="cities">
                <h4>定位城市</h4>
                <div>
                    <?php if(is_array($lastCity)): foreach($lastCity as $key=>$list): ?><a onclick="$.city.GpsLoction()" style="width:80%"><span  id="rego"></span>GPS定位</a><?php endforeach; endif; ?>
                </div>
            </div>
            <div class="cities">
                <h4>最近访问城市</h4>
                <div>
                    <?php if(is_array($newCity)): foreach($newCity as $key=>$list): ?><a href="javascript:$.city.linkCitys('<?php echo ($list[0]); ?>')"><?php echo ($list[0]); ?></a><?php endforeach; endif; ?>
                </div>
            </div>
            <div class="cities">
                <h4>热门城市</h4>
                <div>
                    <a href="javascript:$.city.linkCitys('上海市')">上海</a>
                    <a href="javascript:$.city.linkCitys('北京市')">北京</a>
                    <a href="javascript:$.city.linkCitys('广州市')">广州</a>
                    <a href="javascript:$.city.linkCitys('深圳市')">深圳</a>
                    <a href="javascript:$.city.linkCitys('武汉市')">武汉</a>
                    <a href="javascript:$.city.linkCitys('杭州市')">杭州</a>
                </div>
            </div>
            <ul>
                <?php if(is_array($city_list)): foreach($city_list as $key=>$city_list): ?><li class="charSort" >
                        <a onclick="$.city.showCity(this)"><?php echo ($key); ?></a>
                        <ul class="regin_list_1">
                            <?php if(is_array($city_list)): foreach($city_list as $key=>$list): ?><li class="charname" onclick="$.city.event(this)"><?php echo ($list["cname"]); ?></li><?php endforeach; endif; ?>
                        </ul>
                    </li><?php endforeach; endif; ?>
            </ul>
            <div  class="city_firstLetter">
                <ol></ol>
            </div>

        </div>
        <section class="main_index">
            <div class="main_index_h">
                <div class="sort">
                    <button class="city" onclick="$.city.showCityListSort()">
                        <span></span>
                    </button>
                    <button id="sort_btn1" data='16'>免费调洗 </button>
                    <button id="sort_btn2" data='1' >评价最高</button>
                    <!--<button id="sort_btn3" data='0'>离我最近 </button>-->
                </div>
                <!-- <div class="sort_con">
                    <ul>
                        <li class="fuwu">
                            <ol>
                                <li><a id='tiaoxi' data-fw='16' href="javascript:;">免费调洗</a></li>
                                <li><a id='yinxing' data-fw='17' href="javascript:;">有售隐形</a></li>
                                <li><a data-fw='18' href="javascript:;">验光配镜</a></li>
                                <li><a data-fw='19' href="javascript:;">可代加工</a></li> 
                            </ol>
                        </li>
                        <li class="fenbu">
                            <ol>
                                <li><a data-activity='1' href="javascript:;">减价</a></li>
                                <li><a data-activity='2' href="javascript:;">打折</a></li>
                                <li><a data-activity='3' href="javascript:;">赠送</a></li> 
                                <li><a data-sort='1' href="javascript:;">评价最高</a></li>
                            </ol>
                        </li>
                        <li class="paixu">
                            <ol>
                                <li><a data-sort='0' href="javascript:;">离我最近</a></li>
                                <li><a data-sort='1' href="javascript:;">评价最高</a></li> 
                            </ol>
                        </li>
                    </ul>
                </div> -->
            </div>

            <div class="main_index_con">
            </div>
        </section>
        <div class="mask_index"></div>
        <input type="hidden" id="fuwuStr" />
        <input type="hidden" id="fenbuStr" />
        <input type="hidden" id="paixuStr" />
        <input type="hidden" id="shangjiaStr"/>
        <input type="hidden" id="lats" value="" />
        <input type="hidden" id="lons"  value=""/>
    </body>

    <script language="JavaScript">


        //****************判断进程start***********
        if (localStorage.expires) {
            if (localStorage.expires < exp.getTime() - 1000 * 60 * 5) {
                localStorage.lat = "";
                mygetlocation();
            } else {
                topDiv("off");
            }
        } else {
            localStorage.lat = "";
            mygetlocation();
        }
//*************判断进度end*************************
        if (localStorage.city)
        {
            $(".city > span").html(localStorage.city);
        }
        $('.h_index .store button').click(function() {
            $(this).addClass('cur').siblings().removeClass('cur');
            shangjiaStr = $(this).attr('data-shangjia');
            if (shangjiaStr === 0) {
                shangjiaStr = '';
                $('#shangjiaStr').val(shangjiaStr);
                p = 1;
                myurl();
            } else {
                $('#shangjiaStr').val(shangjiaStr);
                p = 1;
                myurl();
            }
        });

        //排序按钮点击显示隐藏效果
        /* var $sort_btn = $('.main_index_h .sort button'), */
        var data_all = '';
        $('.main_index_h .sort button').click(function() {
            data_all = $(this).attr('data');
            $(this).addClass('cur').siblings().removeClass('cur');
            if (data_all == 16) {
                //alert(data_all);
                fuwuStr = '';
                paixuStr = '';
                $('#fuwuStr').val(fuwuStr);
                $('#paixuStr').val('');
                p = 1;
                myurl();
            }
            if (data_all == 1) {
                //alert(data_all);

                fuwuStr = '';
                paixuStr = 1;
                $('#fuwuStr').val('');
                $('#paixuStr').val(paixuStr);
                p = 1;
                myurl();

            }
            if (data_all == 0) {
                $('fuwuStr').val('');
                $('#paixuStr').val('');
                fuwuStr = '';
                paixuStr = '';
                p = 1;
                myurl();
            }
        });
        /*  $sort_con = $('.sort_con ul').children('li');
         $sort_btn.toggle(function() {
         var $index = $sort_con.eq($(this).index());
         if ($index.hasClass('cur')) {
         $index.removeClass();
         } else {
         $index.addClass('cur').siblings().removeClass();
         }
         }, function() {
         var $index = $sort_con.eq($(this).index());
         if ($index.hasClass('cur')) {
         $index.removeClass();
         } else {
         $index.addClass('cur').siblings().removeClass();
         }
         });
         
         $sort_con.on('click', function() {
         $(this).removeClass('cur');
         });   */

        //实现排序筛选

        $('.fuwu li a').click(function() {

            txt = $(this).text();

            if ($(this).hasClass('cur')) {
                $(this).removeClass('cur');
                fuwuStr = '';
                $('#fuwuStr').val('');
                p = 1;
                myurl();
                $('#sort_btn1').html('服务分类' + '<i></i>');

            }
            else {
                $(this).addClass('cur').parent().siblings().children('a').removeClass('cur');
                fuwuStr = $(this).attr('data-fw');
                $('#fuwuStr').val(fuwuStr);
                p = 1;
                myurl();

                $('#sort_btn1').html(txt + '<i></i>');

            }
            ;
        });
        $('.fenbu li a').click(function() {
            txt = $(this).text();
            if ($(this).hasClass('cur')) {
                $(this).removeClass('cur');
                fenbuStr = '';
                $('#fenbuStr').val('');
                p = 1;
                myurl();
                $('#sort_btn2').html('优惠活动' + '<i></i>');

            }
            else {
                $(this).addClass('cur').parent().siblings().children('a').removeClass('cur');
                fenbuStr = $(this).attr('data-activity');
                $('#fenbuStr').val(fenbuStr);
                p = 1;
                myurl();
                $('#sort_btn2').html(txt + '<i></i>');

            }
        });


        $('.paixu li a').click(function() {

            txt = $(this).text();


            if ($(this).hasClass('cur')) {
                $(this).removeClass('cur');
                paixuStr = '';
                $('#paixuStr').val('');

                $('#sort_btn3').html('智能排序' + '<i></i>');

                p = 1;
                myurl();
            }
            else {
                $(this).addClass('cur').parent().siblings().children('a').removeClass('cur');
                paixuStr = $(this).attr('data-sort');


                /*  $('.main_index_con').html(''); */
                $('#sort_btn3').html(txt + '<i></i>');

                p = 1;
                if (paixuStr === 0) {
                    /*  sortUrl(paixuStr); */
                    paixuStr = '';
                    $('#paixuStr').val(paixuStr);
                    p = 1;
                    myurl();
                } else {
                    $('#paixuStr').val(paixuStr);
                    p = 1;
                    myurl();
                }
            }
        }
        );

    </script>
    <script>
        var $firstLetter = $('.charSort a');
        var txtval = '';
        var num = 0;
        var $city_firstLetterOl = $('.city_firstLetter ol');

        //右边追加节点
        for (var i = 0; i < $firstLetter.length; i++) {
            $city_firstLetterOl.append('<li></li>')
        }
        ;

        //给右边节点赋值（ABCDEFG....）
        var $city_firstLetterLi = $city_firstLetterOl.find('li');
        for (var j = 0; j < $city_firstLetterLi.length; j++) {
            txtval = $firstLetter.eq(num).html();
            $city_firstLetterLi.eq(num).html(txtval);
            num++;
        }



        //点击右边字母跳到对应的首字母开头的城市
        var offsetTop = 0;
        $city_firstLetterLi.on('click', function() {
            offsetTop = $firstLetter.eq($(this).index()).offset().top - 93;  //距离头部高93px
            $('html,body').animate({
                'scrollTop': offsetTop
            }, 500)
        });
    </script>
</html>