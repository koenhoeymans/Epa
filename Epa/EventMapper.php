<?php

/**
 * @package Epa
 */
namespace Epa;

/**
 * @package Epa
 */
interface EventMapper
{
	public function registerForEvent($event, $callback);
}