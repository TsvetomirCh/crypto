<?php

namespace Crypto;

final class Playfair implements Contracts\CipherInterface
{
    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $grid;

    /**
     * The Alphabet constant.
     */
    const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Playfair constructor.
     *
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = Str::prepareTheText($key);
        $this->grid = $this->initPlayFairMatrix();
    }

    /**
     *
     * @param string $text
     * @return mixed
     */
    public function encrypt(string $text) : string
    {
        $text = Str::splitDuplicates(
            Str::prepareTheText($text)
        );

        $text = $this->fixTheLength($text);

        $result = "";
        for($i = 0; $i < strlen($text); $i += 2) {
            $coordinates = $this->getCoordinates($text[$i], $text[$i+1]);
            $result .= $this->playFairCaseEncrypt($coordinates);
        }

        return $result;
    }

    /**
     * @param string $text
     * @return mixed|string
     */
    public function decrypt(string $text) : string
    {
        $text = Str::splitDuplicates(
            Str::prepareTheText($text)
        );

        $text = $this->fixTheLength($text);

        $result = "";
        for($i = 0; $i < strlen($text); $i += 2) {
            $coordinates = $this->getCoordinates($text[$i], $text[$i+1]);
            $result .= $this->playFairCaseDecrypt($coordinates);
        }

        return $result;
    }

    /**
     * Return the key with the alphabet and only unique chars.
     * STEPS:
     *  1. string to array
     *  2. remove duplicates array_unique
     *  3. back to string without delimiter
     *
     * @return string
     */
    private function initPlayFairMatrix() : string
    {
        $text = $this->key . self::ALPHABET;
        $text = str_replace("J", "I", $text);

        return implode('', array_unique(str_split($text)));
    }

    /**
     * @param $text
     * @return string
     */
    private function fixTheLength($text) : string
    {
        if (strlen($text) % 2) {
            return $text . "X";
        }

        return $text;
    }

    /**
     * Determinate Playfair case for encryption.
     *
     * @param array $coords
     * @return string
     */
    private function playFairCaseEncrypt(array $coords) : string
    {
        $x1 = $coords['x1'];
        $x2 = $coords['x2'];
        $y1 = $coords['y1'];
        $y2 = $coords['y2'];

        // Same line
        if ($y1 === $y2) {
            return $this->grid[5 * $y1 + (($x1 + 1) % 5)] . $this->grid[5 * $y2 + (($x2 + 1) % 5)];
        }

        // Same column
        if ($x1 === $x2) {
            return $this->grid[5 * (($y1 + 1) % 5) + $x1] . $this->grid[5 * (($y2 + 1) % 5) + $x2];
        }

        //Different line and column
        return $this->grid[(5 * $y1 + $x2)] . $this->grid[(5 * $y2 + $x1)];
    }

    /**
     * Determinate Playfair case for decryption.
     *
     * @param array $coords
     * @return string
     */
    private function playFairCaseDecrypt(array $coords) : string
    {
        $x1 = $coords['x1'];
        $x2 = $coords['x2'];
        $y1 = $coords['y1'];
        $y2 = $coords['y2'];

        // Same line
        if ($y1 === $y2) {
            return $this->grid[5 * $y1 + (($x1 + 4) % 5)] . $this->grid[5 * $y2 + (($x2 + 4) % 5)];
        }

        // Same column
        if ($x1 === $x2) {
            return $this->grid[5 * (($y1 + 4) % 5) + $x1] . $this->grid[5 * (($y2 + 4) % 5) + $x2];
        }

        //Different line and column
        return $this->grid[(5 * $y1 + $x2)] . $this->grid[(5 * $y2 + $x1)];
    }

    /**
     * @param $firstChar
     * @param $secondChar
     * @return array
     */
    private function getCoordinates($firstChar, $secondChar) : array
    {
        $arr = [];

        $arr['x1'] = strpos($this->grid, $firstChar ) % 5;
        $arr['y1'] = intval(strpos($this->grid, $firstChar) / 5);
        $arr['x2'] = strpos($this->grid, $secondChar) % 5;
        $arr['y2'] = intval(strpos($this->grid, $secondChar) / 5 );

        return $arr;
    }
}