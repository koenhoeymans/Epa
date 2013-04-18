<?php

/**
 * @package Epa
 */
namespace Epa;

/**
 * @package Epa
 */
interface Observer
{
	public function notify(Event $event);
}