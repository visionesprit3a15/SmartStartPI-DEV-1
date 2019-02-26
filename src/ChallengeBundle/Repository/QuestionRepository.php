<?php

namespace ChallengeBundle\Repository;

/**
 * QuestionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionRepository extends \Doctrine\ORM\EntityRepository
{
public function findByQuestion($id)
{
    $query=$this->getEntityManager()
        ->createQuery("SELECT m as question from ChallengeBundle:Question m where m.id ='$id' ");
    return $query->getResult();
}
    public function findByChoix()
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT CONCAT(m.description,m.choix,m.reponse) as choix from ChallengeBundle:Question m ");
        return $query->getResult();
    }
    public function NombreDesQuestion()
    {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('COUNT(e)')
            ->from('ChallengeBundle:Question', 'e')
        ;

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function NombreDesQuestionsWeb()
    {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('COUNT(e)')
            ->from('ChallengeBundle:Question', 'e')
            ->leftJoin('ChallengeBundle:Challenge', 'fc', 'fc.id = e.IdChallenge')
            ->where("fc.specialite = 'web'");

;
        return $queryBuilder->getQuery()->getSingleScalarResult();
    }
    public function NombreDesQuestionsRX()
    {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('COUNT(e)')
            ->from('ChallengeBundle:Question', 'e')
            ->leftJoin('ChallengeBundle:Challenge', 'fc', 'fc.id = e.IdChallenge')
            ->where("fc.specialite = 'reseaux'");


        return $queryBuilder->getQuery()->getSingleScalarResult();
    }
    public function NombreDesQuestionsIT()
    {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('COUNT(e)')
            ->from('ChallengeBundle:Question', 'e')
            ->leftJoin('ChallengeBundle:Challenge', 'fc', 'fc.id = e.IdChallenge')
            ->where("fc.specialite = 'it'");


        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

}
