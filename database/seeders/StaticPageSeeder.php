<?php
/*
    Статические страницы

*/
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaticPage;
use App\Models\User;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::whereId(1)->first();

        $about=new StaticPage();
        $about->title='О компании';
        $about->slug='about1';
        $about->content='Описание компании';
        $about->describe='Описание компании';
        $about->in_menu=true;
        $about->user_id=$user->id;
        $about->save();

        $notShow=new StaticPage();
        $notShow->title='Простая страница';
        $notShow->slug='notout';
        $notShow->content='Не отображается Описание компании';
        $notShow->describe='Описание компании';
        $notShow->user_id=$user->id;
        $notShow->in_menu=false;
        $notShow->save();

    }
}
