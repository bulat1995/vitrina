<?php
/*
	Контроллер работы с отзывами пользователей

*/
namespace App\Http\Controllers\Admin\Shop;

use Illuminate\Http\Request;

use App\Models\Review;
use App\Http\Controllers\Controller;
use App\Http\Repositories\ReviewRepository;
use App\Http\Requests\ShopReviewUpdateRequest;

class ShopReviewAdminController extends Controller
{


	public function __construct()
	{

	}
    
    /**
     * Вывод непроверенных отзывов
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$rep=new ReviewRepository();
    	$reviews=$rep->getReviewsNotChecked();
        return view('admin.shop.review.index',compact('reviews'));
    }



    /**
     * Вывод формы непроверенного отзыва      
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$rep=new ReviewRepository();
        $review=$rep->getReviewById($id);
        return view('admin.shop.review.form',compact('review'));
    }

    /**
     * Обновление отзыва
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopReviewUpdateRequest $request, $id)
    {
        $review=Review::findOrFail($id);
        $review->fill($request->input());
        $review->checked=true;
        if($review->save())
        {
        	return redirect()->route('admin.shop.reviews.index')->with([
        		'success'=>'Отзыв успешно отредактирован',
        	]);
        }
        return redirect()->back()->withInput();
    }

    /**
     * Удаление отзыва
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review=Review::findOrFail($id);

        if($review->delete())
        {
        	return redirect()->route('admin.shop.reviews.index')->with([
        		'success'=>'Отзыв успешно удален',
        	]);
        }
    }
}
