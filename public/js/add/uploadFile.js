let uploadFiles = [];
$("#uploadFile").click(e => {
    e.preventDefault();
    var form = $("form[name=fileUploader]");
    var formaction = "/" + form.attr("action");
    var method = form.attr("method");
    var data = form.serialize();
    var file_data = $("#fileInput").prop('files')[0];
    var form_data = new FormData();
    if (file_data) {
        areYouSure("Vill du ladda upp " + file_data.name + "?", success => {
            if (success) {

                form_data.append('file', file_data);
                form_data.append("rgid", $("body").attr("id"));
                if (!$.urlParam("oid")) {
                    uploadFiles.push({
                        url: formaction, // point to server-side PHP script 
                        dataType: 'text', // what to expect back from the PHP script, if anything
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: method
                    })
                    addAlert(`Kommer ladda upp ${file_data.name} när förfrågan är skapad.`, "Sucess");
                    $("#show-files").prepend($(`<span style="cursor:default;"><i id="uploadFiles-${uploadFiles.length - 1}"class='deleteFile fad fa-times'></i><a style="color:grey">${file_data.name}</a></span>`));
                    $(`#uploadFiles-${uploadFiles.length - 1}`).click(function() {
                        let filename = $(this).parent().children()[1].innerHTML;
                        areYouSure("Vill du ta bort " + filename + "?", () => {
                            let i = $(this).attr("id").split("-")[1];
                            uploadFiles.splice(i, 1);
                            $(this).parent().remove();
                            addAlert("Du tog bort " + filename + "!", "Sucess")
                        })

                    })
                } else {
                    $.ajax({
                        url: formaction, // point to server-side PHP script 
                        dataType: 'text', // what to expect back from the PHP script, if anything
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: method,
                        success: function(data) {
                            if (data.length > 1) {
                                data = JSON.parse(data);
                            } else {
                                addAlert("Något gick fel, försök igen!", "Failed");
                                return;
                            }
                            let allowed = data["allowed"];
                            let fileName = data["fileName"];
                            if (allowed) {
                                let rgid = $("body").attr("id");
                                $("#show-files").prepend($(`<span><i class='deleteFile fad fa-times'></i><a href='/requestFiles/${rgid}/${fileName}' target='_blank'>${fileName}</a></span>`));
                                addLog("Fileupload");
                                $($(".deleteFile")[0]).click(function() {
                                    deleteFile(this)
                                });
                                addAlert("Du laddade upp " + fileName + "!", "Sucess");
                            } else {
                                addAlert(fileName, "Warning")
                            }

                        }
                    });
                }
            }
        })
    }
});
$(".deleteFile").click(function() {
    deleteFile(this)
});

function deleteFile(_this) {
    let path = $($(_this).parent().children()[1]).attr("href");
    let filename = $(_this).parent().children()[1].innerHTML;
    areYouSure("Vill du ta bort " + filename + "?", () => {
        $.post("liveData/getLiveData.php", { action: "removeFile", path }).done(success => {
            if (success) {
                $(_this).parent().remove();
                addLog("removeFile");
                addAlert("Du tog bort " + filename + "!", "Sucess")
            }
        });
    });
}