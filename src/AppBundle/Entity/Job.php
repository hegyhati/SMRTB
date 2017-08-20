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
     * @ORM\OneToMany(targetEntity="MapJob", mappedBy="job")
     */
    private $mapjobs;

    public function getMapCount()
    {
        return $this->mapjobs->count();
    }
    
    public function getMapDone()
    {
        return $this->mapjobs->filter(function ($mj){return $mj->getFinished();})->count();
    }
    
    public function getMapProgress()
    {
        if ($this->getMapCount() == 0) return 0;
        else return 100 * $this->getMapDone() / $this->getMapCount();
    }
    
    
    /**
     * @ORM\OneToMany(targetEntity="ReduceJob", mappedBy="job")
     */
    private $reducejobs;
    
    public function getReduceCount()
    {
        return $this->reducejobs->count();
    }
    
    public function getReduceDone()
    {
        return $this->reducejobs->filter(function ($rj){return $rj->getFinished();})->count();
    }
    
    public function getReduceProgress()
    {
        if ($this->getReduceCount() == 0) return 0;
        else return 100 * $this->getReduceDone() / $this->getReduceCount();
    }
    
    /**
     * @ORM\OneToMany(targetEntity="IntermediatePair", mappedBy="job")
     */
    private $intermediatepairs;
    
    
    /**
	 * @ORM\Column(type="text")
	 */ 
	protected $author = "";
    
	/**
	 * @ORM\Column(type="text")
	 */ 
	protected $inputFile = "";
	
    
    const editing = 0;
    const finalized = 1;
    const runningMap = 2;
    const shuffling = 3;
    const runningReduce = 4;
    const finished =5;
	/**
	 * @ORM\Column(type="integer")
	 */ 
	protected $state = Job::editing;
    
       
    /**
	 * @ORM\Column(type="text")
	 */ 
	protected $mapFunction = "";
    
    /**
	 * @ORM\Column(type="text")
	 */ 
	protected $reduceFunction = "";

    /** 
     * @ORM\Column(type="datetime",  options={"default": 0}) 
     */
    private $lastrequested;

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
     * Constructor
     */
    public function __construct()
    {
        $this->mapjobs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reducejobs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lastrequested = new \DateTime();
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

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Job
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }
    
    public function getStringState() {
        return $this->getStringByState($this->state);
    }
    
    public static function getStringByState($state)
    {
        switch($state) {
            case 0:
                return "under editing"; break;
            case 1:
                return "finalized and ready to run"; break;
            case 2: 
                return "running Map jobs"; break;
            case 3:
                return "shuffling intermediate pairs"; break;
            case 4:
                return "running Reduce jobs"; break;
            case 5: 
                return "finished"; break;
        }    
    }

    /**
     * Set lastrequested
     *
     * @param \DateTime $lastrequested
     *
     * @return Job
     */
    public function setLastrequested($lastrequested)
    {
        $this->lastrequested = $lastrequested;

        return $this;
    }

    /**
     * Get lastrequested
     *
     * @return \DateTime
     */
    public function getLastrequested()
    {
        return $this->lastrequested;
    }

    /**
     * Add intermediatepair
     *
     * @param \AppBundle\Entity\IntermediatePair $intermediatepair
     *
     * @return Job
     */
    public function addIntermediatepair(\AppBundle\Entity\IntermediatePair $intermediatepair)
    {
        $this->intermediatepairs[] = $intermediatepair;

        return $this;
    }

    /**
     * Remove intermediatepair
     *
     * @param \AppBundle\Entity\IntermediatePair $intermediatepair
     */
    public function removeIntermediatepair(\AppBundle\Entity\IntermediatePair $intermediatepair)
    {
        $this->intermediatepairs->removeElement($intermediatepair);
    }

    /**
     * Get intermediatepairs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIntermediatepairs()
    {
        return $this->intermediatepairs;
    }
}
