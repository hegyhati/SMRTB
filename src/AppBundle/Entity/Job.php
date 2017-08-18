<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="job")
 */

class Job 
{
	
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */ 
	protected $id;
	
	/**
	 * @ORM\Column(type="text")
	 */ 
	protected $name = "";
	
	/**
	 * @ORM\Column(type="text")
	 */ 
	protected $inputFile = "";
	
	/**
	 * @ORM\Column(type="boolean")
	 */ 
	protected $finalized = false;
    
    /**
	 * @ORM\Column(type="boolean")
	 */ 
	protected $finished = false;
    
    /**
	 * @ORM\Column(type="text")
	 */ 
	protected $mapFunction = "";
    
    /**
	 * @ORM\Column(type="text")
	 */ 
	protected $reduceFunction = "";

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Job
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set inputFile
     *
     * @param string $inputFile
     *
     * @return Job
     */
    public function setInputFile($inputFile)
    {
        $this->inputFile = $inputFile;

        return $this;
    }

    /**
     * Get inputFile
     *
     * @return string
     */
    public function getInputFile()
    {
        return $this->inputFile;
    }

    /**
     * Set finalized
     *
     * @param boolean $finalized
     *
     * @return Job
     */
    public function setFinalized($finalized)
    {
        $this->finalized = $finalized;

        return $this;
    }

    /**
     * Get finalized
     *
     * @return boolean
     */
    public function getFinalized()
    {
        return $this->finalized;
    }

    /**
     * Set finished
     *
     * @param boolean $finished
     *
     * @return Job
     */
    public function setFinished($finished)
    {
        $this->finished = $finished;

        return $this;
    }

    /**
     * Get finished
     *
     * @return boolean
     */
    public function getFinished()
    {
        return $this->finished;
    }

    /**
     * Set mapFunction
     *
     * @param string $mapFunction
     *
     * @return Job
     */
    public function setMapFunction($mapFunction)
    {
        $this->mapFunction = $mapFunction;

        return $this;
    }

    /**
     * Get mapFunction
     *
     * @return string
     */
    public function getMapFunction()
    {
        return $this->mapFunction;
    }

    /**
     * Set reduceFunction
     *
     * @param string $reduceFunction
     *
     * @return Job
     */
    public function setReduceFunction($reduceFunction)
    {
        $this->reduceFunction = $reduceFunction;

        return $this;
    }

    /**
     * Get reduceFunction
     *
     * @return string
     */
    public function getReduceFunction()
    {
        return $this->reduceFunction;
    }
}
