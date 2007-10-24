<?php


abstract class BasesfJobQueue extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $scheduler_name;


	
	protected $scheduler_params;


	
	protected $status = 0;


	
	protected $requested_status = 0;


	
	protected $polling_delay = 10;


	
	protected $created_at;

	
	protected $collsfJobs;

	
	protected $lastsfJobCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getSchedulerName()
	{

		return $this->scheduler_name;
	}

	
	public function getSchedulerParams()
	{

		return $this->scheduler_params;
	}

	
	public function getStatus()
	{

		return $this->status;
	}

	
	public function getRequestedStatus()
	{

		return $this->requested_status;
	}

	
	public function getPollingDelay()
	{

		return $this->polling_delay;
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
						$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = sfJobQueuePeer::ID;
		}

	} 
	
	public function setName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = sfJobQueuePeer::NAME;
		}

	} 
	
	public function setSchedulerName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->scheduler_name !== $v) {
			$this->scheduler_name = $v;
			$this->modifiedColumns[] = sfJobQueuePeer::SCHEDULER_NAME;
		}

	} 
	
	public function setSchedulerParams($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->scheduler_params !== $v) {
			$this->scheduler_params = $v;
			$this->modifiedColumns[] = sfJobQueuePeer::SCHEDULER_PARAMS;
		}

	} 
	
	public function setStatus($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->status !== $v || $v === 0) {
			$this->status = $v;
			$this->modifiedColumns[] = sfJobQueuePeer::STATUS;
		}

	} 
	
	public function setRequestedStatus($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->requested_status !== $v || $v === 0) {
			$this->requested_status = $v;
			$this->modifiedColumns[] = sfJobQueuePeer::REQUESTED_STATUS;
		}

	} 
	
	public function setPollingDelay($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->polling_delay !== $v || $v === 10) {
			$this->polling_delay = $v;
			$this->modifiedColumns[] = sfJobQueuePeer::POLLING_DELAY;
		}

	} 
	
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = sfJobQueuePeer::CREATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->scheduler_name = $rs->getString($startcol + 2);

			$this->scheduler_params = $rs->getString($startcol + 3);

			$this->status = $rs->getInt($startcol + 4);

			$this->requested_status = $rs->getInt($startcol + 5);

			$this->polling_delay = $rs->getInt($startcol + 6);

			$this->created_at = $rs->getTimestamp($startcol + 7, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfJobQueue object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfJobQueue:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfJobQueuePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfJobQueuePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfJobQueue:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfJobQueue:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(sfJobQueuePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfJobQueuePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfJobQueue:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfJobQueuePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfJobQueuePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collsfJobs !== null) {
				foreach($this->collsfJobs as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = sfJobQueuePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collsfJobs !== null) {
					foreach($this->collsfJobs as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfJobQueuePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getSchedulerName();
				break;
			case 3:
				return $this->getSchedulerParams();
				break;
			case 4:
				return $this->getStatus();
				break;
			case 5:
				return $this->getRequestedStatus();
				break;
			case 6:
				return $this->getPollingDelay();
				break;
			case 7:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfJobQueuePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getSchedulerName(),
			$keys[3] => $this->getSchedulerParams(),
			$keys[4] => $this->getStatus(),
			$keys[5] => $this->getRequestedStatus(),
			$keys[6] => $this->getPollingDelay(),
			$keys[7] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfJobQueuePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setSchedulerName($value);
				break;
			case 3:
				$this->setSchedulerParams($value);
				break;
			case 4:
				$this->setStatus($value);
				break;
			case 5:
				$this->setRequestedStatus($value);
				break;
			case 6:
				$this->setPollingDelay($value);
				break;
			case 7:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfJobQueuePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSchedulerName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSchedulerParams($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setStatus($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRequestedStatus($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPollingDelay($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCreatedAt($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfJobQueuePeer::DATABASE_NAME);

		if ($this->isColumnModified(sfJobQueuePeer::ID)) $criteria->add(sfJobQueuePeer::ID, $this->id);
		if ($this->isColumnModified(sfJobQueuePeer::NAME)) $criteria->add(sfJobQueuePeer::NAME, $this->name);
		if ($this->isColumnModified(sfJobQueuePeer::SCHEDULER_NAME)) $criteria->add(sfJobQueuePeer::SCHEDULER_NAME, $this->scheduler_name);
		if ($this->isColumnModified(sfJobQueuePeer::SCHEDULER_PARAMS)) $criteria->add(sfJobQueuePeer::SCHEDULER_PARAMS, $this->scheduler_params);
		if ($this->isColumnModified(sfJobQueuePeer::STATUS)) $criteria->add(sfJobQueuePeer::STATUS, $this->status);
		if ($this->isColumnModified(sfJobQueuePeer::REQUESTED_STATUS)) $criteria->add(sfJobQueuePeer::REQUESTED_STATUS, $this->requested_status);
		if ($this->isColumnModified(sfJobQueuePeer::POLLING_DELAY)) $criteria->add(sfJobQueuePeer::POLLING_DELAY, $this->polling_delay);
		if ($this->isColumnModified(sfJobQueuePeer::CREATED_AT)) $criteria->add(sfJobQueuePeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfJobQueuePeer::DATABASE_NAME);

		$criteria->add(sfJobQueuePeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setSchedulerName($this->scheduler_name);

		$copyObj->setSchedulerParams($this->scheduler_params);

		$copyObj->setStatus($this->status);

		$copyObj->setRequestedStatus($this->requested_status);

		$copyObj->setPollingDelay($this->polling_delay);

		$copyObj->setCreatedAt($this->created_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getsfJobs() as $relObj) {
				$copyObj->addsfJob($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new sfJobQueuePeer();
		}
		return self::$peer;
	}

	
	public function initsfJobs()
	{
		if ($this->collsfJobs === null) {
			$this->collsfJobs = array();
		}
	}

	
	public function getsfJobs($criteria = null, $con = null)
	{
				include_once 'plugins/sfJobQueuePlugin/lib/model/om/BasesfJobPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfJobs === null) {
			if ($this->isNew()) {
			   $this->collsfJobs = array();
			} else {

				$criteria->add(sfJobPeer::SF_JOB_QUEUE_ID, $this->getId());

				sfJobPeer::addSelectColumns($criteria);
				$this->collsfJobs = sfJobPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfJobPeer::SF_JOB_QUEUE_ID, $this->getId());

				sfJobPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfJobCriteria) || !$this->lastsfJobCriteria->equals($criteria)) {
					$this->collsfJobs = sfJobPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfJobCriteria = $criteria;
		return $this->collsfJobs;
	}

	
	public function countsfJobs($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/sfJobQueuePlugin/lib/model/om/BasesfJobPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfJobPeer::SF_JOB_QUEUE_ID, $this->getId());

		return sfJobPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addsfJob(sfJob $l)
	{
		$this->collsfJobs[] = $l;
		$l->setsfJobQueue($this);
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfJobQueue:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfJobQueue::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 