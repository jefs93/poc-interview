 
<?php
echo "<br>";
echo "\n\nWe are importing a nice file :) ";

$db_host = getenv("DATABASE_CON");
$db_name = getenv("POSTGRES_DB");
$db_user = getenv("POSTGRES_USER");
$db_password = getenv("POSTGRES_PASSWORD");

    // Connecting, selecting database pg_connect
    $connection_string = ("host=".$db_host." port=5432 dbname=".$db_name." user=".$db_user." password=".$db_password);
    
    $dbconn = pg_connect($connection_string);
    if (!$dbconn){
        echo "<br>";
        die("Can't connect to Database");
    }
    // Creating Query
    $parameter = $_GET['company_id'];
    
    // Setting up default value
    if (empty($parameter)) {
        $parameter = 1;
    }  

    $query = "SELECT * FROM companies WHERE company_id = ".$parameter.";";
    $query_result = pg_query($dbconn, $query);

    // Returning result of query "company_name"
    // $line = pg_fetch_result($query_result,0,1);
    while ($row = pg_fetch_assoc($query_result)) {
        
        echo "<br><br>Testing database results...";
        echo "<br><br>The company name is ".$row['company_name']; 
    }
    
    
    
?>


