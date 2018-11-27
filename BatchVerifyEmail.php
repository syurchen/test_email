<?php

class BatchVerifyEmail {

	private $mysqli;

	private $vmail;

	private $tableName;

	private $tableRowEmail;
	
	private $tableRowFlag;

	private $batch;

	public function __construct($host, $user, $pass, $db, $tableName, $tableRowEmail, $tableRowFlag, $batch) {

		$this->mysqli = new mysqli($host, $user, $pass, $db);
		if ($this->mysqli->connect_errno)
			return false;

		$this->tableName = $tableName;
		$this->tableRowEmail = $tableRowEmail;
		$this->tableRowFlag = $tableRowFlag;

		$this->vmail = new verifyEmail();
		$this->batch = $batch;
	}

	public function verifyBatch(){
		$validated = array();
		$invalid = array();

		$emails = $this->selectUncheckedEmails($this->batch);
		foreach ($emails as $email){
			if (isset($email[0]))
				$email = $email[0];
			if ($this->verifySingle($email)){
				$validated[] = $email;
			} else {
				$invalid[] = $email;
			}

		}

		$this->updateValid($validated, $invalid);

		return $validated;
	}

	public function verifySingle($email){
		return ($this->vmail->isValid($email) && $this->vmail->check($email));
	}

	private function updateValid($valid, $invalid){
		$sql = "update {$this->tableName} set {$this->tableRowFlag} = 1 where {$this->tableRowEmail} in ('" .
			implode('\',\'', $valid) . "')";
		$this->mysqli->query($sql);

		$sql = "update {$this->tableName} set {$this->tableRowFlag} = 0 where {$this->tableRowEmail} in ('" .
			implode('\',\'', $invalid) . "')";
		$this->mysqli->query($sql);
	}


	private function selectUncheckedEmails($batch){
		$sql = "select {$this->tableRowEmail} from {$this->tableName} where {$this->tableRowFlag} is null limit {$this->batch}";
		$result = $this->mysqli->query($sql);
		if ($result->num_rows){
			$result = $result->fetch_all();
			return $result;
		}
		return false;
	}


    
}