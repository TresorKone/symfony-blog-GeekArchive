<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Profile;
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
                'azerty123!'
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
                'azerty123!'
            )
        );

        $secondUser->setCreatedAt(new \DateTimeImmutable());
        $manager -> persist($secondUser);

        $adminUser = new User();
        $adminUser -> setEmail('adminUser@test.com');
        $adminUser -> setPassword(
            $this -> userPasswordHasher -> hashPassword(
                $adminUser,
                'azerty123!'
            )
        );
        $adminUser -> setRoles(['ROLE_ADMIN']);

        $adminUser->setCreatedAt(new \DateTimeImmutable());
        $manager -> persist($adminUser);

        //Profile
        $firstUserProfile = new Profile();
        $firstUserProfile->setFullname("first user");
        $firstUserProfile->setPseudo("firstUser");
        $firstUserProfile->setBio("i'm the first user");
        $firstUserProfile->setBirthDate(new \DateTime('2003-03-13'));
        //$firstUserProfile->setCreatedAt(new \DateTimeImmutable());
        $firstUserProfile->setUser($firstUser);
        $manager->persist($firstUserProfile);

        $secondUserProfile = new Profile();
        $secondUserProfile->setFullname("second user");
        $secondUserProfile->setPseudo("secondUser");
        $secondUserProfile->setBio("i'm the second user");
        $secondUserProfile->setBirthDate(new \DateTime('2007-07-17'));
        //$secondUserProfile->setCreatedAt(new \DateTimeImmutable());
        $secondUserProfile->setUser($secondUser);
        $manager->persist($secondUserProfile);

        $adminUserProfile = new Profile();
        $adminUserProfile->setFullname("almighty admin");
        $adminUserProfile->setPseudo("admin");
        $adminUserProfile->setBio("your beloved admin");
        $adminUserProfile->setBirthDate(new \DateTime('2000-01-10'));
        //$adminUserProfile->setCreatedAt(new \DateTimeImmutable());
        $adminUserProfile->setUser($adminUser);
        $manager->persist($adminUserProfile);

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
        $firstPost->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($firstPost);

        $secondPost = new Post();
        $secondPost->setTitle("test second post");
        $secondPost->setDescription("ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddfffffffffffff");
        $secondPost->setOwner($firstUser);
        $secondPost->addCategory($secondCategory);
        $secondPost->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($secondPost);

        $thirdPost = new Post();
        $thirdPost->setTitle("test third post");
        $thirdPost->setDescription("ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddfffffffffffff");
        $thirdPost->setOwner($adminUser);
        $thirdPost->addCategory($secondCategory);
        $thirdPost->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($thirdPost);

        $manager->flush();
    }
}
