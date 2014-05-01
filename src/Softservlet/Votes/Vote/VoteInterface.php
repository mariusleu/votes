<?php namespace Softservlet\Votes\Vote;

interface VoteInterface
{
	/**
	 * Returns the vote's id. This can be
	 * the id in the mysql database for example
	 * 
	 * @return int id
	 */
	public function getId();
	
	/**
	 * Returns the unique identifie (ID) of the object
	 * that placed the vote.
	 * 
	 * @return int id
	 */
	public function getVoterId();

	/**
	 * Returns the name that identifies the voter object.
	 * In addition with its ID (returned by getVoterId())
	 * we can make a query and instantiate the voter object
	 * 
	 * @return string name
	 */
	public function getVoterName();
	
	/**
	 * Returns the id of the votable object
	 * (the object that accepts votes)
	 * 
	 * @return int id
	 */
	public function getVoteableId();
	
	/**
	 * Returns the name identifier of the votable
	 * object
	 * 
	 * @return string votableName
	 */
	public function getVotableName();

	/**
	 * Get the vote value, that was placed by voter
	 * 
	 * @return float value
	 */
	public function getValue();

	/**
	 * Get the vote values range. These are the interval of
	 * values that a vote can get. An array [minValue, maxValue]
	 * is returned.
	 * 
	 * @return array
	 */
	public function getRange();

	/**
	 * Get the minimum value that a vote can get
	 * 
	 * @return float minValue
	 */
	public function getMinValue();

	/**
	 * Get the maximum value that a vote can get
	 * 
	 * @return float maxValue
	 */
	public function getMaxValue();
	
	/**
	 * Get the time when the vote was registered.
	 * The time is returned in unix timestamp.
	 * 
	 * @return int unix timestamp
	 */
	public function getTime();
}