<?php

namespace App\Modules\FileManagement\Messenger\Commands;

use Elao\Enum\Bridge\Symfony\Validator\Constraint\Enum;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use App\Contracts\FileManagement\Enum\FileContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SaveFile
{
    /**
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     * @Enum(class="App\Contracts\FileManagement\Enum\FileContext", asValue=true)
     */
    private string $context;
    /**
     * @Assert\NotBlank()
     * @Assert\File(groups={"user_profile_picture"}, maxSize="10M", mimeTypes={"image/jpeg", "image/jpg", "image/png"})
     */
    private UploadedFile $file;

    public function __construct(string $context, UploadedFile $file)
    {
        $this->context = $context;
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * @return UploadedFile
     */
    public function getFile(): UploadedFile
    {
        return $this->file;
    }
}