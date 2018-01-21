<?php

namespace Avr;

use Exception;
use Goutte\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Parser
 *
 * @package Avr
 */
class Parser
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var string
     */
    private $serial;

    /**
     *
     */
    const ARZON = "https://www.arzon.jp/itemlist.html?t=&m=all&s=&q=%s";
    /**
     *
     */
    const JAVLIBRARY = "http://www.javlibrary.com/tw/vl_searchbyid.php?keyword=%s";

    /**
     * Parser constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $serial
     *
     * @return array
     */
    public function search($serial)
    {
        $this->serial = $serial;

        try {
            return $this->jav();
        } catch (Exception $e) {
            return $this->arzon();
        }
    }

    /**
     * @return array
     */
    private function arzon()
    {
        $search = 'https://www.arzon.jp/index.php?action=adult_customer_agecheck&agecheck=1&redirect=' . urlencode(sprintf(self::ARZON, $this->serial));
        $item = $this->client->request('GET', $search)->filter('dl a')->first()->link()->getUri();
        $crawler = $this->client->request('GET', $item);

        return [
            'serial' => trim($crawler->filter('table.item tr td:nth-child(2)')->eq(7)->text()),
            'title' => $crawler->filter('h1')->first()->text(),
            'cover' => $crawler->filter('img.item_img')->first()->image()->getUri(),
            'actress' => implode(', ', $crawler->filter('table.item tr td:nth-child(2)')->first()->filter('a')->each(function (Crawler $actress) {
                return trim($actress->text());
            })),
            'publisher' => trim($crawler->filter('table.item tr td:nth-child(2)')->eq(2)->text()),
            'director' => trim($crawler->filter('table.item tr td:nth-child(2)')->eq(4)->text()),
            'published_at' => explode(' ', trim($crawler->filter('table.item tr td:nth-child(2)')->eq(5)->text()))[0],
            'series' => trim($crawler->filter('table.item tr td:nth-child(2)')->eq(3)->text()),
            'rate' => null,
        ];
    }

    /**
     * @return array
     */
    private function jav()
    {
        $this->client->getCookieJar()->set(new Cookie('over18', 18));
        $crawler = $this->client->request('GET', sprintf(self::JAVLIBRARY, $this->serial));

        return [
            'serial' => trim($crawler->filter('div#video_id td')->eq(1)->text()),
            'title' => trim($crawler->filter('h3 a')->first()->text()),
            'cover' => $crawler->filter('img#video_jacket_img')->first()->image()->getUri(),
            'actress' => implode(', ', $crawler->filter('span.star a')->each(function (Crawler $actress) {
                return trim($actress->text());
            })),
            'publisher' => trim($crawler->filter('span.label')->first()->text()),
            'director' => $crawler->filter('span.director')->count() ? trim($crawler->filter('span.director')->first()->text()) : null,
            'published_at' => trim($crawler->filter('div#video_date td')->eq(1)->text()),
            'series' => implode(', ', $crawler->filter('span.genre a')->each(function (Crawler $actress) {
                return trim($actress->text());
            })),
            'rate' => str_replace(['(', ')'], '', trim($crawler->filter('span.score')->first()->text())),
        ];
    }
}
