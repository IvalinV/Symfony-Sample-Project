<?php

namespace App\Utils;

use App\Entity\Category;
use App\Utils\AbstractClasses\CategoryTreeAbstract;

class CategoryTreeAdminPage extends CategoryTreeAbstract
{
    public function getCategoryList(int $id=null)
    {
        foreach ($this->buildTree() as $record) {
            if(is_null($record->getParent())){
                $categories[] = $record;
            }
        }
        return $categories; 
    }

    public function getCategory(int $id)
    {
        return $this->entityManager
            ->getRepository(Category::class)
            ->findOneBy(['id' => $id]);
    }
}
