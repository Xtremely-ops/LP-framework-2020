<?php


namespace App\Controller;


use App\Entity\Inscription;
use App\Form\Type\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/inscription")
 * Class InscriptionController
 * @package App\Controller
 */
class InscriptionController extends AbstractController
{
    private $session;

    public function __construct( SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/identifiant")
     * @param $request Request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function identifiant( Request $request )
    {
        $inscription = new Inscription();
        $form = $this->createForm( InscriptionType::class, $inscription );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $inscription = $form->getData();
            $this->session->set('identifiant',serialize($inscription));
            return $this->redirectToRoute('inscription_home');
        }
        return $this->render( "inscription/identifiant.html.twig",
            [ "formIdentifiant" => $form->createView() ]);
    }

    /**
     * @Route("/home", name="inscription_home")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home()
    {
        $twigVar = [];
        if ( $this->session->has('identifiant') )
        {
            $twigVar[ 'identifiant'] = unserialize($this->session->get('identifiant'));
        }
        return $this->render( "inscription/home.html.twig",
            $twigVar);
    }
}