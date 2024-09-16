<?php

namespace App\Enums;

enum Occupation: int
{
	case EMPLOYED = 0;
	case UNEMPLOYED = 1;
	case STUDENT = 2;

	public function name(): string
	{
		return __('enums.occupation.'.$this->value);
	}

	public function occupation_type_text(): string
	{
		return match($this) {
			Occupation::EMPLOYED => 'Employed',
			Occupation::UNEMPLOYED => 'Unemployed',
			Occupation::STUDENT => 'Student'
		};
	}
}
