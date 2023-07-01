<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Connection;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LogController extends Controller
{
    public function log(Request $request)
    {
        $data = [
            'client_ip' => $request->ip(),
            'connection_time' => Carbon::now(),
            'http_verb' => $request->method(),
            'endpoint_called' => $request->path(),
        ];
        Connection::create($data);
        $connections = Connection::latest()->take(25)->get();
        return response()->json($connections);
    }
}
