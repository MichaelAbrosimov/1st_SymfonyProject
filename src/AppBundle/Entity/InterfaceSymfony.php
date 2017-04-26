<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class InterfaceSymfony
 *
 * @package AppBundle\Entity
 * @ORM\Entity()
 */
class InterfaceSymfony
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string")
     */
    private $url;

    /**
     *
     * @ORM\ManyToOne(targetEntity="NamespaceSymfony", inversedBy="interfaces")
     */
    private $namespace;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string) $this->name;
    }

    /**
     * @param string $name
     * @return InterfaceSymfony
     */
    public function setName(string $name): InterfaceSymfony
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return (string) $this->url;
    }

    /**
     * @param string $url
     * @return InterfaceSymfony
     */
    public function setUrl(string $url): InterfaceSymfony
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return NamespaceSymfony
     */
    public function getNamespace(): NamespaceSymfony
    {
        return $this->namespace;
    }

    /**
     * @param NamespaceSymfony $namespace
     * @return $this|InterfaceSymfony
     */
    public function setNamespace(NamespaceSymfony $namespace): InterfaceSymfony
    {
        $this->namespace = $namespace;

        return $this;
    }
}