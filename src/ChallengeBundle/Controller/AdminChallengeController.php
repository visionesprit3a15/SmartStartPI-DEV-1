<?php

namespace ChallengeBundle\Controller;

use ChallengeBundle\Entity\Challenge;
use ChallengeBundle\Entity\Question;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AdminChallengeController extends Controller
{
    public function readAdminAction()
    {   $challenges=$this->getDoctrine()->getRepository(Challenge::class)->findAll();
        return $this->render('@Challenge/AdminChallenge/read_admin.html.twig', array(
            'challenges' => $challenges
        ));
    }

    public function createAdminAction(Request $request)
    {
        //$user = $this->container->get('security.token_storage')->getToken()->getUser();
        $challenge = new Challenge();
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
            //$challenge->setUser($user);


            $sn = $this->getDoctrine()->getManager();
            $sn->persist($challenge);
            $sn->flush();




            return $this->redirectToRoute('read_admin');
        }

        return $this->render('@Challenge/AdminChallenge/create_admin.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function updateAdminAction(Request $request,$id)
    {
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





            return $this->redirectToRoute('read_admin');
        }
        return $this->render('@Challenge/AdminChallenge/update_admin.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function deleteAdminAction($id)
    {
        $sn = $this->getDoctrine()->getManager();
        $challenge=$sn->getRepository(Challenge::class)->find($id);
        $sn->remove($challenge);
        $sn->flush();
        return $this->redirectToRoute('read_admin');

    }
    public function statistiqueAction()
    {    $pieChart = new PieChart();
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
        $pieChart->getOptions()->setHeight(300);
        $pieChart->getOptions()->setWidth(700);
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
        $pieChart1->getOptions()->setHeight(300);
        $pieChart1->getOptions()->setWidth(700);
        $pieChart1->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart1->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart1->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart1->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart1->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('@Challenge/AdminChallenge/statistiqueadmin.html.twig', array(
            'piechart' => $pieChart,
            'piechart1' => $pieChart1
        ));
    }

}
