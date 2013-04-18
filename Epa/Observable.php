<?php

/**
 * @package vidola
 */
namespace Epa;

/**
 * @package Epa
 */
interface Observable
{
	public function addObserver(Observer $observer);
}