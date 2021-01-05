<?php
/*
    Проверка существования параметра в БД
    Валидация принятых характеристик

*/
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Models\ShopProduct;
use App\Models\ShopParameter;
use App\Http\Repositories\ShopProductRepository;

class ShopProductParameterRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $errorMessagePoint=0;
    private $columnName='';

    public function __construct()
    {

    }

    /**
     * Проверка соответствия параметров категории
     * и введенных параметров для товара.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $productRepository=\app(ShopProductRepository::class);
        $category_id=request()->route()->category_id??0;
        if($category_id==0){
            $category_id=ShopProduct::find(request()->route()->product);
        }
        $params=$productRepository->getProductDetailById(0,$category_id);
        if(count($params)!=count($value)){
            //Несовпадают размеры входных данных с данными из БД
            $this->errorMessagePoint=1;
            return false;
        }
        //Проверка на required
        foreach($params as $parameter)
        {
            if($parameter->required &&(!preg_match("/$parameter->regular/im",$value[$parameter->id]))){
                $this->errorMessagePoint=2;
                $this->columnName=$parameter->name;
                return false;
            }
            if($parameter->required && empty($value[$parameter->id])){
                $this->columnName=$parameter->name;
                $this->errorMessagePoint=3;
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $messages=[
            1=>'Заполнены не все параметры',
            'Несоответствие входных данных с требованиями категории',
            "Параметр $this->columnName заполнен неверно",
            "Параметр $this->columnName обязателен для заполнения",
        ];
        return $messages[$this->errorMessagePoint];
    }
}
