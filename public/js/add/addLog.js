var saveLog = [];

function postLog(string, rid) {
    let time = new Date();

    let hours = time.getHours() < 10 ? "0" + time.getHours() : time.getHours();
    let minutes = time.getMinutes() < 10 ? "0" + time.getMinutes() : time.getMinutes();
    let month = (time.getMonth() + 1) < 10 ? "0" + (time.getMonth() + 1) : (time.getMonth() + 1);
    let day = time.getDate() < 10 ? "0" + time.getDate() : time.getDate();
    let timeString = "<b>" + hours + ":" + minutes + ", " + day + "/" + month + " " + time.getFullYear() + "</b>";
    string = timeString + " - " + $("#hiddenName").val() + " " + string;
    if (rid) {
        $.post("/liveData/addLog.php", { string, rid });
    } else {
        saveLog.push({ string, rid });
    }
    $("#all-logs").prepend("<span style=display:block>" + string + "</span>");
}
$.urlParam = function(name) {
    var results = new RegExp('[?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (!results) return false;
    return results[1] || 0;
}

function addLog(action, rid = $.urlParam("oid") ? $.urlParam("oid") : 0) {
    switch (action) {
        case "Adress":
            postLog("La till en adress!", rid)
            break;
        case "removeAdress":
            postLog("Tog bort en adress!", rid);
            break;
        case "Person":
            postLog("La till en person!", rid);
            break;
        case "removePerson":
            postLog("Tog bort en adress!", rid);
            break;
        case "rutPerson":
            postLog("La till en person på delad RUT!", rid);
            break;
        case "removeRutPerson":
            postLog("Tog bort en person på delad RUT!", rid);
            break;
        case "RUT":
            postLog("La till en person på delad RUT!", rid);
            break;
        case "removeRUT":
            postLog("Tog bort en person på delad RUT!", rid);
            break;
        case "Exchange":
            postLog("Bytte sida på informationen", rid);
            break;
        case "Switched":
            postLog("Bytte plats på adresser", rid);
            break;
        case "Article":
            postLog("Valde en artikel", rid);
            break;
        case "removeArticle":
            postLog("Tog bort en vald artikel", rid);
            break;
        case "Fileupload":
            postLog("Ladda upp en fil!", rid);
            break;
        case "removeFile":
            postLog("Tog bort en fil!", rid);
            break;
        case "State":
            postLog("Påbörjade ...!", rid);
            break;

        default:
            break;
    }
}