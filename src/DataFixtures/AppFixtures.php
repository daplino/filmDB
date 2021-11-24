<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Crew;
use App\Entity\Film;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Work;
use App\Entity\Action;
use App\Entity\Person;
use App\Entity\Company;
use App\Entity\Country;
use App\Entity\Project;
use App\Entity\Audience;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    protected $faker;
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager): void
    {
        $actions = ['DEVSLATE','DEVSP','DISTSEL']; 
        // create actions
         foreach ($actions as $action) {
            $newAction = new Action();
            $newAction->setCode($action);
            
            $manager->persist($newAction);
        }
        $manager->flush();

        $audiences = ['All','Children','Adults']; 
        // create audiences
         foreach ($audiences as $audience) {
            $newAudience = new Audience();
            $newAudience->setName($audience);
            $newAudience->setType('film');
            $manager->persist($newAudience);
        }
        $manager->flush();

        $countries = ['AT','BE','BG','CZ']; 

        // create countries
         foreach ($countries as $country) {
            $newCountry = new Country();
            $newCountry->setCode($country);
            $manager->persist($newCountry);
        }
        $manager->flush();

        $roles = ['Director','Writer','Actor 1','Actor 2','Actor 3','Editor','Composer','Sound']; 
        // create countries
         foreach ($roles as $role) {
            $newRole = new Role();
            $newRole->setName($role);
            $manager->persist($newRole);
        }
        $manager->flush();

        
        // create companies

        $this->faker = Factory::create();
        $countries = $manager->getRepository(Country::class)->findAll();

        for ($i = 0; $i < 20; $i++) {
            $company = new Company();
            $country = $countries[array_rand($countries)];
            $company->setCountry($country);
            $company->setName($this->faker->regexify('[A-Z]{' . mt_rand(4, 20) . '}'));
            $company->setPIC(mt_rand(6000001, 6999999));
            $manager->persist($company);
        }
        $manager->flush();

        
        // create 20 projects

        $actions = $manager->getRepository(Action::class)->findAll();
        $companies = $manager->getRepository(Company::class)->findAll();
        
        for ($i = 0; $i < 20; $i++) {
            $project = new Project();
            $action = $actions[array_rand($actions)];
            $company = $companies[array_rand($companies)];
            $project->setAction($action);
            $project->setAction($action);
            $project->setReference(mt_rand(10, 100));
            $project->setYear(mt_rand(2014, 2021));
            $project->setCompany($company);
            $manager->persist($project);
        }

        $manager->flush();

        // create 100 persons
        $genders = ['Male','Female','Other'];
        $countries = $manager->getRepository(Country::class)->findAll();; 
        for ($i = 0; $i < 100; $i++) {
            $person = new Person();
            $country = $countries[array_rand($countries)];
            $person->setGender(array_rand($genders));
            $person->setNationality($country);
            $person->setResidence($country);
            $person->setFirstName($this->faker->firstName());
            $person->setLastName($this->faker->lastName());
            $manager->persist($person);
        }
        $manager->flush();

        // create 20 films

        $audiences = $manager->getRepository(Audience::class)->findAll();; 
        for ($i = 0; $i < 20; $i++) {
            $film = new Film();
            $audience = $audiences[array_rand($audiences)];
            $film->setTitle($this->faker->name());
            $film->setYearOfCopyright(mt_rand(2010, 2020));
            $film->setStatus('OPEN');
            $film->setAudience($audience);
            $manager->persist($film);
        }
        $manager->flush();

        // assign persons to crew 

        $people = $manager->getRepository(Person::class)->findAll();
        $roles = $manager->getRepository(Role::class)->findAll();
        $films = $manager->getRepository(Work::class)->findAll();

        foreach ($films as $film) {
            $totalRoles = (mt_rand(5, 8));

            for($i = 0; $i < $totalRoles; $i++) {
                $crew = new Crew();
                $crew->setWork($film);
                $crew->setRole($roles[$i]);
                $crew->setPerson($people[array_rand($people)]);
                $manager->persist($crew);
            }
            
        }
        $manager->flush();

         // create users 

        
         
        $user = new User();
                 $user->setUserName('Profile EULOGIN');
                 $user->setEmail('eulogin@icc.be');
                 $hash = $this->encoder->encodePassword($user, '123');
                $user->setPassword($hash);
                 $manager->persist($user);
                 $user = new User();         
                 $user->setUserName('Profile EACEA');
                 $user->setEmail('eacea@icc.be');
                 $hash = $this->encoder->encodePassword($user, '123');
                $user->setPassword($hash);
                 $manager->persist($user);
            
         $manager->flush();
 
    }
}
