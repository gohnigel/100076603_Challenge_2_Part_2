<?php

namespace App\Console\Commands;

use App\School;
use App\Student;
use App\Project;
use App\Reading;
use Illuminate\Support\Facades\DB;
use GraphAware\Bolt\Protocol\V1\Session;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SeedSomeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seedsomedata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function createSchool($name)
    {
        // Insert into Eloquent and get ID
        $id = School::create(['name' => $name])->id;

        // Insert into neo4j and link to eloquent
        $cypher = "CREATE (s:School { name: '" . $name . "', eloquentID: ". $id ."})";

        $this->client->run($cypher);
    }

    public function createStudent($number)
    {
        // Insert into Eloquent and get ID
        $id = Student::create(['number' => $number])->id;

        // Insert into neo4j and link to eloquent
        $cypher = "CREATE (sd:Student { number: " . $number . ", eloquentID: ". $id ."})";

        $this->client->run($cypher);
    }

    public function createProject($title)
    {
        // Insert into Eloquent and get ID
        $id = Project::create(['title' => $title])->id;

        // Insert into neo4j and link to eloquent
        $cypher = "CREATE (p:Project { title: '" . $title . "', eloquentID: ". $id ."})";

        $this->client->run($cypher);
    }

    public function createReading($name, $type)
    {
        // Insert into Eloquent and get ID
        $id = Reading::create(['name' => $name, 'type' => $type])->id;

        // Insert into neo4j and link to eloquent
        $cypher = "CREATE (r:Reading { name: '" . $name . "', type: '" . $type . "', eloquentID: ". $id ."})";

        $this->client->run($cypher);
    }

    public function createRelationship()
    {

    }

    public function wipe()
    {
        $this->client->run("MATCH (n) DETACH DELETE n");

        School::truncate();
        Student::truncate();
        Project::truncate();
        Reading::truncate();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Session $client)
    {
        $this->client = $client;

        $this->wipe();

        // Initialise schools
        $names = ['A', 'B'];

        foreach($names as $name)
        {
            $this->createSchool($name);
        }

        // Initialise students
        $numbers = [1, 2, 3, 4, 5];

        foreach($numbers as $number)
        {
            $this->createStudent($number);
        }

        $this->createProject("A");

        $reading = ['name' => 'A', 'type' => 'Book'];

        $this->createReading($reading['name'], $reading['type']);

        // Initialise projects

        // @todo handle relationships

        $cypher = "MERGE(s:School { name: 'A'}) MERGE(s2:School { name: 'B'}) MERGE(sd:Student { number: 1 }) MERGE(sd2:Student { number: 2 }) MERGE(sd3:Student { number: 3 }) MERGE(sd4:Student { number: 4 }) MERGE(sd5:Student { number: 5 }) MERGE(p:Project) MERGE(r:Reading) MERGE (sd)<-[:HAS]->(s)-[:HAS]->(sd2) MERGE(s)-[:HAS]->(sd3) MERGE(sd4)<-[:HAS]-(s2)-[:HAS]->(sd5) MERGE(sd)<-[:MEMBER_OF]-(p)-[:MEMBER_OF]->(sd3) MERGE(p)-[:MEMBER_OF]->(sd5) MERGE(sd3)-[:READING]->(r)<-[:READING]-(sd4)";

        $client->run($cypher);

        // $result = $client->run('MATCH (s:School {}), (sd:Student {}), (p:Project {}), (r:Reading {}) RETURN s, sd, p, r');

        // foreach($result->getRecords() as $record){
        //     echo sprintf('School name is %s with student %d who is a member of project %s and reads %s', $record->get('s')->value('name'), $record->get('sd')->value('number'), $record->get('p')->value('title'), $record->get('r')->value('name') . "\n");
        // }
    }
}
