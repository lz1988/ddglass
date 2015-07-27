/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$.city2 = ({
    city: "",
    asyn: "false",
    lat: localStorage.lat,
    lon: localStorage.lon,
    gpsCity: localStorage.gpscity,
    host: "index.php/index/get_optometrist_list?",
    sort: "",
    distribute: "",
    serve: "",
    youhui: "",
    p: "0",
    url: "",
    mark: "",
    newlyCityStorage: "",
    event: function(o) {
        //当前城市
        this.city = $(o).text();
        this.sortUrl();
        //new citys 
        this.newlyCityStorage = $(o).text();
        this.newlyCitys();

        localStorage.city = $(o).text();
        $(".city>span").html($(o).text());
        $(".main_index_con").html("");
    },
    sortUrl: function() {
        this.url = this.host + "&sort=" + "&distribute=" + "&serve=" + "&youhui=" + "&lat=" + this.lat + "&lon=" + this.lon + "&city=" + this.city + "&p=" + this.p;
        this.ajaxreturn();
    },
    ajaxreturn: function() {
        var sortCityUrl = this.url;
        $.ajax({
            url: sortCityUrl,
            asyn: this.asyn,
            dataType: 'json',
            type: "get",
            success: function(data) {
                if (data) {
                    var html = "";
                    for (var i = 0; i < data.length; i++) {
                        var htmls = '';
                        /*if (data[i].shop_activity === '') {
                            htmls = "";
                        } else {
                            s = data[i].shop_activity;

                            s = s.substring(0, s.length - 1);
                            var strs = new Array();
                            strs = s.split(",");
                            $.each(strs, function(index, tx) {
                                if (tx === 0) {
                                    // alert(tx);
                                    htmls += "<span>减 </span>";
                                }
                                if (tx === 1) {
                                    //alert(tx);
                                    htmls += "<span>折</span>";
                                }
                                if (tx === 2) {
                                    //alert(tx);
                                    htmls += "<span>送</span>";
                                }

                            });
                        }*/
                       /* html += '<a href="index.php/index/shop_detail/id/' + data[i].id + '"><dl class="clearfix">' +
                        '<dt>' +
                        '<img src="/' + data[i].shop_images + '">' +
                        '</dt>' +
                        '<dd>' +
                        '<h3>' + data[i].name + '</h3>' +
                        '<div class="comment">' +
                        '<span>评价' + '<i>' + data[i].num + '</i>' + '条</span>' +
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
                        '</dl></a>';*/

                        if (data[i].op_images_url == "") {
                            shop_images = "./Uploads/shop/shop_images/no_picture.jpg";
                        } else {
                            shop_images = data[i].op_images_url;
                        }

                        html += '<a href="__URL__/optometrist_detail/id/' + data[i].id + '"><dl class="clearfix">' +
                        '<dt>' +
                        '<img src="' + shop_images + '">' +
                        '</dt>' +
                        '<dd>' +
                        '<h3>' + data[i].name + '</h3>' +
                        '<div class="comment">' +
                        '<span>' +urlImages+ '</span><span>' + '<i>' + data[i].num + '</i>条</span>' +
                        '</div>' +
                        '<div class="area">' +
                        '<span>' + data[i].skill + '</span>' +
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
                if (html) {
                    $(".region_list").hide();
                    $('.main_index_con').html(html);
                } else {
                    if (typeof (html) === "undefined") {
                        $(".region_list").hide();
                        $('.main_index_con').css({"width": "500px", "height": "800px"}).append("所选市区还没有滴滴配镜的合作眼镜店！");
                    }
                }
            },
            error: function(x) {

            }
        });
    },
    GpsGetAdd: function() {

    },
    showCityListSort: function() {
        if (this.mark == "") {
            $(".region_list").show();
            this.mark = 1;
        } else {
            $(".region_list").hide();
            this.mark = 0;
        }

    },
    showCity: function(o) {
        if (this.mark == "") {
            $(o).next().show();
            this.mark = 1;
        } else {
            $(o).next().hide();
            this.mark = 0;
        }
    },
    linkCitys: function(o) {
        $(".main_index_con").html("");
        $(".city>span").html(o);
        this.city = o;
        $.ajax({
            url: "index.php/index/newlyCitys",
            type: "GET",
            data: {city:o},
            dataType: "JSON",
            aysn: true,
            success: function() {

            }
        });
        this.sortUrl();
    },
    GpsLoction: function() {
        var url = "http://api.map.baidu.com/geocoder/v2/?ak=I5Szl96uWEjM7K7js6p3D0DI&output=json&pois=1&location=" + localStorage.lat + "," + localStorage.lon;
        $.ajax({
            type: "GET",
            dataType: "JSONP",
            url: url,
            aysn: true,
            success: function(json) {
                localStorage.city = json.result.addressComponent.city;
            }
        });
        $(".city>span").html(localStorage.city);
        this.city = localStorage.city;
        this.sortUrl();
    },
    newlyCitys: function() {
        $.ajax({
            url: "index.php/index/newlyCitys",
            type: "GET",
            data: {city: this.newlyCityStorage},
            dataType: "JSON",
            aysn: true,
            success: function() {

            }
        });
    }
});
