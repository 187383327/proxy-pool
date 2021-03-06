<?php

namespace App\Spiders\Drivers;

use App\Models\Proxy;
use App\Spiders\Spider;

class Xicidaili extends Spider
{
    public function handle()
    {
        $this->sleep = rand(5, 10);
//        $this->use_proxy = true;
        $urls = [
            "http://www.xicidaili.com/nn/",
            "http://www.xicidaili.com/nn/2",
            "http://www.xicidaili.com/nn/3",
            "http://www.xicidaili.com/nt/",
            "http://www.xicidaili.com/nt/2",
            "http://www.xicidaili.com/nt/3",
            "http://www.xicidaili.com/wn/",
            "http://www.xicidaili.com/wn/2",
            "http://www.xicidaili.com/wn/3",
            "http://www.xicidaili.com/nt/",
            "http://www.xicidaili.com/nt/2",
            "http://www.xicidaili.com/nt/3",
        ];

        $this->queryListProcess($urls, "table#ip_list tr", function ($tr) {
            $ip = $tr->find('td:eq(1)')->text();
            $port = $tr->find('td:eq(2)')->text();
            $temp = $tr->find('td:eq(4)')->text();
            if (strpos($temp, '高匿') !== false) {
                $anonymity = Proxy::ANONYMITY_HIGH_ANONYMOUS;
            } elseif (strpos($temp, '透明') !== false) {
                $anonymity = Proxy::ANONYMITY_TRANSPARENT;
            } else {
                $anonymity = Proxy::ANONYMITY_ANONYMOUS;
            }
            $protocol = strtolower($tr->find('td:eq(5)')->text());
            return [$ip, $port, $anonymity, $protocol];
        });
    }
}