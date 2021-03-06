<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="reducejob")
 */

class ReduceJob 
{
	
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */ 
	protected $id;
	
    /**
     * @ORM\ManyToOne(targetEntity="Job", inversedBy="reducejobs")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     */
    private $job;
    
    /**
     * @ORM\OneToMany(targetEntity="IntermediatePair", mappedBy="reducejob")
     */
    private $intermediatepairs;

    public function getValues()
    {
        $values = array();
        foreach($this->intermediatepairs as $pair) {
            $values[]=$pair->getValue();
        }
        return $values;
    }
    
	/**
	 * @ORM\Column(type="boolean")
	 */ 
	protected $finished = false;
    
    /**
	 * @ORM\Column(type="text")
	 */ 
	protected $worker = "";
    
    /**
	 * @ORM\Column(type="text")
	 */ 
	protected $key = "";

    /**
	 * @ORM\Column(type="text")
	 */ 
	protected $result = "";
    
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->intermediatepairs = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set finished
     *
     * @param boolean $finished
     *
     * @return ReduceJob
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
     * Set worker
     *
     * @param string $worker
     *
     * @return ReduceJob
     */
    public function setWorker($worker)
    {
        $this->worker = $worker;

        return $this;
    }

    /**
     * Get worker
     *
     * @return string
     */
    public function getWorker()
    {
        return $this->worker;
    }

    /**
     * Set result
     *
     * @param string $result
     *
     * @return ReduceJob
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set job
     *
     * @param \AppBundle\Entity\Job $job
     *
     * @return ReduceJob
     */
    public function setJob(\AppBundle\Entity\Job $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return \AppBundle\Entity\Job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Add intermediatepair
     *
     * @param \AppBundle\Entity\IntermediatePair $intermediatepair
     *
     * @return ReduceJob
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

    /**
     * Set key
     *
     * @param string $key
     *
     * @return ReduceJob
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
}
