<?php

namespace thinkyaf;

use thinkyaf\Db;

class Model
{
    //表名
    protected $table;
    //初始化
    public function __construct(array $options = null)
    {
        // 获取当前表名
        if (!$this->table) {
            $class_name = get_class($this);
            if (ini_get("yaf.name_suffix")) {
                $class_name = substr_replace($class_name, "", -5);
            }
            $this->table = strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $class_name));
        }
        $this->db = new Db();
        $this->initialize();
    }
    protected function initialize()
    {
    }
    //设置表名
    public function setTable($table_name)
    {
        $this->table = $table_name;
    }
    // 查询多条数据
    public function select()
    {
        $rs = $this->db->select($this->table, '*', ["LIMIT" => 5]);
        $error = $this->db->error();
        if ($error[1]) {
            return $error[2];
        }
        return $rs;
    }
}
