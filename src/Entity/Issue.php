<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IssueRepository")
 */
class Issue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $startedBy;

    /**
     * @ORM\Column(type="boolean", options={"default" : 1})
     */
    private $openStatus;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Label", inversedBy="issues")
     */
    private $labels;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="issue", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"date" = "ASC"})
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->labels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->date = $Date;

        return $this;
    }

    public function getStartedBy(): ?string
    {
        return $this->startedBy;
    }

    public function setStartedBy(string $user): self
    {
        $this->startedBy = $user;

        return $this;
    }

    public function getOpenStatus(): ?bool
    {
        return $this->openStatus;
    }

    public function setOpenStatus(bool $status): self
    {
        $this->openStatus = $status;

        return $this;
    }

    /**
     * @return Collection|Label[]
     */
    public function getLabels(): Collection
    {
        return $this->labels;
    }

    public function addLabels(Label $label): self
    {
        if (!$this->labels->contains($label)) {
            $this->labels[] = $label;
        }

        return $this;
    }

    public function removeLabel(Label $label): self
    {
        if ($this->label->contains($label)) {
            $this->label->removeElement($label);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setIssue($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getIssue() === $this) {
                $comment->setIssue(null);
            }
        }

        return $this;
    }
}
