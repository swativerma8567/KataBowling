<?php

use Bowling\game;

class gameTest extends PHPUnit_Framework_TestCase
{
	private $testGame;

	protected function setUp()
	{
		//Create new instance of game before each test
		$this->testGame=new game();
	}

	/**
	 * @name gameTest::fillRoll
	 * @description Add $noOfPins elements to roll array with value as $valOfPinss
	 * @param  [int] noOfPins
	 * @param  [int] valOfPinss
	 */
	private  function fillRoll($noOfPins,$valOfPinss)
	{
		while ($noOfPins-- >0)
		{
			$this->testGame->roll($valOfPinss);
		}
	}

	/*
		@name gameTest::testAllZeroe
		@description Test score for all gutters (All pin values are zero)
	 */
	public function testAllZeroes()
	{
		$this->fillRoll(20,0);
		$this->assertEquals(0,$this->testGame->getScore());
	}

	/*
		@name gameTest::testAllTwos
		@description Test score when roll have exactly 2 pins (All pin values are two)
	 */
	public function testAllTwos()
	{
		$this->fillRoll(20,2);
		$this->assertEquals(40,$this->testGame->getScore());
	}

	/**
	 * @name gameTest::testSpare
	 * @description On spare add the next pin to current frame result
	 * @return [type]
	 */
	public function testSpare()
	{
		$this->fillRoll(2,5); //spare frame[0]
		$this->fillRoll(1,2); //pin [0] for frame[1]
		$this->fillRoll(17,0); //All remaining pins are zero 
		$this->assertEquals(14,$this->testGame->getScore());
	}

	/**
	 * @name gameTest::testStrike
	 * @description Checks if there is a strike at index 0
	 * 
	 */
	public function testIsStrike()
	{
		$this->fillRoll(1,10); //Strike here frame 0
		$this->fillRoll(1,2); //pin[0] for frame 1
		$this->fillRoll(1,3); //pin[1] for frame 1
		$this->fillRoll(17,0); //All remaining pins are zero 
		$this->assertEquals(true,$this->testGame->isStrike(0));
	}

	/**
	 * @name gameTest::testStrike
	 * @description On Strike add the next two pin to current frame result
	 */
	public function testStrikeResults()
	{
		$this->fillRoll(1,10); //Strike here frame 0
		$this->fillRoll(1,2); //pin[0] for frame 1
		$this->fillRoll(1,3); //pin[1] for frame 1
		$this->fillRoll(17,0); //All remaining pins are zero 
		$this->assertEquals(20,$this->testGame->getScore());
	}

	/**
	 * @name gameTest::testBestScore
	 * @description Check result of best score (12 rolls: 12 strikes)
	 */
	public function testBestScore()
	{
		$this->fillRoll(12,10); //Strike here for all 12 frames
		$this->assertEquals(300,$this->testGame->getScore());
	}

	/**
	 * @name testAlternateMiss
	 * @description Test Alternate miss (20 rolls: 10 pairs of 9 and miss)
	 */
	public function testAlternateMiss()
	{	

		$this->fillRoll(1,9); //frame 0 start
		$this->fillRoll(1,0); //Miss here
		$this->fillRoll(1,9); //frame 1 start
		$this->fillRoll(1,0); //Miss here
		$this->fillRoll(1,9); //frame 2 start
		$this->fillRoll(1,0); //Miss here
		$this->fillRoll(1,9); //frame 3 start
		$this->fillRoll(1,0); //Miss here
		$this->fillRoll(1,9); //frame 4 start
		$this->fillRoll(1,0); //Miss here
		$this->fillRoll(1,9); //frame 5 start
		$this->fillRoll(1,0); //Miss here
		$this->fillRoll(1,9); //frame 6 start
		$this->fillRoll(1,0); //Miss here
		$this->fillRoll(1,9); //frame 7 start
		$this->fillRoll(1,0); //Miss here
		$this->fillRoll(1,9); //frame 8 start
		$this->fillRoll(1,0); //Miss here
		$this->fillRoll(1,9); //frame 9 start
		$this->fillRoll(1,0); //Miss here
		$this->fillRoll(1,9); //frame 10 start
		$this->fillRoll(1,0); //Miss here

		$this->assertEquals(90,$this->testGame->getScore());

	}

	/**
	 * @name testAllSpares
	 * @description Test Alternate spares (21 rolls: 10 pairs of 5 and spare, with a final 5)
	 */
	public function testAllSpares()
	{	
		$this->fillRoll(20,5); //All Spares for 10 frames
		$this->fillRoll(1,5); //All bonus spare as 5
		
		$this->assertEquals(150,$this->testGame->getScore());
	}

	/**
	 * @name testAllSpares
	 * @description Test Alternate spares (21 rolls: 10 pairs of 5 and spare, with a final 5)
	 */
	public function testSparesStrikeConbination()
	{	
		$this->fillRoll(6,10);//6 strikes (frame 0 - frame 5)
		$this->fillRoll(2,5);// spare (frame 6 - frame 7)
		$this->fillRoll(1,8);//frame 8 start
		$this->fillRoll(1,1); 
		$this->fillRoll(1,6);//frame 9 start
		$this->fillRoll(1,3);
		$this->fillRoll(1,10);//frame 10 start
		$this->fillRoll(2,5);

		$this->assertEquals(221,$this->testGame->getScore());
	}
	

	
}

?>