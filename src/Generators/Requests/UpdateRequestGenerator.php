<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Requests;

use Ludovicose\Generator\Generator;

final class UpdateRequestGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'requests/update';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'request';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . 'Update' . $this->getName() . 'Request.php';
    }

    public function getReplacements(): array
    {

        return array_merge(parent::getReplacements(), [
            'template' => $this->getFieldsTemplate(),
            'commentTemplate' => $this->getFieldsCommentTemplate(),
        ]);
    }

    protected function getFieldsTemplate(): string
    {
        $rules = '';

        foreach ($this->fields as $field) {
            $rules .= "\t\t\t'{$field[1]}' => 'required|{$field[0]}',\n";
        }

        return $rules;
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
