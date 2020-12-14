<?php

namespace App\Http\Repositories;


trait NestedSetRepository
{
    private $lft='_lft';
    private $rgt='_rgt';
    private $lvl='_lvl';
    private $parent='parent_id';
    private $name='name';

    public function truncate()
    {
        $this->startConditions()->truncate();
    }
    /*
        Возврат одного узла по идентификатору
    */
    public function getNodeById($id)
    {
        return $this->startConditions()->find($id);
    }
    /*
        Возврат одного узла по идентификатору Вместе удаленными
    */
    public function getNodeByIdWithTrashed($id)
    {
        return $this->startConditions()->withTrashed()->find($id);

    }

    /*
        Поиск крайнего правого положения
    */
    public function getRightMax()
    {
        return $this->startConditions()->max($this->rgt)??0;
    }

    /*
        Расширить или сузить место в БД
        $startPosition -Левый край сдвига в БД
        $shift - ширина сдвига
    */

    public function attract($startPosition,$shift)
    {
        //Сдвиг непричастных
        $result=$this->startConditions()
            ->where($this->lft,'>',$startPosition);
        $result->update([
            $this->lft=>\DB::raw("`$this->lft`+$shift"),
            $this->rgt=>\DB::raw("`$this->rgt`+$shift"),
        ]);
        //Сдвиг предков справа
        $result=$this->startConditions()
            ->where($this->lft,'<',$startPosition+1)
            ->where($this->rgt,'>',$startPosition);
        $result->update([
            $this->rgt=>\DB::raw("`$this->rgt`+$shift"),
        ]);
        return true;
    }

    public function softDelete($node)
    {
        return $this->startConditions()
        ->where($this->lft,'>=',$node->{$this->lft})
        ->where($this->rgt,'<=',$node->{$this->rgt})
        ->update([
            'deleted_at'=>\Carbon\Carbon::now()
        ]);
    }

    public function restore($node)
    {
        $result=$this->startConditions()->withTrashed()
        ->where($this->lft,'>=',$node->{$this->lft})
        ->where($this->rgt,'<=',$node->{$this->rgt})
        ->update([
            'deleted_at'=>null,
        ]);
    }



    public function delete($node)
    {
        $this->startConditions()
        ->where($this->lft,'>=',$node->{$this->lft})
        ->where($this->rgt,'<=',$node->{$this->rgt})
        ->forceDelete();
        $shift=-(1+$node->{$this->rgt} - $node->{$this->lft});
        $this->attract($node->{$this->rgt},$shift);
    }

    public function behead($node)
    {
        $this->startConditions()->withTrashed()
        ->where($this->lft,'>',$node->{$this->lft})
        ->where($this->rgt,'<',$node->{$this->rgt})
        ->update([
            $this->parent=>$node->{$this->parent},
            $this->lft=>\DB::raw("`$this->lft`-1"),
            $this->rgt=>\DB::raw("`$this->rgt`-1"),
            $this->lvl=>\DB::raw("`$this->lvl`-1"),
        ]);
        $this->startConditions()->withTrashed()
        ->where('id','=',$node->id)
        ->forceDelete();
        $this->attract($node->{$this->rgt}-2,-2);
    }


    //Инверсия узла
    public function inverse($node,$direction=false)
    {
        $result=$this->startConditions()
        ->where($this->lft,'>=',$node->{$this->lft})
        ->where($this->rgt,'<=',$node->{$this->rgt})
        ->update([
          $this->rgt=>\DB::raw("-1*(`$this->rgt`)"),
          $this->lft=>\DB::raw("-1*(`$this->lft`)"),
         ]);
    }

    //Перемещение узла из отрицательного узла в новый со смещением
    public function reverse($shift,$level=0)
    {
        $result=$this->startConditions()
        ->where($this->lft,'<',0)
        ->update([
            $this->lft=>\DB::raw("-1*(`$this->lft`+$shift)"),
            $this->rgt=>\DB::raw("-1*(`$this->rgt`+$shift)"),
            $this->lvl=>\DB::raw("$level+(`$this->lvl`)")
         ]);
    }


    /*
        Перемещение узлов
    */
    public function move($node,$nodePlace)
    {
        if(empty($nodePlace))
        {
            $rightMax=$this->getRightMax();
            $nodePlace=(object)['id'=>null,$this->lft=>0,$this->rgt=>$rightMax,$this->lvl=>0];

        }

        if($node->getOriginal($this->parent) != $nodePlace->id  || $nodePlace->id==null)
        {
            $this->inverse($node);
            $newPosition=$this->getNewPosition($node, $nodePlace);

            $level=$nodePlace->_lvl- $node->_lvl+1;
            $shiftReverse=
            ($newPosition<$node->{$this->lft})
            ? $node->{$this->lft}-($newPosition+1)
            : -($newPosition-$node->{$this->rgt});
            $shift=1+$node->{$this->rgt}-$node->{$this->lft};
            $this->attract($node->{$this->lft}-1,-$shift);
            if($newPosition<$node->{$this->lft})
            {
                $shiftPos=$newPosition;
                $shiftOne=$shift;
            }
            else{
                //ок
                $shiftPos=$newPosition-$shift;
                $shiftOne=$shift;
            }

            $this->attract($shiftPos,$shiftOne);
            $this->reverse($shiftReverse,$level);
            $node->{$this->parent}=$nodePlace->id??null;

        }

        return true;
    }

    /*
        Поиск позиции для узла

    */
    public function getNewPosition($node,$nodePlace):int
    {
        $rightMax=$this->getRightMax();
        if(empty($nodePlace))
        {
            $nodePlace=(object)[$this->lft=>0,$this->rgt=>$rightMax,$this->lvl=>0];
        }
        $result=$this->startConditions()
            ->where('name','>',$node->{$this->name})
            ->where($this->lft,'>=',$nodePlace->{$this->lft})
            ->where($this->rgt,'<=',$nodePlace->{$this->rgt})
            ->where($this->lvl,'=',$nodePlace->{$this->lvl}+1)
            ->orderBy('name','ASC')
            ->limit('1')->toBase()
            ->select(['_lft'])->get();

        if(empty($result[0]->_lft)){
            if($nodePlace->{$this->lvl} == 0){
                $result = $rightMax;
            }
            else{
                $result = $nodePlace->{$this->rgt}-1;
            }
        }
        else{
            $result=$result[0]->{$this->lft}-1;
        }
        return $result;
    }


}
