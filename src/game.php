<?php
namespace Bowling;

class game
{
	public $score; //tracks the total score of the game
	public $rollArray = array(); //arrays of pins (max of 21 elements)
	public $frameIndex ; //keeps track of index in frame note: Useful for determining if strike is pin 0 for a frame 


	/**
	 * @name game::roll
	 * @description Add pins to roll array. rollArray holds all the pins knocked down in each roll
	 * @param  [int] $pins
	 */
	public function roll($pins)
	{
		$this->rollArray[]=$pins;
	}

	/**
	 * @name game::getScore
	 * @description return final score for all rolls
	 * @return [int] score
	 */
	public function getScore()
	{
		$this->frameIndex =0; //Initialize FrameIndex to 0;

		for($frame=0;$frame <10;$frame++) //Frames are limited to 10, however the no of pins / frame can be 1,2 or 3 
										  // (consider bonus rounds)
		{
			if($this->isSpare($this->frameIndex))
			{
				//This Frame was a spare , add  10 + first pin of next frame
				$this->score += 10 + $this->getFirstPinOfNextFrame();
				$this->frameIndex+=2; //increment FrameIndex by 2 (so we are now in next frame) 
			}
			else if($this->isStrike($this->frameIndex))
			{	
				//Found a strike at beginning of frame, add the next frame (2 pins) to current frame result
				$this->score += 10 + $this->getSumOfPinsInFrame($this->frameIndex+1);
				$this->frameIndex+=1; //increment FrameIndex by 2 (so we are now in next frame) 

			}
			else
			{
				// This is not a strike or a spare, simply add the sum of pins in frame
				$this->score += $this->getSumOfPinsInFrame($this->frameIndex);
				$this->frameIndex+=2; //Frame has ended , increment FrameIndex by 2 (so we are now in next frame) 
			}
		}

		return $this->score ;


	}

	/**
	 * @name game::getSumOfPinsInFrame
	 * @param  [int] $i frameindex
	 * @return [int] Sum of values of all pins in frame
	 */
	public function getSumOfPinsInFrame($i)
	{
		return $this->rollArray[$i]+$this->rollArray[$i+1];
	}

	/**
	 * @name game::isSpare
	 * @description Checks if the pin at index $i is a spare
	 * @param  [int] $i frameindex
	 * @return boolean true if pin at index $i is a spare else false
	 */
	public function isSpare($i)
	{
		if($this->rollArray[$i] + $this->rollArray[$i+1] == 10)
			return true;
		else
			return false;
	}

	/**
	 * @name game::getFirstPinOfNextFrame
	 * @description Returns the first pin value of next frame
	 * @return [int] Value of first pin from next frame
	 */
	public function getFirstPinOfNextFrame(){

		return $this->rollArray[$this->frameIndex+2];
	}

	/**
	 * @name isStrike
	 * @description Checks if the pin is a strike
	 * @param  [int] frameindex
	 * @return [boolean] True if strike found at index ($i) , else false
	 */
	public function isStrike($i)
	{
		return ($this->rollArray[$i] == 10);
	}
	

}
?>