<?php

class DropdownItem
{

    // constructor
    public function __construct($title, $href)
    {
        $this->title = $title;
        $this->href = $href;
    }
}
function makeDropDown($title, $dropdownItems)
{
    if (func_num_args() > 2) {
        $shouldMakeDropDown = false;
        for ($i = 2; $i < func_num_args(); $i++) {
            if (strtolower(func_get_arg($i)) == strtolower($GLOBALS["engine"]->getRole($_SESSION["uid"]))) {
                $shouldMakeDropDown = true;
                $i = func_num_args();
            }
        }
        if (!$shouldMakeDropDown) return;
    }
    //random id generator for the dropdown.
    $alf = "ABCDEFGHIJKLMNOPQRSTXYZVabcdefighijlkknoqrstyvxyz";
    $id = "";
    for ($i = 0; $i < 16; $i++) {
        $random = rand(0, strlen($alf) - 1);
        $id .= $alf[$random];
    }

    ?>

    <!-- Outputs the navbar when looping through all the items i got from $dropdownItems -->

    <li id="<?php echo $id ?>" class="nav-item">
        <p><?php echo $title; ?> <i class="far fa-angle-down"></i></p>
        <ul class="dropdown-content">
            <?php
            foreach ($dropdownItems as $item) { ?>
                <a class="dropdown-item" href="<?php echo $item->href; ?>">
                    <li>
                        <p><?php echo $item->title; ?></p>
                    </li>
                </a>
            <?php } ?>
        </ul>

    </li>


<?php } ?>