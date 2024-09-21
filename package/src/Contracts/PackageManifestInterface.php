<?php

namespace Nacosvel\Package\Contracts;

interface PackageManifestInterface
{
    /**
     * Get the installed packages manifest.
     *
     * @param string|null $namespace
     * @param string      ...$args
     *
     * @return array|mixed|null
     */
    public function getManifest(string $namespace = null, string ...$args): mixed;

    /**
     * Get the root package manifest.
     *
     * @param string ...$args
     *
     * @return array|mixed|null
     */
    public function getPackageManifest(string ...$args): mixed;

    /**
     * If the package is being replaced or provided but is not really installed,
     * null will be returned as install path.
     * Packages of type meta-packages also have a null install path.
     *
     * @param string $packageName
     *
     * @return string|null
     */
    public function getInstallPath(string $packageName): ?string;

    /**
     * Returns a list of all package names which are present, either by being installed, replaced or provided
     *
     * @return string[]
     * @psalm-return list<string>
     */
    public function getInstalledPackages(): array;

}
