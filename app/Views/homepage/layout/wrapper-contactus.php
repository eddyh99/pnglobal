<?php 
require_once('header-contactus.php');
if (isset($content)) {
    echo view($content);
}
require_once('footer-contactus.php');
