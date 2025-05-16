<?php

require_once('header.php');
require_once('mentor_sidebar.php');
if (isset($content)) {
    echo view($content);
}
require_once('footer.php');