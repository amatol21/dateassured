<?php

namespace App\Enums;

enum StarSign: int
{
	case ARIES = 0;
	case TAURUS = 1;
	case GEMINI = 2;
	case CANCER = 3;
	case LEO = 4;
	case VIRGO = 5;
	case LIBRA = 6;
	case CAPRICORN = 7;

	public function name(): string
	{
		return __('enums.star_sign.'.$this->value);
	}

	public function star_sign_type_text(): string
	{
		return match($this) {
			StarSign::ARIES => 'Aries',
			StarSign::TAURUS => 'Taurus',
			StarSign::GEMINI => 'Gemini',
			StarSign::CANCER => 'Cancer',
			StarSign::LEO => 'Leo',
			StarSign::VIRGO => 'Virgo',
			StarSign::LIBRA => 'Libra',
			StarSign::CAPRICORN => 'Capricorn'
		};
	}
}
