<?php
set_time_limit(-1);
if (!ini_get('date.timezone')) {
    date_default_timezone_set('Asia/Dhaka');
}
session_start();
//$session_id='1'; //$session id
$session_id = session_id();

$yFolder = "uploads/" . date("Y");
if (!file_exists($yFolder)) {
    mkdir($yFolder, 0777, true);
    $myfile = fopen($yFolder . "/index.html", "w");
    fclose($myfile);
}
$ym = date("Y") . "/" . date("m") . "/";
$ym1 = "uploads/" . date("Y") . "/" . date("m");
if (!file_exists($ym1)) {
    mkdir($ym1, 0777, true);
    $myfile = fopen($ym1 . "/index.html", "w");
    fclose($myfile);
}

$path = "uploads/";

$selected_file = $_POST["selected_file"];
$isRequired = $_POST["isRequired"];
$req = "";
if ($isRequired == "1")
    $req = "required";

$validateFieldName = $_POST["validateFieldName"];
$valid_formats = array("pdf"); //"jpg", "png", "gif", "bmp", "txt", "doc", "docx",
$validFileFlag = "";
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_FILES[$selected_file]['name'];
    $size = $_FILES[$selected_file]['size']; // bytes

    $file_size = round($size / (1024 * 1024), 1); // megabytes with 1 digit

    if (strlen($name)) {
        //list($txt, $ext) = explode(".", $name);
        $i = strripos($name, '.');
        if ($i > 0 && $i + 2 < strlen($name)) {
            $ext = strtolower(substr($name, $i + 1));
        } else {
            $ext = 'xxxxx';
        }
        if (in_array($ext, $valid_formats)) {
            if ($file_size <= 1) { // maximum file size 2 MB
                //          $actual_image_name = $session_id."_sig_".substr(str_replace(" ", "_", $txt), 5).".".$ext;
                //          $actual_image_name = $session_id."_".date("H_i_s").".".$ext;
                $actual_image_name = uniqid("DCCI_COS_OPN_", true) . "." . $ext;
                $tmp = $_FILES[$selected_file]['tmp_name'];
                if (move_uploaded_file($tmp, $path . $ym . $actual_image_name)) {
                    //           For Image if you want to display
                    //          echo "<img src='ajaximage/uploads/".$ym.$actual_image_name."' class='preview' style='width:150px; height=150px;' >";
                    $validFileFlag = $ym . $actual_image_name;
                    $flag = 'span_' . $validateFieldName;
                    echo "<font class=$flag color='#000' style='white-space: pre;'>-Uploaded file size is " . number_format($size / 1024) . ' KB </font>';
                } else
                    echo "-failed";
            } else
                echo "-File size max 1 MB";
        } else
            echo "-Invalid file format..";
    } else
        echo "-Please select file..!";
}
?>
<input type="hidden" <?php echo $req == "" ? "" : 'class="required"'; ?> value="<?php echo $validFileFlag; ?>"
       id="<?php echo $validateFieldName; ?>" name="<?php echo $validateFieldName; ?>"/>