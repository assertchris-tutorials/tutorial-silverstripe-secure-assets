<?php

class VideoFileExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $has_one = [
        "ScreencastPage" => "ScreencastPage",
    ];
}
