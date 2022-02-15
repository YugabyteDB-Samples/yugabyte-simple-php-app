<?php

define('HOST', '');
define('PORT', '5433');
define('DB_NAME', 'yugabyte');
define('USER', '');
define('PASSWORD', '');
define('SSL_MODE', 'verify-full');
define('SSL_ROOT_CERT', '');


function connect() {
    print ">>>> Connecting to YugabyteDB!\n";

    $conn = new PDO('pgsql:host=' . HOST . ';port=' . PORT . ';dbname=' . DB_NAME .
                    ';sslmode=' . SSL_MODE . ';sslrootcert=' . SSL_ROOT_CERT,
                    USER, PASSWORD,
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                          PDO::ATTR_EMULATE_PREPARES => true,
                          PDO::ATTR_PERSISTENT => true));

    print ">>>> Successfully connected to YugabyteDB!\n";

    return $conn;
}

function create_database(&$conn) {
    $conn->exec('DROP TABLE IF EXISTS DemoAccount');
    
    $conn->exec('CREATE TABLE DemoAccount ( 
                 id int PRIMARY KEY, 
                 name varchar, 
                 age int, 
                 country varchar, 
                 balance int)');
    
    $conn->exec("INSERT INTO DemoAccount VALUES 
                 (1, 'Jessica', 28, 'USA', 10000), 
                 (2, 'John', 28, 'Canada', 9000)");

    print ">>>> Successfully created table DemoAccount.\n";
}

function select_accounts(&$conn) {
    print ">>>> Selecting accounts:\n";

    $query = 'SELECT name, age, country, balance FROM DemoAccount';

    foreach ($conn->query($query) as $row) {
        print 'name=' . $row['name'] . ', age=' . $row['age'] . ', country=' . $row['country'] . ', balance=' . $row['balance'] . "\n";
    }
}

function transfer_money_between_accounts(&$conn, $amount) {
    try {
        $conn->beginTransaction();

        $conn->exec("UPDATE DemoAccount SET balance = balance - " . $amount . " WHERE name = 'Jessica'");
        
        $conn->exec("UPDATE DemoAccount SET balance = balance + " . $amount . " WHERE name = 'John'");

        $conn->commit();

        print ">>>> Transferred " . $amount . " between accounts\n";

    } catch (PDOException $e) {
        if ($e->getCode() == '40001') {
            print "The operation is aborted due to a concurrent transaction that is modifying the same set of rows.
                   Consider adding retry logic for production-grade applications.\n";
        }
        
        throw $e;
    }
}

try {
    $conn = connect();

    create_database($conn);
    select_accounts($conn);
    transfer_money_between_accounts($conn, 800);
    select_accounts($conn);

} catch (Exception $excp) {
    print "EXCEPTION: " . $excp->getMessage() . "\n";
    exit(1);
}
