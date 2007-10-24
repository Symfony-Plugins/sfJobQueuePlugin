<?php



class sfJobMapBuilder {

	
	const CLASS_NAME = 'plugins.sfJobQueuePlugin.lib.model.map.sfJobMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('sf_job');
		$tMap->setPhpName('sfJob');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 30);

		$tMap->addForeignKey('SF_JOB_QUEUE_ID', 'SfJobQueueId', 'int', CreoleTypes::INTEGER, 'sf_job_queue', 'ID', true, null);

		$tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('TRIES', 'Tries', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('MAX_TRIES', 'MaxTries', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('IS_RECURING', 'IsRecuring', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('RETRY_DELAY', 'RetryDelay', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PARAMS', 'Params', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('MESSAGE', 'Message', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('PRIORITY', 'Priority', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('SCHEDULED_AT', 'ScheduledAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('COMPLETED_AT', 'CompletedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('LAST_TRIED_AT', 'LastTriedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('STATUS', 'Status', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 