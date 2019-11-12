<?php

session_start();
if (!$_SESSION['logged_in']) {
    header("Location: login.php");
} else {
    header("Location: overview_klanten.php");
}