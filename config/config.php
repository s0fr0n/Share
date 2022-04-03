<?php

// Report all PHP errors
error_reporting(E_ALL);
// Report all PHP errors
error_reporting(-1);
// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
   
ob_start(); //Start remembering everything that would normally be outputted, but don't quite do anything with it yet
$ob_output = ob_get_contents(); //Gives whatever has been &quot;saved&quot;
    //ob_end_clean(); //Stops saving things and discards whatever was saved
    //ob_flush(); //Stops saving and outputs it all at once
session_start();
$timezone = date_default_timezone_set( "Europe/Athens" );