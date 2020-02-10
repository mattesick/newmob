<?php

makeDropDown("EKONOMI", array(
    new DropdownItem("FAKTURAREGISTER", "#"),
    new DropdownItem("AVRÄKNING", "#"),
    new DropdownItem("PERSONAL", "#"),
    new DropdownItem("RUT-REGISTER", "#"),
    new DropdownItem("EXPORT FÖR BOKFÖRNING", "#"),
    new DropdownItem("IMPORTERA BESLUIT", "#")
));
//THIS IS AN EXAMPLE OF WHAT THE OUTPUT OF MAKEDROPDOWN WILL BE.
?>

<a class="nav-item" href="#">
    <li id="EKONOMI-dropdown" class="">
        <p>EKONOMI <i class="far fa-angle-down"></i></p>
</a>
<ul class="dropdown-content">
    <a class="dropdown-item" href="#">
        <li>
            <p>FAKTURAREGISTER</p>
        </li>
    </a>
    <a class="dropdown-item" href="#">
        <li>
            <p>AVRÄKNING</p>
        </li>
    </a>
    <a class="dropdown-item" href="#">
        <li>
            <p>PERSONAL</p>
        </li>
    </a>
    <a class="dropdown-item" href="#">
        <li>
            <p>RUT-REGISTER</p>
        </li>
    </a>
    <a class="dropdown-item" href="#">
        <li>
            <p>EXPORTERA FÖR BOKFÖRNING</p>
        </li>
    </a>
    <a class="dropdown-item" href="#">
        <li>
            <p>IMPORTERA BESLUT</p>
        </li>
    </a>
</ul>

</li>