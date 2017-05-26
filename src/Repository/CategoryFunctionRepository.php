<?php

declare(strict_types=1);



namespace SONFin\Repository;



use Illuminate\Support\Collection;



use SONFin\Models\CategoryFunction;



class CategoryFunctionRepository extends DefaultRepository

{





    /**

     * CategoryFunctionRepository constructor.

     */

    public function __construct()

    {

        parent::__construct(CategoryFunction::class);

    }



    public function Lista(): array

    {

        $categories = CategoryFunction::query()

            ->select('f.id function_id', 'f.created_at', 'first_name', 'last_name', 'endereco', 'cpf', 'c.name')

            ->leftJoin('category_functions', 'funcionario.category_function_id', '=', 'category_function.id')

            ->groupBy('category_function.name')

            ->get();


        return $categories->toArray();

    }

}