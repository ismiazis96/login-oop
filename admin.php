<?php

    require_once 'core/init.php';

    if( !$user->is_logged_in() ){
        Session::flash('login','Anda harus login terlebih dahulu');
        Redirect::to('login');
    }

    if ( !$user->is_admin(Session::get('username')) ){
        Session::flash('profile','Anda harus login sebagai admin terlebih dahulu');
        Redirect::to('profile');
    }

    $users = $user->get_users();

    require_once 'templates/header.php';
?>

    <h2>Halaman Admin</h2>

    <?php foreach($users as $_user){ ?>
        <div class="">
            <a href="profile.php?nama=<?= $_user['username']; ?>"> 
                <p><?= $_user['username']; ?></p> 
            </a>
        </div>
        
    <?php } ?>    

<?php  require_once 'templates/footer.php'; ?>