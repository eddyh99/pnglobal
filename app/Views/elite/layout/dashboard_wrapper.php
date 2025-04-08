<?php

require_once('dashboard_header.php');
require_once('dashboard_sidebar.php');
if (isset($content)) {
    echo view($content);
}
require_once('dashboard_footer.php');
