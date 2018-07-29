<?php

namespace App\Controller;

use App\Entity\Cita;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CitasController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Method({"GET"})
     */
    public function index()
    {
        $titulo = 'Citas famosas a lo largo de la historia';

        $citas = $this->getDoctrine()->getRepository(Cita::class)->findAll();

        return $this->render('citas/citas.html.twig', 
        array('titulo' => $titulo ,'citas' => $citas));
    }

     /**
     * @Route("/crearCita", name="crear")
     * @Method({"GET", "POST"})
     */

     public function crearCita(Request $request){

         $cita = new Cita();
         
         $form = $this->createFormBuilder($cita)
         ->add('titulo', TextType::class, array('attr' => array('class' => '')))
         ->add('contenido', TextareaType::class, array(
           'required' => true,
           'attr' => array('class' => '')
         ))
         ->add('guardar', SubmitType::class, array(
           'label' => 'Guardar',
           'attr' => array('class' => 'ui primary button')
         ))
         ->getForm();

         $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()) {
            $cita = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cita);
            $cita->setCreatedAt(new \DateTime('now'));
            $entityManager->flush();
    
            return $this->redirectToRoute('index');
          }


          return $this->render('citas/crearCita.html.twig', array(
            'form' => $form->createView()
          ));
     }
}
