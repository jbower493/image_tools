<?php

require_once './helpers/session.php';
require_once './helpers/redirect.php';
require_once './helpers/process.php';

$user = getUser();

if (!$user) {
    redirect('/login.php');
}

$transformationType = $_POST['transformation'];
$textLineOne = $_POST['lineOne'];
$textLineTwo = $_POST['lineTwo'];

function uploadFile()
{
    if ($_FILES['image']['name'] === '') {
        return [
            "success" => false,
            "error" => "No file provided.",
            "filePath" => null
        ];
    }

    $targetDir = './uploads';
    $targetFileName = basename($_FILES["image"]["name"]);
    $targetFilePath = strtolower($targetDir . "/" . $targetFileName);

    $imageFileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $check = getimagesize($_FILES["image"]["tmp_name"]);

    if ($check === false) {
        return [
            "success" => false,
            "error" => "File is not an image.",
            "filePath" => null
        ];
    }

    if ($_FILES["image"]["size"] > 500000) {
        return [
            "success" => false,
            "error" => "File is too large.",
            "filePath" => null
        ];
    }

    if ($imageFileType != "jpg") {
        return [
            "success" => false,
            "error" => "File type not allowed.",
            "filePath" => null
        ];
    }

    $isUploadStored = move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);

    if (!$isUploadStored) {
        return [
            "success" => false,
            "error" => "Upload failed.",
            "filePath" => null
        ];
    }

    return [
        "success" => true,
        "error" => null,
        "filePath" => $targetFilePath
    ];
}

$processingResult = null;

$result = uploadFile();

if ($result['success']) {
    $processingResult = processFile($result['filePath'], $transformationType, $textLineOne, $textLineTwo);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/main.css" type="text/css" rel="stylesheet">
    <title>Image Tools</title>
</head>

<body>
    <?php if ($processingResult && $processingResult["success"]) : ?>
        <h1>Success!</h1>
        <div class="process"><img src="<?php echo $processingResult['newImagePath'] ?>"></div>
    <?php else : ?>
        <h1>Error!</h1>
        <p><?php echo $processingResult ? $processingResult["error"] : $result['error'] ?></p>
    <?php endif; ?>
    <a href="/">Back to index</a>
</body>

</html>