<?php namespace Softservlet\Votes\Repositories;

use Softservlet\Votes\Voter\VoterInterface;
use Softservlet\Votes\Votable\VotableInterface;
use Softservlet\Votes\Vote\VoteInterface;

interface VoteRepositoryInterface
{
	/**
	 * Retrieve an vote by its id
	 * 
	 * @param int $id
	 * 
	 * @return VoteInterface instance
	 */
	public function find($id);

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
	public function findByVoter(VoterInterface $voter, $value = null, Array $range = array());
	
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
	public function findByVotable(VotableInterface $votable, $value = null, Array $range = array());

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
	public function getCountByVotable(VotableInterface $votable, $value = null, Array $range = array());

	/**
	 * Get the average values of the votest by a votable object
	 * 
	 * @param VotableInterface $voter
	 * @param array $range - optional - search
	 * only the votest which value is on this range
	 * 
	 * @return int count
	 */	
	public function getAvgByVotable(VotableInterface $votable, $range = array());

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
	public function create(VotableInterface $votable, VoterInterface $voter, $value, Array $range);

	/**
	 * Delete an vote by id
	 *  
	 * @param int id
	 */
	public function delete($id);
	
	
}