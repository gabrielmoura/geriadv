<?php

namespace App\Observers;

use App\Models\Calendar as Event;
use Carbon\Carbon;

class CalendarRecurrenceObserver
{
    private function format($data){
        return Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $data);
    }
    public static function created(Event $event)
    {
        if (!$event->calendar()->exists()) {
            $recurrences = [
                'daily' => [
                    'times' => 365,
                    'function' => 'addDay'
                ],
                'weekly' => [
                    'times' => 52,
                    'function' => 'addWeek'
                ],
                'monthly' => [
                    'times' => 12,
                    'function' => 'addMonth'
                ]
            ];
            $startTime = Carbon::parse($event->start_time);
            //$startTime = Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $event->start_time);
            $endTime = Carbon::parse($event->end_time);
            //$endTime = Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $event->end_time);
            $recurrence = $recurrences[$event->recurrence] ?? null;


            if ($recurrence)
                for ($i = 0; $i < $recurrence['times']; $i++) {
                    $startTime->{$recurrence['function']}();
                    $endTime->{$recurrence['function']}();
                    $event->calendars()->create([
                        'name' => $event->name,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'recurrence' => $event->recurrence,
                        'description' => $event->description,
                    ]);
                }
        }
    }

    public function updated(Event $event)
    {
        if ($event->calendars()->exists() || $event->calendar) {
            $startTime = Carbon::parse($event->getOriginal('start_time'))->diffInSeconds($event->start_time, false);
            $endTime = Carbon::parse($event->getOriginal('end_time'))->diffInSeconds($event->end_time, false);
            if ($event->calendar)
                $childEvents = $event->calendar->events()->whereDate('start_time', '>', $event->getOriginal('start_time'))->get();
            else
                $childEvents = $event->calendars;

            foreach ($childEvents as $childEvent) {
                if ($startTime)
                    $childEvent->start_time = Carbon::parse($childEvent->start_time)->addSeconds($startTime);
                if ($endTime)
                    $childEvent->end_time = Carbon::parse($childEvent->end_time)->addSeconds($endTime);
                if ($event->isDirty('name') && $childEvent->name == $event->getOriginal('name'))
                    $childEvent->name = $event->name;
                $childEvent->saveQuietly();
            }
        }

        if ($event->isDirty('recurrence') && $event->recurrence != 'none')
            self::created($event);
    }

    public function deleted(Event $event)
    {
        if ($event->calendars()->exists())
            $events = $event->calendars()->pluck('id');
        else if ($event->event)
            $events = $event->calendar->calendars()->whereDate('start_time', '>', $event->start_time)->pluck('id');
        else
            $events = [];

        Event::whereIn('id', $events)->delete();
    }
}
