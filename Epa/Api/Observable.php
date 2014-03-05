<?php

namespace Epa\Api;

/**
 * Needs to be implemented by a class that wants to make use of observers. It
 * follows the observer pattern.
 */
interface Observable
{
	/**
	 * Adds an observer. The observer should be notified of any events.
	 * 
	 * @param \Epa\Api\Observer $observer
	 * 
	 * @return void
	 */
	public function addObserver(\Epa\Api\Observer $observer);
}