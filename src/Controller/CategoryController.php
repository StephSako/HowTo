<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ForumRepository;
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
     * @var CategoryRepository
     */
    private $cr;
    /**
     * @var ForumRepository
     */
    private $fr;
    public $categories;
    private $latest_posts_forums;
    private $latest_posts_tutorials;

    public function __construct(CategoryRepository $cr, TutorialRepository $tr, ForumRepository $fr)
    {
        $this->cr = $cr;
        $this->tr = $tr;
        $this->fr = $fr;

        // Panneaux latéraux
        $this->categories = $this->cr->findBy(array(), array('label' => 'ASC'));
        $this->latest_posts_tutorials = $this->tr->findTutorials_OB_L(8, 'datecreation');
        $this->latest_posts_forums = $this->fr->findForums_OB_L(8, 'datecreation');
    }

    /**
     * @Route("/category_list/{id}-{label}", name="category.list")
     * @param $id
     * @param $label
     * @return Response
     */
    public function list($id, $label):Response
    {
        $list_posts = $this->tr->categoryList('datecreation', $id);

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
