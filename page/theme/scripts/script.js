/**
 * Created by David on 2015/8/28.
 */
$(document).ready(function(){
    $('li.row').click(function() {
        if ($(this).find('ul').css("display") == 'none') {
            $('ul.tab').hide();
            $(this).find('ul').show();
        } else {
            $(this).find('ul').hide();
        }
    })
    anchor = anchor();
    if (anchor != '') {
        $('ul.tab').eq(anchor.substr(1)).show();
    }

    $('a[name=exchange]').click(function() {
        id = $(this).attr("value");
        $.ajax({
            type: "POST",
            url: "/mall/exchange",
            data: {commodity_id:id},
            dataType: "json",
            success: function(data){
                $('#resText').empty();   //清空resText里面的所有内容
                var html = '';
                $.each(data, function(commentIndex, comment){
                    html += '<div class="comment"><h6>' + comment['username']
                        + ':</h6><p class="para"' + comment['content']
                        + '</p></div>';
                });
                $('#resText').html(html);
            }
        });
    });
});

function request(name) {
    var reg = new RegExp("(^|&)"+name+"=(.*?)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) {
        return r[2];
    }
    return null;
}

function anchor() {
    if (window.location.hash == '') {
        return '';
    } else {
        return window.location.hash.substr(1);
    }
}