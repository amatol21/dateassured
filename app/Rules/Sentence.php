<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Sentence implements ValidationRule
{
	/**
	 * Run the validation rule.
	 *
	 * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
	 */
	public function validate(string $attribute, mixed $value, Closure $fail): void
	{
		$string_length = strlen($value);
		$string_length--;
		for($i = 0; $i <= $string_length; $i++){
			//dump($value[$i]);
			if(!preg_match('#[-?!,.a-zA-Z0-9 ]#', $value[$i])){
				$fail('You can use only these symbols: a-z A-Z 0-9 ?!,.-')->translate();
			}
		}
		
	}
}
