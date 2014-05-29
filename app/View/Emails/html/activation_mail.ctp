<html>
    <body>
        <p>Hello <?php echo $username;?>,</p><br>
        Please click on below link to activate your account<br>
        <a href="<?php echo $activation_link?>">Activate My account</a><br>
        
            Here are your credentials for the account,<br>
            Username/Email : <?php echo $username;?><br>
            password : <?php echo $password;?>
    </body>
</html>