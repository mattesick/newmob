    
    $.post("liveData/requestInfo.php",{rid}).done(function(data) {

    }).fail(function() {
        window.location.href = "error.php";
    });