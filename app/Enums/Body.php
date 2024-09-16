<?php

namespace App\Enums;

enum Body: int
{
	case SLIM = 0;
	case ATHLETIC = 1;
	case CURVY = 2;
	case FEW_EXTRA_KGS = 3;
	case OBESE = 4;

	public function name(): string
	{
		return __('enums.body.'.$this->value);
	}

	public function body_type_text(): string
	{
		return match($this) {
			Body::SLIM => 'Slim',
			Body::ATHLETIC => 'Athletic',
			Body::CURVY => 'Curvy',
			Body::FEW_EXTRA_KGS => 'Few extra kgs',
			Body::OBESE => 'Obese'
		};
	}
}
