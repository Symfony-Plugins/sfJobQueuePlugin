<?php


abstract class BasesfJobQueuePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_job_queue';

	
	const CLASS_DEFAULT = 'plugins.sfJobQueuePlugin.lib.model.sfJobQueue';

	
	const NUM_COLUMNS = 8;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'sf_job_queue.ID';

	
	const NAME = 'sf_job_queue.NAME';

	
	const SCHEDULER_NAME = 'sf_job_queue.SCHEDULER_NAME';

	
	const SCHEDULER_PARAMS = 'sf_job_queue.SCHEDULER_PARAMS';

	
	const STATUS = 'sf_job_queue.STATUS';

	
	const REQUESTED_STATUS = 'sf_job_queue.REQUESTED_STATUS';

	
	const POLLING_DELAY = 'sf_job_queue.POLLING_DELAY';

	
	const CREATED_AT = 'sf_job_queue.CREATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Name', 'SchedulerName', 'SchedulerParams', 'Status', 'RequestedStatus', 'PollingDelay', 'CreatedAt', ),
		BasePeer::TYPE_COLNAME => array (sfJobQueuePeer::ID, sfJobQueuePeer::NAME, sfJobQueuePeer::SCHEDULER_NAME, sfJobQueuePeer::SCHEDULER_PARAMS, sfJobQueuePeer::STATUS, sfJobQueuePeer::REQUESTED_STATUS, sfJobQueuePeer::POLLING_DELAY, sfJobQueuePeer::CREATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'name', 'scheduler_name', 'scheduler_params', 'status', 'requested_status', 'polling_delay', 'created_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Name' => 1, 'SchedulerName' => 2, 'SchedulerParams' => 3, 'Status' => 4, 'RequestedStatus' => 5, 'PollingDelay' => 6, 'CreatedAt' => 7, ),
		BasePeer::TYPE_COLNAME => array (sfJobQueuePeer::ID => 0, sfJobQueuePeer::NAME => 1, sfJobQueuePeer::SCHEDULER_NAME => 2, sfJobQueuePeer::SCHEDULER_PARAMS => 3, sfJobQueuePeer::STATUS => 4, sfJobQueuePeer::REQUESTED_STATUS => 5, sfJobQueuePeer::POLLING_DELAY => 6, sfJobQueuePeer::CREATED_AT => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'name' => 1, 'scheduler_name' => 2, 'scheduler_params' => 3, 'status' => 4, 'requested_status' => 5, 'polling_delay' => 6, 'created_at' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/sfJobQueuePlugin/lib/model/map/sfJobQueueMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.sfJobQueuePlugin.lib.model.map.sfJobQueueMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = sfJobQueuePeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(sfJobQueuePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfJobQueuePeer::ID);

		$criteria->addSelectColumn(sfJobQueuePeer::NAME);

		$criteria->addSelectColumn(sfJobQueuePeer::SCHEDULER_NAME);

		$criteria->addSelectColumn(sfJobQueuePeer::SCHEDULER_PARAMS);

		$criteria->addSelectColumn(sfJobQueuePeer::STATUS);

		$criteria->addSelectColumn(sfJobQueuePeer::REQUESTED_STATUS);

		$criteria->addSelectColumn(sfJobQueuePeer::POLLING_DELAY);

		$criteria->addSelectColumn(sfJobQueuePeer::CREATED_AT);

	}

	const COUNT = 'COUNT(sf_job_queue.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_job_queue.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfJobQueuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfJobQueuePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = sfJobQueuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = sfJobQueuePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return sfJobQueuePeer::populateObjects(sfJobQueuePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfJobQueuePeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BasesfJobQueuePeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			sfJobQueuePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = sfJobQueuePeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return sfJobQueuePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfJobQueuePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfJobQueuePeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(sfJobQueuePeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BasesfJobQueuePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfJobQueuePeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfJobQueuePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfJobQueuePeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(sfJobQueuePeer::ID);
			$selectCriteria->add(sfJobQueuePeer::ID, $criteria->remove(sfJobQueuePeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfJobQueuePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfJobQueuePeer', $values, $con, $ret);
    }

    return $ret;
  }

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += sfJobQueuePeer::doOnDeleteCascade(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(sfJobQueuePeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(sfJobQueuePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof sfJobQueue) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfJobQueuePeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			$affectedRows += sfJobQueuePeer::doOnDeleteCascade($criteria, $con);
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected static function doOnDeleteCascade(Criteria $criteria, Connection $con)
	{
				$affectedRows = 0;

				$objects = sfJobQueuePeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			include_once 'plugins/sfJobQueuePlugin/lib/model/sfJob.php';

						$c = new Criteria();
			
			$c->add(sfJobPeer::SF_JOB_QUEUE_ID, $obj->getId());
			$affectedRows += sfJobPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	
	public static function doValidate(sfJobQueue $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfJobQueuePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfJobQueuePeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(sfJobQueuePeer::DATABASE_NAME, sfJobQueuePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfJobQueuePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(sfJobQueuePeer::DATABASE_NAME);

		$criteria->add(sfJobQueuePeer::ID, $pk);


		$v = sfJobQueuePeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(sfJobQueuePeer::ID, $pks, Criteria::IN);
			$objs = sfJobQueuePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BasesfJobQueuePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/sfJobQueuePlugin/lib/model/map/sfJobQueueMapBuilder.php';
	Propel::registerMapBuilder('plugins.sfJobQueuePlugin.lib.model.map.sfJobQueueMapBuilder');
}
