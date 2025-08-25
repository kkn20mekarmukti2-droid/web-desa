<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\artikelModel;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use App\Models\NotificationToken;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\WebPushConfig;

class NotificationTokenController extends Controller
{
    protected $messaging;

    public function __construct()
    {
        $firebaseCredentials = config('firebase.projects.app.credentials');
        $factory = (new Factory)->withServiceAccount($firebaseCredentials);
        $this->messaging = $factory->createMessaging();
    }

    public function saveToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);
        if (NotificationToken::where('token', $request->token)->doesntExist()) {
            NotificationToken::create([
                'token' => $request->token
            ]);
        }

        return response()->json(['message' => 'Token saved successfully']);
    }

    public function sendPushNotification(Request $request)
    {
        $tokens = NotificationToken::all()->pluck('token')->toArray();
        $artikel = artikelModel::findOrFail($request->input('id'));
        $sampul = '';
        if (strpos($artikel->sampul, 'youtube')) {
            $youtubeUrl = $artikel->sampul;
            preg_match('/embed\/([^\?]*)/', $youtubeUrl, $matches);
            $thumbnail = $matches[1] ?? null;
            $sampul = "https://img.youtube.com/vi/{$thumbnail}/hqdefault.jpg";
        } else {
            $sampul = asset('img/' . $artikel->sampul);
        }
        $pesan = [
            'notification' => [
                'judul' => $artikel->judul,
                'header' => $artikel->header,
                'sampul' => $sampul,
            ],
            'data' => [
                'link' => route('detailartikel',['judul'=>Str::slug($artikel->judul,'-'),'tanggal'=>$artikel->created_at->format('Y-m-d')]) ,
            ],
        ];

        $notification = Notification::create($pesan['notification']['judul'], $pesan['notification']['header'], $pesan['notification']['sampul']);


        $successCount = 0;
        $failureCount = 0;
        $errors = [];

        foreach ($tokens as $token) {
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification($notification)
                ->withData($pesan['data']);

            try {
                $this->messaging->send($message);
                $successCount++;
            } catch (\Exception $e) {
                $failureCount++;
                $errors[] = $e->getMessage();
            }
        }

        return response()->json([
            'message' => 'Notification processing completed',
            'success' => $successCount,
            'failure' => $failureCount,
            'errors' => $errors
        ]);
    }
}
