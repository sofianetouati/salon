<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category")
 * @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_category_all", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_category_products", requirements={"id"="\d+"})
     */
    public function showProducts(Category $category,CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        $listCat = $categoryRepository->findAll();
        $list=[];
        foreach ($listCat as $data ) {
            if($data->getId() !== $category->getId()){
                $list[]=$data;
            }
        }
        $products = $productRepository->findBy(['category' => $category->getId()]);
        foreach ($products as $product) {
            
            $product->setPrice($product->getPrice()/100);
        }
        return $this->render('admin/category/products.html.twig', [
            'products' => $products,
            'category' => $category,
            'list' => $list,
        ]);
    }

    /**
     * @Route("/new", name="admin_category_new", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez pas les droits pour ajouter une catégorie.")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_category_all', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/edit/{id}", name="admin_category_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez pas les droits pour modifier une catégorie.")
     */
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_category_all', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_category_delete", methods={"POST"}, requirements={"id"="\d+"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez pas les droits pour supprimer une catégorie.")
     */
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_category_all', [], Response::HTTP_SEE_OTHER);
    }
}
