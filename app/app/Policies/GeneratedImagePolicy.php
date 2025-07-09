<?php

namespace App\Policies;

use App\Models\GeneratedImage;
use App\Models\User;

class GeneratedImagePolicy
{
    /**
     * Determina se o usuário pode visualizar a imagem gerada.
     */
    public function view(User $user, GeneratedImage $generatedImage)
    {
        return $user->id === $generatedImage->user_id;
    }

    /**
     * Determina se o usuário pode deletar a imagem gerada.
     */
    public function delete(User $user, GeneratedImage $generatedImage)
    {
        return $user->id === $generatedImage->user_id;
    }
}
