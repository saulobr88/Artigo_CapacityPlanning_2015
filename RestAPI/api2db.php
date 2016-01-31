<?php
// This is the API, 2 possibilities: show the app list or show a specific app by id.

$conf['server']='localhost';
$conf['username']='sakila';
$conf['password']='sakila';
$conf['dbname']='sakila';
$conn;

function makeConn()
{
    global $conf, $conn;
    try
    {
        $conn = new PDO("mysql:host=".$conf['server'].";dbname=".$conf['dbname'],
                        $conf['username'],
                        $conf['password']
                        );
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
}

function umakeConn()
{
    global $conn;
    $conn = null;
}

function get_person_by_id($id)
{
    global $conf, $conn;
    makeConn();
    $stmt;
    $person_info = array();
    
    try
    {
        $sql = "SELECT actor_id, first_name, last_name, last_update
        FROM actor WHERE actor_id='" . $id . "'";
        $stmt = $conn->prepare($sql); 
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $person_info['actor_id']    = $row['actor_id'];
        $person_info['first_name']  = $row['first_name'];
        $person_info['last_name']   = $row['last_name'];
        $person_info['last_update'] = $row['last_update'];
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
    
    umakeConn();
    return $person_info;
}

function get_person_list()
{
    //Build the JSON array from the database
    global $conf, $conn;
    makeConn();
    $stmt;
    $person_list = array();
    
    try
    {
        $sql = "SELECT actor_id, first_name, last_name, last_update
                FROM actor";
        $stmt = $conn->prepare($sql); 
        $stmt->execute();
        
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            $person_list[] = array(
                            'actor_id' => $row['actor_id'],
                            'first_name' => $row['first_name'],
                            'last_name' => $row['last_name']
                            );
        }        
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
    
    umakeConn();
    
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
