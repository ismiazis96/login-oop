<?php

    require_once 'core/init.php';

    if(!$user->is_logged_in()){
        Session::flash('login','Anda harus login terlebih dahulu');
        //header('Location: login.php');
        Redirect::to('login');
    }

    $user_data = $user->get_data(Session::get('username'));
    $errors    = array();

    if ( Input::get('submit') ){
        if( Token::check( Input::get('token') ) ){

            // 1. memanggil objek validasi
            $validation = new validation();
            // 2. metode check
            $validation = $validation->check(array(
                'password' => array('required' => true),
                'password_baru' => array(
                                    'required' => true,
                                    'min'      => 3,                        
                                    ),
                'password_verify'=> array(
                                    'required' => true,
                                    'match'    => 'password_baru'
                                    )
                ));
            // 3. lolos ujian
            if ( $validation->passed() ){
                // metode cek nama
                if ( password_verify(Input::get('password'),  $user_data['password']) ) {

                    $user->update_user(array(
                        'password' => password_hash(Input::get('password_baru'), PASSWORD_DEFAULT)
                    ), $user_data['id']);

                    Session::flash('success', 'Selamat Password berhasil diubah');
                    Redirect::to('profile');

                }else{
                    $errors[] = "password lama anda salah";
                }

            }else{
                $errors = $validation->errors();
            }
        } // end if token
    } //end if input submit

    require_once 'templates/header.php';
?>

<!-- <h2>Ganti Password</h2> -->
<h3 class="text-center">Hai <?= $user_data['username']; ?></h2>

<!-- <form action="change-password.php" type="post">
    <label for="password">Password Lama</label>
    <input type="password" name="password"> <br>

    <label for="password_baru">Password Baru</label>
    <input type="password" name="password_baru" id="password_baru"> <br>

    <label for="password_verify">Password Baru Konfirmasi</label>
    <input type="password" name="password_verify" id="password_verify"> <br>

    <input type="hidden" name="token" value="<?= Token::generate(); ?>">
    <input type="submit" name="submit" value="Ganti Password">

    <?php if(!empty($errors)){?>
        <div id="errors">
            <?php foreach ($errors as $error){ ?>
                <li><?php echo $error; ?></li>
            <?php } ?>    
        </div>
    <?php } ?>  
</form> -->

<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
                        <h3>Ubah Password</h3>
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form action="change-password.php" method="post">
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password" class="form-control input_user" value="" placeholder="Password Lama">
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password_baru" id="password_baru" class="form-control input_pass" value="" placeholder="Password Baru">
						</div>
                        <div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password_verify" id="password_verify" class="form-control input_pass" value="" placeholder="Konformasi Password Baru">
						</div>
                        <input type="hidden" name="token" value="<?= Token::generate();?>">
						<div class="d-flex justify-content-center mt-3 login_container">
                            <input type="submit" name="submit" class="btn login_btn" value="Ganti Password">
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


<?php require_once 'templates/footer.php'; ?>

