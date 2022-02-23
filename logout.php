<?php

require_once 'core/init.php';
session_destroy();
// header('Location: login.php');  // redirect ke login.php
Redirect::to('login');

?>