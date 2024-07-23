$(function () {
    
    // Donate option toggle
    $(".upgrade_option").click(function() {
        var check = $(this).find(".upgrade_checkbox_mark");
        
        $(".upgrade_checkbox_mark").stop();
        $(".upgrade_checkbox_mark").hide();
        check.css("width", "50%");
        check.css("height", "50%");
        check.show();
        check.animate({
            width: "100%",
            height: "100%"
        },{
            duration: 200,
            easing: "easeOutBack"
        });
    });
     
    // Donate checkbox
    $("#upgrade_donate").click(function() {
        $("#upgrade_get_key_donate").show();
        $("#upgrade_get_key").hide();
        $("#upgrade_ads_info").hide();
    });
    
    // Don't donate checkbox
    $("#upgrade_no_donate").click(function() {
        $("#upgrade_get_key_donate").hide();
        $("#upgrade_get_key").show();
        $("#upgrade_ads_info").show();
    });
    
    // Get key (donate)
    $("#upgrade_get_key_donate").click(function() {
        location.href = $("#upgrade_form").attr("donate_link");
    });
    
    // Get key (no donate)
    $("#upgrade_get_key").click(function() {
        getkey("no-donate", "");
    });

    // Fade screen
    //$(".fadescreen_container").click(function() { $(".fadescreen").fadeOut(500); });
   // $(".fadescreen_box").click(function(event) { event.stopPropagation(); });
    
    // Disable enter
    $(document).on("keypress", "form", function(event) { 
        return event.keyCode != 13;
    });
});

// Get key popup
function getkey(transaction, from)
{
    $.ajax({
        url: "../php/donate.php",
        method: "POST",
        data: { transaction: transaction, from: from }
    }).done(function(response) {
        if (transaction == "donate")
            $("#upgrade_donate_header").show();
        else
            $("#upgrade_donate_header").hide();
        $("#upgrade_donate_key").html(response);
        $("#upgrade_donate_background").fadeIn(500);
    });
};