<?php

namespace App;

class QueryExceptionUtil
{
	public static function getErrorFromException($exception){
		return "DB:" . explode(": ", explode("\n", $exception->errorInfo[2])[0])[1];
	}
}
