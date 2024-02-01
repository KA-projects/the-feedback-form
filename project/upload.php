<?php
header('Content-Type: application/json');
if ($_FILES['image']['size'] > UPLOAD_ERR_INI_SIZE * 1048576) {
    echo json_encode(array('error' => 'Размер картинки не должен быть больше 1 мб', 'size' => $_FILES['image']['size'], 'max-size-in-byte' => UPLOAD_ERR_INI_SIZE * 1048576));
} else if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tempName = $_FILES['image']['tmp_name'];
    $imageName = $_FILES['image']['name'];

    $uploadDir = 'uploads/';
    $targetPath = $uploadDir . $imageName;
    move_uploaded_file($tempName, $targetPath);

    $response = array('imageUrl' => $targetPath);
    echo json_encode($response);
} else {
    echo json_encode(array('error' => 'File upload failed.', 'size' => $_FILES['image']['size'], 'max-size-in-byte' => UPLOAD_ERR_INI_SIZE * 1048576));
}
?>