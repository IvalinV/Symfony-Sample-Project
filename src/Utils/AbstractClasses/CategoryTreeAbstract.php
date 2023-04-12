<?php

namespace App\Utils\AbstractClasses;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class CategoryTreeAbstract
{
    public $categoriesArrayFromDb;
    protected static $dbConnection;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->categoriesArrayFromDb = $this->getCategories();
    }

    abstract public function getCategoryList(int $id);

    public function buildTree(int $parent_id = null)
    {
        if(is_null($parent_id)){
            return $this->getCategories();
        }
        foreach ($this->getCategories() as $category) {
            if ($category->getId() === $parent_id) {
                return $category->getSubcategories()->toArray();
            }
        }
    }

    private function getCategories(): array
    {
        return $this->entityManager
            ->getRepository(Category::class)
            ->findAll();
        // if(self::$dbConnection) {
        //     return self::$dbConnection;
        // }

        // $connection = $this->entityManager->getConnection();
        // $sql = "SELECT * FROM  categories";
        // $statement = $connection->prepare($sql);
        // $result = $statement->execute();

        // return self::$dbConnection = $result->fetchAll();
    }
}
