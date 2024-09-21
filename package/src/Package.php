<?php

namespace Nacosvel\Package;

use Composer\Autoload\ClassLoader;
use Nacosvel\Package\Contracts\PackageInterface;

class Package implements PackageInterface
{
    /**
     * The root path.
     *
     * @var string
     */
    protected string $rootPath = '';

    /**
     * The vendor path.
     *
     * @var string
     */
    protected string $vendorPath = '';

    /**
     * @param string|null $path
     *
     * @return string
     */
    public function getRootPath(string $path = null): string
    {
        if (false === is_null($path)) {
            return $this->combinePaths($this->getRootPath(), $path);
        }

        if (is_dir($this->rootPath)) {
            return $this->rootPath;
        }

        return $this->rootPath = realpath($this->getVendorPath('../'));
    }

    /**
     * @param string $rootPath
     *
     * @return static
     */
    public function setRootPath(string $rootPath): static
    {
        $this->rootPath = $rootPath;
        return $this;
    }

    /**
     * @param string|null $path
     *
     * @return string
     */
    public function getVendorPath(string $path = null): string
    {
        if (false === is_null($path)) {
            return $this->combinePaths($this->getVendorPath(), $path);
        }

        if (is_dir($this->vendorPath)) {
            return $this->vendorPath;
        }

        foreach (ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
            if (is_dir($vendorDir)) {
                $this->vendorPath = $vendorDir;
            }
        }

        return $this->vendorPath;
    }

    /**
     * @param string $vendorPath
     *
     * @return static
     */
    public function setVendorPath(string $vendorPath): static
    {
        $this->vendorPath = $vendorPath;
        return $this;
    }

    /**
     * This function will ensure that paths are properly joined without extra slashes or missing ones.
     *
     * @param string $basePath
     * @param string $relativePath
     *
     * @return string
     */
    public function combinePaths(string $basePath, string $relativePath): string
    {
        // 去除路径开头和结尾的多余斜线
        $basePath     = rtrim($basePath, '/\\');
        $relativePath = ltrim($relativePath, '/\\');

        // 使用 DIRECTORY_SEPARATOR 将两个路径连接起来
        return $basePath . DIRECTORY_SEPARATOR . $relativePath;
    }

}
