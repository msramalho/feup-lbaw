<?php

namespace App;

class QueryExceptionUtil
{
	public static function getErrorFromException($exception){
		if (is_a($exception, "Illuminate\Database\QueryException")) {
			return explode(": ", explode("\n", $exception->errorInfo[2])[0])[1];
		}
		return $exception->getMessage();
	}
}
