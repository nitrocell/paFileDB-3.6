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

/* Database Configuration */

/* Database driver to use. Any ADOdb driver can be used, however, only mysql and mysqli have been tested and included with paFileDB. If you don't know what to put here, you should leave it as mysql */
$dbDriver = "mysql";

/* Database server to connect to. */
$dbServer = "localhost";

/* Username to use to connect to the database. */
$dbUser = "username";

/* Password for the above username. */
$dbPass = "password";

/* The name of the database to use. */
$dbName = "pafiledb";

/* Table name prefix. Anything entered here will be added before the table name, allowing multiple installations of paFileDB in the same database */
$dbPrefix = "pafiledb_";

/* Set to true to use persistent connections, otherwise set to false. This should be kept as true unless you experience problems with the database connection, then it should be set to false.*/
$dbPConnect = true;

/* Other settings */

/* Disallowed extensions for file uploads. If anyone gains unauthorized
access to your admin center, or one of your admins decides to go 
the-internet-equivalent-of-postal, they can upload a script file using 
the Add File function and run it in their browser, which can allow them 
to do very, very bad things to your paFileDB, website, and entire server.
You can use the disallowed extensions to prevent the uploading of various 
script types, such as PHP. It is recommended that you do not remove any
of the extensions in this list, and if you want to upload a script for 
others to download, it's best to zip it first.

Separate extensions by a space, and do not add the period before them.
*/
$disallowedExtensions = "php php3 php4 php5 phtml shtml fcgi cgi pl asp aspx jsp py sh cfm";


/* DO NOT CHANGE ANYTHING BELOW THIS LINE */
$db = &ADONewConnection($dbDriver);
if ($dbPConnect) {
	$db->PConnect($dbServer, $dbUser, $dbPass, $dbName);
} else {
	$db->Connect($dbServer, $dbUser, $dbPass, $dbName);
}
?>