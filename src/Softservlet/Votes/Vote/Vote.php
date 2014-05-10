<?php namespace Softservlet\Votes\Vote;

class Vote implements VoteInterface
{
	protected $id;
	protected $voterId;
	protected $voterName;
	protected $votableId;
	protected $votableName;
	protected $minValue;
	protected $maxValue;
	protected $time;
	
	public function __construct($id, $voterId, $voterName, $votableId, $votableName, $minValue, $maxValue, $value, $time)
	{
		$this->id = $id;
		$this->voterId = $voterId;
		$this->voterName = $voterName;
		$this->votableId = $votableId;
		$this->votableName = $votableName;
		$this->minValue = (float) $minValue;
		$this->maxValue = (float) $maxValue;
		$this->value = (float) $value;

		if(!is_numeric($time) && is_string($time)) {
			$time = strtotime($time);
		}
		
		$this->time = $time;
	}
	
	/**
	 * Returns the vote's id. This can be
	 * the id in the mysql database for example
	 *
	 * @return int id
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Returns the unique identifie (ID) of the object
	 * that placed the vote.
	 *
	 * @return int id
	*/
	public function getVoterId()
	{
		return $this->voterId;
	}
	
	/**
	 * Returns the name that identifies the voter object.
	 * In addition with its ID (returned by getVoterId())
	 * we can make a query and instantiate the voter object
	 *
	 * @return string name
	*/
	public function getVoterName()
	{
		return $this->voterName;
	}
	
	/**
	 * Returns the id of the votable object
	 * (the object that accepts votes)
	 *
	 * @return int id
	 */
	public function getVoteableId()
	{
		return $this->votableId;
	}
	
	/**
	 * Returns the name identifier of the votable
	 * object
	 *
	 * @return string votableName
	*/
	public function getVotableName()
	{
		return $this->votableName;
	}
	
	/**
	 * Get the vote value, that was placed by voter
	 *
	 * @return float value
	*/
	public function getValue()
	{
		return $this->value;
	}
	
	/**
	 * Get the vote values range. These are the interval of
	 * values that a vote can get. An array [minValue, maxValue]
	 * is returned.
	 *
	 * @return array
	*/
	public function getRange()
	{
		return array($this->minValue, $this->maxValue);
	}
	
	/**
	 * Get the minimum value that a vote can get
	 *
	 * @return float minValue
	*/
	public function getMinValue()
	{
		return $this->minValue;
	}
	
	/**
	 * Get the maximum value that a vote can get
	 *
	 * @return float maxValue
	*/
	public function getMaxValue()
	{
		return $this->maxValue;
	}
	
	/**
	 * Get the unix timestamp when the vote was registered
	 * 
	 * @return int unixtimestamp
	 */
	public function getTime()
	{
		return $this->time;
	}
}