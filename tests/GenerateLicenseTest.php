<?php
namespace Aheenam\LaravelPackageCli\Test;

use PHPUnit\Framework\TestCase;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Memory\MemoryAdapter;
use Aheenam\LaravelPackageCli\PackageGenerator;
use Spatie\Snapshots\MatchesSnapshots;
use Carbon\Carbon;

class GenerateLicenseTest extends TestCase
{
    use MatchesSnapshots;

    protected function setUp()
    {
        (new Filesystem(new Local(__DIR__ . './../')))
            ->deleteDir('dummy-package');
    }

    /** @test */
    public function it_generates_empty_file_if_no_option_set()
    {
        $filesystem = new Filesystem(new MemoryAdapter);

        (new PackageGenerator($filesystem, './', 'dummy/dummy-package'))
            ->generate();

        $this->assertTrue($filesystem->has('/dummy-package'));
        $this->assertTrue($filesystem->has('/dummy-package/LICENSE'));
        $this->assertMatchesSnapshot($filesystem->read('/dummy-package/LICENSE'));
    }

    /** @test */
    public function it_creates_mit_license()
    {
        $filesystem = new Filesystem(new MemoryAdapter);
        Carbon::setTestNow(Carbon::create(2002, 5, 21, 12));

        (new PackageGenerator($filesystem, './', 'dummy/dummy-package', ['license' => 'MIT']))
            ->generateLicense();

        $this->assertTrue($filesystem->has('/dummy-package/LICENSE'));
        
        $licenseContent = $filesystem->read('/dummy-package/LICENSE');
        $this->assertMatchesSnapshot($licenseContent);
        $this->assertContains('Copyright (c) 2002 Dummy', $licenseContent);
    }

    /** @test */
    public function it_creates_apache_2_0_license()
    {
        $filesystem = new Filesystem(new MemoryAdapter);
        Carbon::setTestNow(Carbon::create(2002, 5, 21, 12));

        (new PackageGenerator($filesystem, './', 'dummy/dummy-package', ['license' => 'Apache 2.0']))
            ->generateLicense();

        $this->assertTrue($filesystem->has('/dummy-package/LICENSE'));
        
        $licenseContent = $filesystem->read('/dummy-package/LICENSE');
        $this->assertMatchesSnapshot($licenseContent);
    }

    /** @test */
    public function it_creates_gnu_gpl_v_3_license()
    {
        $filesystem = new Filesystem(new MemoryAdapter);
        Carbon::setTestNow(Carbon::create(2002, 5, 21, 12));

        (new PackageGenerator($filesystem, './', 'dummy/dummy-package', ['license' => 'GNU GPL v3']))
            ->generateLicense();

        $this->assertTrue($filesystem->has('/dummy-package/LICENSE'));
        
        $licenseContent = $filesystem->read('/dummy-package/LICENSE');
        $this->assertMatchesSnapshot($licenseContent);
    }
}
