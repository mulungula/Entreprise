<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Annotation\Route;
use  Doctrine\ORM\EntityManagerInterface;
use  Symfony\Component\HttpFoundation\Request;
use  symfony\Bundle\FrameworkBundle\controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EmployeController extends AbstractController
{

    /**
     * @Route("/ajouter-un-employe.html", name="employe_create", methods={"GET|POST"} )
     */
    public function create (Request $request, EntityManagerInterface $entityManager)
    {

        //////////////------------------1ere partie : GET-------//////////////

        # Variabilisation d'un nouvel objet de Type Employe
        $employe = new Employe();

        $form =$this->createForm(EmployeFormType::class);

        $form->handleRequest($request);

        //////////---------------2eme Partie: POST-------------/////////////

        if($form->isSubmitted() && $form->isValid() ) {
            $entityManager->persist($employe);
            $entityManager->flush();
            return $this->redirectToRoute('default_home');
  
            //$form->get('salary')->getData();
            

        }

        //////////////------------------1ere partie : GET-------//////////////
        
        return $this->render("form/employe.html.twig", [
            "form_employe" => $form->createView()
             

        ]);
    }
        /** 
        *  @Route("/modifier-un-employe-{id}", name="employe_update", methods={"GET|POST"})
        */


     public function delete(Employe $employe, Resquest $request, EntityManagerInterface $entityManager): RedirectResponse
      {
         $form = $this->createForm(EmployeFormType::class,$employe)
            ->$handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($employe);
            $entityManager->flush();

            return $this->redirectToRoute('default-home');
        
        } # end function delete()

        # end class


        return $this->render("form/employe.html.twig", [
            'employe' => $employe,
            'form_employe' => $form->createView()
        ]);
      
        

    }

}