<?php

namespace thinkyaf;

use thinkyaf\library\Medoo;
use Yaf\Application;

class Db extends Medoo
{
    protected $options = [];

    protected $prefix;
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
    public function __construct($options = '')
    {
        if (!is_array($options)) {
            $db = Application::app()->getConfig()->db->toArray();
            $options = isset($db[$options]) ? $db[$options] : $db[$db['default']];
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
    //默认不加前缀
    public function name($name)
    {
        $this->table($this->prefix . $name);
        return $this;
    }
    // 设置表名
    public function table($table)
    {
        $this->table = $table;
        $this->columns = '*';
        $this->where = $this->join = $this->data = null;
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
    //设置数据
    public function data($data)
    {
        $this->data = $data;
        return $this;
    }
    /** 
     * ==================操作数据库==================
     */
    //添加数据
    public function add($data = null)
    {
        $data = $data ? $data : $this->data;
        if (!is_array($data) || !$data) {
            throw new \Exception('数据不能为空', 400);
            return;
        }
        $this->insert($this->table, $data);
        $this->data['id'] = $this->id();
        return $this->getData();
    }
    // 删除数据
    public function del()
    {
        return $this->delete($this->table, $this->where)->rowCount();
    }
    // 更新数据
    public function edit($data = null)
    {
        $data = $data ? $data : $this->data;
        if (!is_array($data) || !$data) {
            throw new \Exception('edit(data) 不能为空', 400);
            return;
        }
        return $this->update($this->table, $data, $this->where)->rowCount();
    }
    // 统计数据
    public function counts($column = '*')
    {
        return  $this->agg('count', $column);
    }
    // 最大值
    public function maxs($column)
    {
        return  $this->agg('max', $column);
    }
    // 最小值
    public function mins($column)
    {
        return  $this->agg('min', $column);
    }
    // 统计和
    public function sums($column)
    {
        return  $this->agg('sum', $column);
    }
    // 数据平均值
    public function avgs($column)
    {
        return  $this->agg('avg', $column);
    }
    //查询单条数据
    public function find()
    {
        $this->act('get');
        return $this->getData();
    }
    //查询多条数据
    public function limit($limit = 15)
    {
        if (!isset($this->where['LIMIT'])) {
            $this->where['LIMIT'] = $limit;
        }
        $this->act('select');
        return $this->getData();
    }
    //查询分页数据
    public function page($limit = 15, $count = 0, $name = 'page')
    {
        $pase = \Yaf\Dispatcher::getInstance()->getRequest()->getQuery($name, 1);
        $count = $count ? $count : $this->counts();
        $this->where['LIMIT'] = ($pase > 1) ? [($pase - 1) * $limit, $limit] : [0, $limit];
        $this->act('select');
        return $this->data;
    }
    // 执行查询
    public function act($type)
    {
        if ($this->join) {
            $this->data = $this->$type($this->table, $this->join, $this->columns, $this->where);
        } else {
            $this->data = $this->$type($this->table, $this->columns, $this->where);
        }
        return $this;
    }
    // 聚合查询
    public function agg($type = 'count', $column)
    {
        if ($this->join) {
            return $this->$type($this->table, $this->join, $column, $this->where);
        }
        return $this->$type($this->table, $column, $this->where);
    }
    /** 
     * ==================获取数据信息==================
     */
    // 获取数据
    public function getData()
    {
        $rs = [
            'info' => $this->info(),
            'error' => $this->error(),
            'sql' => $this->last(),
            'pdo' => $this->pdo,
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
