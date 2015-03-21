<?php
/**
 * Created by PhpStorm.
 * User: derchris
 * Date: 08/03/15
 * Time: 23:36
 */

namespace labmanager;

class db extends \SQLite3
{
    public function __construct()
    {
        $this->open('labmanager.db');
    }

    public function getCount($tableID)
    {
        $result = $this->query('SELECT COUNT(*) AS count FROM ' . $tableID);
        $row = $result->fetchArray();
        $count = $row[ 'count' ];
        $result->finalize();
        return $count;
    }

    public function getCountID($tableID, $id, $value)
    {
        $result = $this->query('SELECT COUNT(*) AS count FROM ' . $tableID . ' WHERE ' . $id . '="' . $value . '"');
        $row = $result->fetchArray();
        $count = $row[ 'count' ];
        $result->finalize();
        return $count;
    }

    public function getCountIDAnd($tableID, $id, $value, $id2, $value2)
    {
        $result = $this->query('SELECT COUNT(*) AS count FROM ' . $tableID . ' WHERE ' . $id . '="' . $value . '" AND ' . $id2 . '="' . $value2 . '"');
        $row = $result->fetchArray();
        $count = $row[ 'count' ];
        $result->finalize();
        return $count;
    }

    public function getCountGroup($tableID, $id, $value, $group)
    {
        $result = $this->query('SELECT COUNT(*) AS count FROM ( SELECT * FROM ' . $tableID . ' WHERE ' . $id . '="' .
            $value . '" GROUP BY ' . $group . ')');
        $row = $result->fetchArray();
        $count = $row[ 'count' ];
        $result->finalize();
        return $count;
    }
}