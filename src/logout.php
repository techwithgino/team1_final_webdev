<?php

//This is self explanatiory i think
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit;
