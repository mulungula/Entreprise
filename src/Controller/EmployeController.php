<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\html;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * 
 *
 */

class EmployeController extends AbstractController
{
   /**
    * une fonction d une controller s'appellera une action.
    * le nom de cette action (cette fonction) commencera tjrs par un verbe
    * evidemment on privilegie l anglais . a defaut , on nomme correctement ses variables en français
    *
    *
    * la route = 1param: l'uri, 2 param: le nom de la route , 3param: la methode HTPP
    *
    * @Route("/ajouter-un-employe.html", name="employe_create", methods={"GET|POST"})
    */
   public function create(Request $request, EntityManagerInterface $entityManager)
   {
       # Variabilistaion d'un nouvel pbjet de type Employe
       $employe = new Employe();

       $form = $this->createForm(EmployeFormType::class, $employe);


       $form ->handleRequest($request);
        

       ////////////// 2eme partie: POST --------- ////////////////////////
         if($form->isSubmitted() && $form->isValid()) {
             
            //$form->get('salary')->getData();

            $entityManager->persist($employe);
            $entityManager->flush();

            return $this->redirectToRoute('default_home');

         }
      


          return $this->render("form/employe.html.twig", [
          "form_employe" => $form->createView()
        ]);
   } # end function create()


   /**
    * @Route("/modifier-un-employe-{id}", name="employe_update", methods={"GET|POST"})
    */
   public function update(Employe $employe, Request $request, EntityManagerInterface $entityManager):Response
   {
       $form = $this->createForm(EmployeFormType::class, $employe)
       ->handleRequest($request);

       if($form->isSubmitted() && $form->isValid())
       {
           $entityManager->persist($employe);
           $entityManager->flush();

           return $this->redirectToRoute('default_home');
       } // end if()
       
        return $this->render("form/employe.html.twig", [
         'employe' => $employe,
         'form_employe' => $form->createView()
        ]);
   } # end function update()

   /**
    * @Route("/supprimer-un-employe-{id}", name="employe_delete", methods={"GET"})
    */
   public function delete(Employe $employe, EntityManagerInterface $entityManager): RedirectResponse
   {
      
    $entityManager->remove($employe);
    $entityManager->flush();

    return $this->redirectToRoute("default_home");
   } # end function delete()




} # end class
