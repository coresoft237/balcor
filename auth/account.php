<?php 

require '../elements/header.php'; 
logged_only();
?>

<div class="container">
    <h1>Bonjour <?= $_SESSION['auth']->username ?></h1>
</div>

<?php require '../elements/footer.php'; ?>