<?php

namespace Scraper\Classes;

use Goutte\Client;

class Scraper
{
    protected $items = [];

    /**
     * @return string
     */
    public function scrapePage()
    {
        $baseURL     = 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/';
        $urlEndpoint = '2015_Developer_Scrape/5_products.html';

        $client = new Client();

        // Go to the Sainsburys test site
        $crawler = $client->request('GET', $baseURL . $urlEndpoint);
        $crawler->filter('ul.productLister li .product .productInner .productInfoWrapper .productInfo')->each(function (
            $node,
            $i
        ) {
            //for each item go to their URL and scrape all details from there.
            $this->getItem($node->filter('a')->attr('href'), $i);
        });

        // Sum up all the unit prices for grand total
        $total = 0.00;

        foreach ($this->items['results'] as $val) {
            $total += $val['unit_price'];
        }
        $this->items['total'] = number_format($total, 2);

        // Final output of json
        return json_encode($this->items, JSON_PRETTY_PRINT);
    }

    /**
     * @param $item_url
     * @param $i
     * @return mixed
     */
    public function getItem($itemUrl, $i)
    {
        $client = new Client();

        //Go to the Sainsburys item page
        $crawler = $client->request('GET', $itemUrl);

        // Title
        $title = $crawler->filter('#content > div.section.productContent > div.pdp > div > div.productTitleDescriptionContainer > h1')->text();

        // Unit price
        $price          = $crawler->filter('div.priceTab > div.pricing > p.pricePerUnit')->text();
        $priceFormatted = preg_replace("/([^0-9\\.])/i", "", $price);

        // Size
        $response      = $client->getInternalResponse();
        $size          = $response->getHeader('Content-Length');
        $sizeFormatted = $this->getFormattedSizeKB($size); //convert from bytes to kilobytes

        // Description
        $description = $crawler->filter('#information > productcontent > htmlcontent > div.productText')->text();

        // Results
        $this->items['results'][] = [
            'title'       => trim($title),
            'size'        => $sizeFormatted,
            'unit_price'  => $priceFormatted,
            'description' => trim($description)
        ];

        return $this->items['results'][$i];
    }

    /**
     * @param $size
     * @return string
     */
    public function getFormattedSizeKB($size)
    {
        $symbol = 'KB';
        $exp    = floor(log($size) / log(1024));
        return sprintf('%.2f ' . $symbol, ($size / pow(1024, floor($exp))));
    }
}
