<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="intermediatepair")
 */

class IntermediatePair 
{
	
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */ 
	protected $id;
	
    /**
     * @ORM\ManyToOne(targetEntity="Job", inversedBy="intermediatepairs")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     */
    private $job;

    /**
     * @ORM\ManyToOne(targetEntity="MapJob", inversedBy="intermediatepairs")
     * @ORM\JoinColumn(name="mapjob_id", referencedColumnName="id")
     */
    private $mapjob;
    
    /**
     * @ORM\ManyToOne(targetEntity="ReduceJob", inversedBy="intermediatepairs")
     * @ORM\JoinColumn(name="reducejob_id", referencedColumnName="id")
     */
    private $reducejob;
    
	/**
	 * @ORM\Column(type="text")
	 */ 
	protected $key="";
	
    /**
	 * @ORM\Column(type="string")
	 */ 
	protected $value = "";


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
     * Set key
     *
     * @param string $key
     *
     * @return IntermediatePair
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

    /**
     * Set value
     *
     * @param string $value
     *
     * @return IntermediatePair
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set mapjob
     *
     * @param \AppBundle\Entity\MapJob $mapjob
     *
     * @return IntermediatePair
     */
    public function setMapjob(\AppBundle\Entity\MapJob $mapjob = null)
    {
        $this->mapjob = $mapjob;

        return $this;
    }

    /**
     * Get mapjob
     *
     * @return \AppBundle\Entity\MapJob
     */
    public function getMapjob()
    {
        return $this->mapjob;
    }

    /**
     * Set reducejob
     *
     * @param \AppBundle\Entity\ReduceJob $reducejob
     *
     * @return IntermediatePair
     */
    public function setReducejob(\AppBundle\Entity\ReduceJob $reducejob = null)
    {
        $this->reducejob = $reducejob;

        return $this;
    }

    /**
     * Get reducejob
     *
     * @return \AppBundle\Entity\ReduceJob
     */
    public function getReducejob()
    {
        return $this->reducejob;
    }

    /**
     * Set job
     *
     * @param \AppBundle\Entity\Job $job
     *
     * @return IntermediatePair
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
}
