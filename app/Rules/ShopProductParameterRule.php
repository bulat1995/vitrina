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
    private $errorMessagePoint=1;
    private $columnName='';

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
        $product=(ShopProduct::find(request()->route()->product));
        $product_id=$product->id ?? 0;
        $category_id=request()->route()->category_id ?? $product->category_id;
        $params=$productRepository->getProductDetailById($product_id,$category_id);

        if(count($params)!=count($value)){
            $this->errorMessagePoint=0;
            return false;
        }

        return $this->checkParameters($params,$value)??true;
    }

    //ПРоверка параметров товара
    public function checkParameters($params,$value)
    {
        $status=true;
        var_dump($params);
        foreach($params as $parameter)
        {
            if($parameter->required && empty($value[$parameter->id])){
                $this->columnName=$parameter->name;
                $this->errorMessagePoint=1;
                $status=false;
            }

            switch($parameter->inputType)
            {
                //Проверка даты
                case 'date': $status=$this->checkDate($value[$parameter->id]); break;

                //Проверка на число
                case 'digit':
                    if(!\is_numeric($value[$parameter->id])){
                        $this->errorMessagePoint=3;
                        $status=false;
                    }
                break;

                //Ссылка
                case 'url':
                    if(!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i',$value[$parameter->id])){
                        $this->errorMessagePoint=4;
                        $status=false;
                    }
                break;

                //Выбор одного из пунктов в списке
                case 'option':
                    $array=explode('|',$parameter->regular);
                    if(\count($array)<=(int)$value[$parameter->id]){
                        $this->errorMessagePoint=5;
                        $status=false;
                    }
                break;

                // //Группа галочек
                // case 'groups':
                //     $groups=explode('|',$parameter->regular);
                //     if(count($value[$parameter->id])>0){
                //         foreach($value[$parameter->id] as $key=>$val)
                //         {
                //             //dd($parameter,$value[$parameter->id]);
                //             if(!isset($groups[$key]))
                //             {
                //                 $this->errorMessagePoint=5;
                //                 $status=false;
                //             }
                //         }
                //     }
                //     //$value[$parameter->id]=implode('|',$value[$parameter->id]);
                // break;

                //Проверка расширения файла
                // case 'file':
                // $files=$value[$parameter->id];
                //     foreach($files as $file){
                //         //dd($file);
                //         $extension=$file->getMimeType();
                //         $groups=explode('|',$parameter->regular);
                //         if(!\in_array($extension,$groups)){
                //             $this->errorMessagePoint=6;
                //             $status=false;
                //         }
                //     }
                // break;

                default:
                    if($parameter->required &&(!preg_match("/$parameter->regular/im",$value[$parameter->id]))){
                        $this->errorMessagePoint=7;
                        $this->columnName=$parameter->name;
                        $status=false;
                    }
                break;
            }
        }
                return $status;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $messages=[
            'Заполнены не все параметры',
            "Параметр $this->columnName обязателен для заполнения",
            'Несуществующее время в параметре'.$this->columnName,
            'Параметр '.$this->columnName.'не является числовым',
            'Параметр '.$this->columnName.'не является ссыдкой на ресурс',
            'Параметр '.$this->columnName.'несуществует',
            'Файл '.$this->columnName.'не соответствует формату',
            'Несоответствие входных данных с требованиями категории',
            "Параметр $this->columnName заполнен неверно",
        ];
        return $messages[$this->errorMessagePoint];
    }


    //Проверка на соответствие даты
    public function checkDate($dateString)
    {
        $status=false;
        
        if(\preg_match("/([0-9]{4}-[0-9]{2}-[0-9]{2})/i",$dateString))
        {
            $dateString=explode('-',$dateString);
            if(checkdate($date[1],$date[2],$date[0])){
                $this->errorMessagePoint=2;
                $status=true;
            }
        }

        return $status;
    }
}
