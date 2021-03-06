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
    private $sourseUrl = "http://api.symfony.com/3.3";
    /**
     * @var int
     */
    public $count = 0;

    /**
     * @var
     */
    private $output;

    protected function configure()
    {
        $this
            ->setName('parser')
            ->setDescription('List of Namespases')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('test', null, InputOption::VALUE_NONE, 'Test Mode');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $route = "/Symfony.html";
        if ($input->getOption('test')) {
            $output->writeln('<fg=red> Test Mode </>');
            $route = "/Symfony/Component/Asset.html";
        }
        $output->writeln([
            '<info>    Парсим    </info>',
            $this->sourseUrl,
            '<info>==========================</info>'
            ]);


        $this->recursParsing($this->sourseUrl . $route, 0);


        $output->writeln('произведено '.(($this->count)/2).' записей');
        return;
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
    private function recursParsing(string $targetUrl, int $level, NamespaceSymfony $parentNameSpace = null, int $root = null)
    {
        $this->output->writeln($targetUrl);
        $content = file_get_contents($targetUrl);
        $crawler = new Crawler($content);

        // current NameSpace
        $crawler_CNS = $crawler->filter('body#namespace > div#content > div#right-column > div#page-content > div.page-header > h1');
        foreach ($crawler_CNS as $domElement_CNS) {
            $nameNameSpace = $domElement_CNS->textContent;
        }
        if (isset($nameNameSpace)) {
            $nameSpace = new NamespaceSymfony();
            $nameSpace->setName($nameNameSpace)
                ->setUrl($targetUrl)
                ->setLevel($level)
                ->setParentNamespace($parentNameSpace)
                ->setRoot($root)
                ->setLeft(++$this->count)
                ->setRight(0); //это костыль, здесь ничего присваивать не нужно, но без него ругается,
                                //Хотя не должен.

            // NameSpaces of NameSpaces (child)
            $crawler_NS = $crawler->filter('div.namespace-list > a');

            foreach ($crawler_NS as $domElement_NS) {
                $nameSpaceUrl = $this->sourseUrl . '/' . $domElement_NS->getAttribute('href');
                $nameSpaceUrl = str_replace('../', '', $nameSpaceUrl);
                $this->recursParsing($nameSpaceUrl, $level + 1, $nameSpace);
            }

            $nameSpace->setRight(++$this->count);

            $em = $this->getContainer()->get('doctrine')->getManager();
            $em->persist($nameSpace);
            $em->flush();

            // Classes of NameSpaces
            $crawler_C = $crawler->filter('div.col-md-6 > a ');
            foreach ($crawler_C as $domElement_C) {
                $className = $domElement_C->textContent;
                $classUrl = $this->sourseUrl . '/' . $domElement_C->getAttribute('href');
                $classUrl = str_replace('../', '', $classUrl);
                $this->addClass($className, $classUrl, $nameSpace);
            }

            // Interfaces of NameSpaces
            $crawler_I = $crawler->filter('div.col-md-6 > em > a ');
            foreach ($crawler_I as $domElement_I) {
                $interfaceName = $domElement_I->textContent;
                $interfaceUrl = $this->sourseUrl . '/' . $domElement_I->getAttribute('href');
                $interfaceUrl = str_replace('../', '', $interfaceUrl);
                $this->addInterface($interfaceName, $interfaceUrl, $nameSpace);
            }
        }
        return;
    }
}
