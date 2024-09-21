<?php

namespace Nacosvel\Package;

use Composer\InstalledVersions;
use Nacosvel\Package\Contracts\PackageManifestInterface;
use OutOfBoundsException;

class PackageManifest extends Package implements PackageManifestInterface
{
    /**
     * The loaded manifest array.
     *
     * @var array
     */
    protected array $manifest = [];

    /**
     * Get the installed packages manifest.
     *
     * @param string|null $namespace
     * @param string      ...$args
     *
     * @return array|mixed|null
     */
    public function getManifest(string $namespace = null, string ...$args): mixed
    {
        if ($args) {
            $package = $this->getManifest($namespace);
            foreach ($args as $arg) {
                $package = $package[$arg] ?? [];
            }
            return $package === [] ? null : $package;
        }

        if (false === is_null($namespace)) {
            $manifest = $this->getManifest();
            foreach ($manifest['packages'] ?? [] as $package) {
                if ($package['name'] === $namespace) {
                    return $package;
                }
            }
            return [];
        }

        if ($this->manifest) {
            return $this->manifest;
        }

        $installed = $this->getVendorPath('/composer/installed.json');

        if (is_file($installed)) {
            $this->manifest = json_decode(file_get_contents($installed), true) ?? [];
        }

        return $this->manifest;
    }

    /**
     * Get the root package manifest.
     *
     * @param string ...$args
     *
     * @return array|mixed|null
     */
    public function getPackageManifest(string ...$args): mixed
    {
        if ($args) {
            $package = $this->getPackageManifest();
            foreach ($args as $arg) {
                $package = $package[$arg] ?? [];
            }
            return $package === [] ? null : $package;
        }

        if (!is_file($path = $this->getRootPath('/composer.json'))) {
            return [];
        }

        return json_decode(file_get_contents($path), true) ?? [];
    }

    /**
     * If the package is being replaced or provided but is not really installed,
     * null will be returned as install path.
     * Packages of type meta-packages also have a null install path.
     *
     * @param string $packageName
     *
     * @return string|null
     */
    public function getInstallPath(string $packageName): ?string
    {
        try {
            return ($installPath = InstalledVersions::getInstallPath($packageName)) ? realpath($installPath) : null;
        } catch (OutOfBoundsException $exception) {
            return null;
        }
    }

    /**
     * Returns a list of all package names which are present, either by being installed, replaced or provided
     *
     * @return string[]
     * @psalm-return list<string>
     */
    public function getInstalledPackages(): array
    {
        return InstalledVersions::getInstalledPackages();
    }

}
