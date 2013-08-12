<?php

require_once('TestHelper.php');

class Epa_UnitTests_CallbackReorderTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function changesCallbackToFirstPosition()
	{
		$callback1 = function() {};
		$callback2 = function() {};
		$arrObj = new \ArrayObject();
		$arrObj['event'][] = $callback1;
		$arrObj['event'][] = $callback2;

		$callbackPosition = new \Epa\CallbackReorder($arrObj, 'event', $callback2);
		$callbackPosition->first();

		$this->assertSame($callback2, $arrObj['event'][0]);
	}
}