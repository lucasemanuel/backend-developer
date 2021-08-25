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
        $this->assertStringContainsString('row1', $rows[1]);
        $this->assertCount(3, $rows);
    }

    /** @test */
    public function should_split_string_by_sizes()
    {
        $string = 'anybigstring';
        $terms = FileHelper::splitBySizes($string, [3, 3, 6]);
        $this->assertEquals('any', $terms[0]);
        $this->assertEquals('big', $terms[1]);
        $this->assertEquals('string', $terms[2]);

        $string = '12320201012000011132703Comprador 1         06050190';
        $terms = FileHelper::splitBySizes($string);
        $this->assertEquals('123', $terms[0]);
        $this->assertEquals('20201012', $terms[1]);
        $this->assertEquals('0000111327', $terms[2]);
        $this->assertEquals('03', $terms[3]);
        $this->assertEquals('Comprador 1         ', $terms[4]);
        $this->assertEquals('06050190', $terms[5]);
    }
}
