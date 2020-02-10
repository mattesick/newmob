$(".add-person").click(function() {
    //adding log
    addLog("Person");
    let id = generateId();
    $(`
    <div>
    <input type='text' id='name${id}' placeholder=' ' name='name'>
    <label for='name${id}'>Företagsnamn/Förnamn...</label>
</div>

<div>
    <input type='text' id='lname${id}' placeholder=' ' name='lname'>
    <label for='lname${id}'>Efternamn...</label>
</div>

<div>
    <input type='tel' id='phone${id}' placeholder=' ' name='phone'>
    <label for='phone${id}'>Tel...</label>
</div>

<div>
    <input type='email' id='email${id}' placeholder=' ' name='email'>
    <label for='email${id}'>Epost...</label>
</div>

<div>
    <input type='text' id='org${id}' placeholder=' ' name='org'>
    <label for='org${id}'>Org./Personnummer...</label>
</div>
    <div class="add-person-button">
    <p id="${id}" class="shared-RUT"><i class="fas fa-plus-circle"></i>Delad RUT</p>
    <i class="fas fa-trash person-trash"></i></div>
`).insertBefore($(this).parent());
    $("input[name=name]").off();
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

const rut = (that) => {
    let length = 0;
    let id = "";
    for (let i = 0; i < $(".shared-RUT").length; i++) {
        if ($(that).is($($(".shared-RUT")[i]))) {
            length = i;
            id = $(that).attr("id");
            break;
        }
    }
    if ($(that).text().includes("Ta bort delad RUT")) {
        //adding log
        addLog("removeRutPerson");
        $(that).html(`<i class="fas fa-plus-circle" aria-hidden="true"></i>Delad RUT`);
        if ($(".person").length == 1) $("#" + id + "person").parent().remove();
        else $("#" + id + "person").remove();

    } else {
        //adding log
        addLog("rutPerson");
        $(that).html(`<i class="fas fa-plus-circle" aria-hidden="true"></i>Ta bort delad RUT`);
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

function findClosestButton(dec, that) {
    let id = $($(that).closest("input").nextAll(':has(' + dec + '):first').find(dec)).attr("id");
    $("#" + id + "person h6").text($(that).val());
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
$("input[name=name]").change(function() {
    console.log($(this));
});