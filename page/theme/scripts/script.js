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