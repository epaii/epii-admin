<?php

namespace epii\composer;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;

class EpiiadminApp extends LibraryInstaller
{
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);
//        if ($this->composer->getPackage()->getType() == 'project' && $package->getInstallationSource() != 'source') {
//            //remove tests dir
//            $this->filesystem->removeDirectory($this->getInstallPath($package) . DIRECTORY_SEPARATOR . 'tests');
//        }
    }

    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {




//        if ('r/epiiadmin-composer' !== $package->getPrettyName()) {
//            throw new \InvalidArgumentException('Unable to install this library!d');
//        }

        if ($this->composer->getPackage()->getType() !== 'project') {
            throw new \InvalidArgumentException('This library must in project');
        }

        if ($package->getPrettyName()=="epii/epiiadmin-app") {


            return 'application/epiiadmin';

        }else if ($package->getPrettyName()=="epii/epiiadmin-demo")
        {


            return 'application/demo';
        }else {
            return parent::getInstallPath($package);
        }

    }

    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        parent::update($repo, $initial, $target);
        if ($this->composer->getPackage()->getType() == 'project' && $target->getInstallationSource() != 'source') {
            //remove tests dir
            $this->filesystem->removeDirectory($this->getInstallPath($target) . DIRECTORY_SEPARATOR . 'tests');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return $packageType=="epiiadmin-app" ||  $packageType=="epiiadmin-demo";
    }
}