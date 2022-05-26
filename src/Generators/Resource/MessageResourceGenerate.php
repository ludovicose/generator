<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Resource;

use Ludovicose\Generator\Generator;

final class MessageResourceGenerate extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'resource/messageResource';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'baseResource';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->getBasePath() . '/' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/' . 'MessagesResource.php';
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath(): string
    {
        return base_path();
    }
}
