<?php

namespace Crypto\Contracts;

interface CipherInterface
{
    /**
     * @param string $text
     * @return mixed
     */
    public function encrypt(string $text) : string;

    /**
     * @param string $text
     * @return mixed|string
     */
    public function decrypt(string $text) : string;
}