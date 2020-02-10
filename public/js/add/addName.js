$(".add-person").click(function(event, log = true) {
    //adding log
    if(log) addLog("Person");
    let id = generateId();
    let newId = {
        name:$($("input[name=name]")[0]).attr("list"),
        lname:$($("input[name=lname]")[0]).attr("list"),
        phone:$($("input[name=phone]")[0]).attr("list"),
        email:$($("input[name=email]")[0]).attr("list"),
        org:$($("input[name=org]")[0]).attr("list"),
    }
    $(`
    <div>
    <input type='text' list='${newId.name}'id='name${id}' placeholder=' ' name='name'>
    <label for='name${id}'>Företagsnamn/Förnamn...</label>
</div>

<div>
    <input type='text' list='${newId.lname}'id='lname${id}' placeholder=' ' name='lname'>
    <label for='lname${id}'>Efternamn...</label>
</div>

<div>
    <input type='tel' list='${newId.phone}'id='phone${id}' placeholder=' ' name='phone'>
    <label for='phone${id}'>Tel...</label>
</div>

<div>
    <input type='email' list='${newId.email}'id='email${id}' placeholder=' ' name='email'>
    <label for='email${id}'>Epost...</label>
</div>

<div>
    <input type='text' list='${newId.org}'id='org${id}' placeholder=' ' name='org'>
    <label for='org${id}'>Org./Personnummer...</label>
</div>
    <div class="add-person-button">
    <p id="${id}" class="shared-RUT"><i class="fas fa-plus-circle"></i>Delad RUT</p>
    <i class="fas fa-trash person-trash"></i></div>
`).insertBefore($(this).parent());
$('input[list^="New"]').off()
$('input[list^="New"]').change(function() {
    fillUserInfo(this);
});
    $("input[name=name]").change(function() {
        findClosestButton(".shared-RUT", this);
    })

    $(".shared-RUT").off();
    $(".shared-RUT").click(function() {
        rut(this)
    });

    $(".person-trash").off();
    $(".person-trash").click(function() {
        //adding log
        addLog("removePerson");
        let id = "";
        for (let i = 0; i < $(".shared-RUT").length; i++) {
            if ($($(this).prev()).is($($(".shared-RUT")[i]))) {
                length = i;
                id = $($(this).prev()).attr("id");
                break;
            }
        }
        if ($(".person").length == 1) $("#" + id + "person").parents(".shared-rut-calc").remove();
        else $("#" + id + "person").remove();
        for (let i = 0; i < 5; i++) {
            $(this).parents(".add-person-button").prev().remove();
        }
        $(this).parents(".add-person-button").remove();
    });
});
$(".shared-RUT").click(function() {
    rut(this)
});

const rut = (_this) => {
    let length = 0;
    let id = "";
    for (let i = 0; i < $(".shared-RUT").length; i++) {
        if ($(_this).is($($(".shared-RUT")[i]))) {
            length = i;
            id = $(_this).attr("id");
            break;
        }
    }
    if ($(_this).text().includes("Ta bort delad RUT")) {
        addLog("removeRutPerson");
        $(_this).html(`<i class="fas fa-plus-circle" aria-hidden="true"></i>Delad RUT`);
        if ($(".person").length == 1) $("#" + id + "person").parent().remove();
        else $("#" + id + "person").remove();

    } else {
        addLog("rutPerson");
        $(_this).html(`<i class="fas fa-plus-circle" aria-hidden="true"></i>Ta bort delad RUT`);
        let person = $($("input[name=name]")[length]).val();
        let personLength = $(".person").length;
        if ($(".shared-rut-calc").length == 0) {
            $(`<div class="shared-rut-calc">
        <h4>Delat RUT</h4>
        <div id="${id}person" class="person">
            <h6>${person}</h6>
            <div class="amount">
                <span class="money"><input type="number" name="rutMoney" id="" min="0"><span>KR</span></span>
                <span class="share"><input type="number" name="rutShare" id="" min="0" max="100"><span>%</span></span>
            </div>
        </div>
    </div>`).insertAfter(".rut-calc-grid");
        } else {
            $(`
            <div id="${id}person" class="person">
            <h6>${person}</h6>
            <div class="amount">
                <span class="money"><input type="number" name="rutMoney" id="" min="0"><span>KR</span></span>
                <span class="share"><input type="number" name="rutShare" id="" min="0" max="100"><span>%</span></span>
            </div>
        </div>
    `).insertAfter($($(".person")[personLength - 1]));
        }

    }
}
$("input[name=name]").change(function() {
    findClosestButton(".shared-RUT", this);
})

function findClosestButton(dec, _this) {
    let id = $($(_this).closest("input").nextAll(':has(' + dec + '):first').find(dec)).attr("id");
    $("#" + id + "person h6").text($(_this).val());
}


function generateId() {
    let alf = "abcdefghijklmnopqrstvkjqwxyzABCDEFGHIJKLMNOPRSTVKJQWXYZ-"
    let id = "";
    for (let i = 0; i < 16; i++) {
        let random = Math.round(Math.random() * alf.length - 1);
        id += alf[random];
    }
    return id;
}


$('input[list^="New"]').change(function() {
    fillUserInfo(this);
})
function fillUserInfo(_this){
    let userId = $(_this).val().split("-")[1] ? $(_this).val().split("-")[1] : 0;
    if(userId){
        $.post("liveData/getLiveData.php", { action: "getUser", userId }).done(data => {
            data = JSON.parse(data);
            if (data != null) {
                let name = $(_this).attr("name")
                    let index = 0;
                    for(let i = 0; i < $(`input[name=${name}]`).length; i++){
                        if($($(`input[name=${name}]`)[i]).attr("id")== $(_this).attr("id")){
                            index = i;
                            break;
                        }
                    }
                    $($("input[name=name]")[index]).parent().attr("id", data["id"]);
                    $($("input[name=name]")[index]).val(data["firstname"])
                    $($("input[name=lname]")[index]).val(data["lastname"])
                    $($("input[name=email]")[index]).val(data["email"])
                    $($("input[name=phone]")[index]).val(data["phone"])
                    $($("input[name=org]")[index]).val(data["personalcode"])
                    if(index === 0){
                        $($("input[name=badress]")[index]).val(data["billingadress"])
                        $($("input[name=badressNr]")[index]).val(data["billingadressnr"])
                        $($("input[name=fepost]")[index]).val(data["billingemail"])
                        $($("input[name=zipcode]")[index]).val(data["zipcode"])
                        $($("input[name=city]")[index]).val(data["city"])
                        if(data["billingreference"] && data["billingreference"].length > 0)
                            $(`[name=billingReference]`).parent().children(".select-selected").html(data["billingreference"]);
                        else    
                            $(`[name=billingReference]`).parent().children(".select-selected").html("Ingen");
                    }

            }
        });
    }
}