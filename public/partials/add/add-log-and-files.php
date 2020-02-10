
<div id="log-and-files">
    <div id="files">
        <form action="liveData/uploadFile.php" method="POST" enctype="multipart/form-data" name="fileUploader" id="fileUploader">
            <input id="fileInput" type="file" name="fileToUpload" accept=".jpg, .png, .pdf, .docx">
            <input id="uploadFile" type="submit" name="submit" value="Upload">
        </form>
        <div id="show-files">
            <?php
            if (isset($_GET["oid"]) && $engine->getRequestId($_GET["oid"])) {
                $rgid = $engine->provider->fetchRow('SELECT generatedId FROM Request WHERE id = ?', array($_GET["oid"]))["generatedId"];
                $path = $_SERVER["DOCUMENT_ROOT"] . "requestFiles" . DIRECTORY_SEPARATOR . $rgid;
                if (file_exists($path)) {
                    $files = array_diff(scandir($path), array('.', '..'));
                    foreach ($files as $file => $fileName) {
                        if(is_file($path . DIRECTORY_SEPARATOR . $fileName))
                            echo "<span><i class='deleteFile fad fa-times'></i><a href='requestFiles/$rgid/$fileName' target='_blank'>$fileName</a></span>";
                    }
                }
            }


            ?>
        </div>
    </div>
    <div id="logs">
        <h4>Redigeringslogg</h4>
        <div id="all-logs">
        </div>
    </div>
</div>