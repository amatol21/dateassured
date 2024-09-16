<?php

namespace App\Enums;

enum Religion: int
{
	case CHRISTIAN = 0;
	case CATHOLIC = 1;
	case ORTHODOX = 2;
	case ISLAM = 3;
	case HINDU = 4;
	case BUDDHIST = 5;
	case NON_RELIGIOUS = 6;

	public function name(): string
	{
		return __('enums.religion.'.$this->value);
	}

	public function religion_text(): string
	{
		return match($this) {
			Religion::CHRISTIAN => 'Christian',
			Religion::CATHOLIC => 'Catholic',
			Religion::ORTHODOX => 'Orthodox',
			Religion::ISLAM => 'Islam',
			Religion::HINDU => 'Hindu',
			Religion::BUDDHIST => 'Buddhist',
			Religion::NON_RELIGIOUS => 'Non religious'
		};
	}
}
