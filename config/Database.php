<?php
// Gets the variables from the .env
require '../vendor/autoload.php';

// Gets the variables from the .env
$dotenv = Dotenv\Dotenv::createImmutable( __DIR__ . '/..' );
$dotenv->load();

// SEPERATE LOCAL FROM DEV

class Database
{
    private $dbHandler;
    private $error;
    private $statement;

    public function __construct()
    {       
        $dsn = "mysql:host=" . $_ENV['HOST_NAME'] . ";dbname=" . $_ENV['DB_TABLE'];
        $pdoOptions = [
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION,
        ];

        try {
            // Try to establish the connection.
             $this->dbHandler = new PDO( $dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $pdoOptions );
        } catch ( PDOException $error ) {
            $this->error = $error->getMessage();
        }
    }

    public function query( $query ){
        $this->statement = $this->dbHandler->prepare( $query );
    }

    // Binds the placeholders.
    public function bind( $parameters, $value, $type = null )
    {
        if( is_null( $type ) ){
            switch( true ){

                case is_int( $value ) :
                $type = PDO::PARAM_INT;
                break;

                case is_bool( $value ) :
                $type = PDO::PARAM_BOOL;
                break;

                case is_null( $value ) :
                $type = PDO::PARAM_NULL;
                break;
                
                default :
                $type = PDO::PARAM_STRING ;

            }
        }
        $this->statement->bindValue( $param, $value, $type );
    }

    public function execute(){
        $this->statement->execute();
    }

    public function fetchAll( $fetchAs = PDO::FETCH_ASSOC )
    {
        $this->execute();
        return $this->statement->fetchAll( $fetchAs );
    }

    public function get( $fetchAs = PDO::FETCH_ASSOC )
    {
        $this->execute();
        return $this->statement->fetch( $fetchAs );
    }


}