
$(".rut-buttons button").click(function() {
    let action = $(this).attr("id");
    let internalNotes = $("#internalNotes").val();
    let generatedId = $("body").attr("id");
    $(`<input type=hidden value=${action} name='action' >`).appendTo("form[name=request]");
    $(`<input type=hidden value='${internalNotes}' name='internalNotes'>`).appendTo("form[name=request]");
    $(`<input type=hidden value='${generatedId}' name='generatedId'>`).appendTo("form[name=request]");


    function arrayInput(name, $type) {
        var inputs = $($type);
        let length = inputs.filter(`[name=${name}]`).length;
        console.log(length)
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

    var form = $("form[name=request]");
    var formaction = "/" + form.attr("action");
    var method = form.attr("method");
    var data = form.serialize();
    
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