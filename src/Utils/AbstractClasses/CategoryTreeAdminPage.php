<?php

namespace App\Utils\AbstractClasses;

class CategoryTreeAdminPage extends CategoryTreeAbstract
{
    public function getCategoryList(int $id=null)
    {
        $categories = $this->buildTree();
        dd($categories);
        $parent = $this->entityManager
            ->getRepository(Category::class)
            ->findOneBy(['id' => $id]);
        
        return [
            'parent' => $parent->getName(),
            'subcategories' => $categories
        ];
    }
}
