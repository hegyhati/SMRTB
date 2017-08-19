<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="mapjob")
 */

class MapJob 
{
	
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */ 
	protected $id;
	
    /**
     * @ORM\ManyToOne(targetEntity="Job", inversedBy="mapjobs")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     */
    private $job;
    
    /**
     * @ORM\OneToMany(targetEntity="IntermediatePair", mappedBy="mapjob")
     */
    private $intermediatepairs;
    
	/**
	 * @ORM\Column(type="text")
	 */ 
	protected $inputchunk="";
	
    /**
	 * @ORM\Column(type="boolean")
	 */ 
	protected $finished = false;
    
    /**
	 * @ORM\Column(type="text")
	 */ 
	protected $worker = "";
    
	
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
     * Set inputchunk
     *
     * @param string $inputchunk
     *
     * @return MapJob
     */
    public function setInputchunk($inputchunk)
    {
        $this->inputchunk = $inputchunk;

        return $this;
    }

    /**
     * Get inputchunk
     *
     * @return string
     */
    public function getInputchunk()
    {
        return $this->inputchunk;
    }

    /**
     * Set finished
     *
     * @param boolean $finished
     *
     * @return MapJob
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
     * @return MapJob
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
     * Set job
     *
     * @param \AppBundle\Entity\Job $job
     *
     * @return MapJob
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
     * @return MapJob
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
