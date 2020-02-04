<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShopRepository")
 */
class Shop
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="shops")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="shop")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transation", mappedBy="shop")
     */
    private $transations;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->transations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setShop($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getShop() === $this) {
                $product->setShop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transation[]
     */
    public function getTransations(): Collection
    {
        return $this->transations;
    }

    public function addTransation(Transation $transation): self
    {
        if (!$this->transations->contains($transation)) {
            $this->transations[] = $transation;
            $transation->setShop($this);
        }

        return $this;
    }

    public function removeTransation(Transation $transation): self
    {
        if ($this->transations->contains($transation)) {
            $this->transations->removeElement($transation);
            // set the owning side to null (unless already changed)
            if ($transation->getShop() === $this) {
                $transation->setShop(null);
            }
        }

        return $this;
    }
}
