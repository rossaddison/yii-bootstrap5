<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Html\Tag\Img;
use Yiisoft\Yii\Bootstrap5\CarouselItem;

/**
 * Tests for `CarouselItem`.
 *
 * @group carousel
 */
final class CarouselItemTest extends \PHPUnit\Framework\TestCase
{
    public function testGetAttributes(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            attributes: ['class' => 'test'],
        );

        $this->assertSame(['class' => 'test'], $carouselItem->getAttributes());
    }

    public function testGetAutoPlayingInterval(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            autoPlayingInterval: 5000,
        );

        $this->assertSame(5000, $carouselItem->getAutoPlayingInterval());
    }

    public function testGetCaption(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            '<strong>First slide</strong>',
        );

        $this->assertSame('&lt;strong&gt;First slide&lt;/strong&gt;', $carouselItem->getCaption());
    }

    public function testGetCaptionAttributes(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            captionAttributes: ['class' => 'test'],
        );

        $this->assertSame(['class' => 'test'], $carouselItem->getCaptionAttributes());
    }

    public function testGetCaptionEncodeWithFalse(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            caption: '<strong>First slide</strong>',
            encodeCaption: false,
        );

        $this->assertSame('<strong>First slide</strong>', $carouselItem->getCaption());
    }

    public function testGetCaptionPlaceholder(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            captionPlaceholder: '<strong>Some representative placeholder content for the first slide.</strong>',
        );

        $this->assertSame(
            '&lt;strong&gt;Some representative placeholder content for the first slide.&lt;/strong&gt;',
            $carouselItem->getCaptionPlaceholder(),
        );
    }

    public function testGetCaptionPlaceholderAttributes(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            captionPlaceholderAttributes: ['class' => 'test'],
        );

        $this->assertSame(['class' => 'test'], $carouselItem->getCaptionPlaceholderAttributes());
    }

    public function testGetCaptionPlaceholderEncodeWithFalse(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            captionPlaceholder: '<strong>Some representative placeholder content for the first slide.</strong>',
            encodeCaptionPlaceholder: false,
        );

        $this->assertSame(
            '<strong>Some representative placeholder content for the first slide.</strong>',
            $carouselItem->getCaptionPlaceholder(),
        );
    }

    public function testGetContent(): void
    {
        $image = Img::tag()->alt('First slide')->src('image-1.jpg');
        $carouselItem = new CarouselItem($image);

        $this->assertSame($image, $carouselItem->getContent());
    }

    public function testGetContentWithStringable(): void
    {
        $carouselItem = new CarouselItem(
            new class () implements \Stringable {
                public function __toString(): string
                {
                    return 'First slide';
                }
            },
        );

        $this->assertSame('First slide', (string) $carouselItem->getContent());
    }

    public function testIsActive(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            active: true,
        );

        $this->assertTrue($carouselItem->isActive());
    }
}
