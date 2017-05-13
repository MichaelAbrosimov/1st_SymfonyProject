<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Tree\Traits\NestedSetEntity;


/**
 * Class NamespaceSymfony
 * @Gedmo\Tree(type="nested")
 * @package AppBundle\Entity
 * @ORM\Entity()
 */
class NamespaceSymfony
{
    use NestedSetEntity ;

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
     * @ORM\OneToMany (targetEntity="InterfaceSymfony", mappedBy="namespace")
     */
    private $interfaces;

    /**
     * @ORM\OneToMany (targetEntity="ClassSymfony", mappedBy="namespace")
     */
    private $classes;


    /**
     * @ORM\OneToMany (targetEntity="NamespaceSymfony", mappedBy="parentNamespace")
     */
    private $childNamespace;


    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne (targetEntity="NamespaceSymfony", inversedBy="childNamespace")
     * @ORM\JoinColumn(name="parent_namespace_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parentNamespace;


    public function __construct()
    {
        $this->interfaces = new ArrayCollection();
        $this->classes = new ArrayCollection();
        $this->childNamespace =new ArrayCollection();
    }

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
     * @return NamespaceSymfony
     */
    public function setName(string $name): NamespaceSymfony
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
     * @return NamespaceSymfony
     */
    public function setUrl(string $url): NamespaceSymfony
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getInterfaces(): ArrayCollection
    {
        return $this->interfaces;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     * @return $this|NamespaceSymfony
     */
    public function setLevel(int $level): NamespaceSymfony
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return $this|NamespaceSymfony
     */
    public function getParentNamespace(): NamespaceSymfony
    {
        return $this->parentNamespace;
    }

    /**
     * @param mixed $parentNamespace
     * @return $this
     */
    public function setParentNamespace(NamespaceSymfony $parentNamespace = null)
    {
        $this->parentNamespace = $parentNamespace;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @param mixed $left
     */
    public function setLeft($left)
    {
        $this->left = $left;
    }

    /**
     * @return mixed
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * @param mixed $right
     */
    public function setRight($right)
    {
        $this->right = $right;
    }

    /**
     * @return mixed
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param mixed $root
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }
}
