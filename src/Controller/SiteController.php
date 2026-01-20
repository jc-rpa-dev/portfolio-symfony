<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProjectRepository;


class SiteController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('site/home.html.twig');
    }

    #[Route('/projets', name: 'app_projects')]
    public function projects(ProjectRepository $projectRepository): Response
    {
    $projects = $projectRepository->findBy([], ['createdAt' => 'DESC']);


    return $this->render('site/projects.html.twig', [
        'projects' => $projects,
    ]);
    }

    #[Route('/competences', name: 'app_skills')]
    public function skills(): Response
    {
        return $this->render('site/skills.html.twig');
    }

    #[Route('/a-propos', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('site/about.html.twig');
    }
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // TODO : envoyer un mail, enregistrer en BDD ou webhook.
            // Ici, on mettra au minimum un flash message.

            $this->addFlash('success', 'Merci pour votre message, je vous répondrai rapidement.');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('site/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
