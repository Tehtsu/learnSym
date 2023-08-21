<?php
namespace App\Controller;

use App\Entity\GuestBookEntity;
use App\Form\Type\GuestBookType;
use App\Repository\GuestBookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController{

    public function __construct(private readonly GuestBookRepository $repository){

    }

    #[Route(path: '/', name: 'index')]
    public function indexAction(Request $request): Response
    {
        $form = $this->createForm(GuestBookType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $data = $form->getData();
            $this->repository->add($data);
            $this->repository->flush();
            $this->addFlash('success', 'Erfolgreich gespeichert!');
            return $this->redirectToRoute('index');
        }

        /**
         * Paginierung
         */
        $limit = 2;
        $maxPages = $this->getMaxPages($limit);
        $currentPage = $this->getCurrentPage($request, $maxPages);

        $entries = $this->repository->getPaginatedEntries($limit, $currentPage);
        //dd($entries);

        return $this->render('index.html.twig',[
            'guestBookForm' => $form,
            'entries' => $entries,
            'maxPages' => $maxPages,
            'currentPage' => $currentPage
        ]);
    }

    private function getMaxPages(int $limit): int
    {
        $totalEntries = $this->repository->count([]);
        return (int)ceil($totalEntries/$limit);
    }

    private function getCurrentPage(Request $request, int $maxPages): int
    {
        $page = (int)$request->get('page',1);
        return min(max($page,1), $maxPages);
    }
}
