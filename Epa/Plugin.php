<?php

/**
 * @package Epa
 */
namespace Epa;

/**
 * @package Epa
 */
abstract class Plugin
{
	abstract public function register(EventMapper $mapper);
}