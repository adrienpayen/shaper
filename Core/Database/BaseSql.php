<?php

namespace Core\Database;

use Core\Helpers\Parameters;

/**
 * Class BaseSql
 *
 * @author Adrien PAYEN <adrien.payen2@gmail.com>
 */
class BaseSql
{
    public static $_instance = null;

    private $db;
    private $table;
    private $columns = [];

    /**
     * BaseSql constructor.
     */
    public function __construct()
    {
        $db = Parameters::getParameters('database');

        try {
            $this->db = new \PDO("mysql:host=".$db['host'].";dbname=".$db['name'].";port=".$db['port'], $db['user'], $db['password']);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\Exception $e) {
            die("Erreur SQL : ".$e->getMessage());
        }

        if (substr(strtolower(get_called_class()), 0, 8 ) === "entities") {
            $this->table = substr(strtolower(get_called_class()), strrpos(strtolower(get_called_class()), '\\') + 1);

            $objectVars = get_class_vars(get_called_class());
            $sqlVars = get_class_vars(get_class());
            $this->columns = array_diff_key($objectVars, $sqlVars);
        }

    }

    /**
     * @return BaseSql|null
     */
    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
            $a = "Core\\Database\\Basesql";
            self::$_instance = new $a();
        }

        return self::$_instance;
    }

    /**
     * @param array $donnees
     */
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set'.ucfirst($key);

            if (substr($method, strrpos($method, '_') + 1) === "second") {
                    $new_method = substr($method, 0, strpos($method, "_"));
                    $this->$new_method($value);
            } elseif (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Save an entity.
     */
    public function save()
    {
        if( $this->id == -1) {
            unset($this->columns['id']);

            $sqlCol = null;
            $sqlKey = null;

            foreach ($this->columns as $column => $value) {
                $data[$column] = $this->$column;
                $sqlCol .= ",". $column;
                $sqlKey .= ",:". $column;
            }
            $sqlCol = ltrim($sqlCol, ",");
            $sqlKey = ltrim($sqlKey, ",");

            $query = $this->db->prepare("INSERT INTO ". $this->table .
                " (" . $sqlCol." )
					VALUES
					(".$sqlKey.");"
            );

            $query->execute($data);

        } else {
            $sqlSet = null;
            foreach ($this->columns as $column => $value) {
                $data[$column] = $this->$column;
                $sqlSet[]= $column ."=:". $column;
            }

            $query = $this->db->prepare("UPDATE ". $this->table .
                " SET date_updated = sysdate(), ".implode(",",$sqlSet).
                " WHERE id=:id;"
            );

            $query->execute($data);
        }
        $this->populate($data);
    }

    /**
     * @param array $search
     * @return mixed
     */
    public function populate($search = ["id" => 1] )
    {
        $query = $this->getOneBy($search, true);
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->table);
        $object = $query->fetch();

        return $object;
    }

    /**
     * @param array $search
     * @param bool $returnQuery
     * @return mixed|PDOStatement
     */
    public function getOneBy($search = [], $returnQuery = false)
    {
        foreach ($search as $key => $value) {
            $where[] = $key.'=:'.$key;
        }

        $query = $this->db->prepare("SELECT * FROM ".$this->table." WHERE ".implode(" AND ", $where));

        $query->execute($search);

        if($returnQuery) {
            return $query;
        }

        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function isUnique($value, $col, $entity)
    {
        $query = $this->db->prepare("SELECT 1 FROM ".$entity." WHERE ".$col."='".$value."'");
        $query->execute();

        if ($query->rowCount() >= 1) {
            return false;
        }

        return true;
    }

    /**
     * @return \PDO
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param Database $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param array $columns
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }
}