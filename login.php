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
                    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                Anda berhasil melakukann Login
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>';
                    Session::flash('profile',$alert);
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



    <div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form action="login.php" method="post">
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