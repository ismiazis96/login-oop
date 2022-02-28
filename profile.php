<?php

    require_once 'core/init.php';

    if(!$user->is_logged_in()){
        Session::flash('login','Anda harus login terlebih dahulu');
        //header('Location: login.php');
        Redirect::to('login');
    }

    if( Session::exists('profile') ){
        echo Session::flash('profile');
    }

    if(Input::get('nama')){
        $user_data = $user->get_data(Input::get('nama'));
    }else{
        $user_data = $user->get_data(Session::get('username'));
    }


    require_once 'templates/header.php';
?>
    <h2>Profile</h2>
    <h3>Hai <?= $user_data['username']; ?></h3><br>

    <?php if( $user_data['username'] == Session::get('username') ){ ?>

        <a href="change-password.php">Ganti Password</a><br>
        
        <!-- fungsi khusus admin role = 1 -->
        <?php if($user->is_admin( Session::get('username') )){ ?>
            <a href="admin.php">Admin</a>
        <?php } ?>    
    <?php } ?>
            

<?php require_once 'templates/footer.php'; ?>

