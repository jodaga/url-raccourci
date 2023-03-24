<?php

use Illuminate\Support\Facades\Route;
use App\Models\Url ;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/' , function(){ 

    /**
     * VALIDATION DE L'URL
     * On utilise la methode make de Validator et les donnes , cles et valeur
     * dans notre cas la cle c'est l'url entrer et la valeur est $url
     */
    $url = request('url') ;

      Validator::make(
          compact('url'), ['url' => 'required | url'])->validate();



    /*verifier si l'url à deja ete raccousci si non retourner
         1 - creation de la BDD urlshortener
         2 - creation de notre model ainsi que la table urlsshortener avec php artisan make:model Url -m 
    */
    
     $record = App\Models\Url::where('url' , $url)->first();
     if($record){
        return view('result')->withShortened($record->shortened);
    }
    /**
     * generation d'un niouveau shortener et unique pour chaque shortened pour que chaque url ait un shortened unique
     * fonction laravel qui permet de generer des chaines de caracteres aleatoire
     */

    function get_unique_short_url(){
        $shortened = Str::random(5);  
        if(App\Models\Url::whereShortened($shortened)->count() != 0){
            return get_unique_short_url();
        }

        return $shortened ;
    }

    //creation d'une nouvelle url pour la renvoyer
    $row = App\Models\Url::create([
        'url' => $url,
        'shortened' => get_unique_short_url()
        //il faudra generer un nouveau shortened et s'assurere que 2 urls n'ait pas le même shortened
    ]);

    if($row){
        return view('result')->withShortened($row->shortened);
    }

}); 

Route::get('/{shortened}', function ($shortened) {
    $url = App\Models\Url::where('shortened' , $shortened)->first();

    if(! $url){
        return redirect('/');
    }else {
        return redirect($url->url);
    }
});  
















