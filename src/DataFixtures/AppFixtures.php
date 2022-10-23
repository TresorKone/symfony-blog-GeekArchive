<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    // for ashing the password

    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {

    }

    public function load(ObjectManager $manager): void
    {

        //User
        $firstUser = new User();
        $firstUser -> setEmail('firstUser@test.com');
        $firstUser -> setPassword(
            $this -> userPasswordHasher -> hashPassword(
                $firstUser,
                '1234h3h'
            )
        );
        $firstUser -> setRoles(['ROLE_USER']);
        $firstUser->setCreatedAt(new \DateTimeImmutable());
        $manager -> persist($firstUser);

        $secondUser = new User();
        $secondUser -> setEmail('secondUser@test.com');
        $secondUser -> setPassword(
            $this -> userPasswordHasher -> hashPassword(
                $secondUser,
                '1234h3h'
            )
        );
        $secondUser->setCreatedAt(new \DateTimeImmutable());
        $manager -> persist($secondUser);

        $adminUser = new User();
        $adminUser -> setEmail('adminUser@test.com');
        $adminUser -> setPassword(
            $this -> userPasswordHasher -> hashPassword(
                $adminUser,
                '1234h3h'
            )
        );
        $adminUser -> setRoles(['ROLE_ADMIN']);
        $adminUser->setCreatedAt(new \DateTimeImmutable());
        $manager -> persist($adminUser);

        //Category
        $firstCategory = new Category();
        $firstCategory->setName("History");
        $firstCategory->setDescription("blablablablablabla somethings history");
        $manager->persist($firstCategory);

        $secondCategory = new Category();
        $secondCategory->setName("FrameData");
        $secondCategory->setDescription("blablablablablabla somethings history");
        $manager->persist($secondCategory);

        $thirdCategory = new Category();
        $thirdCategory->setName("somethings");
        $thirdCategory->setDescription("blablablablablabla somethings history");
        $manager->persist($thirdCategory);


        //Post
        $firstPost = new Post();
        $firstPost->setTitle("testfirst post");
        $firstPost->setDescription("ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddfffffffffffff");
        $firstPost->setOwner($firstUser);
        $firstPost->addCategory($firstCategory);
        $manager->persist($firstPost);

        $secondPost = new Post();
        $secondPost->setTitle("test second post");
        $secondPost->setDescription("ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddfffffffffffff");
        $secondPost->setOwner($firstUser);
        $secondPost->addCategory($secondCategory);
        $manager->persist($secondPost);

        $thirdPost = new Post();
        $thirdPost->setTitle("test second post");
        $thirdPost->setDescription("ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddfffffffffffff");
        $thirdPost->setOwner($adminUser);
        $thirdPost->addCategory($secondCategory);
        $manager->persist($thirdPost);

        $manager->flush();
    }
}
