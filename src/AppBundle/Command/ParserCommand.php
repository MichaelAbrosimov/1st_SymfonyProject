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
    private $sourseUrl = "http://api.symfony.com/3.2";
    /**
     * @var int
     */
    public $count=0;

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
        $output->writeln(array(
            '<info>    Парсим    </>',
            $this->sourseUrl,
            '<info>==========================</>'
        ));

        $this->recursParsing($this->sourseUrl . "/Symfony.html");

        // white text on a green background
        $output->writeln('произведено '.$this->count.' записей');
        return;
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

    /**
     * @param string $targetUrl
     */
    private function recursParsing(string $targetUrl)
    {
        var_dump($targetUrl);
        $content = file_get_contents($targetUrl);
        $crawler = new Crawler($content);
        // current NameSpace
        $crawler_CNS = $crawler->filter('h1');
        foreach ($crawler_CNS as $domElement_CNS) {
            $nameNameSpace = $domElement_CNS->textContent;
        }
        $nameSpace = $this->addNameSpace($nameNameSpace, $targetUrl);
        $this->count++;

        // Classes of NameSpaces
        $crawler_C = $crawler->filter('div.col-md-6 > a ');
        foreach ($crawler_C as $domElement_C) {
            $className = $domElement_C->textContent;
            $classUrl = $this->sourseUrl.'/'.$domElement_C->getAttribute('href');
            $classUrl = str_replace('../','',$classUrl);
            $this->addClass($className, $classUrl, $nameSpace);
            $this->count++;
        }

        // Interfaces of NameSpaces
        $crawler_I = $crawler->filter('div.col-md-6 > em > a ');
        foreach ($crawler_I as $domElement_I) {
            $interfaceName = $domElement_I->textContent;
            $interfaceUrl = $this->sourseUrl.'/'.$domElement_I->getAttribute('href');
            $interfaceUrl = str_replace('../','',$interfaceUrl);
            $this->addInterface($interfaceName, $interfaceUrl, $nameSpace);
            $this->count++;
        }

        // NameSpaces of NameSpaces (child)
        $crawler_NS = $crawler->filter('div.namespace-list > a');
        foreach ($crawler_NS as $domElement_NS) {

            $nameSpaceUrl = $this->sourseUrl.'/'.$domElement_NS->getAttribute('href');
            $nameSpaceUrl = str_replace('../','',$nameSpaceUrl);
            $this->count++;
            $this->recursParsing($nameSpaceUrl);
        }
        return;
    }
}
