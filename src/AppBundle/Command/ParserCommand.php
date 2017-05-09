<?php

namespace AppBundle\Command;

use AppBundle\Entity\ClassSymfony;
use AppBundle\Entity\InterfaceSymfony;
use AppBundle\Entity\NamespaceSymfony;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ParserCommand
 * @package AppBundle\Command
 */
class ParserCommand extends ContainerAwareCommand
{
    /**
     * @var string
     */
    private $sourseUrl = "http://api.symfony.com/3.2/";

    protected function configure()
    {
        $this
            ->setName('parser')
            ->setDescription('List of Namespases')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $content = file_get_contents($this->sourseUrl);
        $crawler_NS = new Crawler($content);
        $crawler_NS = $crawler_NS->filter('div.namespace-container > ul > li > a');

        foreach ($crawler_NS as $domElement_NS) {

            $nameNameSpace = $domElement_NS->textContent;
            $urlNameSpace = $this->sourseUrl . $domElement_NS->getAttribute('href');
            $output->writeln($nameNameSpace);
            $output->writeln(' URL: ' . $urlNameSpace);

            $nameSpace = $this->addNameSpace($nameNameSpace, $urlNameSpace);

            $content = file_get_contents($urlNameSpace);
            $crawler = new Crawler($content);

            // Classes of NameSpaces
            $crawler_C = $crawler->filter('div.col-md-6 > a > abbr');
            $output->write(' Classes: ');

            foreach ($crawler_C as $domElement_C) {
                $className = $domElement_C->textContent;
                $output->write($className."\t");

                $this->addClass($className,'', $nameSpace);
            }

            // Interfaces of NameSpaces
            $crawler_I = $crawler->filter('div.col-md-6 > em > a > abbr');
            $output->write("\n" . ' Interfaces: ');

            foreach ($crawler_I as $domElement_I) {
                $interfaceName = $domElement_I->textContent;
                $output->write( $interfaceName."\t");

                $this->addInterface($interfaceName,'', $nameSpace);
            }
            $output->writeln("\n--------------------------------------------------------------------------");
        }
    }

    /**
     * @param string $name
     * @param string $url
     * @return NamespaceSymfony
     */
    private function addNameSpace(string $name, string $url) : NamespaceSymfony
    {
        $nameSpace = new NamespaceSymfony();
        $nameSpace->setName($name);
        $nameSpace->setUrl($url);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($nameSpace);
        $em->flush();
        return $nameSpace;
    }

    /**
     * @param string $name
     * @param string $url
     * @param NamespaceSymfony $nameSpace
     */
    private function addClass(string $name, string $url, NamespaceSymfony $nameSpace)
    {
        $class = new ClassSymfony();
        $class->setName($name);
        $class->setUrl($url);
        $class->setNamespace($nameSpace);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($class);
        $em->flush();
    }

    /**
     * @param string $name
     * @param string $url
     * @param NamespaceSymfony $nameSpace
     */
    private function addInterface(string $name, string $url, NamespaceSymfony $nameSpace)
    {
        $interface = new InterfaceSymfony;
        $interface->setName($name);
        $interface->setUrl($url);
        $interface->setNamespace($nameSpace);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($interface);
        $em->flush();
    }
}
