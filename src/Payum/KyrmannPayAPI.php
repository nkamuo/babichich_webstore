<?php

namespace App\Payum;

class KyrmannPayAPI
{
    private string $user;

    private string $pass;

    private string $afid;

    private string $offerid;

    private string $encryptKey;

    public function __construct(string $user, string $pass, string $afid, string $offerid, string $encryptKey)
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->afid = $afid;
        $this->offerid = $offerid;
        $this->encryptKey = $encryptKey;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPass(): string
    {
        return $this->pass;
    }

    public function getAfid(): string
    {
        return $this->afid;
    }

    public function getOfferid(): string
    {
        return $this->offerid;
    }

    public function getEncryptKey(): string
    {
        return $this->encryptKey;
    }





}
