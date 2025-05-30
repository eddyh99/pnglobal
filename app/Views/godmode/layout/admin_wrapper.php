<?php

require_once('admin_header.php');
require_once('admin_sidebar.php');
if (isset($content)) {
    echo view($content);
}
require_once('admin_footer.php');



