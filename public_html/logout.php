<?php
// logout.php

// Call session_start() to access session variables
session_start();

// Remove users auth
session_destroy();

// Redirect to index
header('Location: index.php');

exit();
?>
