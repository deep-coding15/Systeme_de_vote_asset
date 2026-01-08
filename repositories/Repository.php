<?php
namespace Repositories;

use Database\Database;

abstract class Repository {
    protected $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }
    public function beginTransaction() {
        $this->db->beginTransaction();
    }

    public function commit() {
        $this->db->commit();
    }

    public function rollback(){
        $this->db->rollBack();
    }

    public function transactionPrepared() {
        
    }
}