<?php

namespace App\Service;

class PingService
{
    public function ping(string $host, string $mode = "ping")
    {
        return $this->exec($host);
    }

    public function exec(string $host)
    {
        $command = sprintf('ping -c 1 -W 5 %s', escapeshellarg($host));
        exec($command, $res, $rval);
        return $rval === 0;
    }

    public function fsock(string $host, int $port = 80, int $timeout = 6)
    {
        try {
            $fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
            if (!$fsock) {
                return false;
            } else {
                return true;
            }
        } catch (\Exception $th) {
            return false;
        }
    }
}
