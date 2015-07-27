var the_s = new Array();
function view_time(the_s_index, objid) {
    if (the_s[the_s_index] > 0) {
        var the_D = Math.floor((the_s[the_s_index] / 3600) / 24)
        var the_H = Math.floor((the_s[the_s_index] - the_D * 24 * 3600) / 3600);
        var the_M = Math.floor((the_s[the_s_index] - the_D * 24 * 3600 - the_H * 3600) / 60);
        var the_S = (the_s[the_s_index] - the_H * 3600) % 60;
        html = "还剩：";
        if (the_D != 0 || the_H != 0) html += '<em class=\"big_f\">' + (the_H + (the_D * 24)) + "</em>小时";
        if (the_D != 0 || the_H != 0 || the_M != 0) html += '<em class=\"big_g\">' + the_M + "</em>分";
        html += '<em class=\"big_g\">' + the_S + "</em>秒";
        $(objid).html(html);
        the_s[the_s_index]--;
    } else {
     $(objid).html("本商品抢购时间已结束！");
     $("#buy,#gwc_ADD").hide();
    }
}