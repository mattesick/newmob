$(".sameAsBillingAdress").click(e => {
    e.preventDefault();
    let parentClass = $(e.target).parents(".move-from").attr("class") ? $(e.target).parents(".move-from").attr("class") : $(e.target).parents(".move-to").attr("class");
    let adress = $("input[name=badress]").val();
    let adressNr = $("input[name=badressNr]").val();
    $($("." + parentClass + " input[name=adress" + parentClass + "]")[0]).val(adress);
    $($("." + parentClass + " input[name=adressNr" + parentClass + "]")[0]).val(adressNr);
});