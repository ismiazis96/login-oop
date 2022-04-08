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

            
            
            Session::flash('profile','<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Selamat Anda berhasil mendaftar
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>');
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


<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
                        Daftar Disini
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form action="register.php" method="post">
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="username" class="form-control input_user" value="" placeholder="username">
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password" class="form-control input_pass" value="" placeholder="password">
						</div>
                        <div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password_verify" class="form-control input_pass" value="" placeholder="ulangi password">
						</div>
                        <input type="hidden" name="token" value="<?= Token::generate();?>">
						<div class="d-flex justify-content-center mt-3 login_container">
                            <input type="submit" name="submit" class="btn login_btn">
                        </div>

                        <?php if(!empty($errors)){?>
                            <div id="errors">
                                <?php foreach ($errors as $error){ ?>
                                    <li><?php echo $error; ?></li>
                                <?php } ?>    
                            </div>
                        <?php } ?>    

					</form>
				</div>
			</div>
		</div>
	</div>

<?php require_once 'templates/footer.php';