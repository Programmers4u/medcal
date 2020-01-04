<?php

namespace App\TG\Availability;

use App\TG\ICalChecker;
use Exception;
use Illuminate\Support\Facades\Storage;
use Timegridio\Concierge\Models\Humanresource;

class ICalSyncService
{
    protected $humanresource;

    public function humanresource(Humanresource $humanresource)
    {
        $this->humanresource = $humanresource;

        return $this;
    }

    public function sync()
    {
        if (empty($this->humanresource->calendar_link)) {
            return false;
        }

        $icalFileContents = $this->getRemoteContents();
        if(!$icalFileContents) return false;

        Storage::put(
            $this->getFilePath("calendar-{$this->humanresource->slug}.ics"),
            $icalFileContents
        );

        $this->compile($this->humanresource->slug, $icalFileContents);
    }

    public function compile($slug, &$contents)
    {
        $icalchecker = new ICalChecker();

        $icalchecker->loadString($contents);

        $events = collect($icalchecker->all());

        $events = $events->map(function ($item) use ($slug) {
            return "{$slug}:{$item->getStart()->toDateString()}";
        })->unique()->sort();

        $compiled = implode("\n", $events->values()->all());

        $this->saveCompiled($compiled);
    }

    protected function saveCompiled($contents)
    {
        return Storage::append($this->getFilePath('ical-exclusion.compiled'), $contents);
    }

    public function getLocalContents()
    {
        $humanresourceSlug = $this->humanresource->slug;

        return Storage::get($this->getFilePath("calendar-{$humanresourceSlug}.ics"));
    }

    public function getRemoteContents()
    {
        try {
            $data = file_get_contents($this->humanresource->calendar_link);
        } catch(Exception $e) {
            $data = false;
        }

        return $data ? $data : false;
    }

    protected function getFilePath($filename)
    {
        $businessId = $this->humanresource->business->id;

        return 'business'.DIRECTORY_SEPARATOR.
                $businessId.DIRECTORY_SEPARATOR.
                'ical'.DIRECTORY_SEPARATOR.
                $filename;
    }
}
