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
        $faker = $this->withFaker();

        $user=User::whereId(1)->first();

        $about=new StaticPage();
        $about->title='Простая страница';
        $about->slug='about1';
        $about->content='Lorem Ipsum';
        $about->describe='Lorem Ipsum';
        $about->in_menu=true;
        $about->user_id=$user->id;
        $about->save();

        $notShow=new StaticPage();
        $notShow->title='Простая страница';
        $notShow->slug='notout';
        $notShow->content='Lorem Ipsum';
        $notShow->describe='Lorem Ipsum';
        $notShow->user_id=$user->id;
        $notShow->in_menu=false;
        $notShow->save();

    }
}
