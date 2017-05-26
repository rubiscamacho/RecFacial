<?php

use Phinx\Seed\AbstractSeed;

class CategoryFunctionsSeeder extends AbstractSeed
{

    const NAMES = [
        'Mecanico',
        'Gerente NTI',
        'Analista Suporte',
        'Mecanico Ajustador',
        'Montador Andaime',
        'Eletrecista',
        'Motorista',
        'Analista Contabil',
        'Gerente RH',


    ];

    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider($this);
        $categoryCosts = $this->table('category_functions');
        $data = [];
        foreach (range(1,10)as $value){
            $data[] =
                [
                    'name' => $faker->categoryName(),
                    'user_id' => rand(1,5),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

        }
        $categoryCosts->insert($data)->save();
    }

    public function categoryName(){
        return \Faker\Provider\Base::randomElement(self::NAMES);
    }
}