<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/auth')]
final class AuthorController extends AbstractController
{

    private $authors;
    public function __construct()
    {
        // $this->authors = array(
        //     array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' =>
        //     'victor.hugo@gmail.com ', 'nb_books' => 100),
        //     array('id' => 2, 'picture' => '/images/william-shakespeare.jpeg', 'username' => ' William Shakespeare', 'email' =>
        //     ' william.shakespeare@gmail.com', 'nb_books' => 200),
        //     array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' =>
        //     'taha.hussein@gmail.com', 'nb_books' => 300),
        // );
    }
    // #[Route('/author', name: 'app_author')]
    // public function index(): Response
    // {
    //     return $this->render('author/index.html.twig', [
    //         'controller_name' => 'AuthorController',
    //     ]);
    // }

    // // question 1 
    // #[Route('/author/{name}', name: 'author_show')]
    // public function showAuthor($name): Response
    // {
    //     return $this->render('author/show.html.twig', [
    //         'author_name' => $name,
    //     ]);
    // }


    // question 2
    // #[Route('/list', name: 'app_list')]
    // public function authorList(): Response
    // {
    //     // $authors = array(
    //     //     array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' =>
    //     //     'victor.hugo@gmail.com ', 'nb_books' => 100),
    //     //     array('id' => 2, 'picture' => '/images/william-shakespeare.jpeg', 'username' => ' William Shakespeare', 'email' =>
    //     //     ' william.shakespeare@gmail.com', 'nb_books' => 200),
    //     //     array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' =>
    //     //     'taha.hussein@gmail.com', 'nb_books' => 300),
    //     // );
    //     return $this->render('author/list.html.twig', [
    //         'authors' => $this->authors,
    //     ]);
    // }
    // // filtrer l'auteur par son ID
    // public function serachById($id)
    // {
    //     foreach ($this->authors as $auth) {
    //         if ($auth['id'] == $id) {
    //             return $auth;
    //         }
    //     }
    //     return null;
    // }

    // #[Route('/{id}', name: 'author_authorDetails')]
    // public function authorDetails($id): Response
    // {  // appel de searchById        
    //     $author = $this->serachById($id);
    //     dump($author);
    //     return $this->render('author/detail.html.twig', [
    //         'author' => $author,
    //     ]);
    // }

    //add statique
    #[Route('/insert', name: 'author_insert')]
    public function insert(EntityManagerInterface $em): Response
    {
        $author = new Author;
        $author->setAuthorName("aboul elkassem");
        $author->setEmail("kassem@gmail.com");

        $em->persist($author);
        $em->flush();

        // return new Response("added with success");
        return $this->redirectToRoute('app_authList');
    }


    //add with form
    #[Route('/add', name: 'author_add')]
    public function add(EntityManagerInterface $em, Request $request): Response
    {
        // Création d’un nouvel objet vide (à remplir via le formulaire)
        $author = new Author;
        // Création du formulaire à partir de la classe AuthorType en l'associant à l'objet $author
        $form = $this->createForm(AuthorType::class, $author);
        //remplir le formulaire (càd l'objet $author) à partir de la requette HTTP
        $form->handleRequest($request);
        // tester le submit
        if ($form->isSubmitted()) {
            //informer doctrine q'on souhaite ajouter un auteur sans exécuter l'insert
            $em->persist($author);
            // éxécuter l'insert dans la base de données
            $em->flush();
            // redirection vers authorList après l'ajout
            return $this->redirectToRoute('app_authList');
        }

        return $this->render('author/form.html.twig', [
            'addAuth' => $form,
        ]);
    }



    //insert with Author Registry
    #[Route('/listAuth', name: 'app_authList')]
    public function list(AuthorRepository $authRepo, Request $req): Response
    {

        // récupérer la valeur de search input from Request by name property
       $name = $req->query->get('auth');

        if ($name) {
            $authors = $authRepo->getAuthByName($name);
        } else {
            $authors = $authRepo->getAllAUthors();
        }
        return $this->render('author/list.html.twig', [
            'authors' => $authors,
            'authName' => $name
        ]);
    }

    //insert with entity manger
    #[Route('/listEM', name: 'app_authListEM')]
    public function listEM(EntityManagerInterface $em): Response
    {
        $author = $em->getRepository(Author::class)->findAll();
        return $this->render('author/list.html.twig', [
            'authors' => $author,
        ]);
    }

    // getAuthorByid
    #[Route('/{id}', name: 'auth_Details')]
    public function authorDetails(AuthorRepository $authRepo, $id): Response
    {
        return $this->render('author/detail.html.twig', [
            'author' =>  $authRepo->find($id),
        ]);
    }




    // getAuthorByid
    #[Route('/delete/{id}', name: 'auth_Delete')]
    public function delete(EntityManagerInterface $em, $id): Response
    {
        //select author to be deleted
        $author = $em->getRepository(Author::class)->find($id);
        //préparer la requette de suppression
        $em->remove($author);
        //exécuter la suppression
        $em->flush();
        return $this->redirectToRoute('app_authList');
    }
    #[Route('/update/{id}', name: 'auth_Update')]
    public function update(EntityManagerInterface $em, Request $request, $id): Response
    {
        // Création d’un nouvel objet vide (à remplir via le formulaire)
        $author = new Author;
        //select author by ID
        $author = $em->getRepository(Author::class)->find($id);
        // Création du formulaire à partir de la classe AuthorType en l'associant à l'objet $author
        $form = $this->createForm(AuthorType::class, $author);
        //remplir le formulaire (càd l'objet $author) à partir de la requette HTTP
        $form->handleRequest($request);
        // tester le submit
        if ($form->isSubmitted() && $form->isValid()) {
            //informer doctrine q'on souhaite ajouter un auteur sans exécuter l'insert
            $em->persist($author);
            // éxécuter l'insert dans la base de données
            $em->flush();
            // redirection vers authorList après l'ajout
            return $this->redirectToRoute('app_authList');
        }

        return $this->render('author/form.html.twig', [
            'addAuth' => $form,
        ]);
    }
}
