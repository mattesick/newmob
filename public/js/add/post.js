$(".rut-buttons button").click(async function() {
    $(".loading").show();
    let action = $(this).attr("id");
    let internalNotes = $("#internalNotes").val();
    let generatedId = $("body").attr("id");
    $(`<input type=hidden value=${action} name='action' >`).appendTo("form[name=request]");
    $(`<input type=hidden value='${internalNotes}' name='internalNotes'>`).appendTo("form[name=request]");
    $(`<input type=hidden value='${generatedId}' name='generatedId'>`).appendTo("form[name=request]");
    for (let i = 0; i < $("input[name=name]").length; i++) {
        let id = $($("input[name=name]")[i]).parent().attr("id") ? $($("input[name=name]")[i]).parent().attr("id") : 0;
        //if id == 0 it means that we havent chosen a person, so we will make it instad.
        if (id == 0) {
            let user = {
                    firstname: $($("input[name=name]")[i]).val(),
                    lastname: $($("input[name=lname]")[i]).val(),
                    phone: $($("input[name=phone]")[i]).val(),
                    email: $($("input[name=email]")[i]).val(),
                    personalcode: $($("input[name=org]")[i]).val(),

                }
                //should only take these if he is the first user being made.
            if (i == 0) {
                user.billingadress = $($("input[name=badress]")[i]).val();
                user.zipcode = $($("input[name=zipcode]")[i]).val();
                user.city = $($("input[name=city]")[i]).val();
                user.billingemail = $($("input[name=fepost]")[i]).val();
                user.billingreference = $(".customer-info .select-selected").text() || "";
            }
            let create = false;
            for (let prop in user) {
                if (user[prop] && user[prop].length > 0) create = true;
            }
            if (create) {
                user = JSON.stringify(user);
                await $.post("/liveData/database_api.php", { action: "createPerson", user }).done((newId) => {
                    $(`<input type=hidden value='${newId}' name='person${i}'>`).appendTo("form[name=request]");
                });
            }

        } else {
            $(`<input type=hidden value='${id}' name='person${i}'>`).appendTo("form[name=request]");
        }

    }
    for (let i = 0; i < $("input[name=adressmove-to]").length; i++) {
        let id = $($("input[name=adressmove-to]")[i]).parent().attr("id");
        $(`<input type=hidden value='${id}' name='adressidmove-to${i}'>`).appendTo("form[name=request]");
    }
    for (let i = 0; i < $("input[name=adressmove-from]").length; i++) {
        let id = $($("input[name=adressmove-from]")[i]).parent().attr("id");
        $(`<input type=hidden value='${id}' name='adressidmove-from${i}'>`).appendTo("form[name=request]");
    }


    //if the input have the same name they will be changed to the name + x. for example person makes person0, person1, person2...
    function arrayInput(name, $type) {
        let inputs = $($type);
        let length = inputs.filter(`[name=${name}]`).length;
        if (length > 1) {
            let inputsNew = inputs.filter(`[name=${name}]`);
            for (let i = 0; i < length; i++) {
                $($(inputsNew)[i]).attr("name", $($(inputsNew)[i]).attr("name") + i);
            }
        }
    }
    for (let i = 0; i < $("form[name=request] input").length; i++) {
        arrayInput($($("form[name=request] input")[i]).attr("name"), "input");
    }
    for (let i = 0; i < $("form[name=request] select").length; i++) {
        arrayInput($($("form[name=request] select")[i]).attr("name"), "select");
    }

    let form = $("form[name=request]");
    let formaction = "/" + form.attr("action");
    let method = form.attr("method");
    let data = form.serialize();

    $.ajax({
        type: method,
        url: formaction,
        data: data,
        success: () => {
            saveLog.forEach(log => {
                log.rid = $("body").attr("id");
                $.post("/liveData/addLog.php", log);
            });
            uploadFiles.forEach(file => {
                $.ajax({
                    url: file.url, // point to server-side PHP script 
                    dataType: file.dataType, // what to expect back from the PHP script, if anything
                    cache: file.cache,
                    contentType: file.contentType,
                    processData: file.processData,
                    data: file.data,
                    type: file.type,
                    success: function(data) {
                        data = JSON.parse(data);
                        if (data["allowed"]) addLog("Fileupload", $("body").attr("id"));
                    }
                });


            })
            if (action == "addRequest") action = "forfr";
            else if (action == "addOffer") action = "offer";
            else if (action == "addOrder") action = "ordra";
            else if (action == "addIncomplete") action = "forfr"
            window.location.href = "orders.php?req=" + action;
        }
    });
});