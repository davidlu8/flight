<?php
class BaseModel {
    public $tableName = '';
    public $primaryKey = 'id';
    public $index = 0;

    function setTable($tableName) {
        $this->tableName = $tableName;
    }

    function execute($sql) {
        return DB::fetch($sql, 1);
    }

    function insert($data) {
        $filterData = array(
            'insert' => $data,
        );
        $sql = $this->formatFilter($filterData);
        DB::execute($sql);
        return DB::lastInsertId();
    }

    function update($data, $filterData = array()) {
        if (!is_array($filterData)) {
            $filterData = array(
                'update' => $data,
                'where' => $filterData,
            );
        } else {
            $filterData['update'] = $data;
        }
        $sql = $this->formatFilter($filterData);
        return DB::execute($sql);
    }

    function delete($filterData = array()) {
        if (!is_array($filterData)) {
            $filterData = array(
                'delete' => 1,
                'where' => $filterData,
            );
        } else {
            $filterData['delete'] = 1;
        }
        $sql = $this->formatFilter($filterData);
        return DB::execute($sql);
    }

    function find($id) {
        if (!is_array($id)) {
            if (is_numeric($id)) {
                $filterData = array(
                    'where' => sprintf("`%s` = '%s'", $this->primaryKey, $id),
                );
            } else {
                $filterData = array(
                    'where' => $id,
                );
            }
        } else {
            $filterData = array(
                'where' => $id
            );
        }
        return $this->item($filterData);
    }

    function finds($whereString, $limit = 0) {
        $filterData = array();
        if (!empty($whereString)) {
            $filterData['where'] = $whereString;
        }
        if (!empty($limit)) {
            $filterData['limit'] = $limit;
        }
        $sql = $this->formatFilter($filterData);
        return $this->items($sql);
    }

    function count($filterData = array()) {
        if (!is_array($filterData)) {
            $filterData = array(
                'select' => 'count(1)',
                'where' => $filterData,
            );
        } else {
            $filterData['select'] = 'count(1)';
        }
        return $this->value($filterData);
    }

    function exist($filterData = array()) {
        if (!is_array($filterData)) {
            $filterData = array(
                'select' => 'count(1)',
                'where' => $filterData,
            );
        } else {
            $filterData['select'] = 'count(1)';
        }
        return $this->value($filterData) > 0 ? true : false;
    }

    function value($filterData = array()) {
        $sql = $this->formatFilter($filterData);
        return DB::fetch($sql, 3);
    }

    function item($filterData = array()) {
        $sql = $this->formatFilter($filterData);
        return DB::fetch($sql);
    }

    function items($filterData = array()) {
        $sql = $this->formatFilter($filterData);
        return DB::fetch($sql, 1);
    }

    function formatFilter($filterData = array()) {
        $queryString = '';
        if (isset($filterData['insert'])) {
            $fieldArray = array();
            $valueArray = array();
            foreach($filterData['insert'] as $field => $value) {
                $fieldArray[] = sprintf("`%s`", $field);
                if (preg_match('/^<!(.+)>$/', $value, $array)) {
                    $valueArray[] = sprintf("%s", $array[1]);
                } else {
                    $valueArray[] = sprintf("'%s'", $value);
                }

            }
            $queryString .= sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->tableName, implode(',', $fieldArray), implode(',', $valueArray));
        } elseif (isset($filterData['update'])) {
            $fieldArray = array();
            foreach($filterData['update'] as $field => $value) {
                if (preg_match('/^<!(.+)>$/', $value, $array)) {
                    $fieldArray[] = sprintf("`%s` = %s", $field, $array[1]);
                } else {
                    $fieldArray[] = sprintf("`%s` = '%s'", $field, $value);
                }
            }
            $queryString .= sprintf('UPDATE %s SET %s ', $this->tableName, implode(',', $fieldArray));
        } elseif (isset($filterData['delete'])) {
            $queryString .= sprintf('DELETE FROM %s ', $this->tableName);
        } else {
            if (isset($filterData['select'])) {
                $queryString .= sprintf("SELECT %s ", !is_array($filterData['select']) ? $filterData['select'] : implode(',', $filterData['select']));
            } else {
                $queryString .= "SELECT * ";
            }

            if (isset($filterData['from'])) {
                $queryString .= sprintf('FROM %s ', $filterData['from']);
            } else {
                $queryString .= sprintf('FROM %s ', $this->tableName);
            }
        }

        if (isset($filterData['join'])) {
            foreach($filterData['join'] as $item) {
                if (isset($item[2])) {
                    $queryString .= sprintf('%s JOIN %s ON %s ', $item[2], $item[0], $item[1]);
                } else {
                    $queryString .= sprintf('JOIN %s ON %s ', $item[0], $item[1]);
                }
            }
        }

        if (isset($filterData['where'])) {
            if (is_array($filterData['where'])) {
                $queryString .= sprintf('WHERE %s ', implode(' AND ', $filterData['where']));
            } else {
                $queryString .= sprintf('WHERE %s ', $filterData['where']);
            }
        }

        if (isset($filterData['group'])) {
            if (is_array($filterData['group'])) {
                $queryString .= sprintf('GROUP BY %s ', implode(',', $filterData['group']));
            } else {
                $queryString .= sprintf('GROUP BY %s ', $filterData['group']);
            }
        }

        if (isset($filterData['having'])) {
            if (is_array($filterData['having'])) {
                $queryString .= sprintf('HAVING %s ', implode(' AND ', $filterData['having']));
            } else {
                $queryString .= sprintf('HAVING %s ', $filterData['having']);
            }
        }

        if (isset($filterData['order'])) {
            if (is_array($filterData['order'])) {
                $orderBy = array();
                foreach($filterData['order'] as $field => $order) {
                    $orderBy[] = sprintf("%s %s", $field, $order);
                }
                $queryString .= sprintf('ORDER BY %s ', implode(',', $orderBy));
            } else {
                $queryString .= sprintf('ORDER BY %s ', $filterData['order']);
            }
        }

        if (isset($filterData['limit'])) {
            if (is_array($filterData['limit'])) {
                $queryString .= sprintf('LIMIT %s,%s ', $filterData['limit'][0], $filterData['limit'][1]);
            } else {
                $queryString .= sprintf('LIMIT %s ', $filterData['limit']);
            }
        }
        return $queryString;
    }
}