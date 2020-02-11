$(".sameAsBillingAdress").click(e => {
    e.preventDefault();
    let parentClass = $(e.target).parents(".move-from").attr("class") ? $(e.target).parents(".move-from").attr("class") : $(e.target).parents(".move-to").attr("class");
    let adress = $("input[name=badress]").val();
    let zipcode = $("input[name=zipcode]").val();
    let city = $("input[name=city]").val();
    $($("." + parentClass + " input[name=adress" + parentClass + "]")[0]).val(adress);
    $($("." + parentClass + " input[name=zipcode" + parentClass + "]")[0]).val(zipcode);
    $($("." + parentClass + " input[name=city" + parentClass + "]")[0]).val(city);
    forceCalcRoute()
});