<?php

    require_once 'core/init.php';

    if(!$user->is_logged_in()){
        $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Anda harus login terlebih dahulu
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        Session::flash('login',$alert);
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
    <div class="container">
        <div class="jumbotron">
            <h3 class="display-4">Profile</h3>
            <p class="lead">Hai <?= $user_data['username']; ?></p>
            <hr class="my-2">
            <p>More info pengguna</p>
            <?php if( $user_data['username'] == Session::get('username') ){ ?>

                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="change-password.php" role="button">Ganti Password</a>
                </p>
                <?php if($user->is_admin(Session::get('username'))){ ?>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="admin.php" role="button">Admin</a>
                </p>
                <?php } ?> 

            <?php } ?>
        </div>
    </div>
   

<?php require_once 'templates/footer.php'; ?>

