<?php

namespace Tests\Unit;

use App\Helpers\FileHelper;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FileHelperTest extends TestCase
{
    /** @test */
    public function should_split_file_by_row()
    {
        $content = <<<EOT
        row0
        row1
        row2
        EOT;

        $file = UploadedFile::fake()->createWithContent('file_text.txt', $content);
        $rows = FileHelper::splitByRow($file);
        var_dump($rows);
        $this->assertStringContainsString('row1', $rows[1]);
        $this->assertCount(3, $rows);
    }
}
