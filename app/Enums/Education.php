<?php

namespace App\Enums;

enum Education: int
{
	case UNI_DEGREE = 0;
	case HIGH_SCGOOL = 1;
	case NO_EDUCATION = 2;

	public function name(): string
	{
		return __('enums.education.'.$this->value);
	}

	public function education_type_text(): string
	{
		return match($this) {
			Education::UNI_DEGREE => 'Uni degree',
			Education::HIGH_SCGOOL => 'High school',
			Education::NO_EDUCATION => 'No education'
		};
	}
}
