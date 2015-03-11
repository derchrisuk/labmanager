<?php
/**
 * Created by PhpStorm.
 * User: derchris
 * Date: 08/03/15
 * Time: 23:36
 */

namespace labmanager;


class db extends \SQLite3 {
    public function __construct() {
        $this->open('../labmanager.db');
    }

    public function getCount($tableID) {
        $result = $this->query('SELECT COUNT(*) as count FROM ' . $tableID);
        $row = $result->fetchArray();
        $count = $row['count'];
        $result->finalize();
        return $count;
    }
}
