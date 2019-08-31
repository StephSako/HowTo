<?php

namespace App\Controller\PanelData;

use App\Entity\Category;
use App\Repository\CategoryRepository;

class Categories {

    private $categories;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categories = $categoryRepository->findBy(array(), array('label' => 'ASC'));
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }
}