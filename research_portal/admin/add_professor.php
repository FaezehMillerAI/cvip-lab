
<?php
session_start();
require_once("../includes/db.php");

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
$name = trim($_POST['name']);
$position = trim($_POST['position']);
$field = trim($_POST['field']);
$email = trim($_POST['email']);
$scholar = trim($_POST['scholar_link']);
$linkedin = trim($_POST['linkedin']);
$bio = trim($_POST['bio']);
    $image_name = null;

    // آپلود عکس استاد
    if(!empty($_FILES['image']['name'])){
        $allowed = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if(in_array($ext, $allowed)){

            if(!is_dir("../uploads")){
                mkdir("../uploads",0777,true);
            }

            $image_name = time() . "_" . rand(1000,9999) . "." . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image_name);

        } else {
            $message = "Invalid image format!";
        }
    }

    if(empty($message)){
$stmt = $conn->prepare("INSERT INTO professor
(name, position, field, email, scholar_link, linkedin, bio, image)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
"ssssssss",
$name,
$position,
$field,
$email,
$scholar,
$linkedin,
$bio,
$image_name
);

        if($stmt->execute()){
            $message = "Professor added successfully!";
        } else {
            $message = "Database error: " . $stmt->error;
        }

        $stmt->close();
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Add Professor</title>

<style>
body{
    margin:0;
    font-family:'Inter',sans-serif;
    background:#f1f5f9;
}
.container{
    max-width:800px;
    margin:60px auto;
    background:white;
    padding:40px;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,0.05);
}
h2{ margin-top:0; }
input, textarea{
    width:100%;
    padding:12px;
    margin-bottom:18px;
    border:1px solid #e2e8f0;
    border-radius:8px;
    font-size:14px;
}
button{
    background:#0f172a;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
}
button:hover{ opacity:0.9; }
.success{ color:green; }
.error{ color:red; }
</style>

</head>
<body>

<div class="container">
<h2>Add New Professor</h2>

<?php if($message): ?>
<p class="<?= strpos($message,'successfully') !== false ? 'success':'error' ?>">
    <?= htmlspecialchars($message) ?>
</p>
<?php endif; ?>
<label>Name</label>
<input type="text" name="name" required>

<label>Position</label>
<input type="text" name="position">

<label>Research Field</label>
<input type="text" name="field">

<label>Email</label>
<input type="email" name="email">

<label>Google Scholar</label>
<input type="text" name="scholar_link">

<label>LinkedIn</label>
<input type="text" name="linkedin">

<label>Biography</label>
<textarea name="bio" rows="5"></textarea>

<label>Profile Image</label>
<input type="file" name="image">

<button type="submit">Save Professor</button>
</form>
</div>

</body>
</html>
