<?php
// This is the API, 2 possibilities: show the app list or show a specific app by id.

$conf['server']='localhost';
$conf['username']='sakila';
$conf['password']='sakila';
$conf['dbname']='sakila';

function get_person_by_id($id) {
    global $conf;
    $con = mysql_connect($conf['server'], $conf['username'], $conf['password']);
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    }

    $db_selected = mysql_select_db($conf['dbname'], $con);
    if (!$db_selected) {
        die('Can\'t use dbname : ' . mysql_error());
    }
    $sql = "SELECT actor_id, first_name, last_name, last_update FROM actor WHERE actor_id='" . $id . "'";
    $result = mysql_query($sql);
    if (!$result) {
        die('Invalid query: ' . $sql . "   " . mysql_error());
    }
//Allocate the array
    $app_info = array();
    $row = mysql_fetch_array($result);

    $person_info['actor_id'] = $row['actor_id'];
    $person_info['first_name'] = $row['first_name'];
    $person_info['last_name'] = $row['last_name'];
    $person_info['last_update'] = $row['last_update'];

    mysql_close($con);
    return $person_info;
}

function get_person_list() {
//Build the JSON array from the database
    global $conf;
    $con = mysql_connect($conf['server'], $conf['username'], $conf['password']);
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    }
//echo 'Connected successfully';
    $db_selected = mysql_select_db($conf['dbname'], $con);
    if (!$db_selected) {
        die('Can\'t use dbname: ' . mysql_error());
    }
    $sql = "SELECT actor_id, first_name, last_name, last_update FROM actor";
    $result = mysql_query($sql);
    if (!$result) {
        die('Invalid query: ' . $sql . "   " . mysql_error());
    }
//Allocate the array
    $person_list = array();
//Loop through database to add books to array
    while ($row = mysql_fetch_array($result)) {
        $person_list[] = array('actor_id' => $row['actor_id'], 'first_name' => $row['first_name'], 'last_name' => $row['last_name']);
    }
    mysql_close($con);
    return $person_list;
}

$possible_url = array("get_person_list", "get_person");
$value = "Ops, ocorreu um erro";

if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
    switch ($_GET["action"]) {
        case "get_person_list" :
            $value = get_person_list();
            break;
        case "get_person" :
            if (isset ($_GET["id"]))
                $value = get_person_by_id($_GET["id"]);
            else
                $value = "Missing argument | faltou argumentos";
            break;
    }
}
//return JSON array
exit (json_encode($value));
?>
