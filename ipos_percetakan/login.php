<?php
session_start();
include 'config/database.php';
$_SESSION['login'] = true;
$_SESSION['success'] = "Selamat, Anda telah masuk";
$error = "";

if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE username=?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if($data){
        if(password_verify($pass, $data['password'])){
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $data['id'];  
            $_SESSION['username'] = $data['username'];    

            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>AGAIN'S PERCETAKAN</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #e346b9, #764ba2);">

<div class="container d-flex justify-content-center align-items-center vh-100">

<div class="p-4 text-white" style="
    width: 350px;
    border-radius: 20px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
">

<div class="text-center mb-3">
    <img src="assets/ag.png" class="rounded-circle" width="80">
    <h4 class="mt-2">LOGIN</h4>
</div>

<?php if(!empty($error)){ ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php } ?>

<form method="post">

<div class="mb-3">
<input type="text" name="username" class="form-control" placeholder="Username">
</div>

<div class="mb-3">
<input type="password" name="password" class="form-control" placeholder="Password">
</div>

<button class="btn btn-light w-100" name="login">Login</button>

</form>

</div>
</div>

</body>
</html>