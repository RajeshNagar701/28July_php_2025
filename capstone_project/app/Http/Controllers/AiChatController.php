<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        // Dynamically fetch live store context
        $categoriesText = \App\Models\Category::active()->pluck('name')->implode(', ');
        $productsContext = \App\Models\Product::active()->get(['name', 'price', 'sizes', 'colors'])->map(function($p) {
            return "- {$p->name} (Price: ₹{$p->price} | Sizes: {$p->sizes} | Colors: {$p->colors})";
        })->implode("\n");

        $systemPrompt = "You are an intelligent, friendly AI shopping assistant for 'ShoeStore', a premium footwear retailer.\n\n"
            . "### EXCLUSIVE KNOWLEDGE BASE ###\n"
            . "1. Available Categories: $categoriesText\n"
            . "2. Current Products List:\n$productsContext\n"
            . "3. Website Shopping Process: Users can browse the Shop, use sidebar filters, click on a product for details/reviews, add them to Wishlist OR Cart, and Checkout securely via Cash on Delivery or Razorpay.\n\n"
            . "### YOUR DIRECTIVES ###\n"
            . "- Answer completely based on the Knowledge Base above. Do NOT hallucinate products or prices.\n"
            . "- Keep answers helpful, warm, and concise (max 3 sentences normally, a bit more if combining product suggestions).\n"
            . "- If they ask what products you have, list 2-3 specific popular options from above with their price.\n"
            . "- If they ask about order/payment process, briefly explain the shopping process.\n\n"
            . "User message: " . $request->message;

        $apiKey = config('services.gemini.key');

        if (!$apiKey || $apiKey === 'your_gemini_api_key_here') {
            return response()->json([
                'success' => false,
                'reply' => 'Error: AI is offline. Administrator needs to configure GEMINI_API_KEY in .env.'
            ]);
        }

        try {
            $response = Http::withOptions(['verify' => false])->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemPrompt]
                        ]
                    ]
                ]
            ]);

            $result = $response->json();

            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                return response()->json([
                    'success' => true,
                    'reply' => trim($result['candidates'][0]['content']['parts'][0]['text'])
                ]);
            }

            // Expose the specific Google AI error so the user knows if their key is invalid
            if (isset($result['error']['message'])) {
                return response()->json([
                    'success' => false,
                    'reply' => 'Google API Error: ' . $result['error']['message']
                ]);
            }

            return response()->json([
                'success' => false,
                'reply' => 'Received an unexpected response format from Google AI.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Gemini Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'reply' => 'Critical connection error connecting to Google AI server.'
            ]);
        }
    }
}
