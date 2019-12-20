<?php

namespace thinkyaf;

use thinkyaf\org\Medoo;
use Yaf\Application;

class Db extends Medoo
{
    // 表名
    protected $table;
    // 字段
    protected $columns = '*';
    // 条件
    protected $where = [];
    // join
    protected $join = null;
    //数据
    public $data = null;
    // 初始化
    public function __construct(array $options = null)
    {
        if (!$options) {
            $db = Application::app()->getConfig()->db;
            $options = [
                'database_type' => $db->type,
                'database_name' => $db->database,
                'server' => $db->hostname,
                'username' => $db->username,
                'password' => $db->password,
                'charset' => $db->charset
            ];
        }
        parent::__construct($options);
    }
    //当前obj
    public function obj()
    {
        return $this;
    }
    // 获取pdo
    public function pdo()
    {
        return $this->pdo;
    }
    /** 
     * ==================设置参数==================
     */ 
    // 设置表名
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }
    // 设置join
    public function join($join)
    {
        $this->join = $join;
        return $this;
    }
    //设置字段
    public function field($columns)
    {
        $this->columns = $columns;
        return $this;
    }
    //设置字段
    public function where($where)
    {
        $this->where = $where;
        return $this;
    }
    /** 
     * ==================操作数据库==================
     */ 
    //查询单条数据
    public function find()
    {
        if ($this->join) {
            $this->data = $this->get($this->table, $this->join, $this->columns, $this->where);
        } else {
            $this->data = $this->get($this->table, $this->columns, $this->where);
        }
        return $this;
    }
    //查询单条数据
    public function limit($limit = 15)
    {
        if (!isset($this->where['LIMIT'])) {
            $this->where['LIMIT'] = $limit;
        }
        if ($this->join) {
            $this->data = $this->select($this->table, $this->join, $this->columns, $this->where);
        } else {
            $this->data = $this->select($this->table, $this->columns, $this->where);
        }
        return $this;
    }
    /** 
     * ==================获取数据信息==================
     */ 
    // 获取数据
    public function getData()
    {
        $rs = [
            'info' => $this->info(),
            'sql' => $this->sql,
            'pdo' => $this->pdo,
            'error' => $this->error(),
            'data' => $this->data
        ];
        return $rs;
    }
}

/*
1.PDO::beginTransaction — 启动一个事务
2.PDO::commit — 提交一个事务
3.PDO::__construct — 创建一个表示数据库连接的 PDO 实例
4.PDO::errorCode — 获取跟数据库句柄上一次操作相关的 SQLSTATE
5.PDO::errorInfo — 获取错误信息
6.PDO::exec — 执行一条 SQL 语句,并返回受影响的行数
7.PDO::getAttribute — 取回一个数据库连接的属性
8.PDO::getAvailableDrivers — 返回一个可用驱动的数组(了解即可)
9.PDO::inTransaction — 检查是否在一个事务内(了解即可)
10.PDO::lastInsertId — 返回最后插入行的ID或序列值
11.PDO::prepare — 创建SQL的预处理,返回PDOStatement对象
12.PDO::query — 用于执行查询SQL语句,返回PDOStatement对象
13.PDO::quote — 为sql字串添加单引号
14.PDO::rollBack — 回滚一个事务
15.PDO::setAttribute — 设置属性
*/
