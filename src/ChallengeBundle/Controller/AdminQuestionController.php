<?php

namespace ChallengeBundle\Controller;

use ChallengeBundle\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class AdminQuestionController extends Controller
{
    public function createQuestionAction(Request $request)
    {
        $question = new Question();
        $form = $this->createFormBuilder($question)
            ->add('description',TextType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('reponse', TextType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('choix',TextType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('challenge',EntityType::class,array(
                'class' =>'ChallengeBundle\Entity\Challenge',
                'choice_label' => 'nom',
                'multiple'=>false
            ), array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))

            ->getForm();
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $description = $form['description']->getData();
            $reponse = $form['reponse']->getData();
            $choix = $form['choix']->getData();
            $challenge = $form['challenge']->getData();

            $question->setDescription($description);
            $question->setReponse($reponse);
            $question->setChoix($choix);
            $question->setChallenge($challenge);

            //$challenge->setUser($user);


            $sn = $this->getDoctrine()->getManager();
            $sn->persist($question);
            $sn->flush();

            return $this->redirectToRoute('readQuestion');
        }
        return $this->render('@Challenge/AdminQuestion/create_question.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function readQuestionAction()
    {
        $questions=$this->getDoctrine()->getRepository(Question::class)->findAll();
        return $this->render('@Challenge/AdminQuestion/read_question.html.twig', array(
            'questions' => $questions
        ));
    }

    public function updateQuestionAction(Request $request,$id)
    {
        $question = $this->getDoctrine()->getRepository(Question::class)->find($id);

        $question->setDescription($question->getDescription());
        $question->setReponse($question->getReponse());
        $question->setChoix($question->getChoix());
        $question->setChallenge($question->getChallenge());

        $form = $this->createFormBuilder($question)
            ->add('description',TextType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('reponse', TextType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('choix',TextType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('challenge',EntityType::class,array(
                'class' =>'ChallengeBundle\Entity\Challenge',
                'choice_label' => 'nom',
                'multiple'=>false
            ), array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))

            ->getForm();
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $description = $form['description']->getData();
            $reponse = $form['reponse']->getData();
            $choix = $form['choix']->getData();
            $challenge = $form['challenge']->getData();

            $sn = $this->getDoctrine()->getManager();
            $question=$sn->getRepository(Question::class)->find($id);


            $question->setDescription($description);
            $question->setReponse($reponse);
            $question->setChoix($choix);
            $question->setChallenge($challenge);

            //$challenge->setUser($user);

            $sn->flush();

            return $this->redirectToRoute('readQuestion');
        }

        return $this->render('@Challenge/AdminQuestion/update_question.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function deleteQuestionAction($id)
    {
        $sn = $this->getDoctrine()->getManager();
        $question=$sn->getRepository(Question::class)->find($id);
        $sn->remove($question);
        $sn->flush();
        return $this->redirectToRoute('readQuestion');
    }

}
