<?php

namespace Nacosvel\Package\Contracts;

interface PackageInterface
{
    /**
     * @param string|null $path
     *
     * @return string
     */
    public function getRootPath(string $path = null): string;

    /**
     * @param string $rootPath
     *
     * @return static
     */
    public function setRootPath(string $rootPath): static;

    /**
     * @param string|null $path
     *
     * @return string
     */
    public function getVendorPath(string $path = null): string;

    /**
     * @param string $vendorPath
     *
     * @return static
     */
    public function setVendorPath(string $vendorPath): static;

    /**
     * This function will ensure that paths are properly joined without extra slashes or missing ones.
     *
     * @param string $basePath
     * @param string $relativePath
     *
     * @return string
     */
    public function combinePaths(string $basePath, string $relativePath): string;

}
