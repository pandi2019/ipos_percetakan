<?php
session_start();

include '../../config/auth.php';
include '../../config/database.php';
include '../../templates/header.php';

$id_user = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM user WHERE id=$id_user")->fetch_assoc();

// UPDATE NAMA
if(isset($_POST['update_profil'])){
    $username = $_POST['username'];

    $conn->query("UPDATE user SET username='$username' WHERE id=$id_user");

    $_SESSION['username'] = $username; 

    header("Location: index.php?page=profil&status=username");
    exit;
}

// UPDATE PASSWORD
if(isset($_POST['update_password'])){
    $pass_lama = $_POST['password_lama'];
    $pass_baru = $_POST['password_baru'];

    if(!password_verify($pass_lama, $user['password'])){
        $error = "Password lama salah!";
    } else {

        
        $pass_baru_hash = password_hash($pass_baru, PASSWORD_DEFAULT);

        
        $conn->query("UPDATE user 
        SET password='$pass_baru_hash' 
        WHERE id=$id_user");

        header("Location: index.php?page=profil&status=password");
        exit;
    }
}
?>

<h3 class="mb-4 fw-bold"><i class="bi bi-person-circle"></i> Pengaturan Akun</h3>

<?php if(isset($error)){ ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php } ?>

<?php if(isset($_GET['status']) && $_GET['status']=='username'){ ?>
<div class="alert alert-success">Nama berhasil diupdate!</div>
<?php } ?>

<?php if(isset($_GET['status']) && $_GET['status']=='password'){ ?>
<div class="alert alert-success">Password berhasil diupdate!</div>
<?php } ?>

<div class="row g-4">

<!-- PROFILE CARD -->
<div class="col-md-4">
<div class="card shadow border-0 text-center p-4">

    <div class="mb-3">
        <i class="bi bi-person-circle" style="font-size:80px; color:#6c757d;"></i>
    </div>

    <h5 class="fw-bold"><?= $user['username'] ?></h5>
    <p class="text-muted">User Aktif</p>

</div>
</div>

<!-- FORM AREA -->
<div class="col-md-8">

<!-- GANTI NAMA -->
<div class="card shadow border-0 mb-4">
<div class="card-body">

<h5 class="fw-bold mb-3"><i class="bi bi-pencil-square"></i> Ganti Nama</h5>

<form method="post">
    <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-person"></i></span>
        <input type="text" name="username" class="form-control" 
        value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
    </div>

    <button type="submit" name="update_profil" class="btn btn-primary w-100">
        Simpan Perubahan
    </button>
</form>

</div>
</div>

<!-- GANTI PASSWORD -->
<div class="card shadow border-0">
<div class="card-body">

<h5 class="fw-bold mb-3"><i class="bi bi-lock"></i> Ganti Password</h5>

<form method="post">
    <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-key"></i></span>
        <input type="password" name="password_lama" class="form-control" placeholder="Password Lama" required>
    </div>

    <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
        <input type="password" name="password_baru" class="form-control" placeholder="Password Baru" required>
    </div>

    <button type="submit" name="update_password" class="btn btn-danger w-100">
        Update Password
    </button>
</form>

</div>
</div>

</div>
</div>
<?php include '../../templates/footer.php'; ?>