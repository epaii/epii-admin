<?php

namespace epii\composer;

use Composer\Composer;

use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;


class Plugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        $manager = $composer->getInstallationManager();

        //框架核心
        $manager->addInstaller(new EpiiadminApp($io, $composer));


    }
}