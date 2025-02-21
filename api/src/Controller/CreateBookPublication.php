<?php

namespace App\Controller;

use App\BookPublishingHandler;
use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class CreateBookPublication extends AbstractController
{
    public function __construct(
        private BookPublishingHandler $bookPublishingHandler
    )
    {
    }

    public function __invoke(Book $book)
    {
        $this->bookPublishingHandler->handle($book);

        return $book;
    }
}
