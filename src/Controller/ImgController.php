<?php

namespace App\Controller;


use App\Entity\ListeImage;
use App\Form\Type\ListeImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Un controller pour la gestion d'une banque d'images
 * @Route("/img")
 * Class ImgController
 * @package App\Controller
 */
class ImgController extends AbstractController
{
     /**
     * Affiche une page d'accueil, ligne graphique + message de bienvenu
     * @Route("/home", name="img_home")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home() {
        return $this->render('img/home.html.twig',[]);
    }

    /**
     * Methode en charge de du dowload de l'image si elle existe
     * @Route("/affiche/{nom}", name="img_affiche")
     * @param $num
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function affiche( $nom )
    {
        $filename = ListeImage::PATH_IMG."/$nom";
        if ( ! file_exists($filename) )
            return $this->render('img/no_image.html.twig', ['nom'=>$nom]);
        return $this->file($filename);
    }

    /**
     * Génération du code HTML pour le menu (embedding dans la ligne graphique)
     * @Route("/img/menu", name="menu_img")
     *
     * @return Response
     */
    public function menu()
    {
        $listeImages = new ListeImage();
        return $this->render('img/menu.html.twig', [
                'url' => '/img/data/',
                'items'=> $listeImages->getListeImage()
            ]);
    }

    /**
     * @Route("/liste", name="img_liste")
     * @return Response
     */
    public function liste( Request $request )
    {
        $img = new \App\Entity\ListeImage();
        $form = $this->createForm(ListeImageType::class, $img);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form['upload']->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                //$safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                //$newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        ListeImage::PATH_IMG,
                        $originalFilename.'.jpg'
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                return $this->redirect("/img/liste");
            }
        }

        return $this->render("img/liste.html.twig",
            ['form'=> $form->createView() ]);
    }

    /**
     * @Route("/delete/{path}", name="img_delete")
     * @param $path
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete( $path )
    {
        $liste = new ListeImage();
        $liste->removeImage($path);
        return $this->redirect("/img/liste");
    }


    public function upload()
    {

    }
}