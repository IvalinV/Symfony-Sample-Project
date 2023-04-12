<?php

namespace App\Controller;

use App\Utils\AbstractClasses\CategoryTreeAdminPage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@Route("admin")
 * 
*/

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/my_profile.html.twig');
    }

    /**
     * @Route("/categories", name="admin_categories")
     */
    public function categories(CategoryTreeAdminPage $categories): Response
    {
        dd($categories->getCategoryList());
        return $this->render('admin/categories.html.twig', [
            'categories' => ''
        ]);
    }

    /**
     * @Route("/edit-category", name="admin_edit_category")
     */
    public function editCategory(): Response
    {
        return $this->render('admin/edit_category.html.twig');
    }


    /**
     * @Route("/videos", name="admin_videos")
     */
    public function videos(): Response
    {
        return $this->render('admin/videos.html.twig');
    }

    /**
     * @Route("/upload-video", name="admin_upload_video")
     */
    public function uploadVideo(): Response
    {
        return $this->render('admin/upload_video.html.twig');
    }

    /**
     * @Route("/users", name="admin_users")
     */
    public function users(): Response
    {
        return $this->render('admin/users.html.twig');
    }
}
