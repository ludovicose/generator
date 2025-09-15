<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Controller;

use Illuminate\Support\Str;
use Ludovicose\Generator\Generator;

final class ControllerGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'controller/controller';


    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'controllers';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . $this->getControllerName() . 'Controller.php';
    }


    /**
     * Gets controller name based on model
     *
     * @return string
     */
    public function getControllerName(): string
    {
        return ucfirst($this->getPluralName());
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements(): array
    {
        return array_merge(parent::getReplacements(), [
            'controller'      => $this->getControllerName(),
            'plural'          => $this->getPluralName(),
            'singular'        => $this->getSingularName(),
            'appname'         => $this->getRootNamespace(),
            'api'             => Str::lower($this->getName()),
            'tag'             => $this->getModule(),
            'commentTemplate' => $this->getFieldsCommentTemplate(),
        ]);
    }

    protected function getFieldsCommentTemplate(): string
    {
        $rules = '';

        if (empty($this->fields)) {
            return '
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Название",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *         )
     *    ),';
        }

        foreach ($this->fields as $field) {
            $rules .= '
     *     @OA\Parameter(
     *         name="'. $field[1].'",
     *         in="query",
     *         description="",
     *         required=false,
     *         @OA\Schema(
     *             type="'. $field[0].'",
     *         )
     *    ),';
        }

        return $rules;
    }
}
