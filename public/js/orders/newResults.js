$("#results").scroll(function() {
    if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
        let state = $(".active").text();
        if (state == "FÖRFRÅGNINGAR") state = "FÖRFRÅGAN";
        let currentLimit = $("tr").length - 1;
        $(".loading").show();
        $.post("/liveData/getLiveData.php", { action: "newResults", state, currentLimit }).done(data => {
            data = JSON.parse(data)
            requests = data[0];
            users = data[1];
            requests.forEach((result, index) => {
                let dueDate = result.dueDate ? result.dueDate.split(" ")[0] : "";
                let dueTime = result.dueTime ? result.dueTime : "";
                let userName = users[index] ? users[index].firstname + " " + users[index].lastname : "";
                let userId = users[index] ? users[index].uid : "";
                let incomplete = (result.state == "INCOMPLETE") ? "red" : "";
                let element = `
                <tr class="${incomplete}">
                <td><a href="add.php?oid=${result.id}">${result.id}</a></td>
                <td>${result.created}</td>
                <td><a href="customer.php?uid=${userId}">${userName}</a></td>
                <td>${dueDate}</td>
                <td>${dueTime}</td>
                <td>Flyttpaket 2, Malmö - Arlöv</td>
                <td>LB</td>
                <td>4h</td>
                <td>EKO</td>
                <td>
                    <div class="order-table-buttons">
                        <i class="fas fa-arrow-alt-to-bottom"></i>
                        <i class="fas fa-trash"></i>
                    </div>
                </td>
            </tr>
                `;
                $(element).appendTo($("tbody"))

            });
            $(".loading").hide();
        });
    }
})