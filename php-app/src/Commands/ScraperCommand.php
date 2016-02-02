<?php

namespace Scraper\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Scraper\Classes\Scraper;


class ScraperCommand extends Command
{

    protected $scraper;

    /**
     * ScraperCommand constructor.
     */
    public function __construct()
    {
        $this->scraper = new Scraper();
        parent::__construct();
    }

    /**
     * Configure the command
     */
    protected function configure()
    {
        $this
            ->setName('sainsburys:items')
            ->setDescription('scrapes sainsburys items from the engineer test url');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->scraper->scrapePage());
    }
}