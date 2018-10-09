<?php

namespace App\Controller;

use App\Entity\EntryCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @param $code
     * @return Response
     * @Route("/{code}", name="code_check")
     */
    public function checkCodeAction($code)
    {

        $em = $this->getDoctrine()->getManager();
        $avCode = $em->getRepository(EntryCode::class)->findByCode($code);

        if ($avCode != null){
            return $this->render('default/code.html.twig', array(
                'code' => $avCode
            ));
        }

        return new Response("LOSE");
    }
}
