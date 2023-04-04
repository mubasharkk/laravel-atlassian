<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\NoReturn;

class AddonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    const ATLASIAN_DOMAIN = 'https://marketplace.atlassian.com';

    public function toArray(Request $request): array
    {
        $embeddedData = $this->_embedded;
        return [
            'key'           => $this->key,
            'id'            => $this->id,
            'name'          => $this->name,
            'description'   => $this->summary,
            'link'          => self::atlassianUrl($this->_links->alternate->href),
            'categories'    => array_map(function ($category) {
                return $category->name;
            }, $embeddedData->categories),
            'vendor'        => [
                'name'     => $embeddedData->vendor->name,
                'programs' => [
                    'topVendorStatus' => $embeddedData->vendor->programs->topVendor,
                ],
                'link'     => self::atlassianUrl($embeddedData->vendor->_links->alternate->href),
            ],
            'status'        => $this->status,
            'logo'          => $embeddedData->logo->_links->highRes->href ?? $embeddedData->logo->_links->image->href,
            'reviews'       => $embeddedData->reviews,
            'downloads'     => $embeddedData->distribution->downloads,
            'totalInstalls' => $embeddedData->distribution->totalInstalls ?? 0,
            'totalUsers'    => $embeddedData->distribution->totalUsers ?? 0 ,
        ];
    }

    public static function atlassianUrl(string $path): string
    {
        return self::ATLASIAN_DOMAIN.$path;
    }
}
