<?php
namespace App\Models;
use PDO;

abstract class BaseModel {
    protected $db;
    public function __construct(array $config){
        $this->db = new PDO(
            $config['db']['dsn'],
            $config['db']['user'],
            $config['db']['pass'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }
}
