<?php

namespace App\Services;

use App\Models\Book;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapService
{
    public function generateXml(): string
    {
        return $this->buildSitemap()->render();
    }

    public function writeToFile(string $absolutePath): void
    {
        $this->buildSitemap()->writeToFile($absolutePath);
    }

    private function buildSitemap(): Sitemap
    {
        $now = now();

        $sitemap = Sitemap::create()
            ->add(Url::create(url('/'))->setLastModificationDate($now))
            ->add(Url::create(url('/books'))->setLastModificationDate($now))
            ->add(Url::create(url('/about'))->setLastModificationDate($now))
            ->add(Url::create(url('/collaboration-books'))->setLastModificationDate($now))
            ->add(Url::create(url('/publications'))->setLastModificationDate($now));

        try {
            $publishedBooks = Book::where('status', Book::STATUS_PUBLISHED)
                ->select(['slug', 'updated_at'])
                ->cursor();

            foreach ($publishedBooks as $book) {
                $sitemap->add(
                    Url::create(url('/books/'.$book->slug))
                        ->setLastModificationDate($book->updated_at ?? $now)
                );
            }
        } catch (\Throwable) {
        }

        try {
            $collabBooks = Book::whereIn('status', [Book::STATUS_OPEN, Book::STATUS_EDITING])
                ->select(['slug', 'updated_at'])
                ->cursor();

            foreach ($collabBooks as $book) {
                $sitemap->add(
                    Url::create(url('/collaboration-books/'.$book->slug))
                        ->setLastModificationDate($book->updated_at ?? $now)
                );
            }
        } catch (\Throwable) {
        }

        return $sitemap;
    }
}
