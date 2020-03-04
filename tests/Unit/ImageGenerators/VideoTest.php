<?php

namespace Spatie\Medialibrary\Tests\Unit\ImageGenerators;

use Spatie\Medialibrary\Conversions\Conversion;
use Spatie\Medialibrary\ImageGenerators\FileTypes\Video;
use Spatie\Medialibrary\Tests\TestCase;

class VideoTest extends TestCase
{
    /** @test */
    public function it_can_convert_a_video()
    {
        $imageGenerator = new Video();

        if (! $imageGenerator->requirementsAreInstalled()) {
            $this->markTestSkipped('Skipping video test because requirements to run it are not met');
        }

        $media = $this->testModelWithoutMediaConversions->addMedia($this->getTestWebm())->toMediaCollection();

        $this->assertTrue($imageGenerator->canConvert($media));

        $imageFile = $imageGenerator->convert($media->getPath(), new Conversion('test'));

        $this->assertEquals('image/jpeg', mime_content_type($imageFile));

        $this->assertEquals($imageFile, str_replace('.webm', '.jpg', $media->getPath()));
    }
}
