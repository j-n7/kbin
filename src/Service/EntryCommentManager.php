<?php declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Factory\EntryCommentFactory;
use PHPUnit\Framework\Assert;
use App\Entity\EntryComment;
use App\DTO\EntryCommentDto;
use App\Entity\User;

class EntryCommentManager
{
    /**
     * @var EntryCommentFactory
     */
    private $commentFactory;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntryCommentFactory $commentFactory, EntityManagerInterface $entityManager)
    {
        $this->commentFactory = $commentFactory;
        $this->entityManager  = $entityManager;
    }

    public function createComment(EntryCommentDto $commentDto, User $user): EntryComment
    {
        $comment = $this->commentFactory->createFromDto($commentDto, $user);

        $this->entityManager->persist($comment);

        return $comment;
    }

    public function editComment(EntryComment $comment, EntryCommentDto $commentDto): EntryComment
    {
        Assert::assertSame($comment->getEntry()->getId(), $commentDto->getEntry()->getId());

        $comment->setBody($commentDto->getBody());

        return $comment;
    }

    public function createCommentDto(EntryComment $comment): EntryCommentDto
    {
        return $this->commentFactory->createDto($comment);
    }
}
