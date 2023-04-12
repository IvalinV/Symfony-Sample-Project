<?php

namespace App\Utils;

use App\Entity\Category;
use App\Utils\AbstractClasses\CategoryTreeAbstract;

class CategoryTreeFrontPage extends CategoryTreeAbstract
{
    public function getCategoryList(int $id)
    {
        $categories = $this->buildTree($id);
        $parent = $this->entityManager
            ->getRepository(Category::class)
            ->findOneBy(['id' => $id]);
        
        return [
            'parent' => $parent->getName(),
            'subcategories' => $categories
        ];
    }
}
