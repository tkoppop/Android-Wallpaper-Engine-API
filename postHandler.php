<?php
$url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if (isset($_POST["submit"]) && isset($_POST['key'])) {
    if ($_POST['key'] == "CodesEasy@Wallpaper@Test@App") {
        $target_image = "images/";
        $target_thumbnail = "thumbnails/";
        $imageFileType = strtolower(pathinfo(basename($_FILES["image"]["name"]), PATHINFO_EXTENSION));
        $thumbnailFileType = strtolower(pathinfo(basename($_FILES["thumbnail"]["name"]), PATHINFO_EXTENSION));

        $file_name_image = md5(microtime() . basename($_FILES["image"]["name"])) . "." . $imageFileType;
        $file_name_thumbnail = md5(microtime() . basename($_FILES["thumbnail"]["name"])) . "." . $imageFileType;

        $target_file_image = $target_image . $file_name_image;
        $target_file_thumbnail = $target_thumbnail . $file_name_thumbnail;
        $uploadImage = 1;
        $uploadThumbnail = 1;

        $checkImage = getimagesize($_FILES["image"]["tmp_name"]);
        $checkThumbnail = getimagesize($_FILES["thumbnail"]["tmp_name"]);

        if (checkImageAndUpload($checkImage, $target_file_image, $file_name_image, $imageFileType, "image")
            && checkImageAndUpload($checkThumbnail, $target_file_thumbnail, $file_name_thumbnail, $thumbnailFileType, "thumbnail")) {
            if (addToWallpaperJSON($_POST['title'], $url . $target_file_thumbnail, $url . $target_file_image))
                successMessage("Wallpaper Successfully Added");
            else errorMessage("Failed to add JSON");
        } else {
            errorMessage("Failed adding wallpaper");
        }
    } else errorMessage("Access Key error.");
}

function checkImageAndUpload($check, $target_file, $fileName, $imageFileType, $type)
{
    if ($check !== false) {
        $uploadImage = 1;
        if (uploadImage($target_file, $fileName, $imageFileType, $uploadImage, $type)) {
            return true;
        } else return false;
    } else {
        errorMessage("Images files are only allowed.");
        return false;
    }
}

function uploadImage($target_file, $fileName, $imageFileType, $uploadOk, $type)
{
    if (file_exists($target_file)) {
        errorMessage("Sorry, file already exists.");
        $uploadOk = 0;
    }
    if ($_FILES["$type"]["size"] > 20000000) {
        errorMessage("Sorry, your file is too large.");
        $uploadOk = 0;
    }
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        errorMessage("Sorry, only JPG, JPEG and PNG files are allowed.");
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        return false;
    } else {
        if (move_uploaded_file($_FILES["$type"]["tmp_name"], $target_file)) {
            successMessage("File " . $fileName . " as been moved to storage.");
            return true;
        } else {
            errorMessage("Error while moving " . $fileName . ".");
            return false;
        }
    }
}

function addToWallpaperJSON($title, $thumbnail, $image)
{
    $file = file_get_contents('apis/wallpaper.json', true);
    if ($file === false) {
        return false;
    } else {
        $data = json_decode($file, true);
        if ($data === NULL) {
            return false;
        } else {
            unset($file);
            $data[] = array('title' => $title, 'thumbnail' => $thumbnail, 'image' => $image);
            $result = json_encode($data);
            if (file_put_contents('apis/wallpaper.json', $result) === false) {
                return false;
            }
            unset($result);
            return true;
        }
    }
}

function successMessage($message)
{
    echo '
    <div class="alert alert-success" role="alert">
        ' . $message . '
    </div>
    ';
}

function errorMessage($message)
{
    echo '
    <div class="alert alert-danger" role="alert">
        ' . $message . '
    </div>
    ';
}

?>