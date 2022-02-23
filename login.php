<?php
// csrf
   

require_once 'core/init.php';

if ($user->is_logged_in()) {
    //header('Location: profile.php');
    Redirect::to('profile');
}
if ( Session::exists('login') ) {
    echo Session::flash('login');
}

$errors = array();
if ( Input::get('submit') ){
    if( Token::check( Input::get('token') ) ){

        // 1. memanggil objek validasi
        $validation = new validation();
        // 2. metode check
        $validation = $validation->check(array(
            'username' => array('required' => true),
            'password' => array('required' => true)
            ));
        // 3. lolos ujian
        if ( $validation->passed() ){
            // metode cek nama
            if ($user->cek_nama( Input::get('username') )){
                if ($user->login_user( Input::get('username'), Input::get('password')) ){
                    
                    Session::flash('profile','Selamat anda berhasil login');
                    Session::set('username', Input::get('username'));
                    //header('Location: profile.php');
                    Redirect::to('profile');
                }else{
                    $errors[] = "login gagal";
                }

            }else{
                $errors[] = "username belum ada";
            }

        }else{
            $errors = $validation->errors();
        }
    } // end if token
} //end if input submit


require_once 'templates/header.php';
?>

<h2>Login disini</h2>
<form action="login.php" method="post">
    <label for="">Username :</label>
    <input type="text" name="username"><br>

    <label for="">Password :</label>
    <input type="password" name="password"><br><br>

    <input type="hidden" name="token" value="<?= Token::generate();?>">

    <input type="submit" name="submit" value="Login Sekarang">

    <?php if(!empty($errors)){?>
        <div id="errors">
            <?php foreach ($errors as $error){ ?>
                <li><?php echo $error; ?></li>
            <?php } ?>    
        </div>
    <?php } ?>    


</form>

<?php require_once 'templates/footer.php';