<?php

namespace App\Enums;

enum Languages: int
{
	case ENGLISH = 0;

	public function name(): string
	{
		return __('enums.language.'.$this->value);
	}

	public function language_type_text(): string
	{
		return match($this) {
			Languages::ENGLISH => 'English'
		};
	}
}
