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

    if (!empty($_POST) && !empty($_POST['email'])) {
        require_once '../elements/db.php';

        $query = $pdo->prepare('SELECT * FROM users WHERE email = :email AND confirmed_at IS NOT NULL');
        $query->execute([
            'email' => $_POST['email']
        ]);
        $user = $query->fetch();

        if ($user) {
            $mail = new PHPMailer(true);

            try {
                $reset_token = str_random(60);
                $query = $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?');
                $query->execute([$reset_token, $user->id]);

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
                $mail->Subject = 'Reinitialisation de votre mot de passe';
                $mail->Body    = "Afin de reinitialiser votre mot de passe, merci de cliquer sur ce lien\n\nhttp://localhost:8000/auth/confirm.php?id={$user->id}&token=$reset_token<b>in bold!</b>";

                $mail->send();

                $_SESSION['flash']['success'] = 'Les instructions du rappel de mot de passe vous ont ete envoyees par email !';
                header('Location: login.php');
                exit();
                // echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['flash']['danger'] = 'Aucun ne correspond a cette adresse email !';
        }
    }
?>
<?php require '../elements/header.php'; ?>

<div class="container">
    <div class="row mb-5">
        <div class="col-md-6 mt-4 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4>Mot de passe oublie</h4>
                </div>

                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group my-2">
                            <button class="btn btn-primary btn-block" type="submit">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../elements/footer.php'; ?>