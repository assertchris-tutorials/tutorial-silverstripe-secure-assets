<?php

class ScreencastPage extends Page
{
    private static $has_many = [
        "VideoFiles" => "File",
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // Add file upload to its own tab

        $upload = new UploadField("VideoFiles");
        $upload->setAllowedFileCategories("mov");
        $upload->setFolderName("secure");

        $fields->insertAfter(new Tab("VideoFiles"), "Main");
        $fields->addFieldToTab("Root.VideoFiles", $upload);

        return $fields;
    }

    public function onAfterWrite()
    {
        parent::onAfterWrite();

        /** @var Versioned $versioned */
        $versioned = $this;

        // if this screencast page is published...

        if ($versioned->latestPublished()) {
            foreach ($this->VideoFiles() as $file) {
                /** @var Folder $folder */
                $folder = Folder::find_or_make("unsecure");

                if ($folder) {
                    $file->setParentID($folder->ID);
                    $file->write();
                }
            }
        }
    }
}
