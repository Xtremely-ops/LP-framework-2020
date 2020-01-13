<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class ListeImage
{
    // chemin pour la banque d'image, un répertoire images à la racines du projet
    const PATH_IMG = __DIR__."/../../data/images";

    protected $liste;

    public function __construct()
    {
        $this->liste = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getListeImage(): ArrayCollection
    {
        $listeImages = scandir(self::PATH_IMG);
        foreach ( $listeImages as $key => $pathName ) {
            if ( is_dir( $pathName ) )
                unset( $listeImages[$key]); // on retire les . et .. de la liste
            else
                $this->liste->add(new Image($pathName));
        }
        return $this->liste ;
    }

    public function removeImage( $path )
    {
        if (file_exists( self::PATH_IMG.'/'.$path))
        {
            unlink(self::PATH_IMG.'/'.$path);
        }
        return $this;
    }
}