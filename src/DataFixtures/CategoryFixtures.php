<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Main Categories
        CategoryFactory::createOne(['name' => 'Electronics']);
        CategoryFactory::createOne(['name' => 'Toys']);
        CategoryFactory::createOne(['name' => 'Books']);
        CategoryFactory::createOne(['name' => 'Movies']);

        //Sub Categories: Electronics
        $parent = $manager->getRepository(Category::class)->findOneBy(['name' => 'Electronics']);

        CategoryFactory::createOne(['name' => 'Cameras'])->setParent($parent);
        CategoryFactory::createOne(['name' => 'PCs'])->setParent($parent);
        CategoryFactory::createOne(['name' => 'Laptops'])->setParent($parent);
        CategoryFactory::createOne(['name' => 'Smart phones'])->setParent($parent);

        //Sub Categories: Books
        $parent = $manager->getRepository(Category::class)->findOneBy(['name' => 'Books']);

        CategoryFactory::createOne(['name' => 'Fiction'])->setParent($parent);
        CategoryFactory::createOne(['name' => 'Novels'])->setParent($parent);
        CategoryFactory::createOne(['name' => 'Biography'])->setParent($parent);

        //Sub Categories: Movies
        $parent = $manager->getRepository(Category::class)->findOneBy(['name' => 'Movies']);

        CategoryFactory::createOne(['name' => 'Action'])->setParent($parent);
        CategoryFactory::createOne(['name' => 'Thriler'])->setParent($parent);
        CategoryFactory::createOne(['name' => 'Biographic'])->setParent($parent);
        CategoryFactory::createOne(['name' => 'Drama'])->setParent($parent);
    }
}
