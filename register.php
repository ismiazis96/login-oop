<?php

require_once 'core/init.php';

if ($user->is_logged_in()) {
    header('Location: profile.php');
}

$errors = array();
if ( Input::get('submit') ){
    if (Token::check( Input::get('token') )){

    // 1. memanggil objek validasi
    $validation = new validation();
    // 2. metode check
    $validation = $validation->check(array(
        'username' => array(
                        'required' => true,
                        'min'      => 3,
                        'max'      => 50,
                    ),
        'password' => array(
                        'required' => true,
                        'min'      => 3,
                    ),
        'password_verify' => array(
                         'required' => true,
                         'match'    => 'password'  
                    )
        ));
    // metode cek nama
    if( $user->cek_nama(Input::get('username')) ){
        $errors[] = "username sudah ada";
    } else {
        // 3. lolos ujian
        if ( $validation->passed() ){
    
            $user->register_user(array(
                'username' => Input::get('username'),
                'password' => password_hash(Input::get('password'), PASSWORD_DEFAULT)
            ));
            
            Session::flash('profile','Selamat anda berhasil mendaftar');
            Session::set('username', Input::get('username'));
            //header('Location: profile.php');
            Redirect::to('profile');
        }else{
            $errors = $validation->errors();
        }
    }

    } // end if token
        
}


require_once 'templates/header.php';
?>

<h2>Daftar disini</h2>
<form action="register.php" method="post">
    <label for="">Username :</label>
    <input type="text" name="username"><br>

    <label for="">Password :</label>
    <input type="password" name="password"><br>
    
    <label for="">Ulangi Password :</label>
    <input type="password" name="password_verify"><br>
    <br>
    <input type="hidden" name="token" value="<?= Token::generate(); ?>">

    <input type="submit" name="submit" value="Daftar Sekarang">

    <?php if(!empty($errors)){?>
        <div id="errors">
            <?php foreach ($errors as $error){ ?>
                <li><?php echo $error; ?></li>
            <?php } ?>    
        </div>
    <?php } ?>    


</form>

<?php require_once 'templates/footer.php';