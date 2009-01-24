<?php
App::import('vendor', 'dummy.dummydata/data');
/*------------------------------------------------------------------------------------------------*\
  Functions in brief:

   GENERATOR

     get_lipsum 
     get_firstnames
     get_surnames
     get_cities
     get_states
     get_colors
     get_provinces
     get_provinces_nl
     get_countries
     get_counties
     generate_random_text_str
     generate_random_num_str
     generate_random_alphanumeric_str
     generate_email_address
     generate_name
     generate_street_address
     return_random_subset
    
    USER ACCOUNTS
    
      get_account
      save_form
      load_form
      delete_form
      get_forms

    MISC 

      db_connect
      db_disconnect
      convert_datetime_to_timestamp
    
\*------------------------------------------------------------------------------------------------*/

// Including Cakes db config file
require_once 'config/database.php';

// a few globals
$g_title = "generatedata.com";

// MySQL database settings
//$g_table_prefix = "dg_"; // if you change this, be sure to update the SQL in /install/db_install.sql
//$g_db_hostname = "localhost";
//$g_db_name     = "dummy";
//$g_db_username = "root";
//$g_db_password = "";


/*------------------------------------------------------------------------------------------------*\
  Function:    db_connect
  Description: connects to a database. After connecting, you should always call
               disconnect_db() to close it when you're done.
\*------------------------------------------------------------------------------------------------*/
function db_connect() {
	// Using the same db config as cake
	$myDbConnection = new DATABASE_CONFIG();
	$g_db_name = $myDbConnection->default['database'];
	$g_db_username = $myDbConnection->default['login'];
	$g_db_password = $myDbConnection->default['password'];
	$g_db_hostname = $myDbConnection->default['host'];
	
	$g_table_prefix = "dg_"; // if you change this, be sure to update the SQL in /install/db_install.sql
	

	$link = mysql_connect($g_db_hostname, $g_db_username, $g_db_password);
	//or die("Couldn't connect to database.");
	mysql_select_db($g_db_name);
	// or die ("couldn't find database '$g_db_name'.");
	

	return $link;
}

/*------------------------------------------------------------------------------------------------*\
  Function:    db_disconnect
  Description: disconnects from a database
\*------------------------------------------------------------------------------------------------*/
function db_disconnect($link) {
	@mysql_close($link);
}

/*--------------------------------------------------------------------------*\
  Function:    get_lipsum
  Description: returns an array of lorem ipsum words. Assumes that a file 
	             exists in a misc/ subfolder called loremipsum.txt, containing 
							 lorem ipsum text. 
\*--------------------------------------------------------------------------*/
function get_lipsum() {
	// grab all the words in the text files & put them in an array (1 word per index) 
	$lines = file("misc/loremipsum.txt");
	$words = array();
	
	foreach ($lines as $line) {
		$words_in_line = preg_split("/\s+/", $line);
		$words = array_merge($words, $words_in_line);
	}
	
	return $words;
}

/*--------------------------------------------------------------------------*\
  Function:    get_firstnames
  Description: returns an array of first names
  Parameter:   gender - "male", "female", or empty for either
\*--------------------------------------------------------------------------*/
function get_firstnames($gender = "") {
	
	$names = &DummyDataSource::get_firstnames();
	
	return $names;
}
/*---
 * -----------------------------------------------------------------------*\
  Function:    get_urls
  Description: returns an array of urls
\*--------------------------------------------------------------------------*/
function get_urls() {
	$names = &DummyDataSource::get_urls();
	return $names;
}

/*--------------------------------------------------------------------------*\
  Function:    get_surnames
  Description: returns an array of surnames
\*--------------------------------------------------------------------------*/
function get_surnames() {
		
	$names = &DummyDataSource::get_surnames();
	return $names;
}

/*--------------------------------------------------------------------------*\
  Function:    get_cities
  Description: returns an array of cities
\*--------------------------------------------------------------------------*/
function get_cities() {
	global $g_table_prefix;
	
	$query = mysql_query("
    SELECT city
    FROM   {$g_table_prefix}cities
      ");
	
	$cities = array();
	while ($city_info = mysql_fetch_assoc($query))
		$cities[] = $city_info['city'];
	
	return $cities;
}

/*--------------------------------------------------------------------------*\
  Function:    get_colors
  Description: returns an array of cities
\*--------------------------------------------------------------------------*/
function get_colors() {
	
	$colors = &DummyDataSource::get_colors();
	
	return $colors;
}

/*--------------------------------------------------------------------------*\
  Function:    get_states
  Description: returns an array of first names
\*--------------------------------------------------------------------------*/
function get_states() {
	global $g_table_prefix;
	
	$query = mysql_query("
    SELECT state, state_short
    FROM   {$g_table_prefix}states
      ");
	
	$states = array();
	while ($state_info = mysql_fetch_assoc($query))
		$states[] = array($state_info['state'], $state_info['state_short']);
	
	return $states;
}

/*--------------------------------------------------------------------------*\
  Function:    get_provinces
  Description: returns an array of Canadian provinces
\*--------------------------------------------------------------------------*/
function get_provinces() {
	global $g_table_prefix;
	
	$query = mysql_query("
    SELECT province, prov_short
    FROM   {$g_table_prefix}provinces
      ");
	
	$provinces = array();
	while ($province_info = mysql_fetch_assoc($query))
		$provinces[] = array(
				$province_info['province'], 
				$province_info['prov_short']);
	
	return $provinces;
}

/*--------------------------------------------------------------------------*\
  Function:    get_provinces_nl
  Description: returns an array of Dutch provinces
\*--------------------------------------------------------------------------*/
function get_provinces_nl() {
	global $g_table_prefix;
	
	$query = mysql_query("
    SELECT *
    FROM   {$g_table_prefix}provinces_netherlands
      ");
	
	$provinces = array();
	while ($province_info = mysql_fetch_assoc($query))
		$provinces[] = array(
				$province_info['province'], 
				$province_info['prov_short']);
	
	return $provinces;
}

/*--------------------------------------------------------------------------*\
  Function:    get_counties
  Description: returns an array of UK counties
\*--------------------------------------------------------------------------*/
function get_counties() {
	global $g_table_prefix;
	
	$query = mysql_query("
    SELECT county, chapman_code
    FROM   {$g_table_prefix}counties
      ");
	
	$counties = array();
	while ($county_info = mysql_fetch_assoc($query))
		$counties[] = array($county_info['county'], $county_info['chapman_code']);
	
	return $counties;
}

/*--------------------------------------------------------------------------*\
  Function:    get_countries
  Description: returns an array of countries
\*--------------------------------------------------------------------------*/
function get_countries() {
	global $g_table_prefix;
	
	$query = mysql_query("
    SELECT country
    FROM   {$g_table_prefix}countries
      ");
	
	$countries = array();
	while ($country_info = mysql_fetch_assoc($query))
		$countries[] = $country_info['country'];
	
	return $countries;
}

/*--------------------------------------------------------------------------*\
  Function:    generate_random_text_str
  Parameters:  $starts_with_lipsum  - true/false
               $type                - "fixed"/"range"
               $min     - the minimum # of words to return OR the total number 
               $max     - the max # of words to return (or null for "fixed" type)
\*--------------------------------------------------------------------------*/
function generate_random_text_str($words, $starts_with_lipsum, $type, $min, $max = "") {
	// determine the number of words to return
	$index = 0;
	if ($type == "fixed")
		$num_words = $min;
	else if ($type == "range")
		$num_words = rand($min, $max);
	
	if ($num_words > count($words))
		$num_words = count($words);
		
	// determine the offset 
	$offset = 0;
	if (!$starts_with_lipsum)
		$offset = rand(2, count($words) - ($num_words + 1));
	
	$word_array = array_slice($words, $offset, $num_words);
	
	return join(" ", $word_array);
}

/*-----------------------------------------------------------------------------------------------*\
 Function: generate_random_num_str
 Purpose:  converts all x's and X's in a string with a random digit. X's: 1-9, x's: 0-9.
\*-----------------------------------------------------------------------------------------------*/
function generate_random_num_str($str) {
	// loop through each character and convert all unescaped X's to 1-9 and 
	// unescaped x's to 0-9.
	$new_str = "";
	for ($i = 0; $i < strlen($str); $i++) {
		if ($str[$i] == '\\' && ($str[$i + 1] == "X" || $str[$i + 1] == "x"))
			continue;
		else if ($str[$i] == "X") {
			if ($i != 0 && ($str[$i - 1] == '\\'))
				$new_str .= "X";
			else
				$new_str .= rand(1, 9);
		} else if ($str[$i] == "x")
			if ($i != 0 && ($str[$i - 1] == '\\'))
				$new_str .= "x";
			else
				$new_str .= rand(0, 9);
		else
			$new_str .= $str[$i];
	}
	
	return trim($new_str);
}

/*------------------------------------------------------------------------*\
 Function: generate_random_alphanumeric_str
 Purpose:  converts the following characters in the string and returns it:
           C, c, A - any consonant (Upper case, lower case, any)
           V, v, B - any vowel (Upper case, lower case, any)
           L, l, V - any letter (Upper case, lower case, any)
           X       - 1-9
           x       - 0-9
\*------------------------------------------------------------------------*/
function generate_random_alphanumeric_str($str) {
	$letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$consonants = "BCDFGHJKLMNPQRSTVWXYZ";
	$vowels = "AEIOU";
	
	// loop through each character and convert all unescaped X's to 1-9 and 
	// unescaped x's to 0-9.
	$new_str = "";
	for ($i = 0; $i < strlen($str); $i++) {
		switch ($str[$i]){
			// Numbers
			case "X":
				$new_str .= rand(1, 9);
			break;
			case "x":
				$new_str .= rand(0, 9);
			break;
			
			// Letters
			case "L":
				$new_str .= $letters[rand(0, strlen($letters) - 1)];
			break;
			case "l":
				$new_str .= strtolower($letters[rand(0, strlen($letters) - 1)]);
			break;
			case "D":
				$bool = rand() & 1;
				if ($bool)
					$new_str .= $letters[rand(0, strlen($letters) - 1)];
				else
					$new_str .= strtolower($letters[rand(0, strlen($letters) - 1)]);
			break;
			
			// Consonants
			case "C":
				$new_str .= $consonants[rand(0, strlen($consonants) - 1)];
			break;
			case "c":
				$new_str .= strtolower($consonants[rand(0, strlen($consonants) - 1)]);
			break;
			case "E":
				$bool = rand() & 1;
				if ($bool)
					$new_str .= $consonants[rand(0, strlen($consonants) - 1)];
				else
					$new_str .= strtolower($consonants[rand(0, strlen($consonants) - 1)]);
			break;
			
			// Vowels
			case "V":
				$new_str .= $vowels[rand(0, strlen($vowels) - 1)];
			break;
			case "v":
				$new_str .= strtolower($vowels[rand(0, strlen($vowels) - 1)]);
			break;
			case "F":
				$bool = rand() & 1;
				if ($bool)
					$new_str .= $vowels[rand(0, strlen($vowels) - 1)];
				else
					$new_str .= strtolower($vowels[rand(0, strlen($vowels) - 1)]);
			break;
			
			default:
				$new_str .= $str[$i];
			break;
		}
	}
	
	return trim($new_str);
}

/*-----------------------------------------------------------------------------------------------*\
 Function: generate_email_address
 Purpose:  generates and returns an email address with the following format:
             [PREFIX]@[DOMAIN].[SUFFIX]
             
               PREFIX: 1-3 lipsum words separated with period
               DOMAIN: 1-4 lipsum words with no separator
               SUFFIX: edu, com, org, ca
\*-----------------------------------------------------------------------------------------------*/
function generate_email_address($words) {
	// prefix
	$num_prefix_words = rand(1, 3);
	$offset = rand(0, count($words) - ($num_prefix_words + 1));
	$word_array = array_slice($words, $offset, $num_prefix_words);
	$word_array = preg_replace("/[,.]/", "", $word_array);
	$prefix = join(".", $word_array);
	
	// domain
	$num_domain_words = rand(1, 3);
	$offset = rand(0, count($words) - ($num_domain_words + 1));
	$word_array = array_slice($words, $offset, $num_domain_words);
	$word_array = preg_replace("/[,.]/", "", $word_array);
	$domain = join("", $word_array);
	
	// suffix
	$valid_suffixes = array("xx", "xz", "xz", "xc");
	$suffix = $valid_suffixes[rand(0, count($valid_suffixes) - 1)];
	
	$email = "$prefix@$domain.$suffix";
	
	return $email;
}

/*-----------------------------------------------------------------------------------------------*\
 Function: generate_name
 Purpose:  converts certain characters
\*-----------------------------------------------------------------------------------------------*/
function generate_name($str, $male_names, $female_names, $names, $surnames) {
	$letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	
	while (preg_match("/MaleName/", $str))
		$str = preg_replace("/MaleName/", get_random_name($male_names), $str, 1);
	while (preg_match("/FemaleName/", $str))
		$str = preg_replace("/FemaleName/", get_random_name($female_names), $str, 1);
	while (preg_match("/Name/", $str))
		$str = preg_replace("/Name/", get_random_name($names), $str, 1);
	while (preg_match("/Surname/", $str))
		$str = preg_replace("/Surname/", $surnames[rand(0, count($surnames) - 1)], $str, 1);
	while (preg_match("/Initial/", $str))
		$str = preg_replace("/Initial/", $letters[rand(0, strlen($letters) - 1)], $str, 1);
	
	return trim($str);
}

/*-----------------------------------------------------------------------------------------------*\
 Function: generate_street_address
 Purpose:  generates a street address
\*-----------------------------------------------------------------------------------------------*/
function generate_street_address($words) {
	$street_address = "";
	$street_name = ucwords(generate_random_text_str($words, false, "fixed", 1));
	$valid_str_types = array(
			"St.", 
			"St.", 
			"Street", 
			"Road", 
			"Rd.", 
			"Rd.", 
			"Ave", 
			"Av.", 
			"Avenue");
	$street_type = $valid_str_types[rand(0, count($valid_str_types) - 1)];
	
	$format = rand(1, 4);
	
	switch ($format){
		case "1":
			$street_address = "P.O. Box " . rand(100, 999) . ", " . rand(100, 9999) . " $street_name " . $street_type;
		break;
		case "2":
			$street_address = rand(100, 999) . "-" . rand(100, 9999) . " $street_name " . $street_type;
		break;
		case "3":
			$street_address = "Ap #" . rand(100, 999) . "-" . rand(100, 9999) . " $street_name " . $street_type;
		break;
		case "4":
			$street_address = rand(100, 9999) . " $street_name " . $street_type;
		break;
	}
	
	return $street_address;
}

/*-----------------------------------------------------------------------------------------------*\
 Function: get_random_name
\*-----------------------------------------------------------------------------------------------*/
function get_random_name($name_array) {
	$name = $name_array[rand(0, count($name_array) - 1)];
	if (is_array($name)) {
		return $name[0];
	}
	return $name;
}

/*-----------------------------------------------------------------------------------------------*\
 Function: get_random_color
\*-----------------------------------------------------------------------------------------------*/
function get_random_color($name_array) {
	return $name_array[rand(0, count($name_array) - 1)];
}

/*-----------------------------------------------------------------------------------------------*\
  Function:    return_random_subset
  Description: accepts an array as an argument, and returns a random subset 
               of its elements. May be empty, or the same set.
  Parameters:  $set - the set of items
               $num - the number of items in the set to return
\*-----------------------------------------------------------------------------------------------*/
function return_random_subset($set, $num) {
	// check $num is no greater than the total set
	if ($num > count($set))
		$num = count($set);
	
	shuffle($set);
	return array_slice($set, 0, $num);
}

/*------------------------------------------------------------------------------------------------*\
  Function:    get_account
\*------------------------------------------------------------------------------------------------*/
function get_account($account_id) {
	global $g_table_prefix;
	
	$link = db_connect();
	
	$query = mysql_query("
    SELECT *
    FROM   {$g_table_prefix}user_accounts
    WHERE  account_id = $account_id
      ");
	$user_info = mysql_fetch_assoc($query);
	
	$form_count_query = mysql_query("
    SELECT count(*)
    FROM   {$g_table_prefix}forms
    WHERE  account_id = $account_id
      ");
	$form_count = mysql_fetch_array($form_count_query);
	db_disconnect($link);
	
	// temp!
	

	$user_info["num_forms_saved"] = $form_count[0];
	
	return $user_info;
}

/*------------------------------------------------------------------------------------------------*\
  Function:    save_form
\*------------------------------------------------------------------------------------------------*/
function save_form($account_id, $form_name, $form_content) {
	global $g_table_prefix;
	
	$link = db_connect();
	
	// find out if there's already a form with this name for this user
	$count_query = mysql_query("
    SELECT count(*)
    FROM   {$g_table_prefix}forms
    WHERE  account_id = $account_id
    AND    form_name = '$form_name'
      ");
	
	$result = mysql_fetch_row($count_query);
	$form_already_exists = ($result[0] == 0) ? false : true;
	
	if ($form_already_exists) {
		$query = mysql_query("
		  UPDATE {$g_table_prefix}forms
			SET    content = '$form_content'
			WHERE  account_id = $account_id AND
			       form_name = '$form_name'
						   ");
		echo '{ success: "true",  message: "Your form has been updated.", form_name: "' . $form_name . '" }';
	} else {
		$query = mysql_query("
		  INSERT INTO {$g_table_prefix}forms (account_id, form_name, content)
      VALUES ($account_id, '$form_name', '$form_content')
						   ");
		$form_id = mysql_insert_id();
		echo '{ success: "true",  message: "Your form has been saved.", form_id: "' . $form_id . '", form_name: "' . $form_name . '" }';
	}
	
	db_disconnect($link);
}

/*------------------------------------------------------------------------------------------------*\
  Function:    load_form
\*------------------------------------------------------------------------------------------------*/
function load_form($form_id) {
	global $g_table_prefix;
	
	if (!isset($_SESSION["account_id"]))
		return;
	
	$link = db_connect();
	$query = mysql_query("
    SELECT *
    FROM   {$g_table_prefix}forms
    WHERE  form_id = $form_id
      ");
	db_disconnect($link);
	
	if (mysql_num_rows($query) == 0) {
		echo '{ success: false,  message: "Sorry, this form isn\'t found. You might want to try logging out then logging back in." }';
		return;
	}
	
	$result = mysql_fetch_assoc($query);
	if ($result["account_id"] != $_SESSION["account_id"]) {
		echo '{ success: false, message: "Sorry, you don\'t have permission to view this form. Please re-login in and try again." }';
		return;
	}
	
	// escape all double quotes
	$clean_str = preg_replace("/^\{/", "", $result["content"]);
	$clean_str = preg_replace("/\}$/", "", $clean_str);
	
	echo '{ success: true, ' . $clean_str . ' }';
}

/*------------------------------------------------------------------------------------------------*\
  Function:    delete_form
\*------------------------------------------------------------------------------------------------*/
function delete_form($form_id) {
	global $g_table_prefix;
	
	if (!isset($_SESSION["account_id"]))
		return;
	
	$link = db_connect();
	$query = mysql_query("
    SELECT *
    FROM   {$g_table_prefix}forms
    WHERE  form_id = $form_id
      ");
	
	if (mysql_num_rows($query) == 0) {
		echo '{ success: false,  message: "Sorry, this form isn\'t found. You might want to try logging out then logging back in." }';
		return;
	}
	
	$result = mysql_fetch_assoc($query);
	if ($result["account_id"] != $_SESSION["account_id"]) {
		echo '{ success: false, message: "Sorry, you don\'t have permission to delete this form. Please re-login in and try again." }';
		return;
	}
	
	mysql_query("
	  DELETE FROM {$g_table_prefix}forms 
		WHERE  form_id = $form_id
		  ");
	
	db_disconnect($link);
	
	echo "{ success: true, form_id: $form_id  }";
}

/*------------------------------------------------------------------------------------------------*\
  Function:    get_forms
\*------------------------------------------------------------------------------------------------*/
function get_forms($account_id) {
	global $g_table_prefix;
	
	$link = db_connect();
	$query = mysql_query("
    SELECT form_id, form_name
    FROM   {$g_table_prefix}forms
    WHERE  account_id = $account_id
    ORDER BY form_name
      ") or die(mysql_error());
	db_disconnect($link);
	
	$forms = array();
	while ($result = mysql_fetch_assoc($query))
		$forms[] = array($result["form_id"], $result["form_name"]);
	
	return $forms;
}

/*------------------------------------------------------------------------------------------------*\
  Function:    convert_datetime_to_timestamp
\*------------------------------------------------------------------------------------------------*/
function convert_datetime_to_timestamp($datetime) {
	list($date, $time) = explode(" ", $datetime);
	list($year, $month, $day) = explode("-", $date);
	list($hours, $minutes, $seconds) = explode(":", $time);
	
	return mktime($hours, $minutes, $seconds, $month, $day, $year);
}

/*------------------------------------------------------------------------------------------------*\
  Function:    add_years_to_datetime
  Purpose:     adds years to a MySQL datetime & returns a UNIX timestamp of the new date
\*------------------------------------------------------------------------------------------------*/
function add_years_to_datetime($datetime, $years_to_add) {
	list($date, $time) = explode(" ", $datetime);
	list($year, $month, $day) = explode("-", $date);
	list($hours, $minutes, $seconds) = explode(":", $time);
	
	return mktime($hours, $minutes, $seconds, $month, $day, $year + $years_to_add);
}

/*------------------------------------------------------------------------------------------------*\
  Function:    update_total_row_count
\*------------------------------------------------------------------------------------------------*/
function update_total_row_count($account_id, $num_rows) {
	global $g_table_prefix;
	
	$link = db_connect();
	
	// Ben, surely there's a way to do this in a single query...
	$select_query = mysql_query("
    SELECT num_records_generated 
    FROM   {$g_table_prefix}user_accounts
    WHERE  account_id = $account_id
      ");
	
	$result = mysql_fetch_assoc($select_query);
	$num_generated = $result["num_records_generated"];
	
	$new_total = $num_generated + $num_rows;
	
	mysql_query("
    UPDATE {$g_table_prefix}user_accounts 
    SET    num_records_generated = $new_total
    WHERE  account_id = $account_id
      ");
	
	db_disconnect($link);
}

function clean_hash($hash) {
	$clean_hash = $hash;
	
	if (get_magic_quotes_gpc()) {
		while (list($key, $value) = each($hash)) {
			if (!is_array($value))
				$clean_hash[$key] = stripslashes($value);
			else {
				$clean_array = array();
				foreach ($value as $val)
					$clean_array[] = stripslashes($val);
				$clean_hash[$key] = $clean_array;
			}
		}
	}
	
	return $clean_hash;
}

?>
