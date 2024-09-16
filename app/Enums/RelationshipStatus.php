<?php

namespace App\Enums;

enum RelationshipStatus: int
{
	case SINGLE = 0;
	case NEVER_HAD_RELATIONSHIP = 1;
	case DIVORCED = 2;

	public function name(): string
	{
		return __('enums.relationship_status.'.$this->value);
	}

	public function relationship_status_type_text(): string
	{
		return match($this) {
			RelationshipStatus::SINGLE => 'Single',
			RelationshipStatus::NEVER_HAD_RELATIONSHIP => 'Never had relationship',
			RelationshipStatus::DIVORCED => 'Divorced'
		};
	}
}
