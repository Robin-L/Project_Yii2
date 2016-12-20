<?php 

namespace console\controllers;

use Yii;
use yii\console\Controller;

class TestController extends Controller
{
	// CMD: yii test/index Test 25
	public function actionIndex($name, $age)
	{
		echo "name is {$name}\n";
		echo "age is {$age}";
		return self::EXIT_CODE_NORMAL;
	}
}