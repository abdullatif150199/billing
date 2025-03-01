<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;

class MikrotikService
{
    static protected $LIST = 'ISOLIR';

    protected ?Client $mikrotikClient = null;

    public function __construct($config)
    {
        $config = new Config([
            'host' => $config['ip'],
            'port' => intval($config['port']),
            'user' => $config['username'],
            'pass' => $config['password'],
        ]);

        $this->mikrotikClient = new Client($config);
    }

    public static function getInstance(): MikrotikService
    {
        return app(MikrotikService::class);
    }

    public function query(Query $query)
    {
        return $this->mikrotikClient->query($query)->read();
    }

    public function isolir(string $ip)
    {
        $query = (new Query("/ip/firewall/address-list/print"))
            ->where('address', $ip)
            ->where('list', self::$LIST);

        $result = $this->query($query);
        if (empty($result)) {
            $query = (new Query("/ip/firewall/address-list/add"))
                ->equal('address', $ip)
                ->equal('list', self::$LIST);

            $result = $this->query($query);
        }

        return $result;
    }

    public function batalIsolir(string $ip)
    {
        $query = (new Query("/ip/firewall/address-list/print"))
            ->where('address', $ip)
            ->where('list', self::$LIST);
        $isolirList = $this->query($query);

        foreach ($isolirList as $isolir) {
            $this->removeFilter($isolir['.id']);
        }

        return $isolirList;
    }

    protected function removeFilter(string $id)
    {
        $query = (new Query('/ip/firewall/address-list/remove'))
            ->equal('.id', $id);

        return $this->query($query);
    }
}
