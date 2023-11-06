<?php
//stopper session redirecter til index side
session_start();
session_unset();
session_destroy();
header("location:../index.php");