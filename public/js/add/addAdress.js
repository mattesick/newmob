$(".add-adress").click(e => {
    let parentClass = $(e.target).parent().parent().parent().attr("class");
    newAdress(e, parentClass)
});

function newAdress(e, parentClass) {
    if (e) {
        e.preventDefault();
        addLog("Adress");
    }

    let insertAfter = ".insertAfter" + parentClass;
    let id = generateId();
    $("." + parentClass + " .add-adress").parent("a").remove();
    $(`          
        <div class="custom-select new-custom-select">
            <select name="typeofliving${parentClass}">
            </select>
        </div>
        <div class="checkbox">
            <input type="checkbox" name="bigElevator${parentClass}" id="big${id}">
            <p>Stor hiss</p>
            <input type="checkbox" name="smallElevator${parentClass}" id="small${id}">
            <p>Liten hiss</p>
        </div>
        <div>
        <div>
            <input style="width:75%;" type="text" placeholder=" " name="adress${parentClass}" id="adress${id}">
            <label for="adress${id}">Adress...</label>
        </div>
        <input style="width:25%;" type="number" placeholder="Nr..." name="adressNr${parentClass}" id="adressnr${id}">
    </div>
    
<div>
    <input type='text' id='zip${id}' placeholder=' ' name='zipcode${parentClass}'>
    <label for='zip${id}'>Postnummer...</label>
</div>

<div>
    <input type='text' id='city${id}' placeholder=' ' name='city${parentClass}'>
    <label for='city${id}'>Ort...</label>
</div>

<div>
    <input type='text' id='living${id}' placeholder=' ' name='living${parentClass}'>
    <label for='living${id}'>Bostadsyta...</label>
</div>

<div>
    <input type='text' id='contact${id}' placeholder=' ' name='contact${parentClass}'>
    <label for='contact${id}'>Kontaktperson...</label>
</div>

<div>
    <input type='tel' id='phone${id}' placeholder=' ' name='phone${parentClass}'>
    <label for='phone${id}'>Telnummer...</label>
</div>
        <div class="removeable">
            <a style="text-decoration:none;" href="JavaScript:void(0)">
                <p class="add-adress"><i class="fas fa-plus-circle"></i>Lägg till adress</p>
            </a>
        </div>
        <div class="arrows insertAfter${parentClass}">
        <i class="fas fa-exchange"></i>
        <i class="fas fa-trash"></i>
    </div>
        `).insertAfter(insertAfter);

    var x, i, j, selElmnt, a, b, c;
    /*look for any elements with the class "custom-select":*/
    x = document.getElementsByClassName("new-custom-select")[document.getElementsByClassName("new-custom-select").length - 1];

    $("." + parentClass + " .new-custom-select select").append($($("#boende-example select").html()));
    $(".new-custom-select").removeClass("new-custom-select");
    selElmnt = x.getElementsByTagName("select")[0];
    $($(insertAfter)[0]).removeClass("insertAfter" + parentClass);
    /*for each element, create a new DIV that will act as the selected item:*/
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x.appendChild(a);
    /*for each element, create a new DIV that will contain the option list:*/
    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    for (j = 1; j < selElmnt.length; j++) {
        /*for each option in the original select element,
        create a new DIV that will act as an option item:*/
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function(e) {
            /*when an item is clicked, update the original select box,
            and the selected item:*/
            var y, i, k, s, h;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            h = this.parentNode.previousSibling;
            for (i = 0; i < s.length; i++) {
                if (s.options[i].innerHTML == this.innerHTML) {
                    s.selectedIndex = i;
                    h.innerHTML = this.innerHTML;
                    y = this.parentNode.getElementsByClassName("same-as-selected");
                    for (k = 0; k < y.length; k++) {
                        y[k].removeAttribute("class");
                    }
                    this.setAttribute("class", "same-as-selected");
                    break;
                }
            }
            h.click();
        });
        b.appendChild(c);
    }
    x.appendChild(b);
    a.addEventListener("click", function(e) {
        /*when the select box is clicked, close any other select boxes,
        and open/close the current select box:*/
        e.stopPropagation();
        closeAllSelect(this);
        this.nextSibling.classList.toggle("select-hide");
        this.classList.toggle("select-arrow-active");
    });
    $("." + parentClass + " .add-adress").click(e => {
        let parentClassNew = $(e.target).parents(".move-from").attr("class") ? $(e.target).parents(".move-from").attr("class") : $(e.target).parents(".move-to").attr("class");
        newAdress(e, parentClassNew)
    });
    $(".arrows .fa-exchange").off();
    $(".arrows .fa-exchange").click(e => {
        upOrDown(e.target);
    });
    $(".arrows .fa-trash").off();
    $(".arrows .fa-trash").click(e => {
        removePlace(e.target);
    });

}


$(".arrows .fa-exchange").click(e => {
    upOrDown(e.target)
});

function upOrDown(target) {
    let place = 0;
    let parentClass = $(target).parents(".move-from").attr("class") ? $(target).parents(".move-from").attr("class") : $(target).parents(".move-to").attr("class");
    for (let i = 0; i < $("." + parentClass + " .arrows .fa-exchange").length; i++) {
        if ($(target).is($($("." + parentClass + " .arrows .fa-exchange")[i]))) {
            place = i;
            break;
        }
    }
    let length = $(`input[name=adress${parentClass}`).length;
    if (place == length - 1) return;
    //adding log
    addLog("Switched");
    $("input[name=bigElevatorto]").prop("checked")
    let move = {
        typeofliving: $($(`.${parentClass} .custom-select .select-selected`)[place]).html(),
        bigElevator: $($(`input[name=bigElevator${parentClass}]`)[place]).prop("checked"),
        smallElevator: $($(`input[name=smallElevator${parentClass}]`)[place]).prop("checked"),
        adress: $($(`input[name=adress${parentClass}]`)[place]).val(),
        adressNr: $($(`input[name=adressNr${parentClass}]`)[place]).val(),
        zipcode: $($(`input[name=zipcode${parentClass}]`)[place]).val(),
        city: $($(`input[name=city${parentClass}]`)[place]).val(),
        living: $($(`input[name=living${parentClass}]`)[place]).val(),
        contact: $($(`input[name=contact${parentClass}]`)[place]).val(),
        phone: $($(`input[name=phone${parentClass}]`)[place]).val()
    }
    $($(`.${parentClass} .custom-select .select-selected`)[place]).html($($(`.${parentClass} .custom-select .select-selected`)[place + 1]).html())
    $($(`input[name=bigElevator${parentClass}]`)[place]).prop("checked", $($(`input[name=bigElevator${parentClass}]`)[place + 1]).prop("checked"))
    $($(`input[name=smallElevator${parentClass}]`)[place]).prop("checked", $($(`input[name=smallElevator${parentClass}]`)[place + 1]).prop("checked"))
    $($(`input[name=adress${parentClass}]`)[place]).val($($(`input[name=adress${parentClass}]`)[place + 1]).val())
    $($(`input[name=adressNr${parentClass}]`)[place]).val($($(`input[name=adressNr${parentClass}]`)[place + 1]).val())
    $($(`input[name=zipcode${parentClass}]`)[place]).val($($(`input[name=zipcode${parentClass}]`)[place + 1]).val())
    $($(`input[name=city${parentClass}]`)[place]).val($($(`input[name=city${parentClass}]`)[place + 1]).val())
    $($(`input[name=living${parentClass}]`)[place]).val($($(`input[name=living${parentClass}]`)[place + 1]).val())
    $($(`input[name=contact${parentClass}]`)[place]).val($($(`input[name=contact${parentClass}]`)[place + 1]).val());
    $($(`input[name=phone${parentClass}]`)[place]).val($($(`input[name=phone${parentClass}]`)[place + 1]).val());

    $($(`.${parentClass} .custom-select .select-selected`)[place + 1]).html(move.typeofliving);
    $($(`input[name=bigElevator${parentClass}]`)[place + 1]).prop("checked", move.bigElevator);
    $($(`input[name=smallElevator${parentClass}]`)[place + 1]).prop("checked", move.smallElevator);
    $($(`input[name=adress${parentClass}]`)[place + 1]).val(move.adress);
    $($(`input[name=adressNr${parentClass}]`)[place + 1]).val(move.adressNr);
    $($(`input[name=zipcode${parentClass}]`)[place + 1]).val(move.zipcode);
    $($(`input[name=city${parentClass}]`)[place + 1]).val(move.city);
    $($(`input[name=living${parentClass}]`)[place + 1]).val(move.living);
    $($(`input[name=contact${parentClass}]`)[place + 1]).val(move.contact);
    $($(`input[name=phone${parentClass}]`)[place + 1]).val(move.phone);

}
$(".arrows .fa-trash").click(e => {
    removePlace(e.target);
});

function removePlace(target) {
    let place = 0;
    let parentClass = $(target).parents(".move-from").attr("class") ? $(target).parents(".move-from").attr("class") : $(target).parents(".move-to").attr("class");
    for (let i = 0; i < $("." + parentClass + " .arrows .fa-trash").length; i++) {
        if ($(target).is($($("." + parentClass + " .arrows .fa-trash")[i]))) {
            place = i + 1;
            break;
        }
    }
    let length = $(`input[name=adress${parentClass}]`).length;
    let last = $($("." + parentClass + " .fa-trash")[$("." + parentClass + " .fa-trash").length - 1]);
    $(target).parent().remove();
    //adding log
    addLog("removeAdress");
    $($(`.${parentClass} .custom-select`)[place]).remove();
    $($(`.${parentClass} .checkbox`)[place]).remove();
    $($(`input[name=adress${parentClass}]`).parent()[place]).parent().remove();
    $($(`input[name=zipcode${parentClass}]`).parent()[place]).remove();
    $($(`input[name=city${parentClass}]`).parent()[place]).remove();
    $($(`input[name=living${parentClass}]`).parent()[place]).remove();
    $($(`input[name=contact${parentClass}]`).parent()[place]).remove();
    $($(`input[name=phone${parentClass}]`).parent()[place]).remove();
    $($(`.${parentClass} .removeable`)[place]).remove();
    if ($(target).is(last)) {
        $($(`.${parentClass} .removeable`)[place - 1]).html(`
        <a style="text-decoration:none;" href="#">
            <p class="add-adress"><i class="fas fa-plus-circle"></i>Lägg till adress</p>
        </a>`)
        $($("." + parentClass + " .arrows")[$("." + parentClass + " .arrows").length - 1]).addClass("insertAfter" + parentClass);
        $("." + parentClass + " .add-adress").click(e => {
            let parentClassNew = $(e.target).parents(".move-from").attr("class") ? $(e.target).parents(".move-from").attr("class") : $(e.target).parents(".move-to").attr("class");
            newAdress(e, parentClassNew)
        });

    }

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