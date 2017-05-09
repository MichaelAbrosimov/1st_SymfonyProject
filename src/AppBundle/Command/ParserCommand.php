<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class ParserCommand extends ContainerAwareCommand
{
    private $sourseUrl="http://api.symfony.com/3.2/";

    protected function configure()
    {
        $this
            ->setName('parser')
            ->setDescription('List of Namespases')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $content = file_get_contents($this->sourseUrl);
        $crawler_NS = new Crawler($content);
        $crawler_NS = $crawler_NS->filter('div.namespace-container > ul > li > a');

        foreach ($crawler_NS as $domElement_NS){

            $output->writeln($domElement_NS->textContent);
            $urlNameSpace = $this->sourseUrl.$domElement_NS->getAttribute('href');
            $output->writeln(' URL: '.$urlNameSpace);

            $content = file_get_contents($urlNameSpace);
            $crawler = new Crawler($content);

            // Classes of NameSpaces
            $crawler_C = $crawler->filter('div.col-md-6 > a > abbr');
            $output->write(' Classes: ');

            foreach ($crawler_C as $domElement_C){
                $output->write($domElement_C->textContent."\t");
            }

            // Interfaces of NameSpaces
            $crawler_I = $crawler->filter('div.col-md-6 > em > a > abbr');
            $output->write("\n".' Interfaces: ');

            foreach ($crawler_I as $domElement_I){
                $output->write($domElement_I->textContent."\t");
            }
            $output->writeln("\n--------------------------------------------------------------------------");
        }
    }
}
