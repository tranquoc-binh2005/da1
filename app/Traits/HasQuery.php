<?php
namespace App\Traits;

trait HasQuery
{
    protected string $query = '';

    public function setQuery($baseQuery): self
    {
        $this->query = $baseQuery;
        return $this;
    }

    public function keyword(array $keyword = []): self
    {
        if (!empty($keyword['q'])) {
            $likeParts = [];
            foreach ($keyword['field'] as $field) {
                $likeParts[] = "{$field} LIKE '%{$keyword['q']}%'";
            }
            if (stripos($this->query, 'WHERE') !== false) {
                $this->query .= ' AND (' . implode(' OR ', $likeParts) . ')';
            } else {
                $this->query .= ' WHERE (' . implode(' OR ', $likeParts) . ')';
            }
        }
        return $this;
    }

    public function simple(array $simpleFilter = []): self
    {
        $conditions = [];

        foreach ($simpleFilter as $key => $value) {
            if ($value !== 0 && !empty($value)) {
                $conditions[] = "{$key} = '{$value}'";
            }
        }

        if (!empty($conditions)) {
            if (stripos($this->query, 'WHERE') !== false) {
                $this->query .= ' AND ' . implode(' AND ', $conditions);
            } else {
                $this->query .= ' WHERE ' . implode(' AND ', $conditions);
            }
        }
        return $this;
    }

    public function complex(array $complexFilter = []): self
    {
        $conditions = [];

        foreach ($complexFilter as $field => $condition) {
            foreach ($condition as $operator => $value) {
                switch ($operator) {
                    case 'gt':
                        $conditions[] = "{$field} > '{$value}'";
                        break;
                    case 'gte':
                        $conditions[] = "{$field} >= '{$value}'";
                        break;
                    case 'lt':
                        $conditions[] = "{$field} < '{$value}'";
                        break;
                    case 'lte':
                        $conditions[] = "{$field} <= '{$value}'";
                        break;
                    case 'eq':
                        $conditions[] = "{$field} = '{$value}'";
                        break;
                    case 'between':
                        [$min, $max] = explode(',', $value);
                        $conditions[] = "({$field} BETWEEN '{$min}' AND '{$max}')";
                        break;
                    case 'in':
                        $inValues = explode(',', $value);
                        $inString = implode("','", $inValues);
                        $conditions[] = "{$field} IN ('{$inString}')";
                        break;
                }
            }
        }

        if (!empty($conditions)) {
            if (stripos($this->query, 'WHERE') !== false) {
                $this->query .= ' AND ' . implode(' AND ', $conditions);
            } else {
                $this->query .= ' WHERE ' . implode(' AND ', $conditions);
            }
        }

        return $this;
    }

    public function date(array $dateFilter = []): self
    {
        $conditions = [];

        foreach ($dateFilter as $field => $condition) {
            foreach ($condition as $operator => $date) {
                $date = date('Y-m-d', strtotime($date));

                switch ($operator) {
                    case 'gt':
                        $conditions[] = "DATE({$field}) > '{$date}'";
                        break;
                    case 'gte':
                        $conditions[] = "DATE({$field}) >= '{$date}'";
                        break;
                    case 'lt':
                        $conditions[] = "DATE({$field}) < '{$date}'";
                        break;
                    case 'lte':
                        $conditions[] = "DATE({$field}) <= '{$date}'";
                        break;
                    case 'eq':
                        $conditions[] = "DATE({$field}) = '{$date}'";
                        break;
                    case 'between':
                        [$startDate, $endDate] = explode(',', $date);
                        $startDate = date('Y-m-d', strtotime($startDate));
                        $endDate   = date('Y-m-d', strtotime($endDate));
                        $conditions[] = "(DATE({$field}) BETWEEN '{$startDate}' AND '{$endDate}')";
                        break;
                }
            }
        }

        if (!empty($conditions)) {
            if (stripos($this->query, 'WHERE') !== false) {
                $this->query .= ' AND ' . implode(' AND ', $conditions);
            } else {
                $this->query .= ' WHERE ' . implode(' AND ', $conditions);
            }
        }

        return $this;
    }

    public function sort(array $sort = []): self
    {
        if (!empty($sort) && count($sort) === 2) {
            $column = $sort[0];
            $direction = strtoupper($sort[1]) === 'DESC' ? 'DESC' : 'ASC';
            $this->query .= " ORDER BY tb1.{$column} {$direction}";
        }

        return $this;
    }

    public function relation(array $relations = []): self
    {
        $mainAlias = 'tb1';
        $this->query = str_replace($this->model->getTable(), "{$this->model->getTable()} AS {$mainAlias}", $this->query);

        $i = 2;
        foreach ($relations as $relation) {
            $foreignKey = rtrim($relation, 's') . '_id';
            $alias = "tb{$i}";
            $this->query .= " LEFT JOIN {$relation} AS {$alias} ON {$mainAlias}.{$foreignKey} = {$alias}.id";
            $i++;
        }
        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function convertSnakeToCamel(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $camelKey = lcfirst(str_replace('_', '', ucwords($key, '_')));
            $result[$camelKey] = is_array($value) ? $this->convertSnakeToCamel($value) : $value;
        }
        return $result;
    }
}
