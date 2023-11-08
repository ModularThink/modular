<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Modules\Support\Traits\EditorImage;

use function PHPUnit\Framework\assertFileExists;

uses(EditorImage::class);

beforeEach(function () {
    $this->file = UploadedFile::fake()->image('A nice file.jpg');
});

it('can upload an image to the default editor media file path', function () {
    $result = $this->uploadImage($this->file, 'original');

    expect($result)->toHaveKeys(['fileName', 'filePath', 'fileUrl', 'readableName']);
    expect($result['readableName'])->toBe('A nice file');
    assertFileExists($result['filePath']);

    (new Filesystem)->delete($result['filePath']);
});
