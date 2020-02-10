<?php
require_once "../boot.php";
include_once "rights/auth.php"; ?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include "js/scripts.php";
    include "css/style.php";
    ?>
    <link rel="stylesheet" href="css/index.css">
    <link href='fullcalendar-4.3.1/packages/core/main.css' rel='stylesheet' />
    <link href='fullcalendar-4.3.1/packages/daygrid/main.css' rel='stylesheet' />
    <link href='fullcalendar-4.3.1/packages/timegrid/main.css' rel='stylesheet' />
    <link href='fullcalendar-4.3.1/packages/list/main.css' rel='stylesheet' />
    <script src='fullcalendar-4.3.1/packages/core/main.js'></script>
    <script src='fullcalendar-4.3.1/packages/core/locales-all.js'></script>
    <script src='fullcalendar-4.3.1/packages/interaction/main.js'></script>
    <script src='fullcalendar-4.3.1/packages/daygrid/main.js'></script>
    <script src='fullcalendar-4.3.1/packages/timegrid/main.js'></script>
    <script src='fullcalendar-4.3.1/packages/list/main.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let initialLocaleCode = 'sv';
            let calendarEl = document.getElementById('calendar');
            let events = [];
            <?php
            $events = $engine->provider->fetchResultSet('SELECT * FROM Request');
            if ($events->rowCount() !== 0) {
                while ($events->next()) {
                    $start = explode(" ", $events->row["dueDate"])[0];
                    if ($events->row["dueTime"]) $start .= "T" . $events->row["dueTime"];

            ?>
                    events.push({
                            title: <?php echo json_encode($events->row["state"]); ?>, // a property!
                            start: <?php echo json_encode($start) ?>, // a property!
                            url: "add.php?oid=" + <?php echo json_encode($events->row["id"]); ?>,
                            id: <?php echo json_encode($events->row["id"]); ?>,
                        }

                    );

            <?php }
            }
            ?>
            let calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                events: events,
                themeSystem: "bootstrap4",
                locale: initialLocaleCode,
                buttonIcons: true, // show the prev/next text
                weekNumbers: true,
                navLinks: true, // can click day/week names to navigate views
                eventStartEditable: true,

                eventLimit: true, // allow "more" link when too many events
                eventRender: function(info) {
                    console.log(info)
                   // $(info.el).css("background", "red")

                },


                eventDrop: function(info, view) {
                    let tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
                    let date = (new Date(info.event.start - tzoffset)).toISOString().slice(0, -1);
                    console.log(info.event)
                    areYouSure("Vill du flytta " + info.event.title + " till " + date.split("T")[0] + ", " + date.split("T")[1].substr(0, 5) + "?", () => {
                        //yes press
                        if (info.view.type == "dayGridMonth")
                            $.post("liveData/getLiveData.php", {
                                action: "draggedRequestDate",
                                id: info.event.id,
                                date: date
                            })
                        switch (info.view.type) {
                            case "dayGridMonth":
                                $.post("liveData/getLiveData.php", {
                                    action: "draggedRequestDate",
                                    id: info.event.id,
                                    date: date
                                })
                                break;
                            case "timeGridWeek":
                                $.post("liveData/getLiveData.php", {
                                    action: "draggedRequestDate",
                                    id: info.event.id,
                                    date: date
                                });
                                $.post("liveData/getLiveData.php", {
                                    action: "draggedRequestTime",
                                    id: info.event.id,
                                    date: date
                                })
                                break;
                            case "timeGridDay":
                                $.post("liveData/getLiveData.php", {
                                    action: "draggedRequestTime",
                                    id: info.event.id,
                                    date: date
                                })
                                break;
                            default:
                                break;
                        }
                    }, () => {
                        //No press
                        info.revert();
                    })
                },

            });

            calendar.render();



        });
    </script>
</head>

<body>
    <?php
    include_once "partials/nav.php";
    ?>
    <div class="welcome">
        <h2>VÄLKOMMEN, <?php echo $engine->getName($_SESSION["uid"]); ?>!</h2>
        <p><?php
            $dag = "";
            switch (date('w')) {
                case '0':
                    $dag = 'Söndag';
                    break;
                case '1':
                    $dag = 'Måndag';
                    break;
                case "2":
                    $dag = "Tisdag";
                    break;
                case "3":
                    $dag = "Onsdag";
                    break;
                case "4":
                    $dag = "Torsdag";
                    break;
                case "5":
                    $dag = "Fredag";
                    break;
                case "6":
                    $dag = "Lördag";
                    break;
            }
            echo $dag . " " . date("d-m-Y");
            ?></p>
    </div>
    <main>
        <div class="dashboard" id="calendar">

        </div>
        <div class="todo">
            <h2>Att göra:</h2>
            <div class="todo-tasks">
                <p>
                    - 08.00-10.00, Ta ut magasin(Röd 249.)
                </p>
                <p>
                    - 11.00, Ring Bosse.
                </p>
                <p>
                    - 13.00 - 14.00, Karls Aktiebolag AB kommer på besök till kontoret.
                </p>

            </div>

            <div id="addTodo"><i class="fas fa-plus-circle fa-2x"></i></div>
        </div>
        <div class="news">
            <h2>Nyheter:</h2>
            <div class="news-new">
                <p>
                    - Nytt system!
                </p>
                <p>
                    - Ny ägare, Transport AB
                </p>
                <p>
                    - Anna Andersson - Långtidsledig
                </p>
                <p>
                    - Ny ägare, Transport AB
                </p>
                <p>
                    - Anna Andersson -
                </p>

            </div>
            <a href="#">
                <div id="news-readmore">Läs mer</div>
            </a>
        </div>


    </main>
    <div class="modal fade" id="modal" role="dialog">
        <div class="modal-dialog modal-sm custom-modal">
            <div class="modal-content">
                <form class="addNew">
                </form>
            </div>
        </div>
    </div>
</body>

</html>