<?php


abstract class BasesfJob extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $sf_job_queue_id;


	
	protected $type;


	
	protected $tries;


	
	protected $max_tries;


	
	protected $is_recuring;


	
	protected $retry_delay;


	
	protected $params;


	
	protected $message;


	
	protected $priority = 0;


	
	protected $created_at;


	
	protected $scheduled_at;


	
	protected $completed_at;


	
	protected $last_tried_at;


	
	protected $status = 2;

	
	protected $asfJobQueue;

	
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

	
	public function getSfJobQueueId()
	{

		return $this->sf_job_queue_id;
	}

	
	public function getType()
	{

		return $this->type;
	}

	
	public function getTries()
	{

		return $this->tries;
	}

	
	public function getMaxTries()
	{

		return $this->max_tries;
	}

	
	public function getIsRecuring()
	{

		return $this->is_recuring;
	}

	
	public function getRetryDelay()
	{

		return $this->retry_delay;
	}

	
	public function getParams()
	{

		return $this->params;
	}

	
	public function getMessage()
	{

		return $this->message;
	}

	
	public function getPriority()
	{

		return $this->priority;
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

	
	public function getScheduledAt($format = 'Y-m-d H:i:s')
	{

		if ($this->scheduled_at === null || $this->scheduled_at === '') {
			return null;
		} elseif (!is_int($this->scheduled_at)) {
						$ts = strtotime($this->scheduled_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [scheduled_at] as date/time value: " . var_export($this->scheduled_at, true));
			}
		} else {
			$ts = $this->scheduled_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getCompletedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->completed_at === null || $this->completed_at === '') {
			return null;
		} elseif (!is_int($this->completed_at)) {
						$ts = strtotime($this->completed_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [completed_at] as date/time value: " . var_export($this->completed_at, true));
			}
		} else {
			$ts = $this->completed_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getLastTriedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->last_tried_at === null || $this->last_tried_at === '') {
			return null;
		} elseif (!is_int($this->last_tried_at)) {
						$ts = strtotime($this->last_tried_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [last_tried_at] as date/time value: " . var_export($this->last_tried_at, true));
			}
		} else {
			$ts = $this->last_tried_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getStatus()
	{

		return $this->status;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = sfJobPeer::ID;
		}

	} 
	
	public function setName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = sfJobPeer::NAME;
		}

	} 
	
	public function setSfJobQueueId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sf_job_queue_id !== $v) {
			$this->sf_job_queue_id = $v;
			$this->modifiedColumns[] = sfJobPeer::SF_JOB_QUEUE_ID;
		}

		if ($this->asfJobQueue !== null && $this->asfJobQueue->getId() !== $v) {
			$this->asfJobQueue = null;
		}

	} 
	
	public function setType($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->type !== $v) {
			$this->type = $v;
			$this->modifiedColumns[] = sfJobPeer::TYPE;
		}

	} 
	
	public function setTries($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->tries !== $v) {
			$this->tries = $v;
			$this->modifiedColumns[] = sfJobPeer::TRIES;
		}

	} 
	
	public function setMaxTries($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->max_tries !== $v) {
			$this->max_tries = $v;
			$this->modifiedColumns[] = sfJobPeer::MAX_TRIES;
		}

	} 
	
	public function setIsRecuring($v)
	{

		if ($this->is_recuring !== $v) {
			$this->is_recuring = $v;
			$this->modifiedColumns[] = sfJobPeer::IS_RECURING;
		}

	} 
	
	public function setRetryDelay($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->retry_delay !== $v) {
			$this->retry_delay = $v;
			$this->modifiedColumns[] = sfJobPeer::RETRY_DELAY;
		}

	} 
	
	public function setParams($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->params !== $v) {
			$this->params = $v;
			$this->modifiedColumns[] = sfJobPeer::PARAMS;
		}

	} 
	
	public function setMessage($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->message !== $v) {
			$this->message = $v;
			$this->modifiedColumns[] = sfJobPeer::MESSAGE;
		}

	} 
	
	public function setPriority($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->priority !== $v || $v === 0) {
			$this->priority = $v;
			$this->modifiedColumns[] = sfJobPeer::PRIORITY;
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
			$this->modifiedColumns[] = sfJobPeer::CREATED_AT;
		}

	} 
	
	public function setScheduledAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [scheduled_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->scheduled_at !== $ts) {
			$this->scheduled_at = $ts;
			$this->modifiedColumns[] = sfJobPeer::SCHEDULED_AT;
		}

	} 
	
	public function setCompletedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [completed_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->completed_at !== $ts) {
			$this->completed_at = $ts;
			$this->modifiedColumns[] = sfJobPeer::COMPLETED_AT;
		}

	} 
	
	public function setLastTriedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [last_tried_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_tried_at !== $ts) {
			$this->last_tried_at = $ts;
			$this->modifiedColumns[] = sfJobPeer::LAST_TRIED_AT;
		}

	} 
	
	public function setStatus($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->status !== $v || $v === 2) {
			$this->status = $v;
			$this->modifiedColumns[] = sfJobPeer::STATUS;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->sf_job_queue_id = $rs->getInt($startcol + 2);

			$this->type = $rs->getString($startcol + 3);

			$this->tries = $rs->getInt($startcol + 4);

			$this->max_tries = $rs->getInt($startcol + 5);

			$this->is_recuring = $rs->getBoolean($startcol + 6);

			$this->retry_delay = $rs->getInt($startcol + 7);

			$this->params = $rs->getString($startcol + 8);

			$this->message = $rs->getString($startcol + 9);

			$this->priority = $rs->getInt($startcol + 10);

			$this->created_at = $rs->getTimestamp($startcol + 11, null);

			$this->scheduled_at = $rs->getTimestamp($startcol + 12, null);

			$this->completed_at = $rs->getTimestamp($startcol + 13, null);

			$this->last_tried_at = $rs->getTimestamp($startcol + 14, null);

			$this->status = $rs->getInt($startcol + 15);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 16; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfJob object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfJob:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfJobPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfJobPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfJob:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfJob:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(sfJobPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfJobPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfJob:save:post') as $callable)
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


												
			if ($this->asfJobQueue !== null) {
				if ($this->asfJobQueue->isModified()) {
					$affectedRows += $this->asfJobQueue->save($con);
				}
				$this->setsfJobQueue($this->asfJobQueue);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfJobPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfJobPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

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


												
			if ($this->asfJobQueue !== null) {
				if (!$this->asfJobQueue->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfJobQueue->getValidationFailures());
				}
			}


			if (($retval = sfJobPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfJobPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getSfJobQueueId();
				break;
			case 3:
				return $this->getType();
				break;
			case 4:
				return $this->getTries();
				break;
			case 5:
				return $this->getMaxTries();
				break;
			case 6:
				return $this->getIsRecuring();
				break;
			case 7:
				return $this->getRetryDelay();
				break;
			case 8:
				return $this->getParams();
				break;
			case 9:
				return $this->getMessage();
				break;
			case 10:
				return $this->getPriority();
				break;
			case 11:
				return $this->getCreatedAt();
				break;
			case 12:
				return $this->getScheduledAt();
				break;
			case 13:
				return $this->getCompletedAt();
				break;
			case 14:
				return $this->getLastTriedAt();
				break;
			case 15:
				return $this->getStatus();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfJobPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getSfJobQueueId(),
			$keys[3] => $this->getType(),
			$keys[4] => $this->getTries(),
			$keys[5] => $this->getMaxTries(),
			$keys[6] => $this->getIsRecuring(),
			$keys[7] => $this->getRetryDelay(),
			$keys[8] => $this->getParams(),
			$keys[9] => $this->getMessage(),
			$keys[10] => $this->getPriority(),
			$keys[11] => $this->getCreatedAt(),
			$keys[12] => $this->getScheduledAt(),
			$keys[13] => $this->getCompletedAt(),
			$keys[14] => $this->getLastTriedAt(),
			$keys[15] => $this->getStatus(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfJobPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setSfJobQueueId($value);
				break;
			case 3:
				$this->setType($value);
				break;
			case 4:
				$this->setTries($value);
				break;
			case 5:
				$this->setMaxTries($value);
				break;
			case 6:
				$this->setIsRecuring($value);
				break;
			case 7:
				$this->setRetryDelay($value);
				break;
			case 8:
				$this->setParams($value);
				break;
			case 9:
				$this->setMessage($value);
				break;
			case 10:
				$this->setPriority($value);
				break;
			case 11:
				$this->setCreatedAt($value);
				break;
			case 12:
				$this->setScheduledAt($value);
				break;
			case 13:
				$this->setCompletedAt($value);
				break;
			case 14:
				$this->setLastTriedAt($value);
				break;
			case 15:
				$this->setStatus($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfJobPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSfJobQueueId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setType($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTries($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setMaxTries($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsRecuring($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setRetryDelay($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setParams($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setMessage($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setPriority($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCreatedAt($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setScheduledAt($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setCompletedAt($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setLastTriedAt($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setStatus($arr[$keys[15]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfJobPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfJobPeer::ID)) $criteria->add(sfJobPeer::ID, $this->id);
		if ($this->isColumnModified(sfJobPeer::NAME)) $criteria->add(sfJobPeer::NAME, $this->name);
		if ($this->isColumnModified(sfJobPeer::SF_JOB_QUEUE_ID)) $criteria->add(sfJobPeer::SF_JOB_QUEUE_ID, $this->sf_job_queue_id);
		if ($this->isColumnModified(sfJobPeer::TYPE)) $criteria->add(sfJobPeer::TYPE, $this->type);
		if ($this->isColumnModified(sfJobPeer::TRIES)) $criteria->add(sfJobPeer::TRIES, $this->tries);
		if ($this->isColumnModified(sfJobPeer::MAX_TRIES)) $criteria->add(sfJobPeer::MAX_TRIES, $this->max_tries);
		if ($this->isColumnModified(sfJobPeer::IS_RECURING)) $criteria->add(sfJobPeer::IS_RECURING, $this->is_recuring);
		if ($this->isColumnModified(sfJobPeer::RETRY_DELAY)) $criteria->add(sfJobPeer::RETRY_DELAY, $this->retry_delay);
		if ($this->isColumnModified(sfJobPeer::PARAMS)) $criteria->add(sfJobPeer::PARAMS, $this->params);
		if ($this->isColumnModified(sfJobPeer::MESSAGE)) $criteria->add(sfJobPeer::MESSAGE, $this->message);
		if ($this->isColumnModified(sfJobPeer::PRIORITY)) $criteria->add(sfJobPeer::PRIORITY, $this->priority);
		if ($this->isColumnModified(sfJobPeer::CREATED_AT)) $criteria->add(sfJobPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(sfJobPeer::SCHEDULED_AT)) $criteria->add(sfJobPeer::SCHEDULED_AT, $this->scheduled_at);
		if ($this->isColumnModified(sfJobPeer::COMPLETED_AT)) $criteria->add(sfJobPeer::COMPLETED_AT, $this->completed_at);
		if ($this->isColumnModified(sfJobPeer::LAST_TRIED_AT)) $criteria->add(sfJobPeer::LAST_TRIED_AT, $this->last_tried_at);
		if ($this->isColumnModified(sfJobPeer::STATUS)) $criteria->add(sfJobPeer::STATUS, $this->status);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfJobPeer::DATABASE_NAME);

		$criteria->add(sfJobPeer::ID, $this->id);

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

		$copyObj->setSfJobQueueId($this->sf_job_queue_id);

		$copyObj->setType($this->type);

		$copyObj->setTries($this->tries);

		$copyObj->setMaxTries($this->max_tries);

		$copyObj->setIsRecuring($this->is_recuring);

		$copyObj->setRetryDelay($this->retry_delay);

		$copyObj->setParams($this->params);

		$copyObj->setMessage($this->message);

		$copyObj->setPriority($this->priority);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setScheduledAt($this->scheduled_at);

		$copyObj->setCompletedAt($this->completed_at);

		$copyObj->setLastTriedAt($this->last_tried_at);

		$copyObj->setStatus($this->status);


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
			self::$peer = new sfJobPeer();
		}
		return self::$peer;
	}

	
	public function setsfJobQueue($v)
	{


		if ($v === null) {
			$this->setSfJobQueueId(NULL);
		} else {
			$this->setSfJobQueueId($v->getId());
		}


		$this->asfJobQueue = $v;
	}


	
	public function getsfJobQueue($con = null)
	{
				include_once 'plugins/sfJobQueuePlugin/lib/model/om/BasesfJobQueuePeer.php';

		if ($this->asfJobQueue === null && ($this->sf_job_queue_id !== null)) {

			$this->asfJobQueue = sfJobQueuePeer::retrieveByPK($this->sf_job_queue_id, $con);

			
		}
		return $this->asfJobQueue;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfJob:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfJob::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 