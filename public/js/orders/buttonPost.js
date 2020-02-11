$.urlParam = function(name) {
    let results = new RegExp('[?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (!results) return false;
    return results[1] || 0;
}
$(document).ready(() => {
    $(".loading").show();
    if (req = $.urlParam("req")) {
        $.get("liveData/whichOrder.php", { req }).done(function(data) {
            $("main").empty();
            $(data).appendTo("main");
            $("#button-navigation button").click(function() {
                liveDataPost(this);
            });
            history.pushState("", req, "orders.php?req=" + req)
            $.getScript("/js/orders/buttons.js");
            $(".loading").hide();
        }).fail(function() {
            window.location.href = "error.php";
        });
    } else {
        $.get("liveData/whichOrder.php", { req: "for" }).done(function(data) {
            $("main").empty();
            $(data).appendTo("main");
            $("#button-navigation button").click(function() {
                liveDataPost(this);
            });
            $.getScript("/js/orders/buttons.js");
            $(".loading").hide();
        }).fail(function() {
            window.location.href = "error.php";
        });
    }
});

$("#button-navigation button").click(function() {
    liveDataPost(this);
});

function liveDataPost(that) {
    if ($(that).hasClass("active")) return;
    let req = $(that).text().toLowerCase().substring(0, 5);
    $(".loading").show();
    $.get("liveData/whichOrder.php", { req }).done(function(data) {
        $("main").empty();
        $(data).appendTo("main");
        $("#button-navigation button").click(function() {
            liveDataPost(this);
        });
        history.pushState("", req, "orders.php?req=" + req)
        $.getScript("/js/orders/buttons.js");
        $(".loading").hide();
    }).fail(function() {
        window.location.href = "error.php";
    });
}