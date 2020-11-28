<?php

namespace App\Service;

class PingService
{
    public function ping(string $host, string $mode = "exec")
    {
        $host = preg_replace("(^https?://)", "", $host);
        list($host, $port) = array_pad(explode(':', $host, 2), 2, null);
        $port = intval($port);

        $validIpAddressRegex = "/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/";

        $validHostnameRegex = "/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/";
        if (preg_match($validIpAddressRegex, $host) || preg_match($validHostnameRegex, $host)) {
            if ($port > 0) {
                return $this->fsock($host, $port);
            }
            switch ($mode) {
                case "exec":
                    return $this->exec($host);
                case "fsock":
                    dd($port);
                    return $this->fsock($host);
                default:
                    if ($this->exec($host)) {
                        return true;
                    } else {
                        return $this->fsock($host);
                    }
            }
        }

        return false;
    }

    public function exec(string $host)
    {
        $command = sprintf('ping -c 1 -W 5 %s', escapeshellarg(escapeshellcmd($host)));
        exec($command, $res, $rval);
        return $rval === 0;
    }

    public function fsock(string $host, int $port = 80, int $timeout = 6)
    {
        if ($port == 0) {
            $port = 80;
        }
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
