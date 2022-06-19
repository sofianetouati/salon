<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product")
 * @isGranted("ROLE_MANAGER", message="Vous ne pouvez pas accéder à cette section.")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="admin_product_all", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        foreach ($products as $product)
        {
            $product->setPrice($product->getPrice()/100);
        }

        return $this->render('admin/product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_product_new", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez pas les droits pour ajouter une prestation.")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('admin_product_all', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/edit/{id}", name="admin_product_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez pas les droits pour modifier une prestation.")
     */
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            return $this->redirectToRoute('admin_product_all', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_product_delete", methods={"POST"}, requirements={"id"="\d+"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez pas les droits pour supprimer une prestation.")
     */
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_product_all', [], Response::HTTP_SEE_OTHER);
    }
}
