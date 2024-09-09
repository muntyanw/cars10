<?php

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'date' => '23.02.2001',
                'products' => [
                    [
                        'name' => 'product 1',
                        'price' => 30,
                    ],
                    [
                        'name' => 'product 2',
                        'price' => 34,
                    ],
                    [
                        'name' => 'product 3',
                        'price' => 60,
                    ]
                ]
            ],
            [
                'date' => '23.02.2001',
                'products' => [
                    [
                        'name' => 'product 1',
                        'price' => 30,
                    ],
                    [
                        'name' => 'product 2',
                        'price' => 34,
                    ],
                    [
                        'name' => 'product 3',
                        'price' => 60,
                    ]
                ]
            ],
            [
                'date' => '23.02.2001',
                'products' => [
                    [
                        'name' => 'product 1',
                        'price' => 30,
                    ],
                    [
                        'name' => 'product 2',
                        'price' => 34,
                    ],
                    [
                        'name' => 'product 3',
                        'price' => 60,
                    ]
                ]
            ],
            [
                'date' => '23.02.2001',
                'products' => [
                    [
                        'name' => 'product 1',
                        'price' => 30,
                    ],
                    [
                        'name' => 'product 2',
                        'price' => 34,
                    ],
                    [
                        'name' => 'product 3',
                        'price' => 60,
                    ]
                ]
            ]
        ];
        
        
        foreach($data as $orderItem){
            // логика создания ордера
            foreach($orderItem['products'] as $product){
//                 логика записи товаров
                echo __LINE__;
                
            }
        }
        
    }
}
