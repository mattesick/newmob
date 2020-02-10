let lastButton;
let open = false;
$("#articles button").click(function() {
    $(".active").removeClass("active")
    $(this).addClass("active");
    let article = $(this).text();
    let buttonHtml = $(this).html();
    let lastButtonHtml;
    if (lastButton) lastButtonHtml = lastButton.html()
    $.post("liveData/whichArticle.php", { article }).done(function(data) {
        $(".options").empty();
        $(data).appendTo($(".options"));
        $('button[id^="articleButton-"]').click(function() {
            chooseArticle(this)
        });
        if ($("#articles-dropdown").css("display") == "none") {
            $("#articles-dropdown").css("display", "block");
            open = true;
        } else if (!lastButton || lastButtonHtml == buttonHtml) {
            if ($("#articles-dropdown").css("display") == "block") {
                $("#articles-dropdown").css("display", "none");
                $(".active").removeClass("active");
                open = false;
            }
        }
    }).fail(function() {
        window.location.href = "error.php";
    });


    lastButton = $(this);
});

function chooseArticle(that) {
    console.log($(that).attr("id").split("-")[1]);
}