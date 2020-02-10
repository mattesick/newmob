let navItem = $(".nav-item p");
//I use these because we are using multiple dropdowns.
//when adding a dropdown make sure the "li" has an id. Use the other dropdowns as help.
navItem.click(e => {
    let listItem = $(e.target).parent();
    if (listItem[0].nodeName == "P") listItem = listItem.parent().attr("id");
    else listItem = listItem.attr("id");
    if ($("#" + listItem).hasClass("show")) $("#" + listItem).removeClass("show");
    else {
        $(".show").removeClass("show");
        $("#" + listItem).addClass("show");
    }
})