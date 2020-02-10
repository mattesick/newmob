<?php include "dropdowns/dropdown.php"; ?>

<nav id="myTopnav">
    <ul>
        <a class="" style="position:absolute; height:80px; width:150px" href="index.php"></a>
            <li id="logo">
                <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                    <i class="fa fa-bars fa-2x"></i>
                </a>
            </li>
        <a class="nav-item" href="add.php">
            <li class="center-flex">
                <div id="add"></div>
            </li>

        </a>

        <a class="nav-item" href="orders.php">
            <li class="center-flex">
                <div id="register"></div>
            </li>
        </a>
        <?php
        //These are dropdowns that are made in dropdown.php. Look at mallDropDown.php to see an example of a dropdown.
        makeDropDown("MAGASINERING", array(
            new DropdownItem("MAGASINREGISTER", "#"),
            new DropdownItem("VISA RITNING", "#"),
            new DropdownItem("ALLMÄNNA BESTÄMMELSER", "#"),
            new DropdownItem("FULLMAKT", "#"),
            new DropdownItem("UPPSÄGNING", "#"),
            new DropdownItem("INVENTARIELISTA", "#"),
            new DropdownItem("LAGAR & BESTÄMMELSER", "#")
        ), "customer", "admin");



        makeDropDown("EKONOMI", array(
            new DropdownItem("FAKTURAREGISTER", "#"),
            new DropdownItem("AVRÄKNING", "#"),
            new DropdownItem("PERSONAL", "#"),
            new DropdownItem("RUT-REGISTER", "#"),
            new DropdownItem("EXPORT FÖR BOKFÖRNING", "#"),
            new DropdownItem("IMPORTERA BESLUT", "#")
        ), "CUSTOMER" ,"Admin");

        ?>
        <a class="nav-item" href="#">
            <li>
                <p>STATISTIK</p>
            </li>
        </a>
        <div class="right-side-menu">
            <li id="search">

                <form action="search.php" method="post">
                    <button type="submit"><i class="far fa-search"></i></button>
                    <input type="text" placeholder="Sök..">
                </form>

            </li>
            <a class="nav-item" href="settings.php">
                <li>
                    <p><i style="padding:0;" class="fas fa-cog fa-2x"></i></p>
                </li>
            </a>
        </div>
    </ul>
</nav>
<input type="hidden" id="hiddenName" value='<?php echo $engine->getName($_SESSION["uid"]);?>'>
<script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "") {
            x.className += "responsive";
        } else {
            x.className = "";
        }
    }
</script>
<div class="row">
          <div class="col-lg-12">
              <?php show_messsage('success'); ?>
              <?php show_messsage('danger'); ?>
              <?php show_messsage('info'); ?>
          </div>
      </div>