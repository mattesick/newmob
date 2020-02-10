$(".fa-trash").click(function() {

    let oid = $(this).parents("tr").children()[0].innerHTML;
    areYouSure("Du kommer att avboka order " + oid + "!", () => {
        $(this).parents("tr").remove();
        $.post("/liveData/buttonsAction.php", { action: "remove", oid }, function(data) {});
        addAlert("Abokade förfrågan!", "Warning")
    });

});


$(".addOffer").click(function() {
    $(this).parents("tr").remove();
    let oid = $(this).parents("tr").children()[0].innerHTML;
    $.post("/liveData/buttonsAction.php", { action: "addOffer", oid });
    addAlert("Skapade en offert!")
});
$(".addOrder").click(function() {
    $(this).parents("tr").remove();
    let oid = $(this).parents("tr").children()[0].innerHTML;
    $.post("/liveData/buttonsAction.php", { action: "addOrder", oid })
    addAlert("Skapade en order!")
});