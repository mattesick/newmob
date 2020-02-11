function addAlert(msg, color) {
    let alf = "abcdefghijklmnopqrstwxyzABDEFGHIJLKMNOPQRSGTVXYZ";
    let id = "";
    for (let i = 0; i < 10; i++) {
        id += alf[Math.round(Math.random() * (alf.length - 1))];
    }
    switch (color) {
        case "Warning":
            color = "#F6D559";
            break;
        case "Sucess":
            color = "#A4FF7C";
            break;
        case "Failed":
            color = "#FF7C7C";
            break;
        default:
            color = "#A4FF7C";
            break;
    }
    $(".alerts").append($(`<div id=${id} style="background-color:${color}; display:none" class='alert'>${msg}<i style="float:right;"class="fad fa-times" aria-hidden="true"><span style="right:-100px;"class="alert-after"></span></div>`));
    $(`<style>#${id} .alert-after{ background-color:${color} }</style>`).appendTo("head")
    $("#" + id + " i").click(function() {
        $("#" + id).remove();
    })
    $("#" + id).fadeIn(1000, () => {
        $("#" + id + " .alert-after").fadeIn();
        $("#" + id + " .alert-after").css("right", "-25px");
        $("#" + id + " .alert-after").css("transform", "rotateZ(765deg)");
    });


    setTimeout(() => {
        $("#" + id + " .alert-after").fadeOut(400, () => {
            $("#" + id).fadeOut(400);
        });
        setTimeout(() => {
            $("#" + id).remove();
        }, 800)
    }, 5000)

}
//Testing
// setTimeout(() => {
//     addAlert("Du laddade upp en fil!", "Warning");
//     addAlert("Du laddade upp en fil!", "Sucess");
//     addAlert("Du laddade upp en fil!", "Failed");
// }, 1000)
function areYouSure(string, callback, deniedCallback = () => { return false }) {
    $("#modal").empty();
    $("#modal").modal("show");
    $("#modal").append(`<div class='are-you-sure'><h3>Är du säker?</h3><p>${string}</p><button id="iamsure">JA</button><button id="iamnotsure">NEJ</button></div>`)
    $("#iamsure").click(callback);
    $("#iamnotsure").click(deniedCallback);
    $(".are-you-sure button").click(() => {
        $("#modal").modal("hide");
    })
}