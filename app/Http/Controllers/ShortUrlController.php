<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
            'keyword' => 'required|string|max:50|unique:short_urls,keyword',
            // 
        ]);

        $baseUrl = config('app.url');
        $shortUrl = $baseUrl . '/' . $request->keyword;

        $shortUrl = config('app.url') . '/' . $request['keyword'];

        // Simpan sementara QR image di storage
        $filename = 'qrcodes/' . Str::uuid() . '.png';
        $qrcodeImage = QrCode::format('png')->size(300)->generate($shortUrl);

        if ($qrcodeImage) {
            Storage::disk('public')->put($filename, $qrcodeImage);
        } else {
            return response()->json(['error' => 'Failed to generate QR code'], 500);
        }

        $short = ShortUrl::create([
            'original_url' => $request->original_url,
            'keyword' => $request->keyword,
            'short_url' => $shortUrl,
            'qrcode_path' => $filename,
        ]);

        return response()->json($short, 201);
    }

    public function redirect($keyword)
    {
        $short = ShortUrl::where('keyword', $keyword)->firstOrFail();
        $short->increment('clicks');
        return redirect()->to($short->original_url);
    }
}
