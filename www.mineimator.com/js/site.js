preload(["images/download_archive.png",
         "images/download_archive_hover.png",
         "images/download_installer.png",
         "images/download_installer_hover.png",
         "images/download_macos.png",
         "images/download_macos_hover.png",
         "images/download_package.png",
         "images/download_package_hover.png",
         "images/index_download.png",
         "images/index_download_hover.png",
         "images/index_head_dragon.png",
         "images/index_head_front.png",
         "images/index_head_ghast.png",
         "images/index_head_logo.png",
         "images/index_head_program.jpg",
         "images/index_link_showcase.png",
         "images/index_link_showcase_hover.png",
         "images/index_link_full_showcase.png",
         "images/index_link_full_showcase_hover.png",
         "images/index_link_back.png",
         "images/index_link_back_hover.png",
         "images/index_link_forums.png",
         "images/index_link_forums_hover.png",
         "images/index_link_upgrade.png",
         "images/index_link_upgrade_hover.png",
         "images/page_logo.png",
         "images/shadow.png",
         "images/sky.png",
         "images/stone.jpg",
         "images/frame.png",
         "images/next.jpg",
         "images/prev.png",
         "images/upgrade_dec.png",
         "images/upgrade_dec_hover.png",
         "images/upgrade_inc.png",
         "images/upgrade_inc_hover.png",
         "images/upgrade_get_key_donate.png",
         "images/upgrade_get_key_donate_hover.png",
         "images/upgrade_get_key.png",
         "images/upgrade_get_key_hover.png",
         "images/wood.png",
         "images/youtube.png"]);
     
function valueMerge(val1, val2, amount) {
    return (val1 + (val2 - val1) * amount);
}

function getTransform(rotate, scale) {
    return {
        '-webkit-transform' : 'rotate('+ rotate +'deg) scale(' + scale + ')',
        '-moz-transform' : 'rotate('+ rotate +'deg) scale(' + scale + ')',
        '-ms-transform' : 'rotate('+ rotate +'deg) scale(' + scale + ')',
        'transform' : 'rotate('+ rotate +'deg) scale(' + scale + ')'
    };
};

function isAtBottom() {
    var docViewTop = $("body").scrollTop();
    var docViewBottom = docViewTop + $("body").height();
    var pageBottom = $(".page").height();

    return (docViewBottom > pageBottom - 100);
}

function urlFriendly(str) {
    return str.toLowerCase().replace(/[^a-z0-9 ]/g, "").replace(/ /g, "-");
}

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1449759491754514";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
