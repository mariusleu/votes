<?php 

use Softservlet\Votes\Repositories\DB\DBVoteRepository as Repo;
use Softservlet\Votes\Repositories\DB\Vote as VoteDB;
use Softservlet\Votes\Votable\VotableInterface;
use Softservlet\Votes\Voter\VoterInterface;

class VotesRepositoryTest extends PHPUnit_Framework_TestCase
{	
	protected $repo;
	protected $vote;
	
	public function __construct()
	{
		$this->repo = new Repo(new VoteDB);	
	}

	public function testRepo()
	{
		$this->_testCreate();
		$this->_testFindByVotable();
		$this->_testFindByVoter();
		$this->_testAvg();
		$this->_testCount();	
		$this->_testDelete();
	}
	
	protected function _testCreate()
	{
		$voter = $this->_voter();
		$votable = $this->_votable();
			
		$vote = $this->repo->create($votable, $voter, 1, [0,1]);
		$this->vote = $vote;
		
		
		$find = $this->repo->find($vote->getId());	
		$this->assertEquals($vote->getId(), $find->getId());
	}
	
	protected function _testFindByVoter()
	{
		$vote = $this->repo->findByVotable($this->_votable(),$this->vote->getValue(), $this->vote->getRange());
		$this->assertEquals($vote[0]->getId(), $this->vote->getId());
		
	}

	
	protected function _testFindByVotable()
	{
		$vote = $this->repo->findByVotable($this->_votable(),$this->vote->getValue(), $this->vote->getRange());	
		$this->assertEquals($vote[0]->getId(), $this->vote->getId());
	}
	
	protected function _testAvg()
	{
		$avg = $this->repo->getAvgByVotable($this->_votable(), $this->vote->getRange());
		$this->assertEquals(intval($avg), $this->vote->getValue());
	}
		
	protected function _testCount()
	{
		$count = $this->repo->getCountByVotable($this->_votable(), $this->vote->getValue(), $this->vote->getRange());
		$this->assertEquals($count, 1);
	}

	protected function _testDelete()
	{
		$response = $this->repo->delete($this->vote->getId());	
		
		$this->assertEquals($response, true);
	}
	
	protected function _votable()
	{
		return new Votable(1);
	}
	
	protected function _voter()
	{
		return new Voter(2);
	}
}

/////////////////////////////////////////////////////

class Votable implements VotableInterface
{	
	protected $id;
	
	public function __construct($id)
	{
		$this->id = $id;
	}
	
	public function getId()
	{
		return $this->id;
	}	
	
	public function getName()
	{
		return get_class($this);
	}
}

class Voter extends Votable implements VoterInterface{}
