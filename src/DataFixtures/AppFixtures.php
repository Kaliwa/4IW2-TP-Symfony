<?php

namespace App\DataFixtures;

use App\Entity\Chapter;
use App\Entity\Classroom;
use App\Entity\Exercise;
use App\Entity\Subject;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $users = [];
        $classrooms = [];
        $subjects = [];
        $chapters = [];
        $faker = Factory::create();
        $this->createSubjects($manager, $subjects, $faker);
        $this->createClassrooms($manager, $classrooms, $subjects, $faker);
        $this->createUsers($manager, $classrooms, $users, $faker);
        $this->createChapters($manager, $subjects,  $chapters, $faker);
        $this->createExercises($manager, $chapters, $faker);
        $manager->flush();
    }

    
    protected function createClassrooms(ObjectManager $manager, array &$classrooms, array &$subjects, $faker): void
    {
        for ($l = 0; $l < 10; $l++) {
            $class = new Classroom();
            $class->setLevel((string )$l . "th Grade");
            $class->setName($faker->text(10));
            $classrooms[] = $class;
            $manager->persist($class);
    
            for ($i = 0; $i < rand(2, 4); $i++) {
                $subject = $faker->randomElement($subjects);
                $class->addSubjectID($subject);
            }
        }
    }
        
    protected function createUsers(ObjectManager $manager, array &$classrooms, array &$users, $faker): void
    {
        foreach ($classrooms as $classroom) {
            for ($i = 0; $i < 10; $i++) {
                $user = new User();
                $user->setFirstName($faker->firstName);
                $user->setLastName($faker->lastName);
                $user->setUsername($faker->username);
                $user->setEmail($faker->email);
                $user->setPassword(password_hash($faker->password, PASSWORD_BCRYPT));
                $user->setClasseID($classroom);
                $users[] = $user;
                $manager->persist(object: $user);
            }
        }
            $roles = ['ROLE_ADMIN', 'ROLE_USER', 'ROLE_BANNED'];
            foreach ($roles as $i => $role) {
                $user = new User();
                $user->setFirstName("John")
                    ->setLastName("Doe")
                    ->setUsername("johndoe" . $i)
                    ->setEmail("john+$i@doe.com")
                    ->setRoles([$role]);
        
                $hashedPassword = password_hash("0000", PASSWORD_BCRYPT);
                $user->setPassword($hashedPassword);
        
                $user->setClasseID($classroom);
        
                $manager->persist($user);
            }
            }

        protected function createSubjects(ObjectManager $manager, array &$subjects, $faker): void
        {
            $subjectNames = [
                'Mathematics',
                'History',
                'Physics',
                'Chemistry',
                'Biology',
                'Literature',
                'Geography',
                'Philosophy',
                'Computer Science',
                'Art'
            ];
        
            foreach ($subjectNames as $name) {
                $subject = new Subject();
                $subject->setName($name);
                $subject->setDescription($faker->text(100));
                $subjects[] = $subject;
                $manager->persist($subject);
            }
        }
            
    protected function createChapters(ObjectManager $manager, array &$subjects, array &$chapters, $faker): void
    {
        foreach ($subjects as $subject) {
            for ($j = 0; $j < 10; $j++) {
                $chapter = new Chapter();
                $chapter->setTitle($faker->text(10));
                $chapter->setDescription($faker->text(100));
                $chapter->setSubjectID($subject);
                $chapters[] = $chapter;
                $manager->persist($chapter);
            }
        }
    }
    
    protected function createExercises(ObjectManager $manager, array $chapters, $faker): void
    {
        foreach($chapters as $chapter) {
            for ($k = 0; $k < 10; $k++) {
                $exercise = new Exercise();
                $exercise->setQuestion($faker->text(10));
                $exercise->setResponse($faker->text(100));
                $exercise->setChapterID($chapter);
                $manager->persist($exercise);
            }
        }
    }    
}