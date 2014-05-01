<?php namespace Softservlet\Votes\Voter;

interface VoterInterface
{
	/**
	 * Get the voter object id
	 * 
	 * @return int id
	 */
	public function getId();

	/**
	 * Get the voter object name identifier
	 * that should be used in addition to id
	 * to query and instantiate the vote object
	 * 
	 * @return string name
	 */
	public function getName();
}