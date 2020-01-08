<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    // chemin pour la banque d'image, un répertoire images à la racines du projet
    const PATH_IMG = __DIR__."/../../data/images";

    /**
     * Affiche une page d'accueil, ligne graphique + message de bienvenu
     * @Route("/home", name="home_img")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home() {
        return $this->render('img/home.html.twig',[]);
    }

    /**
     * Methode en charge de du dowload de l'image si elle existe
     * @Route("/data/{nom}", name="data_img")
     * @param $num
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function affiche( $nom )
    {
        $filename = self::PATH_IMG."/$nom.jpg";
        if ( ! file_exists($filename) )
            return $this->render('img/no_image.html.twig', ['nom'=>"$nom.jpg"]);
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
        $listeImages = scandir(self::PATH_IMG);
        foreach ( $listeImages as $key => $pathName ) {
            if ( is_dir( $pathName ) )
                unset( $listeImages[$key]); // on retire les . et .. de la liste
            else
                $listeImages[$key] = substr($pathName, 0, -4 ); // on retire l'extension .jpg
        }
        return $this->render('img/menu.html.twig', [
                'url' => '/img/data/',
                'items'=> $listeImages
            ]);
    }
}