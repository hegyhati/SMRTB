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
     * @ORM\OneToMany(targetEntity="MapJob", mappedBy="mapjob")
     */
    private $mapjobs;

    /**
     * @ORM\OneToMany(targetEntity="ReduceJob", mappedBy="reducejob")
     */
    private $reducejobs;
    
    
    /**
	 * @ORM\Column(type="text")
	 */ 
	protected $author = "";
    
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

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Job
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }
    
    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        if(! $this->getFinalized()) return "Still editing";
        else if (! $this->getFinished()) return "Ready to run or running";
        else return "Finished";
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mapjobs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reducejobs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add mapjob
     *
     * @param \AppBundle\Entity\MapJob $mapjob
     *
     * @return Job
     */
    public function addMapjob(\AppBundle\Entity\MapJob $mapjob)
    {
        $this->mapjobs[] = $mapjob;

        return $this;
    }

    /**
     * Remove mapjob
     *
     * @param \AppBundle\Entity\MapJob $mapjob
     */
    public function removeMapjob(\AppBundle\Entity\MapJob $mapjob)
    {
        $this->mapjobs->removeElement($mapjob);
    }

    /**
     * Get mapjobs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMapjobs()
    {
        return $this->mapjobs;
    }

    /**
     * Add reducejob
     *
     * @param \AppBundle\Entity\ReduceJob $reducejob
     *
     * @return Job
     */
    public function addReducejob(\AppBundle\Entity\ReduceJob $reducejob)
    {
        $this->reducejobs[] = $reducejob;

        return $this;
    }

    /**
     * Remove reducejob
     *
     * @param \AppBundle\Entity\ReduceJob $reducejob
     */
    public function removeReducejob(\AppBundle\Entity\ReduceJob $reducejob)
    {
        $this->reducejobs->removeElement($reducejob);
    }

    /**
     * Get reducejobs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReducejobs()
    {
        return $this->reducejobs;
    }
}
