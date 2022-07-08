<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;

    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Chichas', null, $manager);
        
        $this->createCategory('Chicha New', $parent, $manager);
        $this->createCategory('Chicha Lux', $parent, $manager);
        $this->createCategory('Chicha Eco', $parent, $manager);

        $parent = $this->createCategory('Consommables', null, $manager);

        $this->createCategory('Charbon', $parent, $manager);
        $this->createCategory('Tabac Chicha', $parent, $manager);
        $this->createCategory('Parfum Chicha', $parent, $manager);
                
        $manager->flush();
    }

    public function createCategory(string $name, Categories $parent = null, ObjectManager $manager)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);

        $this->addReference('cat-'.$this->counter, $category);
        $this->counter++;

        return $category;
    }
}

