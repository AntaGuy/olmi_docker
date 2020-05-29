<?php
namespace App\Utils;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UsernameGenerator
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Generate a username for a given User
     *
     * @param User $user
     * @return string
     */
    public function generateUsernameByText(string  $last_name, string  $first_name)
    {
        $username = substr(mb_strtoupper($this->cleanString($last_name . $first_name)), 0, 8);

        $users = $this->em->getRepository(User::class)->findByUsername($username);

        if( $users ){
            $u = 1;
            while( $this->em->getRepository(User::class)->findByUsername($username . $u) ){
                $u++;
            }

            $username = $username . $u;
        }

        return $username;
    }

}