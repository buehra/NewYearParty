<?php

namespace App\Controller;

use App\Entity\EntryCode;
use App\Form\CodeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function checkCodeAction($code, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $avCode = $em->getRepository(EntryCode::class)->findByCode($code);

        if ($avCode != null){
            $form = $this->createForm(CodeType::class, $avCode);
            $form->handleRequest($request);

            return $this->render('default/code.html.twig', array(
                'code' => $avCode,
                'form' => $form->createView()
            ));
        }

        return new Response("LOSE");
    }

    /**
     * @param EntryCode $code
     * @param Request $request
     * @return Response
     * @Route("/{code}/submit", name="code_save", methods={"POST"})
     */
    public function codeSaveAction(EntryCode $code, Request $request){
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(CodeType::class, $code);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($code);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return new Response("FAILED");
    }
}
