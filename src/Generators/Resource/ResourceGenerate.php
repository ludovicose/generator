<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Resource;

use Ludovicose\Generator\Generator;

final class ResourceGenerate extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'resource/resource';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'resource';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . $this->getName() . 'Resource.php';
    }

    public function getReplacements(): array
    {
        return array_merge(parent::getReplacements(), [
            'template'        => $this->getFieldsTemplate(),
            'commentTemplate' => $this->getFieldsCommentTemplate(),
        ]);
    }


    protected function getFieldsTemplate(): string
    {
        $resource = '';

        foreach ($this->fields as $field) {
            $resource .= "\t\t\t'{$field[1]}' => \$this->{$field[1]},\n";
        }

        return $resource;
    }

    protected function getFieldsCommentTemplate(): string
    {
        $rules = '';

        if (empty($this->fields)) {
            return '
 *     @OA\Property(
 *         property="",
 *         type="",
 *         description=""
 *     ),';
        }

        foreach ($this->fields as $field) {
            $rules .= '
 *     @OA\Property(
 *         property="' . $field[1] . '",
 *         type="' . $field[0] . '",
 *         description=""
 *     ),';
        }

        return $rules;
    }
}
