<?php

    require_once 'core/init.php';

    if( !$user->is_logged_in() ){
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Anda harus login terlebih dahulu
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        Session::flash('login','".$alert."');
        Redirect::to('login');
    }

    if ( !$user->is_admin(Session::get('username')) ){
        Session::flash('profile','Anda harus login sebagai admin terlebih dahulu');
        Redirect::to('profile');
    }

    $users = $user->get_users();

    require_once 'templates/header.php';
?>

    <div class="container">

        <h2 class="">Halaman Admin</h2>
    
        <?php foreach($users as $_user){ ?>
            <div class="">
                <!-- <a href="profile.php?nama=<?= $_user['username']; ?>"> 
                    <p><?= $_user['username']; ?></p> -->
                    <ul class="list-group">
                        <a href="profile.php?nama=<?= $_user['username']; ?>" rel="noopener noreferrer">
                            <li class="list-group-item">
                                <?= $_user['username']; ?>
                            </li>
                        </a>
                        
                    </ul> 
                </a>
            </div>
            
        <?php } ?>    
    </div>

<?php  require_once 'templates/footer.php'; ?>