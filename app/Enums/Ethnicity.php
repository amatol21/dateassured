<?php

namespace App\Enums;

enum Ethnicity: int
{
    case ASIAN = 0;
    case ARAB = 1;
    case CAUCASIAN = 2;
    case AFRICAN = 3;
	 case AMERICAN = 4;
	 case LATINO = 5;

    public function name(): string
    {
        return __('enums.ethnicity.'.$this->value);
    }

	public function ethnicity_type_text(): string
	{
		return match($this) {
			Ethnicity::ASIAN => 'Asian',
			Ethnicity::ARAB => 'Arab',
			Ethnicity::CAUCASIAN => 'Caucasian',
			Ethnicity::AFRICAN => 'African',
			Ethnicity::AMERICAN => 'American',
			Ethnicity::LATINO => 'Latino'
		};
	}
	 
}
