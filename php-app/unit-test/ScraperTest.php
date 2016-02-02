<?php

namespace Scraper\UnitTests;

use Scraper\Classes\Scraper;

class ScraperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Scrape the page Test
     */
    public function testScrapePage()
    {

        $scraper    = new Scraper();
        $resultJSON = $scraper->scrapePage(); //check scrape returns a JSON file
        $this->assertJSON($resultJSON);

        $resultArray = json_decode($resultJSON, true);
        $this->assertArrayHasKey('results', $resultArray);
        $this->assertArrayHasKey('title', $resultArray['results'][0]);
        $this->assertArrayHasKey('size', $resultArray['results'][0]);
        $this->assertArrayHasKey('unit_price', $resultArray['results'][0]);
        $this->assertArrayHasKey('description', $resultArray['results'][0]);
        $this->assertArrayHasKey('total', $resultArray);

        // Check number of results in array
        $itemCount = count($resultArray['results']);
        $this->assertEquals("7", $itemCount);
    }


    /**
     * Test the scrapers getFormattedSizeKB method
     */
    public function testGetFormattedSizeKB()
    {
        $sizeOfPage = 2048;

        $formatKB   = new Scraper();
        $formatSize = $formatKB->getFormattedSizeKB($sizeOfPage);

        $this->assertEquals("2.00 KB", $formatSize);

    }

    /**
     * Test one of the item urls processes all the results
     */
    public function testGetItemTest()
    {
        $itemUrl = 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-apricot-ripe---ready-320g.html';
        $i       = 0;

        $scraper     = new Scraper();
        $resultJSON  = $scraper->scrapePage(); //check scrape returns a JSON file
        $resultArray = json_decode($resultJSON, true);

        $scrape    = new Scraper();
        $itemArray = $scrape->getItem($itemUrl, $i);

        $this->assertEquals($resultArray['results'][0], $itemArray);
    }


}