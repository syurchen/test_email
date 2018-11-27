<?php

include 'BatchVerifyEmail.php';
include 'verify-email/class.verifyEmail.php';
include 'config.php';

$batchVer = new BatchVerifyEmail(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, DB_TABLENAME, DB_EMAIL_FIELDNAME, DB_FLAG_FIELDNAME, SCR_BATCH);

if ($batchVer){
	print_r($batchVer->verifyBatch());
}

