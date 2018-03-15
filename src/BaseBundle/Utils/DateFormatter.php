<?php

namespace BaseBundle\Utils;

class DateFormatter
{
	static private $months = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
	private $timestamp;
	private $withTime;

	public function __construct($timestamp, $withTime = false)
	{
		$this->timestamp = $timestamp;
		$this->withTime = $withTime;
	}

	function __toString()
	{
		$result = date('j ', $this->timestamp);
		$result .= self::$months[date('n', $this->timestamp) - 1];
		$result .= date(' Y', $this->timestamp) . ' г.';

		if ($this->withTime) {
			$result .= ' в ' . date('H:i', $this->timestamp);
		}

		return $result;
	}

} 