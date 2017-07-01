<?php

namespace Svi;

use \Doctrine\DBAL\Schema\Schema;
use \Doctrine\DBAL\Schema\Table;
use \Doctrine\DBAL\Schema\Column;
use \Doctrine\DBAL\Connection;
use \Doctrine\DBAL\Query\QueryBuilder;

// Singleton
abstract class Manager
{
	protected static $_instance = [];
	/** @var Application */
	protected static $app;
	private $schemaName = null;
	/** @var null Schema */
	private $schema = null;
	private $cache = [];

	private function __construct()
	{

	}

	private function __clone()
	{

	}

	private function __wakeup()
	{

	}

	public static function setApp(Application $app)
	{
		static::$app = $app;
	}

	protected function setSchemaName($schemaName)
	{
		$this->schemaName = $schemaName;
	}

	/**
	 * @param string $schemaName
	 * @return Manager
	 */
	public static function getInstance($schemaName = 'default')
	{
		if (!array_key_exists($schemaName, static::$_instance) || !array_key_exists(get_called_class(), static::$_instance[$schemaName])) {
			$instance = new static();
			if (!array_key_exists($schemaName, static::$_instance)) {
				static::$_instance[$schemaName] = [];
			}
			static::$_instance[$schemaName][get_called_class()] = $instance;
			$instance->schemaName = $schemaName;
		}

		return static::$_instance[$schemaName][get_called_class()];
	}

	/**
	 * @return Connection
	 */
	public function getConnection()
	{
		return static::$app->getSilex()['dbs'][$this->schemaName];
	}

	/**
	 * Must return fields in like that: classFieldName => Column schema
	 */
	abstract protected function getFields();

	/**
	 * Must return table name in SQL DB where entity stored
	 */
	abstract protected function getTableName();

	abstract protected function getEntityClassName();

	/**
	 * @return \Doctrine\DBAL\Schema\Schema
	 */
	public function getDbSchema()
	{
		return $this->schema;
	}

	/**
	 * @return Table
	 * @throws \Exception
	 */
	final public function getTableSchema()
	{
		if ($this->schema === null) {
			$this->schema = new Schema();
		}
		if (!$this->schema->hasTable($this->getTableName())) {
			/** @var \Doctrine\DBAL\Schema\Table $table */
			$table = $this->schema->createTable($this->getTableName());
			$this->cache['table'] = $table;

			$dbColumnsToFieldNames = [];
			$fieldToColumnNames = [];
			$columns = array();
			foreach ($this->getFields() as $key => $value) {
				$column = $table->addColumn($value[0], $value[1]);
				if (count($value) > 2) {
					$i = 0;
					foreach ($value as $pKey => $pVal) {
						$i++;
						if ($i < 3)	continue;
						if ($pVal == 'id') {
							$column->setNotnull(true);
							$column->setAutoincrement(true);
							$table->setPrimaryKey(array($value[0]));
							$this->cache['idFieldName'] = $key;
							$this->cache['idColumnName'] = $column->getName();
						} elseif ($pVal == 'ai') {
							$column->setAutoincrement(true);
						} elseif ($pVal === 'null') {
							$column->setNotnull(false);
						} elseif($pVal == 'unique') {
							$table->addUniqueIndex(array($column->getName()));
						} elseif($pVal == 'index') {
							$table->addIndex(array($column->getName()));
						} elseif($pVal == 'unsigned') {
							$column->setUnsigned(true);
						} else {
							switch (strtolower($pKey)) {
								case 'length': $column->setLength($pVal);break;
								case 'precision': $column->setPrecision($pVal);break;
								case 'scale': $column->setScale($pVal);break;
								case 'unsigned': $column->setUnsigned($pVal);break;
								case 'fixed': $column->setFixed($pVal);break;
								case 'notnull': $column->setNotnull($pVal);break;
								case 'ai': $column->setAutoincrement($pVal);break;
								case 'comment': $column->setComment($pVal);break;
								default: throw new \Exception("Unsupported parameter \"$pVal\" for column \"$key\"");
							}
						}
					}
				}
				if (!$table->getPrimaryKey()) {
					throw new \Exception('There is no primary key for ' . $this->getEntityClassName());
				}
				$columns[$key] = $column;
				$dbColumnsToFieldNames[$column->getName()] = $key;
				$fieldToColumnNames[$key] = $column->getName();
			}
			foreach ($this->getIndexes() as $cols) {
				$table->addIndex($cols);
			}
			foreach ($this->getForeigners() as $manager => $params) {
				/** @var Manager $foreignManager */
				$foreignManager = call_user_func($manager . '::getInstance("' . $this->schemaName . '")');
				$table->addForeignKeyConstraint($foreignManager->getTableSchema(),
					is_array($params[0]) ? $params[0] : array($params[0]),
					is_array($params[1]) ? $params[1] : array($params[1]), isset($params[2]) ? $params[2] : array());
			}

			$this->cache['columns'] = $columns;
			$this->cache['db_to_field'] = $dbColumnsToFieldNames;
			$this->cache['field_to_db'] = $fieldToColumnNames;
			$this->cache['table'] = $table;
		}

		return $this->cache['table'];
	}

	/**
	 * Must return table indexes in that format:
	 * return [
	 *   ['tableDbColumn1', 'tableDbColumn2', ...],
	 *   ['tableDbColumn4', 'tableDbColumn7', ...],
	 *   ...
	 * ];
	 *
	 * If you want to add one-column index, just use 'index' field parameter in getFields()
	 *
	 * @return array
	 */
	public function getIndexes()
	{
		return [];
	}

	/**
	 * Must return table foreign keys constraints in that format:
	 * return [
	 *   'My\TestBundle\Manager\SomeForeignManager' => [['ourTableDbColumn1', 'ourTableDbColumn1', ...], ['foreignTableDbColumn1', 'foreignTableDbColumn2', ...]],
	 *   'My\TestBundle\Manager\OtherForeignManager' =>[['ourTableDbColumn2', 'ourTableDbColumn4', ...], ['foreignTableDbColumn2', 'foreignTableDbColumn4', ...]],
	 *   ...
	 * ];
	 *
	 * or simply:
	 *
	 * return [
	 *   'My\TestBundle\Entity\SomeForeignEntity' => ['ourTableDbColumn1', 'foreignTableDbColumn1', ['onDelete' => 'cascade']],
	 *   'My\TestBundle\Entity\OtherForeignEntity' =>['ourTableDbColumn2', 'foreignTableDbColumn2'],
	 *   ...
	 * ];
	 *
	 * @return array
	 */
	public function getForeigners()
	{
		return [];
	}

	/**
	 * Return schemas in like that: classFieldName => Column schema
	 * @return Column[]
	 * @throws \Exception
	 */
	final public function getColumnsSchemas()
	{
		if (!array_key_exists('columns', $this->cache)) {
			$this->getTableSchema();
		}

		return $this->cache['columns'];
	}

	/**
	 * Returns field value by class private field name
	 * @param $fieldName
	 * @return mixed
	 */
	final public function getFieldValue($fieldName)
	{
		$method = 'get' . ucfirst($fieldName);

		return $this->$method();
	}

	/**
	 * @param $fieldName
	 * @param $value
	 * @return mixed
	 */
	final public function setFieldValue($fieldName, $value)
	{
		$method = 'set' . ucfirst($fieldName);

		return $this->$method($value);
	}

	/**
	 * @param $dbFieldName
	 * @return mixed
	 * @throws \Exception
	 */
	final public function getFieldValueByDbKey($dbFieldName)
	{
		$this->getTableSchema();
		if (!array_key_exists('db_to_field', $this->cache) && !array_key_exists($dbFieldName, $this->cache['db_to_field'])) {
			throw new \Exception('There is no field mapped to ' . $dbFieldName . ' in ' . $this->getEntityClassName());
		}
		$method = 'get' . ucfirst($this->cache['db_to_field'][$dbFieldName]);

		return $this->$method();
	}

	/**
	 * Sets class field value by DB field name
	 *
	 * @param $dbFieldName
	 * @param $value
	 * @throws \Exception
	 */
	final public function setFieldValueByDbKey(Entity $entity, $dbFieldName, $value)
	{
		$this->getTableSchema();
		if (!array_key_exists('db_to_field', $this->cache) && !array_key_exists($dbFieldName, $this->cache['db_to_field'])) {
			throw new \Exception('There is no field mapped to ' . $dbFieldName . ' in ' . get_class($this));
		}
		$fieldName = $this->cache['db_to_field'][$dbFieldName];
		$method = 'set' . ucfirst($fieldName);

		/** @var Column $columnSchema */
		$columnSchema = $this->cache['columns'][$fieldName];
		if ($columnSchema->getType() == 'Array') {
			if (!is_array($value)) {
				$value = $value ? unserialize($value) : [];
			}
		} elseif ($columnSchema->getType() == 'Boolean') {
			$value = $value ? true : false;
		}

		$entity->$method($value);
	}

	/**
	 * Returns class field name which is primary ID field
	 *
	 * @return string
	 */
	final public function getIdFieldName()
	{
		$this->getTableSchema();

		return $this->cache['idFieldName'];
	}

	/**
	 * Returns DB field name which is primary ID field
	 *
	 * @return mixed
	 */
	final public function getIdColumnName()
	{
		$this->getTableSchema();

		return $this->cache['idColumnName'];
	}

	final public function getDbColumnNames()
	{
		$this->getTableSchema();

		return $this->cache['field_to_db'];
	}


	/**
	 * Returns array which used for update or insert SQL operations
	 *
	 * @param Entity $entity
	 * @param bool $onlyChanged
	 * @param bool $updateLoadedData
	 * @return array
	 */
	final public function getDataArray(Entity $entity, $onlyChanged = false, $updateLoadedData = false)
	{
		$result = array();

		foreach ($this->getColumnsSchemas() as $fieldName => $schema) {
			$value = $this->getFieldValue($fieldName);
			if ($schema->getType() == 'Array') {
				if (!is_array($value) || !$value) {
					$value = serialize([]);
				} else {
					$value = serialize($value);
				}
			}
			if ($onlyChanged && array_key_exists($schema->getName(), $entity->getLoadedData())) {
				if ($schema->getType() == 'Boolean') {
					if ($value === ($entity->getLoadedData()[$schema->getName()] ? true : false)) {
						continue;
					}
				}
				if ($value === $entity->getLoadedData()[$schema->getName()]) {
					continue;
				}
			}
			if ($updateLoadedData) {
				$entity->getLoadedData()[$schema->getName()] = $value;
			}
			if (!$value) {
				if ($value === false) {
					$value = '0';
				} elseif ($value === 0) {
					$value = '0';
				}
			}
			$result[$schema->getName()] = $value;
		}

		return $result;
	}


	/**
	 * Fills class fields by SQL returned data
	 *
	 * @param array $data
	 * @param Entity|null $entity
	 * @return $this
	 */
	final public function fillByData(array $data, Entity $entity = null)
	{
		$entityName = $this->getEntityClassName();
		$entity = $entity ? $entity : new $entityName;
		$entity->setLoadedData($data);
		foreach ($data as $key => $value) {
			if ($key == $this->getIdColumnName()) {
				$entity->setLoadedFromDb(true);
			}
			$this->setFieldValueByDbKey($entity, $key, $value);
		}

		return $this;
	}

	public function save(Entity $entity)
	{
		$connection = $this->getConnection();
		if ($entity->getLoadedFromDb()) {
			$data = $this->getDataArray($entity,true, true);
			if (count($data)) {
				$connection->update($this->getTableName(), $data, [$this->getIdColumnName() => $this->getFieldValue($this->getIdFieldName())]);
			}
		} else {
			$data = $this->getDataArray($entity, false, true);
			if (count($data)) {
				$connection->insert($this->getTableName(), $data);
			}
			$this->setFieldValue($this->getIdFieldName(), $connection->lastInsertId());
		}
		$this->cache['fetch'] = [];
		$entity->setLoadedFromDb(true);

		return $this;
	}

	public function delete(Entity $entity)
	{
		$connection = $this->getConnection();
		if ($entity->getLoadedFromDb()) {
			$connection->delete($this->getTableName(), array($this->getIdColumnName() => $this->getFieldValue($this->getIdFieldName())));
			$this->cache['fetch'] = [];
		}
	}

	/**
	 * @param QueryBuilder $qb
	 * @param null $noCache
	 * @return $this|null
	 */
	public function fetchOne(QueryBuilder $qb, $noCache = null)
	{
		$result = $this->fetch($qb, $noCache);

		return array_key_exists(0, $result) ? $result[0] : null;
	}

	public function fetch(QueryBuilder $qb, $noCache = null)
	{
		$entityName = $this->getEntityClassName();
		$entity = new $entityName;
		$qb->resetQueryPart('from');
		$columnNames = [];
		foreach ($this->getDbColumnNames() as $n) {
			$columnNames[] = 'e.' . $n;
		}
		$qb->select(implode(', ', $columnNames))->from($this->getTableName(), 'e');

		$cacheKey = null;
		if (!$noCache) {
			$cacheKey = $qb->getSQL();
			foreach ($qb->getParameters() as $k => $v) {
				$cacheKey .= $k . $v;
			}
		}

		if ($cacheKey) {
			if (array_key_exists('fetch', $this->cache) && array_key_exists($cacheKey, $this->cache['fetch'])) {
				return $this->cache['fetch'][$cacheKey];
			}
		}
		$result = [];
		$items = $qb->execute()->fetchAll();
		if (count($items)) {
			foreach ($items as $e) {
				if (isset($entity)) {
					$this->fillByData($e, $entity);
					$result[] = $entity;
					unset($entity);
				} else {
					$result[] = new static($e);
				}
			}
		} else {
			unset($entity);
		}
		if ($cacheKey) {
			if (!array_key_exists('fetch', $this->cache)) {
				$this->cache['fetch'] = [];
			}
			$this->cache['fetch'][$cacheKey] = $result;
		}

		return $result;
	}

	public function findBy(array $criteria = [], array $orderBy = null, $limit = null, $offset = null, $noCache = null)
	{
		$connection = $this->getConnection();

		$db = $connection->createQueryBuilder();
		$entityName = $this->getEntityClassName();
		$entity = new $entityName();
		$columns = $this->getColumnsSchemas();
		unset($entity);
		if (count($criteria)) {
			foreach ($criteria as $col => $val) {
				if (!isset($columns[$col])) {
					throw new \Exception('There is no field "' . $col . '" in ' . $this->getEntityClassName());
				}
				/** @var Column $column */
				$column = $columns[$col];
				if ($val === null) {
					$db->andWhere($column->getName() . " IS NULL");
				} else {
					$db->andWhere($column->getName() . " = :$col")->setParameter($col, $val);
				}
			}
		}
		if (is_array($orderBy) && count($orderBy)) {
			foreach ($orderBy as $col => $val) {
				if (!isset($columns[$col])) {
					throw new \Exception('There is no field "' . $col . '" in ' . $this->getEntityClassName());
				}
				/** @var Column $column */
				$column = $columns[$col];
				$db->addOrderBy($column->getName(), $val);
			}
		}
		if ($limit !== null) {
			$db->setMaxResults($limit);
		}
		if ($offset != null) {
			$db->setFirstResult($offset);
		}

		return self::fetch($db, $noCache);
	}

	public function findOneBy(array $criteria = [], array $orderBy = null, $noCache = null)
	{
		$result = self::findBy($criteria, $orderBy, 1, null, $noCache);

		return @$result[0];
	}

	public function __call($name, $arguments) {
		if (preg_match('/^findBy(.*)$/', $name, $matches)) {
			if (count($arguments) < 1) {
				throw new \Exception('Too few parameters');
			}
			return self::findBy([lcfirst($matches[1]) => $arguments[0]], @$arguments[1], @$arguments[2], @$arguments[3], @$arguments[4]);
		} elseif (preg_match('/^findOneBy(.*)$/', $name, $matches)) {
			if (count($arguments) < 1) {
				throw new \Exception('Too few parameters');
			}

			return $this->findOneBy([lcfirst($matches[1]) => $arguments[0]], @$arguments[1], @$arguments[2]);
		}

		throw new \ErrorException ('Call to Undefined Method ' . get_called_class() . '::' . $name . '()', 0, E_ERROR);
	}

}