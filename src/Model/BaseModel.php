<?php
declare(strict_types=1);

namespace SimpleMVC\Model;

use PDO;
use PDOException;
use SimpleMVC\Exception\DuplicateEntryException;

abstract class BaseModel
{
    private PDO $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Retrieves database data based on passed parameters.
     *
     * All columns (*) are retrieved if none are specified.
     *
     * @param string $table
     * @param array $params
     * @param bool $fetchAll
     * @return array|mixed
     */
    protected function find(string $table, array $params, bool $fetchAll = true)
    {
        $query = 'SELECT ';

        if(isset($params['columns'])) {
            $query .= $this->buildQuerySegment($params['columns'], ',');
        } else {
            $query .= '*';
        }

        $query .= ' FROM ' . $table;

        if(isset($params['conditions'])) {
            $query .= ' WHERE ' . $params['conditions'];
        }

        if(isset($params['order'])) {
            $query .= ' ORDER BY ' . $params['order'];
        }

        $statement = $this->pdo->prepare($query);
        $statement->execute($params['bind']);

        if(true === $fetchAll) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Inserts passed data in database based on passed parameters
     *
     * @param string $table
     * @param array $params : array containing columns and bind values
     * @return bool
     * @throws DuplicateEntryException
     */
    protected function insert(string $table, array $params) : bool
    {
        $query = "INSERT INTO $table (";
        $query .= $this->buildQuerySegment($params['columns'], ',');
        $query .= ') VALUES (';
        $query .= $this->buildQuerySegment($params['columns'], ', :', ':');
        $query .= ')';

        $statement = $this->pdo->prepare($query);
        try {
            $statement->execute($params['bind']);
        } catch (PDOException $e) {
            if($e->getCode() === '23000') {
                throw new DuplicateEntryException();
            }
            return false;
        }
        return true;
    }

    /**
     * Updates passed data based on passed parameters
     *
     * @param string $table
     * @param array $params : array containing columns, bind values and conditions
     * @return bool
     */
    protected function update(string $table, array $params) : bool
    {
        $query = "UPDATE $table SET ";
        $query .= $this->buildQuerySegment($params['set'], ', ');
        $query .= ' WHERE ' . $params['conditions'];

        $statement = $this->pdo->prepare($query);
        try {
            $statement->execute($params['bind']);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Deletes data inside database based on passed parameters
     *
     * @param string $table
     * @param array $params
     * @return bool
     */
    protected function delete(string $table, array $params) : bool
    {
        $query = "DELETE FROM $table WHERE ";
        $query .= $params['conditions'];

        $statement = $this->pdo->prepare($query);
        try {
            $statement->execute($params['bind']);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Builds a query segment trough the passed array
     *
     * @param array $toCycle
     * @param string $separator
     * @param string $beforeSeparator
     * @return string
     */
    private function buildQuerySegment(array $toCycle, string $separator, string $beforeSeparator = '') : string
    {
        $querySegment = '';
        foreach ($toCycle as $column) {
            $querySegment .= ($querySegment===''?$beforeSeparator:$separator) . $column;
        }

        return $querySegment;
    }
}