<?php
session_start();
require_once("../includes/db.php");

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// بررسی شناسه استاد از URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: dashboard.php");
    exit();
}

// دریافت اطلاعات استاد بر اساس id (نه LIMIT 1)
$stmt = $conn->prepare("SELECT * FROM professor WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$professor = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$professor) {
    header("Location: dashboard.php");
    exit();
}

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // id استاد را از فرم می‌گیریم (امن‌تر از استفاده دوباره از GET)
    $post_id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    $name = $_POST['name'];
    $position = $_POST['position'];
    $field = $_POST['field'];
    $email = $_POST['email'];
    $scholar = $_POST['scholar_link'];
    $linkedin = $_POST['linkedin'];
    $bio = $_POST['bio'];

    $image_name = $professor['image'];

    if(!empty($_FILES['image']['name'])){
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','webp'];

        if(in_array($ext, $allowed)){

            if(!is_dir("../uploads")){
                mkdir("../uploads",0777,true);
            }

            $image_name = time().".".$ext;
            move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$image_name);
        }
    }

    // آپدیت دقیقا همان رکورد با id صحیح
    $stmt = $conn->prepare("UPDATE professor SET 
        name=?, position=?, field=?, email=?, scholar_link=?, linkedin=?, bio=?, image=? 
        WHERE id=?");

    $stmt->bind_param("ssssssssi",
        $name,$position,$field,$email,$scholar,$linkedin,$bio,$image_name,$post_id
    );

    if($stmt->execute()){
        $message = "Profile updated successfully!";
        header("Location: dashboard.php");
        exit();
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Professor</title>

<style>
body{font-family:Inter;background:#f1f5f9;margin:0}
.container{
    max-width:800px;
    margin:50px auto;
    background:white;
    padding:40px;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,0.05);
}
input,textarea{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ddd;
    border-radius:8px;
}
button{
    background:#0f172a;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:8px;
}
</style>
</head>

<body>

<div class="container">
<h2>Edit Professor Profile</h2>

<form method="POST" enctype="multipart/form-data">

    <!-- اضافه شدن فقط همین فیلد مخفی برای حفظ id -->
    <input type="hidden" name="id" value="<?= htmlspecialchars($professor['id']) ?>">

    <label>Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($professor['name']) ?>">

    <label>Position</label>
    <input type="text" name="position" value="<?= htmlspecialchars($professor['position']) ?>">

    <label>Research Field</label>
    <input type="text" name="field" value="<?= htmlspecialchars($professor['field']) ?>">

    <label>Email</label>
    <input type="text" name="email" value="<?= htmlspecialchars($professor['email']) ?>">

    <label>Google Scholar</label>
    <input type="text" name="scholar_link" value="<?= htmlspecialchars($professor['scholar_link']) ?>">

    <label>LinkedIn</label>
    <input type="text" name="linkedin" value="<?= htmlspecialchars($professor['linkedin']) ?>">

    <label>Biography</label>
    <textarea name="bio" rows="5"><?= htmlspecialchars($professor['bio']) ?></textarea>

    <label>Profile Image</label>
    <input type="file" name="image">

    <button type="submit">Save Changes</button>

</form>

</div>

</body>
</html>
