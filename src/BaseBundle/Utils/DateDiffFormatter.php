<?php

namespace BaseBundle\Utils;

use Sv\BaseBundle\Utils\Utils;

class DateDiffFormatter
{
	private $timestamp;
	private $short;
	private $bold;
	private $withSeconds;

	public function __construct($timestamp, $short = false, $bold = false, $withSeconds = false)
	{
		$this->timestamp = $timestamp;
		$this->short = $short;
		$this->bold = $bold;
		$this->withSeconds = $withSeconds;
	}

	function __toString()
	{
		$now = new \DateTime('now');
		$diff = $now->diff(\DateTime::createFromFormat('U', $this->timestamp));

		$result = '';
		if (($y = $diff->format('%Y')) > 0) {
			$result .= $this->getPlural($y, 'год', 'года', 'лет');
		}
		if (($m = $diff->format('%m')) > 0) {
			$result .= $this->getPlural($m, 'месяц', 'месяца', 'месяцев');
		}
		if (($d = $diff->format('%d')) > 0) {
			$result .= $this->getPlural($d, 'день', 'дня', 'дней');
		}
		if (($h = $diff->format('%H')) > 0) {
			$result .= $this->getPlural($h, 'час', 'часа', 'часов');
		}
		if (($mi = $diff->format('%i')) > 0) {
			$result .= $this->getPlural($mi, 'минута', 'минуты', 'минут');
		}
		if ($this->withSeconds && ($s = $diff->format('%s')) > 0) {
			$result .= $this->getPlural($s, 'секунда', 'секунды', 'секунд');
		}

		return $result;
	}

	function getPlural($value, $one, $four, $many)
	{
		return ($this->bold ? '<b>' : '') . intval($value) . ($this->bold ? '</b>' : '') . ' ' .
			($this->short ? mb_substr($one, 0, 1, 'utf-8') . '. ' : Utils::getPlural($value, $one, $four, $many) . ' ');
	}

}