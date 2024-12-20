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
        $this->createClassrooms($manager, $classrooms, $faker);
        $this->createUsers($manager, $classrooms, $users, $faker);
        $this->createSubjects($manager, $subjects, $faker);
        $this->createChapters($manager, $subjects,  $chapters, $faker);
        $this->createExercises($manager, $chapters, $faker);
        $manager->flush();
    }

    
    protected function createClassrooms(ObjectManager $manager, array &$classrooms, $faker): void
    {
        for ($l = 0; $l < 10; $l++) {
            $class = new Classroom();
            $class->setLevel((string) $l);
            $class->setName($faker->text(10));
            $classrooms[] = $class;
            $manager->persist($class);
        }
    }

    protected function createUsers(ObjectManager $manager, array &$classrooms, array &$users, $faker): void
    {
        foreach ($classrooms as $classroom) {
            for ($i = 0; $i < 10; $i++) {
                $user = new User();
                $user->setFirstName($faker->firstName);
                $user->setLastName($faker->lastName);
                $user->setEmail($faker->email);
                $user->setPassword(password_hash($faker->password, PASSWORD_BCRYPT));
                $user->setClasseID($classroom);
                $users[] = $user;
                $manager->persist($user);
            }
        }
    }

    protected function createSubjects(ObjectManager $manager, array &$subjects, $faker): void
    {
        for ($i = 0; $i < 10; $i++) {
            $subject = new Subject();
            $subject->setName($faker->text(10));
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