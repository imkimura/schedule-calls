<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class MeetingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'subject' => $this->resource->subject,
            'link' => $this->resource->link,
            'description' => $this->resource->description,
            'time_start' => $this->isValidDateTime($this->resource->meeting_start) ? $this->parseDateTime($this->resource->meeting_start) : null,
            'time_end' => $this->isValidDateTime($this->resource->meeting_end) ? $this->parseDateTime($this->resource->meeting_end) : null,
            'participants' => CustomerResource::collection($this->resource->participants)
        ];
    }

    /**
     * Verifica se a string é uma data/hora válida.
     *
     * @param mixed $dateTime
     * @return bool
     */
    private function isValidDateTime($dateTime): bool
    {
        return !empty($dateTime) && strtotime($dateTime) !== false;
    }

    /**
     * Converte uma string de data/hora para o formato 'd/m/Y H:i'.
     *
     * @param string $dateTime
     * @return string
     */
    private function parseDateTime(string $dateTime): string
    {
        return Carbon::parse($dateTime)->format('d/m/Y H:i');
    }
}
