<?php

/***************************************************************
* paFileDB 3.6                                                 *
*                                                              *
* Author: PHP Arena <http://www.phparena.net>                  *
* File Version 3.6                                             *
* Copyright ©2005-2007 PHP Arena. All Rights Reserved.         *
*                                                              *
* THIS FILE MAY NOT BE REDISTRIBUTED.                          *
* For more information, please see the PHP Arena license at:   *
* http://www.phparena.net/license.html                         *
***************************************************************/

/**
  * This function checks the database to see if a user with the
  * given username and password combination exists. Returns true
  * or false.
  *
  * Parameters:
  *    $username: The username you are checking
  *    $password: The string that you want to check, should be MD5 encrypted
  *    $u: Optional, but if the username and password are correct,
  *       the member's info will be placed into this array.
  *
  */      
function checkpass($username, $password, &$u)
{
    global $db, $dbPrefix;
    
    //Run the query and put the resulting array in the $u array
    $u = $db->GetArray("SELECT * FROM ".$dbPrefix."users WHERE user_username = '".$username."' AND user_password = '".$password."'");
    
    /* Count the elements in $u. If the result is 0, no username exists with that
    password, so return false. Otherwise, it will be 1, which means the username
    and password combo exists, so you guessed it, return true. 
    if (count($u) == 0) { return false; }
    else { return true; }*/
    return (is_array($u) && count($u) == 1) ? true : false;
}


/**
  * checkaccess() will check if the user can access the section
  * of the admin center, and will error out if not.
  *
  * Parameters:
  *  $level: The minimum user level required for access,
  *    1 for moderator, 2 for admin, 3 for uber admin
  *
  */
function checkaccess($level) {
    global $userinfo;
    if ($userinfo[0]['user_status'] < $level) {
        smarty_error(lang('perm_denied'));
    }
}

$guestArray = array(array('user_userid' => 0, 'user_username' => lang('guest'), 'user_status' => 0));

if (isset($_COOKIE['pafiledb_user']) && isset($_COOKIE['pafiledb_pass'])) { //If the cookie exists, do all this:
    
    $userinfo = array();
    if (checkpass($_COOKIE['pafiledb_user'], $_COOKIE['pafiledb_pass'], $userinfo)) {
        //checkpass() returned true, so the user exists
        
        //$adminloggedin is a var used throughout the script to see if someone's logged in.
        if ($userinfo[0]['user_status'] == 1) {
        	smarty_error(lang('perm_denied'));
        }
        $userloggedin = true;
        if (!empty($userinfo[0]['user_passvalidation'])) {
        	$db->Execute("UPDATE ".$dbPrefix."users SET user_passvalidation = '' WHERE user_userid = ".$userinfo[0]['user_userid']);
        }
        $smarty->assign('userinfo', $userinfo[0]);
        
    } else { //The cookie exists, but the user/pass don't match
        
        //set $adminloggedin to false and trash the cookie so they're recognized as a guest
        $userloggedin = false;
        $smarty->assign('userinfo', $guestArray[0]);
        $userinfo = $guestArray;
        setcookie('pafiledb_user', '', time()-3600);
        setcookie('pafiledb_pass', '', time()-3600);
    }
} else {
    $userloggedin = false;
    $smarty->assign('userinfo', $guestArray[0]);
    $userinfo = $guestArray;
}

$smarty->assign('userloggedin', $userloggedin); //Send the stuff to Smarty

?>