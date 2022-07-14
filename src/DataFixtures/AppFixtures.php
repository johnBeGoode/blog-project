<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
    
        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setTitle('Titre' . $i);
            $article->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae bibendum libero, at mattis orci. Etiam facilisis, leo pellentesque hendrerit tincidunt, leo libero volutpat lectus, ut consectetur ex odio et ipsum. Cras ac velit quam. Nulla facilisi. Quisque tortor arcu, sagittis a massa quis, pharetra hendrerit justo. Suspendisse tincidunt sit amet neque ac ullamcorper. Aenean tristique lacinia dolor et finibus. Suspendisse facilisis lacus in gravida molestie. Sed sit amet odio congue, tristique orci eget, elementum lorem. Proin vel maximus velit.

            Curabitur purus quam, consequat sit amet aliquam et, efficitur non ante. Sed bibendum dolor eu mollis semper. Duis sit amet eros vitae dui blandit consectetur. Ut at turpis cursus nisl dignissim dictum. Praesent vehicula lobortis quam, a feugiat augue commodo sit amet. Maecenas velit nibh, imperdiet at egestas vel, auctor eu velit. Proin nec justo ut libero molestie porttitor. Praesent at dapibus odio. Vivamus ornare faucibus luctus.
            
            Donec ullamcorper elementum ante. Etiam feugiat non erat at imperdiet. Quisque facilisis elit in faucibus gravida. Etiam viverra tempus sem eu consequat. Etiam volutpat iaculis sapien vitae dictum. Nunc imperdiet ultrices maximus. Integer aliquam pretium suscipit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus mi metus, malesuada quis fermentum nec, interdum ut mauris. Mauris sodales urna eu est tincidunt, sollicitudin efficitur lectus consequat. Etiam vestibulum purus eu pharetra interdum. Quisque vestibulum, diam eu porttitor posuere, urna nisl ultricies lectus, ut rhoncus mi quam ac mauris. Vestibulum dapibus quam eleifend quam semper tempor. Vestibulum sed pretium lectus. Fusce non felis ac nunc mollis eleifend quis a nunc.');
            $article->setImage("default-picture.jpg");
            $manager->persist($article);
        }

        for ($i = 0; $i < 2; $i++) { 
            $user = new User();
            $user->setEmail('mail' . $i . '@email.com');
            $user->setFirstName('Prénom' . $i);
            $user->setLastName('Nom' . $i);
            $user->setPassword($this->encoder->hashPassword($user, 'azerty'));
            $user->setIsVerified(true);
        }
       
        $manager->flush();
    }
}
