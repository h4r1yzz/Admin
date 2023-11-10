<?php

namespace App\Http\Controllers\LiveStreaming;

use Illuminate\Http\Request;
use App\Models\Events; // Make sure to use the correct mode
use Hashids\Hashids;
use Carbon\Carbon;
use App\Http\Requests\StoreContestRequest;


class StoreContestController
{
    public function store(StoreContestRequest $request)
    {
        // Validate and store the input data in the MongoDB database
        $uniqueContestId = $this->generateUniqueContestId();
        $validatedData = $request->validated();
        $validatedData = $this->removeNullValues($validatedData);

        // Check if a record with the same title already exists
        $existingContest = Events::where('title', $validatedData['title'])->first();

        if ($existingContest) {
            // If a contest with the same title exists, return a validation error with input data
            return redirect()->route('contests.create')
                ->withErrors(['title' => 'The title already exists. Please choose a different title.'])
                ->withInput();
        }

        $prefix = 'https://sugarbook.me/live-streaming/contests/';
        $title = $validatedData['title'];
        $url = $prefix . str_replace(' ', '-', strtolower($title));
        $validatedData['url'] = $url;


        $validatedData['contest_id'] = $uniqueContestId;

        $validatedData['sorting'] = null;
        $validatedData['is_countdown_required'] = true;
        $validatedData['auto_enrollment'] = 1;

        // Generate title_locale based on title
        $title = $validatedData['title'];
        $title_locale = 'contest.title.' . str_replace(' ', '', strtolower($title));
        $validatedData['title_locale'] = $title_locale;
        
        $validatedData['is_countdown_required'] = (bool)$validatedData['is_countdown_required'];
        $validatedData['contest_start_at'] = new \MongoDB\BSON\UTCDateTime(Carbon::parse($request->contest_start_at));
        $validatedData['contest_end_at'] = new \MongoDB\BSON\UTCDateTime(Carbon::parse($request->contest_end_at));
        $validatedData['contest_display_start_at'] = new \MongoDB\BSON\UTCDateTime(Carbon::parse($request->contest_display_start_at));
        $validatedData['contest_display_end_at'] = new \MongoDB\BSON\UTCDateTime(Carbon::parse($request->contest_display_end_at));

        // Initialize an empty array for "gifterGraphics" and "streamerGraphics"
        $gifterGraphics = [];
        $streamerGraphics = [];
        $streamerGraphicsTier1 = [];
        $streamerGraphicsTier2 = [];
        $floatingGifterGraphics = [];
        $floatingStreamerGraphics = [];
        $coinGraphics = [];
        // Loop through the form input to create the "gifterGraphics" and "streamerGraphics" arrays
        $gifterGraphicsInput = $request->input('gifterGraphics');
        $streamerGraphicsInputs = [
            'streamerGraphics' => $request->input('streamerGraphics'),
            'streamerGraphicsTier1' => $request->input('streamerGraphicsTier1'),
            'streamerGraphicsTier2' => $request->input('streamerGraphicsTier2'),
        ];
        $floatingGifterGraphicsInput = $request->input('floatingGifterGraphics');
        $floatingStreamerGraphicsInput = $request->input('floatingStreamerGraphics');
        $coinGraphicsInput = $request->input('coinGraphics');


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
                $currentGifterGraphic = array_filter($currentGifterGraphic, function ($value) {
                    return !is_null($value);
                });

                $gifterGraphics[] = $currentGifterGraphic;
            }
        }

        //STREAMERS MAIN , TIER1, TIER2
                $tiers = [null, 1, 2]; // Define the tiers

        foreach ($tiers as $tier) {
            $key = 'streamerGraphics' . ($tier !== null ? 'Tier' . $tier : ''); // Build the key

            if (!isset($streamerGraphicsInputs[$key])) {
                continue; // Skip if the input data doesn't exist
            }

            foreach ($streamerGraphicsInputs[$key] as $index => $graphicData) {
                // Handle file upload and store the file path
                $assetUrl = $this->uploadFileAndGetPath($request, "$key.$index.asset_url");

                // Initialize an empty array for the current streamer graphic
                $currentStreamerGraphic = [
                    'type' => 'leaderboard_banner',
                    'asset_url' => $assetUrl,
                    'reference' => 'live_contest_lv_banner_1',
                    'url' => $url,
                    'targeted_audiences' => 'streamers',
                    'is_countdown_required' => (bool) ($graphicData['is_countdown_required'] ?? true),
                    'title_font_color' => $graphicData['title_font_color'],
                    'countdown_font_color' => $graphicData['countdown_font_color'],
                    'cta' => 'leaderboard',
                ];

                if ($tier !== null) {
                    $currentStreamerGraphic['tier'] = $tier; // Set the tier if it's not null
                }

                // Filter out null values from the graphic array
                $currentStreamerGraphic = array_filter($currentStreamerGraphic, function ($value) {
                    return !is_null($value);
                });

                ${"streamerGraphics" . ($tier !== null ? "Tier" . $tier : "")}[] = $currentStreamerGraphic;
            }
        }

        //FLOATING GIFTER AND STREAMER
        foreach (['viewers' => $floatingGifterGraphicsInput, 'streamers' => $floatingStreamerGraphicsInput] as $targetAudience => $graphicsInput) {
            $graphics = [];
        
            foreach ($graphicsInput as $index => $graphicData) {
                // Handle file upload and store the file path
                $assetUrl = $this->uploadFileAndGetPath($request, "floating{$targetAudience}Graphics.$index.asset_url");
        
                // Initialize an empty array for the current graphic
                $currentGraphic = [
                    'type' => 'player_floating_banner',
                    'asset_url' => $assetUrl,
                    'targeted_audiences' => $targetAudience,
                    'is_countdown_required' => (bool) ($graphicData['is_countdown_required'] ?? true),
                    'text' => $graphicData['text'],
                    'title_font_color' => $graphicData['title_font_color'],
                    'countdown_font_color' => $graphicData['countdown_font_color'],
                    'template' => $graphicData['template'],
                    'cta' => 'mini_leaderboard',
                ];
        
                // Filter out null values from the graphic array
                $currentGraphic = array_filter($currentGraphic, function ($value) {
                    return !is_null($value);
                });
        
                $graphics[] = $currentGraphic;
            }
        
            // Append the graphics to the respective array
            if ($targetAudience === 'viewers') {
                $floatingGifterGraphics = $graphics;
            } elseif ($targetAudience === 'streamers') {
                $floatingStreamerGraphics = $graphics;
            }
        }

        foreach ($coinGraphicsInput as $index => $graphicData) {
            // Handle file upload and store the file path
            $assetUrl = $this->uploadFileAndGetPath($request, "coinGraphics.$index.asset_url");

            // Initialize an empty array for the current streamer graphic
            $currentCoinGraphic = [
                'type' => 'coins_contest_banner',
                'asset_url' => $assetUrl,
                'targeted_audiences' => 'all',
                'is_countdown_required' => (bool) ($graphicData['is_countdown_required'] ?? true),
            ];

            // Filter out null values from the graphic array
            $currentCoinGraphic = array_filter($currentCoinGraphic, function ($value) {
                return !is_null($value);
            });

            $coinGraphics[] = $currentCoinGraphic;
        }

        $validatedData['graphics'] = array_merge($gifterGraphics,$streamerGraphics,$streamerGraphicsTier1,$streamerGraphicsTier2,$floatingStreamerGraphics,$floatingGifterGraphics,$coinGraphics);

        //GIFTS
        // Initialize an empty array for "gifts_bounded"
        $giftsBounded = [];

        // Loop through the form input to create the "gifts_bounded" array
        $giftsInput = $request->input('gifts_bounded');
        foreach ($giftsInput as $gift) {
            // Initialize an empty array for the current gift
            if (isset($gift['id'], $gift['pricing_id'])){
            $currentGift = [
                'id' => $gift['id'],
                'pricing_id' => $gift['pricing_id'],
            ];

            // Remove null values from the current gift
            $currentGift = array_filter($currentGift, function ($value) {
                return $value !== null;
            });

            // Add the current gift to the "gifts_bounded" array if it's not empty
            if (!empty($currentGift)) {
                $giftsBounded[] = $currentGift;
            }
            }
        }

        // Add the "gifts_bounded" array to the $validatedData
        $validatedData['gifts_bounded'] = $giftsBounded;

        $newContest = Events::create($validatedData);
        return response()->json(["result" => "ok"], 201);
    
    }

    private function uploadFileAndGetPath($request, $fieldName)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Store the file in the 'public/uploads' directory
            $storedPath = $file->storeAs('public/uploads', $fileName);
            
            if ($storedPath) {
                // If the file was stored successfully, return its public URL
                return asset('storage/' . str_replace('public/', '', $storedPath));
            } else {
                // Handle the error if the file couldn't be stored
                return null;
            }
        }

        return null; // Return null if no file was uploaded
    }



    private function removeNullValues($data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->removeNullValues($value);
                if (empty($data[$key])) {
                    unset($data[$key]);
                }
            } elseif ($value === null && $key !== 'sorting') {
                unset($data[$key]);
            }
        }

        return $data;
    }

    private function generateUniqueContestId()
    {
        // Generate a unique "contest_id" with a maximum length of 12 characters
        $hashids = new Hashids('your_salt_here', 12); // Adjust the salt and min length as needed

        // Create a unique "contest_id" based on the current timestamp
        $uniqueContestId = $hashids->encode(time());

        // Check if the "contest_id" already exists in the database and generate a new one if it does
        while (Events::where('contest_id', $uniqueContestId)->exists()) {
            $uniqueContestId = $hashids->encode(time() + rand(10000, 99999)); // Add randomness
        }

        return $uniqueContestId;
    }
}
?>