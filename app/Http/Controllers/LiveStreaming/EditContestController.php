<?php

namespace App\Http\Controllers\LiveStreaming;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Http\Requests\StoreContestRequest;
use Carbon\Carbon;


class EditContestController
{

    public function edit($id)
    {
        $event = Events::find($id);

        if (!$event) {
            return redirect()->route('contests.post')->with('error', 'Contest not found');
        }

        return view('contests.edit', compact('event'));
    }

    public function update(StoreContestRequest $request, $id)
    {
        $event = Events::find($id);

        if (!$event) {
            return redirect()->route('contests.post')->with('error', 'Contest not found');
        }

        // Generate title_locale based on title
        $title = $event->title;
        $title_locale = 'contest.title.' . str_replace(' ', '', strtolower($title));
        $event->title_locale = $title_locale;

        // Format date-time fields
        $event->contest_start_at = new \MongoDB\BSON\UTCDateTime(Carbon::parse($request->contest_start_at));
        $event->contest_end_at = new \MongoDB\BSON\UTCDateTime(Carbon::parse($request->contest_end_at));
        $event->contest_display_start_at = new \MongoDB\BSON\UTCDateTime(Carbon::parse($request->contest_display_start_at));
        $event->contest_display_end_at = new \MongoDB\BSON\UTCDateTime(Carbon::parse($request->contest_display_end_at));

        // Convert is_countdown_required to a boolean
        $event->is_countdown_required = (bool)$event->is_countdown_required;    
        
    
         // Handle the "graphics" array similar to the StoreContestController
         $gifterGraphics = [];

         $gifterGraphicsInput = $request->input('gifterGraphics');

         
         //GRAPHICS MAIN
        for ($i = 0; $i < 3; $i++) {
            // Gifter Graphics
            foreach ($gifterGraphicsInput as $index => $graphicData) {
                // Handle file upload and store the file path
                $assetUrl = $this->uploadFileAndGetPath($request, "gifterGraphics.$index.asset_url");

                // Initialize an empty array for the current gifter graphic
                $currentGifterGraphic = [
                    'type' => 'leaderboard_banner',
                    'asset_url' => $assetUrl,
                    'reference' => 'live_contest_lv_banner_1',
                    'url' => $url,
                    'targeted_audiences' => 'viewers',
                    'is_countdown_required' => (bool) ($graphicData['is_countdown_required'] ?? true),
                    'countdown_font_color' => $graphicData['countdown_font_color'],
                    'title_font_color' => $graphicData['title_font_color'],
                    'cta' => 'leaderboard',
                ];

                // Set tier only for tiers greater than 0
                if ($i > 0) {
                    $currentGifterGraphic['tier'] = $i;
                }

                if (!preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $currentGifterGraphic['countdown_font_color']) || 
                    !preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $currentGifterGraphic['title_font_color'])) {

                    return redirect()
                      ->back()
                      ->withInput()
                      ->withErrors(['color' => 'The color format is invalid for Gifter Graphics']);
                  
                }
                $currentGifterGraphic = array_filter($currentGifterGraphic, function ($value) {
                    return !is_null($value);
                });

                $gifterGraphics[] = $currentGifterGraphic;
            }
        }
        dd($graphics);
         // Update the "graphics" array in the event
         $event->graphics = $graphics;

         
         
          // Handle the "gifts_bounded" array similar to the StoreContestController
          $giftsBounded = [];

          $giftsInput = $request->input('gifts_bounded');
          
          if (is_array($giftsInput)) {
              foreach ($giftsInput as $gift) {
                  $giftsBounded[] = [
                      'id' => $gift['id'],
                      'pricing_id' => $gift['pricing_id'],
                  ];
              }
          } else {
              // Handle the case where $giftsInput is not an array, e.g., it's null
              // You can decide how to handle this situation, e.g., set $giftsBounded to an empty array or handle it differently.
              $giftsBounded = [];
          }
          
          // Update the "gifts_bounded" array in the event
          $event->gifts_bounded = $giftsBounded;
          

        $event->save(); 
        //$event->update($request->all());
        return redirect()->route('contests.post')->with('success', 'Contest updated successfully');
    }

    
    private function uploadFileAndGetPath($request, $fieldName)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName); // Save the file to the 'uploads' directory

            return '/uploads/' . $fileName; // Store the file path in the database
        }

        return null; // Return null if no file was uploaded
    }
    
}

