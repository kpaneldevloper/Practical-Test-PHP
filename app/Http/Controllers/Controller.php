<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        $response = Http::get('https://gnews.io/api/v4/top-headlines?country=in&language=hi&token=baa1b8f33da2a1189c7dcbf444ca6b50');
        $jsonData = $response->json();
        $html = '';
        if(isset($jsonData['articles']) && count($jsonData['articles'])){
            foreach($jsonData['articles'] as $row){
                $temp = $row['source'];
                $html .= '<div class="col">';
                $html .= '<div class="card" style="width: 18rem;">';
                $html .= '<img src="'.$row['image'].'" class="card-img-top" alt="'.$row['title'].'">';
                $html .= '<div class="card-body">';
                $html .= '<h5 class="card-title">'.$row['title'].'</h5>';
                $html .= '<p class="card-text">'.$row['description'].'</p>';
                $html .= '<a href="'.$temp['url'].'" class="btn btn-primary">'.$temp['name'].'</a>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
            }
        }
        $data['html'] = $html;
        return view('welcome',$data);
    }
}
