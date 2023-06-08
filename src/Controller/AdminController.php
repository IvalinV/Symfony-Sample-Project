<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Utils\CategoryTreeAdminPage;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/categories", name="admin_categories", methods={"GET", "POST"})
     */
    public function categories(CategoryTreeAdminPage $categories, Request $request, EntityManagerInterface $manager): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
 
        $is_invalid = null;

        if($this->saveCategory($form, $category, $request, $manager)){
            return $this->redirectToRoute('admin_categories');
        }
        elseif ($request->isMethod('post')) {
            $is_invalid = ' is-invalid';
        }

        return $this->renderForm('admin/categories.html.twig', [
            'categories' => $categories->getCategoryList(),
            'form' => $form,
            'is_invalid' => $is_invalid
        ]);
    }

    /**
     * @Route("/edit-category/{id}", name="admin_edit_category")
     */
    public function editCategory($id, CategoryTreeAdminPage $categoryTreeAdminPage, Request $request, EntityManagerInterface $manager): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
 
        $is_invalid = null;

        if($this->saveCategory($form, $category, $request, $manager)){
            return $this->redirectToRoute('admin_categories');
        }
        elseif ($request->isMethod('post')) {
            $is_invalid = ' is-invalid';
        }

        return $this->renderForm('admin/edit_category.html.twig', [
            'categories' => $categoryTreeAdminPage->getCategoryList(),
            'selectedCategory' => $categoryTreeAdminPage->getCategory($id),
            'form' => $form,
            'is_invalid' => $is_invalid
        ]);
    }

    /**
     * @Route("/update-category/{id}", methods={"POST"}, name="admin_update_category")
     */
    public function updateCategory($id, Request $data, EntityManagerInterface $manager): Response
    {
        // dd($data->request);
        $category = $manager
            ->getRepository(Category::class)
            ->findOneBy(['id' => $id]);

        $parent = $manager
            ->getRepository(Category::class)
            ->findOneBy(['id' => $data->request->get('parent')]);

        $category->setName($data->request->get('name'));
        $category->setParent($parent);

        $manager->persist($category);
        $manager->flush();

        return $this->redirectToRoute('admin_categories');
    }

    /**
     * @Route("/create-category", methods={"POST"}, name="admin_create_category")
     */
    public function createCategory(Request $data, EntityManagerInterface $manager): Response
    {
        $category = new Category();
        $parent = $manager->getRepository(Category::class)->findOneBy(['id' => $data->request->get('parent')]);

        $category->setName($data->request->get('name'));
        $category->setParent($parent);

        $manager->persist($category);
        $manager->flush();

        return $this->redirectToRoute('admin_categories');
    }

    /**
     * @Route("/delete-category/{id}", name="admin_delete_category", requirements={"id":"\d+"})
     */
    public function deleteCategory(Category $category, EntityManagerInterface $manager)
    {
        $manager->remove($category);
        $manager->flush();

        return $this->redirectToRoute('admin_categories');
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

    private function saveCategory($form, $category, $request, $manager){
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $category->setName($request->request->get('category')['name']);

            $parent = $manager
                ->getRepository(Category::class)
                ->find($request->request->get('category')['parent']);

            $category->setParent($parent);

            $manager->persist($category);
            $manager->flush();

            return true;
        }

        return false;
    }
}
