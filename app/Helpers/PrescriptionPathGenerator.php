<?php

namespace App\Helpers;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

/**
 * Class PrescriptionPathGenerator
 * @package App\Helpers
 */
class PrescriptionPathGenerator implements PathGenerator
{

    /**
     * Get a unique base path for the given media.
     * @return string
     */
    protected function getBasePath(): string
    {
        return 'plasma/prescriptions';
    }

    /**
     * @param \Spatie\MediaLibrary\Models\Media $media
     *
     * @return string
     */
    public function getPath(Media $media): string
    {
        return $this->getBasePath() . '/';
    }

    /**
     * @param \Spatie\MediaLibrary\Models\Media $media
     *
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath() . '/conversions/';
    }

    /**
     * @param \Spatie\MediaLibrary\Models\Media $media
     *
     * @return string
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath() . '/responsive-images/';
    }
}