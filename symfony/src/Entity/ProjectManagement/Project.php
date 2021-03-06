<?php

namespace App\Entity\ProjectManagement;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Security\User;
use App\Modules\ProjectManagement\Messenger\Commands\CreateProject;
use App\Repository\ProjectManagement\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
#[ApiResource(
    collectionOperations: [],
    graphql: [
        'create' => [
            'input' => CreateProject::class,
            'messenger' => 'input',
            'security_post_denormalize' => 'is_granted("IS_AUTHENTICATED_REMEMBERED")',
        ],
        'item_query' => [
            'security' => 'is_granted(constant("\\\App\\\Contracts\\\Security\\\Enum\\\Permission::PROJECT_VIEW_OWN"), object)',
        ],
        'collection_query' => [
            'security' => 'is_granted(constant("\\\App\\\Contracts\\\Security\\\Enum\\\Permission::PROJECT_VIEW_OWN"))',
        ],
    ],
    itemOperations: [
        'get' => [
            'security' => 'is_granted(constant("\\\App\\\Contracts\\\Security\\\Enum\\\Permission::PROJECT_VIEW_OWN"), object)',
        ],
    ]
)]
class Project
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    private function __construct()
    {
    }

    public static function create(UuidInterface $uuid, string $name): self
    {
        $self = new static();
        $self->id = $uuid;
        $self->setName($name);

        return $self;
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }
}
