<?php
namespace Aheenam\LaravelPackageCli\Test;
use PHPUnit\Framework\TestCase;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Memory\MemoryAdapter;
use Aheenam\LaravelPackageCli\PackageGenerator;
use Spatie\Snapshots\MatchesSnapshots;

class GenerateLicenseTest extends TestCase
{

    use MatchesSnapshots;

    protected function setUp()
    {
        (new Filesystem(new Local(__DIR__ . './../')))
            ->deleteDir('dummy-package');
    }

    /** @test */
    public function it_generates_empty_file_if_no_option_set ()
    {
        $filesystem = new Filesystem(new MemoryAdapter);

        (new PackageGenerator($filesystem, './', 'dummy/dummy-package'))
            ->generate();

        $this->assertTrue($filesystem->has('/dummy-package'));
        $this->assertTrue($filesystem->has('/dummy-package/LICENSE'));
        $this->assertMatchesSnapshot($filesystem->read('/dummy-package/LICENSE'));
    }
}