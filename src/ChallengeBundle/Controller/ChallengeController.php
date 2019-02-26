<?php

namespace ChallengeBundle\Controller;

use ChallengeBundle\Entity\Challenge;
use ChallengeBundle\Entity\Question;
use ChallengeBundle\Repository\ChallengeRepository;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ChallengeController extends Controller
{
    public function createAction(Request $request)
    {
        $user=$this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $users = $em->getRepository('MyBundle:User')->find($user);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
       $challenge = new Challenge();
        $agendanumber=$challenges=$this->getDoctrine()
            ->getRepository(Challenge::class)->findAll();
        //nb projet
        //$projetnumber=$projets=$this->getDoctrine()
           // ->getRepository(Projet::class)->findAll();
        //nb missions
        //$missionsnumber=$missions=$this->getDoctrine()
            //->getRepository(Mission::class)->findAll();
        //nb challenges
       // $challengenumber=$challenges=$this->getDoctrine()
            //->getRepository(Challenge::class)->findAll();
        $form = $this->createFormBuilder($challenge)
            ->add('nom',TextType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('description', TextType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('date',DateType::class,[
                'widget' => 'single_text',

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => true,

                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('email', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
//            ->add('image', FileType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('phone', TextType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('specialite',TextType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('imageFile',VichImageType::class)
            ->getForm();
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $name = $form['nom']->getData();
            $description = $form['description']->getData();
            $date = $form['date']->getData();
            $email = $form['email']->getData();
            $phone = $form['phone']->getData();
            $specialite = $form['specialite']->getData();
            $image=$form['imageFile']->getData();


            $challenge->setNom($name);
            $challenge->setDescription($description);
            $challenge->setDate($date);
            $challenge->setEmail($email);
            $challenge->setPhone($phone);
            $challenge->setSpecialite($specialite);
            $challenge->setImageFile($image);

            $challenge->setIdEntreprise($users);

            $sn = $this->getDoctrine()->getManager();
            $sn->persist($challenge);
            $sn->flush();




         return $this->redirectToRoute('read');
        }

        return $this->render('@Challenge/Challenge/create.html.twig', array(
            'form'=>$form->createView(),'number'=>count($agendanumber)
        ));
    }

    public function readAction()

    { $challenges=$this->getDoctrine()->getRepository(Challenge::class)->findAll();

        return $this->render('@Challenge/Challenge/read.html.twig', array(
            'challenges' => $challenges
        ));
    }

    public function updateAction(Request $request,$id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $challenge = $this->getDoctrine()->getRepository(Challenge::class)->find($id);

        $challenge->setNom($challenge->getNom());
        $challenge->setDescription($challenge->getDescription());
        $challenge->setDate($challenge->getDate());
        $challenge->setEmail($challenge->getEmail());
        $challenge->setPhone($challenge->getPhone());
        $challenge->setSpecialite($challenge->getSpecialite());

        $form = $this->createFormBuilder($challenge)
            ->add('nom',TextType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('description', TextType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('date',DateType::class
                ,[
                    'widget' => 'single_text',

                    // prevents rendering it as type="date", to avoid HTML5 date pickers
                    'html5' => true,

                    // adds a class that can be selected in JavaScript
                    'attr' => ['class' => 'js-datepicker'],
                ],array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('email', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
//            ->add('image', FileType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('phone', TextType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('specialite',TextType::class, array('attr' => array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('imageFile',VichImageType::class)
            ->getForm();

        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $name = $form['nom']->getData();
            $description = $form['description']->getData();
            $date = $form['date']->getData();
            $email = $form['email']->getData();
            $phone = $form['phone']->getData();
            $specialite = $form['specialite']->getData();
            $image=$form['imageFile']->getData();


            $sn = $this->getDoctrine()->getManager();
            $challenge=$sn->getRepository(Challenge::class)->find($id);
            $challenge->setNom($name);
            $challenge->setDescription($description);
            $challenge->setDate($date);
            $challenge->setEmail($email);
            $challenge->setPhone($phone);
            $challenge->setSpecialite($specialite);
            $challenge->setImageFile($image);
            //$challenge->setUser($user);
            $sn->flush();





           return $this->redirectToRoute('read');
        }

        return $this->render('@Challenge/Challenge/update.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function deleteAction($id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $sn = $this->getDoctrine()->getManager();
        $challenge=$sn->getRepository(Challenge::class)->find($id);
        $sn->remove($challenge);
        $sn->flush();
        return $this->redirectToRoute('read');
    }
    public function rechercheChallengeAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($request->isXmlHttpRequest()) {
            $nom = $request->get('nom');
            $missions = $this->getDoctrine()
                ->getRepository(Challenge::class)->findByNom($nom);
            $se = new Serializer(array(new ObjectNormalizer()));

            $data = $se->normalize($missions);
            return new JsonResponse($data);
        }
        return $this->render('@Challenge/Challenge/rechercheChallenge.html.twig', array(// ...
        ));
    }

    public function searchAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $entities =  $em->getRepository('ChallengeBundle:Challenge')->findByNom($requestString);
        if(!$entities) {
            $result['entities']['error'] = "there is no challenge with this name";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }
        return new Response(json_encode($result));

    }



    public function getRealEntities($entities){
        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = [$entity->getNom(), $entity->getDescription(), $entity->getDate(), $entity->getImageFile(),$entity->getEmail(),$entity->getPhone(),$entity->getSpecialite()];
        }
        return $realEntities;
    }

    public function statistiqueAction()
    {  $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $pieChart = new PieChart();
        $em= $this->getDoctrine();
        $totalChallenges=$em->getRepository(Challenge::class)->NombreDesChallenge();
        $EventsWEB=($em->getRepository(Challenge::class)->NombreDesChallengeWeb()*100)/$totalChallenges;
        $EventsRX=($em->getRepository(Challenge::class)->NombreDesChallengeRx()*100)/$totalChallenges;
        $EventsIT=($em->getRepository(Challenge::class)->NombreDesChallengeIT()*100)/$totalChallenges;
        $pieChart->getData()->setArrayToDataTable(
            [['etat evenement', 'etat'],
                ['web',     $EventsWEB],
                ['reseaux',      $EventsRX],
                ['IT',  $EventsIT],
            ]
        );

        $pieChart->getOptions()->setTitle('Pourcentages des Challenges selon leurs specialités');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        //**************************************************************************************

        $pieChart1 = new PieChart();
        $em= $this->getDoctrine();
        $totalQuestion=$em->getRepository(Question::class)->NombreDesQuestion();
        $questweb=($em->getRepository(Question::class)->NombreDesQuestionsWeb()*100)/$totalQuestion;
        $questrx=($em->getRepository(Question::class)->NombreDesQuestionsRX()*100)/$totalQuestion;
        $questit=($em->getRepository(Question::class)->NombreDesQuestionsIT()*100)/$totalQuestion;

        $pieChart1->getData()->setArrayToDataTable(
            [['etat evenement', 'etat'],
                ['0%-50%',     $questweb],
                ['50%-75%',      $questrx],

                ['75%-100%',  $questit],
            ]
        );
        $pieChart1->getOptions()->setTitle('Pourcentages des questions par pourcentage');
        $pieChart1->getOptions()->setHeight(500);
        $pieChart1->getOptions()->setWidth(900);
        $pieChart1->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart1->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart1->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart1->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart1->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('@Challenge/Challenge/statistique.html.twig', array(
            'piechart' => $pieChart,
            'piechart1' => $pieChart1
        ));
    }

}
