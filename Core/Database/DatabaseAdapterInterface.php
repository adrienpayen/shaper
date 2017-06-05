<?php
namespace Core\Database;

/**
 * Interface DatabaseAdapterInterface
 * @package Core\Database
 */
interface DatabaseAdapterInterface
{
    public function connect();

    public function disconnect();

    public function query($query);

    public function fetch();

    public function select($table, $conditions = '', $fields = '*', $order = '', $limit = null, $offset = null);

    public function insert($table, array $data);

    public function update($table, array $data, $conditions);

    public function delete($table, $conditions);

    public function getInsertId();

    public function countRows();

    public function getAffectedRows();
}