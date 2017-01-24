<?php

namespace Crypto;

use Crypto\Contracts\CipherInterface;

final class Caesar implements CipherInterface
{
	/**
	 * Shift param
     */
	const NUMBER = 3;

	/**
	 * Encrypt function.
	 *
	 * @param $text
	 * @return string
     */
	public function encrypt(string $text) : string
	{
	    $text = Str::prepareTheText($text);

	    $result = '';
		for($i = 0; $i < strlen($text); $i++) {
			//ASCII value of character
			$character = ord($text[$i]);
			//ASCII: 97 = a
			if ($character >= 97) {
				$result .= chr(($character + self::NUMBER - 97) % 26 + 97);
			//ASCII: 65 = A | 91 = Z
			} else if ($character >= 65 && $character < 91) {
				$result .= chr(($character + self::NUMBER - 65 ) % 26 + 65);
			} else {
				$result .= $text[$i];
			}
		}
		return $result;
	}

	/**
	 * Decrypt function.
	 *
	 * @param $text
	 * @return string
     */
	public function decrypt(string $text) : string
	{
        $text = Str::prepareTheText($text);

	    $result = '';
		for ($i = 0; $i < strlen($text); $i++) {
			//ASCII value of character
			$character = ord($text[$i]);
			//ASCII: 97 = a
			if ($character >= 97) {
				$result .= chr(($character - self::NUMBER - 97 + 26) % 26 + 97);
				//ASCII: 65 = A | 91 = Z
			} else if ($character >= 65 && $character < 91) {
				$result .= chr(($character - self::NUMBER - 65 + 26) % 26 + 65);
			} else {
				$result .= $text[$i];
			}
		}
		return $result;
	}

}