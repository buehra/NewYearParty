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
     * @param $hash
     * @return Response
     * @Route("/{hash}", name="code_check")
     */
    public function checkCodeAction($hash, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $avCode = $em->getRepository(EntryCode::class)->findByUrlHash($hash);

        if ($avCode != null){
            $form = $this->createForm(CodeType::class, $avCode);
            $form->handleRequest($request);

            return $this->render('default/code.html.twig', array(
                'code' => $avCode,
                'form' => $form->createView()
            ));
        }

        return $this->render('default/lose.html.twig');
    }

    /**
     * @param EntryCode $code
     * @param Request $request
     * @return Response
     * @Route("/{code}/submit", name="code_save", methods={"POST"})
     */
    public function codeSaveAction(EntryCode $code, Request $request){
        $em = $this->getDoctrine()->getManager();

        $existingCode = $em->getRepository(EntryCode::class)->find($code->getId());

        if ($existingCode->getEmail() == null){
            $form = $this->createForm(CodeType::class, $code);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){
                $em->persist($code);
                $em->flush();

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('default/codeExist.html.twig');
    }
}
