<?php

namespace App\Enums;

enum Kids: int
{
	case NO = 0;
	case YES = 1;

	public function name(): string
	{
		return __('enums.kids.'.$this->value);
	}

	public function kids_type_text(): string
	{
		return match($this) {
			Kids::NO => 'No',
			Kids::YES => 'Yes'
		};
	}
}
