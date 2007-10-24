<?php


abstract class BasesfJobPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_job';

	
	const CLASS_DEFAULT = 'plugins.sfJobQueuePlugin.lib.model.sfJob';

	
	const NUM_COLUMNS = 16;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'sf_job.ID';

	
	const NAME = 'sf_job.NAME';

	
	const SF_JOB_QUEUE_ID = 'sf_job.SF_JOB_QUEUE_ID';

	
	const TYPE = 'sf_job.TYPE';

	
	const TRIES = 'sf_job.TRIES';

	
	const MAX_TRIES = 'sf_job.MAX_TRIES';

	
	const IS_RECURING = 'sf_job.IS_RECURING';

	
	const RETRY_DELAY = 'sf_job.RETRY_DELAY';

	
	const PARAMS = 'sf_job.PARAMS';

	
	const MESSAGE = 'sf_job.MESSAGE';

	
	const PRIORITY = 'sf_job.PRIORITY';

	
	const CREATED_AT = 'sf_job.CREATED_AT';

	
	const SCHEDULED_AT = 'sf_job.SCHEDULED_AT';

	
	const COMPLETED_AT = 'sf_job.COMPLETED_AT';

	
	const LAST_TRIED_AT = 'sf_job.LAST_TRIED_AT';

	
	const STATUS = 'sf_job.STATUS';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Name', 'SfJobQueueId', 'Type', 'Tries', 'MaxTries', 'IsRecuring', 'RetryDelay', 'Params', 'Message', 'Priority', 'CreatedAt', 'ScheduledAt', 'CompletedAt', 'LastTriedAt', 'Status', ),
		BasePeer::TYPE_COLNAME => array (sfJobPeer::ID, sfJobPeer::NAME, sfJobPeer::SF_JOB_QUEUE_ID, sfJobPeer::TYPE, sfJobPeer::TRIES, sfJobPeer::MAX_TRIES, sfJobPeer::IS_RECURING, sfJobPeer::RETRY_DELAY, sfJobPeer::PARAMS, sfJobPeer::MESSAGE, sfJobPeer::PRIORITY, sfJobPeer::CREATED_AT, sfJobPeer::SCHEDULED_AT, sfJobPeer::COMPLETED_AT, sfJobPeer::LAST_TRIED_AT, sfJobPeer::STATUS, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'name', 'sf_job_queue_id', 'type', 'tries', 'max_tries', 'is_recuring', 'retry_delay', 'params', 'message', 'priority', 'created_at', 'scheduled_at', 'completed_at', 'last_tried_at', 'status', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Name' => 1, 'SfJobQueueId' => 2, 'Type' => 3, 'Tries' => 4, 'MaxTries' => 5, 'IsRecuring' => 6, 'RetryDelay' => 7, 'Params' => 8, 'Message' => 9, 'Priority' => 10, 'CreatedAt' => 11, 'ScheduledAt' => 12, 'CompletedAt' => 13, 'LastTriedAt' => 14, 'Status' => 15, ),
		BasePeer::TYPE_COLNAME => array (sfJobPeer::ID => 0, sfJobPeer::NAME => 1, sfJobPeer::SF_JOB_QUEUE_ID => 2, sfJobPeer::TYPE => 3, sfJobPeer::TRIES => 4, sfJobPeer::MAX_TRIES => 5, sfJobPeer::IS_RECURING => 6, sfJobPeer::RETRY_DELAY => 7, sfJobPeer::PARAMS => 8, sfJobPeer::MESSAGE => 9, sfJobPeer::PRIORITY => 10, sfJobPeer::CREATED_AT => 11, sfJobPeer::SCHEDULED_AT => 12, sfJobPeer::COMPLETED_AT => 13, sfJobPeer::LAST_TRIED_AT => 14, sfJobPeer::STATUS => 15, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'name' => 1, 'sf_job_queue_id' => 2, 'type' => 3, 'tries' => 4, 'max_tries' => 5, 'is_recuring' => 6, 'retry_delay' => 7, 'params' => 8, 'message' => 9, 'priority' => 10, 'created_at' => 11, 'scheduled_at' => 12, 'completed_at' => 13, 'last_tried_at' => 14, 'status' => 15, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/sfJobQueuePlugin/lib/model/map/sfJobMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.sfJobQueuePlugin.lib.model.map.sfJobMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = sfJobPeer::getTableMap();
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
		return str_replace(sfJobPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfJobPeer::ID);

		$criteria->addSelectColumn(sfJobPeer::NAME);

		$criteria->addSelectColumn(sfJobPeer::SF_JOB_QUEUE_ID);

		$criteria->addSelectColumn(sfJobPeer::TYPE);

		$criteria->addSelectColumn(sfJobPeer::TRIES);

		$criteria->addSelectColumn(sfJobPeer::MAX_TRIES);

		$criteria->addSelectColumn(sfJobPeer::IS_RECURING);

		$criteria->addSelectColumn(sfJobPeer::RETRY_DELAY);

		$criteria->addSelectColumn(sfJobPeer::PARAMS);

		$criteria->addSelectColumn(sfJobPeer::MESSAGE);

		$criteria->addSelectColumn(sfJobPeer::PRIORITY);

		$criteria->addSelectColumn(sfJobPeer::CREATED_AT);

		$criteria->addSelectColumn(sfJobPeer::SCHEDULED_AT);

		$criteria->addSelectColumn(sfJobPeer::COMPLETED_AT);

		$criteria->addSelectColumn(sfJobPeer::LAST_TRIED_AT);

		$criteria->addSelectColumn(sfJobPeer::STATUS);

	}

	const COUNT = 'COUNT(sf_job.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_job.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfJobPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfJobPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = sfJobPeer::doSelectRS($criteria, $con);
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
		$objects = sfJobPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return sfJobPeer::populateObjects(sfJobPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfJobPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BasesfJobPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			sfJobPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = sfJobPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinsfJobQueue(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfJobPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfJobPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfJobPeer::SF_JOB_QUEUE_ID, sfJobQueuePeer::ID);

		$rs = sfJobPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinsfJobQueue(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfJobPeer::addSelectColumns($c);
		$startcol = (sfJobPeer::NUM_COLUMNS - sfJobPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		sfJobQueuePeer::addSelectColumns($c);

		$c->addJoin(sfJobPeer::SF_JOB_QUEUE_ID, sfJobQueuePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfJobPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfJobQueuePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getsfJobQueue(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addsfJob($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initsfJobs();
				$obj2->addsfJob($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfJobPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfJobPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfJobPeer::SF_JOB_QUEUE_ID, sfJobQueuePeer::ID);

		$rs = sfJobPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfJobPeer::addSelectColumns($c);
		$startcol2 = (sfJobPeer::NUM_COLUMNS - sfJobPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfJobQueuePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfJobQueuePeer::NUM_COLUMNS;

		$c->addJoin(sfJobPeer::SF_JOB_QUEUE_ID, sfJobQueuePeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfJobPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = sfJobQueuePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfJobQueue(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addsfJob($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initsfJobs();
				$obj2->addsfJob($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}

	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return sfJobPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfJobPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfJobPeer', $values, $con);
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

		$criteria->remove(sfJobPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BasesfJobPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfJobPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfJobPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfJobPeer', $values, $con);
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
			$comparison = $criteria->getComparison(sfJobPeer::ID);
			$selectCriteria->add(sfJobPeer::ID, $criteria->remove(sfJobPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfJobPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfJobPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(sfJobPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(sfJobPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof sfJob) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfJobPeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(sfJob $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfJobPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfJobPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(sfJobPeer::DATABASE_NAME, sfJobPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfJobPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(sfJobPeer::DATABASE_NAME);

		$criteria->add(sfJobPeer::ID, $pk);


		$v = sfJobPeer::doSelect($criteria, $con);

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
			$criteria->add(sfJobPeer::ID, $pks, Criteria::IN);
			$objs = sfJobPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BasesfJobPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/sfJobQueuePlugin/lib/model/map/sfJobMapBuilder.php';
	Propel::registerMapBuilder('plugins.sfJobQueuePlugin.lib.model.map.sfJobMapBuilder');
}
