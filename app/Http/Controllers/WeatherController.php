<?php

namespace App\Http\Controllers;

use App\Services\Weather;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;

class WeatherController extends BaseController
{
    use ValidatesRequests;

    protected $client;

    public function __construct(Weather $client) {
        $this->client = $client;
    }

    public function index(Request $request) {
        $view = view('welcome');

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'date' => 'required|date'
            ]);

            $byDateResponse = $this->client->send('getByDate', $request->input());

            $result = $byDateResponse['result'] ?? null;
            $error  = $byDateResponse['error'] ?? null;

            if (null !== $error) {
                $errors = new MessageBag();

                foreach ($error['data'] as $key => $messages) {
                    $errors->add($key, $messages[0]);
                }
                $view->with('errors', $errors);
            }

            $view->with('result', $result);
            $view->with('post', $request->post());
        }

        $historyResponse = $this->client->send('getHistory', ['lastDays' => 30]);

        $view->with('history', $historyResponse['result']);

        return $view;
    }
}
