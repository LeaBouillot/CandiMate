<?php

namespace App\Enum;

enum JobStatus: string
{
    case A_POSTULER = 'A postuler';
    case EN_ATTENTE = 'En attente';
    case ENTRETIEN = 'Entretien';
    case REFUSE = 'Refusé';
    case ACCEPTE = 'Accepté';

    public function label(): string
    {
        return $this->value;
    }

    public static function getLabels(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_column(self::cases(), 'value')
        );
    }
}