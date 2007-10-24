<?php



class sfJobQueueMapBuilder {

	
	const CLASS_NAME = 'plugins.sfJobQueuePlugin.lib.model.map.sfJobQueueMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_job_queue');
		$tMap->setPhpName('sfJobQueue');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('SCHEDULER_NAME', 'SchedulerName', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('SCHEDULER_PARAMS', 'SchedulerParams', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('STATUS', 'Status', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('REQUESTED_STATUS', 'RequestedStatus', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('POLLING_DELAY', 'PollingDelay', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 