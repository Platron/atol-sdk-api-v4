<?php

namespace Platron\AtolV4\data_objects;

abstract class BaseDataObject
{
	/**
	 * Получить параметры, сгенерированные командой
	 * @return array
	 */
	public function getParameters()
	{
		$fieldVars = array();
		foreach (get_object_vars($this) as $name => $value) {
			if (null !== $value) {
				if ($value instanceof BaseDataObject) {
					$fieldVars[$name] = $value->getParameters();
				} else {
					$fieldVars[$name] = $value;
				}
			}
		}
		return $fieldVars;
	}
}
