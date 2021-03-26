<?php
/*
    Контроллер отзывов
    пользователя о товарах

*/
namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ShopProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShopReviewCreateRequest;
use App\Http\Requests\ShopReviewUpdateRequest;
use App\Http\Repositories\ReviewRepository;

class ShopReviewController extends Controller
{

    //Репозиторий Отзывов
    private $repository;

    public function __construct()
    {
        $this->middleware('auth');
        $this->repository=new ReviewRepository();
    }


    /**
     * Отображение всех отзывов
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->guest())
        {
            abort(403);
        }
        $reviews=$this->repository->getReviewsByUser(auth()->user()->id);
        return view('shop.review.index',compact('reviews'));
    }



    /**
     * Формирование нового отзыва
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopReviewCreateRequest $request)
    {
        if(auth()->guest())
        {
            abort(403);
        }
        $review=new Review($request->input());
        $review->user_id=auth()->user()->id;
        if($review->save())
        {
            return redirect()->back()->with([
                'success'=>'Отзыв отправлен. После проверки'.
                ' на корректность отзыв будет размещен на сайте.Спасибо!',
            ]);
        }
        return reduirect()->back();

    }

    /**
     * Отображение формы редактирования отзыва
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->guest())
        {
            abort(403);
        }
        $review=Review::findOrFail($id);
        if($review->user_id!=auth()->user()->id){
            abort(403);
        }

        $product=ShopProduct::findOrFail($review->product_id);
        return view('shop.review.edit',compact('review','product'));

    }

    /**
     * Изменение отзыва
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopReviewUpdateRequest $request, $id)
    {
        if(auth()->guest())
        {
            abort(403);
        }
        $review=Review::findOrFail($id);
        
        if($review->user_id!=auth()->user()->id){
            abort(403);
        }
        $review=Review::findOrFail($id);
        $review->checked=0;
        $review->fill($request->input());
        if($review->save())
        {
            return redirect()->route('shop.reviews.index')->with([
                'success'=>'Отзыв отправлен. После проверки'.
                ' на корректность отзыв будет размещен на сайте.Спасибо!',
            ]);
        }
        return reduirect()->back();
    }


    /**
     * Удаление отзыва по его идентификатору
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->guest())
        {
            abort(403);
        }
        $review=Review::findOrFail($id);
        if($review->user_id!=auth()->user()->id){
            abort(403);
        }
        if($review->delete())
        {
            return redirect()->back()->with([
                'success'=>'Отзыв успешно удален'
            ]);
        }
    }
}
