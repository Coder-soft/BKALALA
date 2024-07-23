var topContent = [];
var startContent = 0;
var selectContentIndex = -1;
var showcaseTable;

$(function () {
    
    // Showcase
    showcaseTable = $("#showcase_table");
    if (showcaseTable.length)
    {
        getTopContent();

        // Load more stuff
        $("body").scroll(function() { checkShowNextBatch(); });

        // Previous/Next
        let moveDuration = 200;
        let moveDistance = "800px";
        $("#showcase_prev").click(function() {
            $("#showcase_container").animate({ marginLeft: moveDistance, opacity: 0 }, { duration: moveDuration, complete: function() {
                $("#showcase_container").css({ marginLeft: "-" + moveDistance });
                $("#showcase_content").css({ backgroundImage: "none" });
                openContent(selectContentIndex - 1);
                $("#showcase_container").animate({ marginLeft: "0px", opacity: 1 }, { duration: moveDuration });
            }});
        });

        $("#showcase_next").click(function() {
            $("#showcase_container").animate({ marginLeft: "-" + moveDistance, opacity: 0 }, { duration: moveDuration, complete: function() {
                $("#showcase_container").css({ marginLeft: moveDistance });
                $("#showcase_content").css({ backgroundImage: "none" });
                openContent(selectContentIndex + 1);
                $("#showcase_container").animate({ marginLeft: "0px", opacity: 1 }, { duration: moveDuration });
            }});
        });

        // Keyboard shortcuts
        $(document).on('keydown', function (event) {
            if (selectContentIndex >= 0) {
                if (event.keyCode == 37 && !$("#showcase_prev").is(":hidden"))
                    $("#showcase_prev").click();
                if (event.keyCode == 39 && !$("#showcase_next").is(":hidden"))
                    $("#showcase_next").click();
                if (event.keyCode == 27) 
                    closeContent();
            }
        });

        // Resize video
        resizeContent();

        // Close content
        $(".fadescreen, .fadescreen_container").click(function() { closeContent(); });
        $(".fadescreen_box, #showcase_content").click(function(event) { event.stopPropagation(); });
    }
});

// Checks every 100ms if the video is resized
var lastWidth;
function resizeContent()
{
    var ratio = 16 / 9;
    var width = $("#showcase_content").width();
    if (width != lastWidth) {
        $("#showcase_content").height(width / ratio);
        lastWidth = width;
    }

    setTimeout(resizeContent, 200);
}

// User clicks the background or escape
function closeContent()
{
    $(".fadescreen").fadeOut(500, function() {
        $("#showcase_content iframe").remove();
        selectContentIndex = -1;
    });
}

// Retrieves the top rated content from the database
function getTopContent()
{
    // Get content
    $("#showcase_loadmore").hide();
    $("#showcase_loading").show();
    $.ajax({
        url: "../php/showcase.php",
        method: "POST",
        data: {
            contentType: showcaseTable.attr("contentType"),
            timeSpan: showcaseTable.attr("timeSpan")
        }
    }).done(function(response) {

        try {
            topContent = JSON.parse(response);
        } catch (e) {
            console.log(response);
        }
        startContent = 0;
        showcaseTable.html("");
        $("#showcase_loading").hide();
        $("select").change(function() { filterContent(); })

        showNextBatch();
        checkShowNextBatch();
        $("#showcase_loadmore").show();
    });
}

// Filters the content
function filterContent()
{
    let contentType = $("#showcase_filter_contenttype").val();
    let timeSpan = $("#showcase_filter_timespan").val();
    window.location = "?content=" + contentType + "&timespan=" + timeSpan;
}

// Formats a date string
function formatDate(str)
{
    let date = new Date(Date.parse(str));
    let monthNames = [
        "Jan", "Feb", "Mar",
        "Apr", "May", "June", "July",
        "Aug", "Sep", "Oct",
        "Nov", "Dec"
    ];

    let day = date.getDate();
    let monthIndex = date.getMonth();
    let year = date.getFullYear();
  
    return monthNames[monthIndex] + " " + day + ", " + year;
}

// Opens a video or image preview
function openContent(index)
{
    let content = topContent[index];
    selectContentIndex = index;
    $("#showcase_content iframe").remove();
    
    if (content["type"] == "video") {
        let videoHtml = '<iframe autoplay="true" allowfullscreen="" frameborder="0" width="480" height="270" src="https://www.youtube.com/embed/' + content["youtube"] + '?feature=oembed"></iframe>';
        $("#showcase_content").append(videoHtml);
        $("#showcase_content a").hide();
    } else {
        $("#showcase_content").css({ backgroundImage: "url('" + content["imageurl"] + "')"});
        $("#showcase_content a").show();
        $("#showcase_content a").attr("title", "View full");
        $("#showcase_content a").attr("href", content["imageurl"]);
    }
    $("#showcase_content_info .rep").html(content["rep"] + " votes");
    $("#showcase_content_info .posted").html("Posted " + formatDate(content["posted"]));
    $("#showcase_content_info .title").html(content["title"]);
    $("#showcase_content_info .user").html(content["user"]);
    $("#showcase_content_info .topiclink").attr("href", "https://www.mineimatorforums.com/index.php?/topic/" + content["topicid"] + "-" + urlFriendly(content["title"]) + "/");
    $("#showcase_content_info .userlink").attr("href", "https://www.mineimatorforums.com/index.php?/profile/" + content["userid"] + "-" + urlFriendly(content["user"]) + "/");
    $("#showcase_content_background").fadeIn(500);
    $("#showcase_prev").toggle(index > 0);
    $("#showcase_next").toggle(index < topContent.length - 1);
}

function checkShowNextBatch()
{
    if ($("#showcase_loadmore").length && !$("#showcase_loadmore").is(":hidden") && isAtBottom()) {
        showNextBatch();
    }
}

function showNextBatch()
{
    let batchAmount = parseInt(showcaseTable.attr("batchAmount"));
    let itemPerRow = 3;
    
    let currentRow = showcaseTable.find("tr").last();
    if (currentRow.length == 0) {
        currentRow = $("<tr></tr>");
        showcaseTable.append(currentRow);
    }

    let i;
    for (i = startContent; i < Math.min(startContent + batchAmount, topContent.length); i++)
    {
        let currentContent = topContent[i];
        if (currentRow.children().length == itemPerRow)
        {
            currentRow = $("<tr></tr>");
            showcaseTable.append(currentRow);
        }

        // Create preview
        var html = '<div class="preview">';
        if (currentContent["type"] == "video")
            html += '<img src="https://i.ytimg.com/vi/' + currentContent["youtube"] + '/hqdefault.jpg" class="youtube thumbnail"/>';
        else
            html += '<span style="background-image:url(\'' + currentContent["imagethumb"] + '\');" class="thumbnail"></span>';
        html += '<img src="images/frame.png" class="frame"/>';
        if (currentContent["type"] == "video")
            html += '<img src="images/youtube.png" class="video"/>';
        html += '</div>';

        // Create title
        html += '<div class="title">' + currentContent["title"] + '</div> by ' + currentContent["user"];

        // Create cell
        let cell = $("<td title='Click to view'>" + html + "</td>");

        // Rotate by random degrees
        let rotate = [ -3, -1.5, 1.5, 3 ][Math.floor(Math.random() * 4)];
        let cellPreview = cell.find(".preview");
        cellPreview.css(getTransform(rotate, 1));
        
        // Mouse events
        cell.mouseenter(function() {
            $({ prop: 0 }).animate({ prop: 1 }, {
                step: function(progress) { cellPreview.css(getTransform(valueMerge(rotate, -rotate, progress), valueMerge(1, 1.2, progress))); },
                duration: 100
            });
        });
        cell.mouseleave(function() {
            $({ prop: 0 }).animate({ prop: 1 }, {
                step: function(progress) { cellPreview.css(getTransform(valueMerge(-rotate, rotate, progress), valueMerge(1.2, 1, progress))); },
                duration: 100
            });
        });

        let cellIndex = i;
        cell.click(function() { openContent(cellIndex); })

        currentRow.append(cell);
    }

    startContent = i;
    if (startContent >= topContent.length)
        $("#showcase_loadmore").hide();
}