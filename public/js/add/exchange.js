$("#exchange").click(() => {
    //adding log
    addLog("Exchange");
    let movefrom = $(".move-from");
    let moveto = $(".move-to");
    $(".move-from h2").html("Flytt TILL:");
    $(".move-to h2").html("Flytt FRÅN:");
    moveto.addClass("move-from").removeClass("move-to");
    movefrom.addClass("move-to").removeClass("move-from")
    let listMoveto = $(".address-list-move-to")
    let listMovefrom = $(".address-list-move-from")
    listMoveto.addClass("address-list-move-from").removeClass("address-list-move-to");
    listMovefrom.addClass("address-list-move-to").removeClass("address-list-move-from");
    moveFrom = $(".move-from input");
    moveTo = $(".move-to input");
    let from = $(".insertAftermove-from");
    $(".insertAftermove-to").addClass("insertAftermove-from").removeClass("insertAftermove-to");
    from.addClass("insertAftermove-to").removeClass("insertAftermove-from")
    for (let i = 0; i < moveFrom.length; i++) {
        let newName = $(moveFrom[i]).attr("name").split("");
        newName.splice($(moveFrom[i]).attr("name").length - 2, $(moveFrom[i]).attr("name").length);
        newName = newName.join("")
        newName += "from";
        $(moveFrom[i]).attr("name", newName)
    }
    for (let i = 0; i < moveTo.length; i++) {
        let newName = $(moveTo[i]).attr("name").split("");
        newName.splice($(moveTo[i]).attr("name").length - 4, $(moveTo[i]).attr("name").length);
        newName = newName.join("")
        newName += "to";
        $(moveTo[i]).attr("name", newName)
    }
});