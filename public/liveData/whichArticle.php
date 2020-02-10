<?php
require_once "../../boot.php";
if (isset($_POST["article"])) {
    $articleTitle = $_POST["article"];
    $html = "";
    $result = $engine->provider->fetchResultSet('SELECT * from article WHERE articleTitle = ?', array($articleTitle));
    if ($result->rowCount() !== 0) {
        while ($result->next()) {
            $title = $result->row["title"];
            $aid = $result->row["id"];
            $html .= "
            <div>
            <div class='option'>
            <h2>$title</h2>";
            $resultButtons = $engine->provider->fetchResultSet('SELECT * from articleButton WHERE aid = ?', array($aid));
            if ($resultButtons->rowCount() !== 0) {
                while ($resultButtons->next()) {
                    $fmt = new NumberFormatter( 'de_DE', NumberFormatter::DECIMAL );
                    $price =  $fmt->format($resultButtons->row["price"]);
                    $ordPrice = $fmt->format($resultButtons->row["ordPrice"]);
                    $type = $resultButtons->row["type"];
                    $bid = $resultButtons->row["id"];
                    if($price && $ordPrice){
                        $html .= "
                        <button id='articleButton-$bid'><b>$type - $price:-</b>
                        <div>(ord. $ordPrice:-)</div>
                        </button>
                        ";
                    } else if($price){
                        $html .= "
                        <button id='articleButton-$bid'><b>$type - $price:-</b>
                        </button>
                        ";
                    } else if($type){
                        $html .= "
                        <button id='articleButton-$bid'><b>$type</b>
                        </button>
                        ";
                    }
                }
            }
            $html .= "
                </div>
                </div>
                ";
        }
    }
    echo $html;
}
