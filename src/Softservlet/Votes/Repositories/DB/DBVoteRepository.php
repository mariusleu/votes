<?php namespace Softservlet\Votes\Repositories\DB;

use Softservlet\Votes\Repositories\VoteRepositoryInterface;
use Softservlet\Votes\Vote\Vote;
use Softservlet\Votes\Repositories\DB\Vote as VoteDB;
use Softservlet\Votes\Voter\VoterInterface;
use Softservlet\Votes\Votable\VotableInterface;

class DBVoteRepository implements VoteRepositoryInterface
{
	/**
	 * Holds the Vote eloquent instance
	 * 
	 * @var Illuminate\Database\Eloquent\Model
	 */
	protected $vote;
	
	
	public function __construct(VoteDB $vote)
	{
		$this->vote = $vote;
	}
	
	/**
	 * Retrieve an vote by its id
	 *
	 * @param int $id
	 *
	 * @return VoteInterface instance
	 */
	public function find($id)
	{
		$data = $this->vote->where('id','=',$id)->first();
		
		if(is_null($data)) {
			return null;
		}
		
		return $this->instance($data);
	}
	
	/**
	 * Find the votes posted by a voter
	 *
	 * @param VoterInterface $voter
	 * @param string $value - optional - search
	 * only the votes that have this given value
	 * @param array $range - optional - search
	 * only the votest which value is on this range
	 *
	 * @return array<VoteInterface>
	*/
	public function findByVoter(VoterInterface $voter, $value = null, Array $range = array())
	{
		$holder = array(
			'voter_id' => $voter->getId(),
			'voter_name' => $voter->getName()
		);

		$data = $this->queryBy($holder, $value, $range);
		
		return $this->instance($data->get());
	}
	
	/**
	 * Find the votes posted by a votable object
	 *
	 * @param VotableInterface $voter
	 * @param string $value - optional - search
	 * only the votes that have this given value
	 * @param array $range - optional - search
	 * only the votest which value is on this range
	 *
	 * @return array<VoteInterface>
	*/
	public function findByVotable(VotableInterface $votable, $value = null, Array $range = array())
	{
		$holder = array(
			'votable_id' => $votable->getId(),
			'votable_name' => $votable->getName()
		);
		
		$data = $this->queryBy($holder, $value, $range);
		
		return $this->instance($data->get());
	}
	
	/**
	 * Get the count of the votest by a votable object
	 *
	 * @param VotableInterface $voter
	 * @param string $value - optional - search
	 * only the votes that have this given value
	 * @param array $range - optional - search
	 * only the votest which value is on this range
	 *
	 * @return int count
	*/
	public function getCountByVotable(VotableInterface $votable, $value = null, Array $range = array())
	{
		$holder = array(
			'votable_id' => $votable->getId(),
			'votable_name' => $votable->getName()
		);
		
		$data = $this->queryBy($holder, $value, $range);
		
		return $data->count();
	}
	
	/**
	 * Get the average values of the votest by a votable object
	 *
	 * @param VotableInterface $voter
	 * @param array $range - optional - search
	 * only the votest which value is on this range
	 *
	 * @return int count
	*/
	public function getAvgByVotable(VotableInterface $votable, $range = array())
	{
		$holder = array(
			'votable_id' => $votable->getId(),
			'votable_name' => $votable->getName()	
		);
		
		$data = $this->queryBy($holder, null, $range);
		
		return $data->avg('value');
	}
	
	/**
	 * Create a new vote object and assings it to votable and voter
	 *
	 * @param VotableInterface $votable
	 * @param VoterInterface $voter
	 * @param float $value
	 * @param array $range
	 *
	 * @return VoteInterface instance
	*/
	public function create(VotableInterface $votable, VoterInterface $voter, $value, Array $range)
	{
		$this->vote->unguard();
		
		$data = $this->vote->create(array(
				'votable_id' => $votable->getId(),
				'votable_name' => $votable->getName(),
				'voter_id' => $voter->getId(),
				'voter_name' => $voter->getName(),
				'value' => $value,
				'min_value' => $range[0],
				'max_value' => $range[1]	
		));
		
		return $this->instance($data);
	}
	
	/**
	 * Delete an vote by id
	 *
	 * @param int id
	*/
	public function delete($id)
	{
		return $this->vote->where('id','=',$id)->delete();	
	}
	
	//return an Vote instance 
	protected function instance($vote)
	{
		if(is_array($vote) || $vote instanceof \IteratorAggregate) {
			return $this->instanceArray($vote);
		} elseif($vote instanceof VoteDB) {	
			return $this->instanceSingle($vote);
		}
	}

	//return an vote instance by a single object
	protected function instanceSingle(VoteDB $vote) 
	{
		return new Vote(
				$vote->id, 
				$vote->voter_id,
				$vote->voter_name,
				$vote->votable_id,
				$vote->votable_name, 
				$vote->min_value,
				$vote->max_value, 
				$vote->value,
				$vote->created_at
		);		
	}	

	//return an array of votes instance by array of models
	protected function instanceArray($data)
	{
		$votes = array();
		
		foreach($data as $vote) {
			$votes[] = $this->instanceSingle($vote);		
		}
		
		return $votes;
	}

	//abstract query of votes
	protected function queryBy(Array $holder, $value = null, Array $range = array())
	{
		$data = $this->vote;
		
		foreach($holder as $key => $value)	{
			$data->where($key,'=',$value);
		}
		
		if(!is_null($value)) {
			$data->where('value','=',$value);
		}
		
		if(count($range) == 2) {
			$data->where('min_value','=',$range[0])
			->where('max_value','=',$range[1]);
		}
		
		return $data;
	}
}