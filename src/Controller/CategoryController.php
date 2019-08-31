<?php

namespace App\Controller;

use App\Controller\PanelData\Categories;
use App\Controller\PanelData\LatestPosts;
use App\Entity\Category;
use App\Entity\Forum;
use App\Entity\Tutorial;
use App\Repository\TutorialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @var TutorialRepository
     */
    private $tr;
    /**
     * @var Category[]|array
     */
    private $categories;
    /**
     * @var Forum[]|array
     */
    private $latest_posts_forums;
    /**
     * @var Tutorial[]|array
     */
    private $latest_posts_tutorials;

    public function __construct(Categories $categories, LatestPosts $latestPosts)
    {
        // Panneaux latéraux
        $this->categories = $categories->getCategories();
        $this->latest_posts_tutorials = $latestPosts->getLatestPostsTutorials();
        $this->latest_posts_forums = $latestPosts->getLatestPostsForums();
    }

    /**
     * @Route("/category_list/{id}-{label}", name="category.list")
     * @param $id
     * @param $label
     * @return Response
     */
    public function list($id, $label):Response
    {
        $list_posts = $this->tr->findBy(array('idCategory' => $id), array('datecreation' => 'DESC'));

        return $this->render('pages/category_posts_lists.html.twig', [
            'categories' => $this->categories,
            'latest_posts_tutorials' => $this->latest_posts_tutorials,
            'latest_posts_forums' => $this->latest_posts_forums,
            'list_posts' => $list_posts,
            'label' => $label,
            'current_menu' => 'tutorial'
        ]);
    }
}
