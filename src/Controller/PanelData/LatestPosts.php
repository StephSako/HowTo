<?php

namespace App\Controller\PanelData;

use App\Entity\Forum;
use App\Entity\Tutorial;
use App\Repository\ForumRepository;
use App\Repository\TutorialRepository;

class LatestPosts {

    private $latest_posts_tutorials;
    private $latest_posts_forums;

    /**
     * @param TutorialRepository $tutorialRepository
     * @param ForumRepository $forumRepository
     */
    public function __construct(TutorialRepository $tutorialRepository, ForumRepository $forumRepository)
    {
        $this->latest_posts_tutorials = $tutorialRepository->findTutorials_OB_L(8, 'datecreation');
        $this->latest_posts_forums = $forumRepository->findForums_OB_L(8, 'datecreation');
    }

    /**
     * @return Forum[]|array
     */
    public function getLatestPostsForums()
    {
        return $this->latest_posts_forums;
    }

    /**
     * @return Tutorial[]|array
     */
    public function getLatestPostsTutorials()
    {
        return $this->latest_posts_tutorials;
    }

}