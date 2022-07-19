<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
      
      require '../elements/functions.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


    require '../auth/phpmailer/PHPMailer.php';
    require '../auth/phpmailer/Exception.php';
    require '../auth/phpmailer/SMTP.php';

    if (!empty($_POST)) {
        $errors = [];
        require_once '../elements/db.php';

        if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
            $errors['username'] = "Votre pseudo n'est pas valide (alpha-numerique) !";
        } else {
            $query = $pdo->prepare('SELECT id FROM users WHERE username = ?');
            $query->execute([$_POST['username']]);
            $user = $query->fetch();
            
            if ($user) {
                $errors['username'] = "Ce pseudo est deja pris !";
            }
        }

        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Votre email n'est pas valide !";
        } else {
            $query = $pdo->prepare('SELECT id FROM users WHERE email = ?');
            $query->execute([$_POST['email']]);
            $user = $query->fetch();
            
            if ($user) {
                $errors['email'] = "Cet email est deja utilise pour un autre compte !";
            }
        }

        if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
            $errors['password'] = "Vous devez entrer un mot de passe valide !";
        }

        if (empty($errors)) {
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                $query = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?");
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $token = str_random(60);
                $query->execute([$_POST['username'], $password, $_POST['email'], $token]);
                $user_id = $pdo->lastInsertId();

                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'apachecordovax@gmail.com';                     //SMTP username
                $mail->Password   = 'ubblyazegpciiodi';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;      
                $mail->SMTPOptions = array(
                    'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                    );                              //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('apachecordovax@gmail.com', 'Mailer');
                $mail->addAddress($_POST['email'], $_POST['username']);     //Add a recipient
                

                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Confirmation de votre compte';
                $mail->Body    = "Afin de valider votre compte, merci de cliquer sur ce lien\n\nhttp://localhost:8000/auth/confirm.php?id=$user_id&token=$token<b>in bold!</b>";

                $mail->send();

                // mail($_POST['email'], "Confirmation de votre compte", "Afin de valider votre compte, merci de cliquer sur ce lien\n\nhttp://localhost:8000/auth/confirm.php?id=$user_id&token=$token");
                $_SESSION['flash']['success'] = "Un email de confirmation vous a ete envoye pour valider votre compte.";
                header('Location: /auth/login.php');
                exit();
                // echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }


            

            
        }
    }
?>

<?php require '../elements/header.php'; ?>


<div class="container">
    <div class="row mb-5">
        <div class="col-md-6 mt-4 mx-auto">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach?>
                    </ul>
                </div>
            <?php endif ?>

            <div class="card">
                <div class="card-header">
                    <h4>S'inscrire</h4>
                </div>

                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="pseudo" class="form-label">Pseudo</label>
                            <input type="text" name="username" id="pseudo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password_confirm" class="form-label">Confirmez votre mot de passe</label>
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">S'inscrire</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../elements/footer.php'; ?>