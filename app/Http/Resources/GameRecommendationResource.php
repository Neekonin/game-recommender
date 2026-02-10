<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameRecommendationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'score' => $this['score'],
            'game' => [
                'id' => $this['game']->id,
                'name' => $this['game']->name,
                'cover_image' => $this['game']->cover_image,
                'rating' => $this['game']->rating,
                'metacritic' => $this['game']->metacritic,
            ],
        ];
    }
}
