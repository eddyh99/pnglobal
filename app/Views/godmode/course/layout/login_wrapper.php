<?php

require_once('login_header.php');

if (isset($content)) {
    echo view($content);
}
require_once('login_footer.php');



